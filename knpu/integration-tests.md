# Integration Tests

Isn't *mocking* awesome? Yes! Except... when it's not. In a unit test, we use mocking
so that each class can be tested in complete isolation: no database, no API calls
and no friendly dinner parties. But sometimes... if you mock everything... there's
nothing *really* left to test

For example, how would you test that a complex query in a Doctrine repository works?
If you *mock* the database connection then... I guess you could test that the query
string you wrote looks ok? That's silly! The *only* way to *truly* test this method
is to run that query against a *real* database.

Here's the deal: sometimes, when you think about testing a class, you start to
realize that if you mock all the dependencies... then the test becomes worthless!
In these cases, you need an *integration* test.

## Setting up the Database

Let's jump in! `EnclosureBuilderService` already has a unit test. But since it talks
to the database, if we *really* want to make sure it works, we need a test where it...
*actually* talks to the database!

First, we need to finish our entities. Find ``Security`` and copy the ``id`` field.
Open ``Dinosaur`` and paste this in. Do the same for ``Enclosure``. We haven't needed
these yet because we haven't touched the database at all. 

[[[ code('4d9187422e') ]]]

[[[ code('f3b1fb18e0') ]]]

Now, go to your terminal and create the database:

```terminal
php bin/console doctrine:database:create
```

Huh, I already have one. Lucky me! Create the schema:

```terminal
php bin/console doctrine:schema:create
```

## Hello Integration Test

Now to the integration test! Create a new class: `EnclosureBuilderServiceIntegrationTest`.
I don't always create a separate class for integration tests: it's up to you. Unit
tests and integration tests can actually live next to each other in the same test
class. Unlike herbivore and carnivore dinsosaurs who should really each get their
own enclosure.

This time, instead of `TestCase`, extend `KernelTestCase`.

[[[ code('679a2d164f') ]]]

This is not *that* crazy: `KernelTestCase` itself extends `TestCase`: so we have
all the normal methods. But it *also* has a few new methods to help us boot Symfony's
container. And *that* will give us access to our *real* services.

Add the test method: `public function testItBuildsEnclosureWithTheDefaultSpecification()`.
Hmm, that's a big name!

[[[ code('ac78eceaf6') ]]]

## Booting & Fetching the Container

Here is the key difference between a unit test and an integration test: instead of
creating the `EnclosureBuilderService` and passing in mock dependencies,
we'll boot Symfony's container and ask *it* for the `EnclosureBuilderService`.
And of course, *that* will be configured to talk to our real database. This makes
integration tests less "pure" than unit tests: if an integration tests fails, the
problem could live in *multiple* different places - not just in *this* class. And
also, integration tests are *way* slower than unit tests. Together, this makes them
less hipster than unit tests. Despite my love for being hipster, I'll concede that
integration tests are *really* helpful.

To use the real services, first call `self::bootKernel()` to... um... boot Symfony's
"kernel": its "core". Now we can say `$enclosureBuilderService = self::$kernel->getContainer()->get()`
and the service's id: `EnclosureBuilderService::class`.

[[[ code('32cb9d4955') ]]]

But before we do *anything* else... there's a surprise! Find your terminal and run
phpunit with `--filter`. Copy the method's name and paste it:

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

## Fetching Private Services

Woh! It *explodes*!

> You have requested a non-existent service AppBundle\Service\EnclosureBuilderService.

That's weird because... in `app/config/services.yml`, we're using the service
auto-registration code from Symfony 3.3, which registers each class as a service...
and uses the *class* name as the service id. So why does it say the service isn't
found?

Because... all services are *private* thanks to the `public: false`. This is actually
very important to how Symfony works - you can learn more about it in our Symfony 3.3
tutorial. But the point is, when a service is `public: false`, it means that you
cannot fetch it directly from the container. Normally, that's no problem! We use
dependency injection everywhere. Well... everywhere *except* our tests.

How do we fix this? Open `app/config/config_test.yml`. In Symfony 4, you should
open or create `config/services_test.yaml`. Add the `services` key and use `_defaults`
below with `public: true`.

[[[ code('a3e817da13') ]]]

Then, we're going to create a service *alias*. Back in the test, copy the entire
class name - which is the service id. Over in `config_test.yml`, add `test.` and
then paste. Set this to `@` and paste again.

[[[ code('8fd5f902c5') ]]]

This creates a public *alias*: even though the original service is private, we can
use this new `test.` service id to fetch our original service out of the container.

Try it! Back in the test, inside `get()`, add `test.` and *then* the class name.

[[[ code('db3400a4f3') ]]]

Move over and try the test again!

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

Ha! It works! It shows "Risky" because we don't have any assertions. But it did
*not* blow up.

## Adding the Database Assertions

Let's finish the thing! Above the variable, I'll add some inline documentation so
that PhpStorm gives me auto-completion. Now, call the `->buildEnclosure()` method.
We'll use the default arguments. That should create 1 `Security` and 3 `Dinosaur`
entities.

[[[ code('dfc418cc4e') ]]]

And... yea! All we need to do now is count the results in the database to make sure
they're correct! First, fetch the EntityManager with `self::$kernel->getContainer()`
then `->get('doctrine')->getManager()`. I'll also add inline phpdoc above this to help
code completion.

[[[ code('fe7306f23b') ]]]

To count the results, I'll paste in some code: this accesses the `Security` repository,
counts the results and calls `getSingleScalarResult()` to return *just* that number.
After this, use `$this->assertSame()` to assert that `1` will match `$count`. If
they don't match, then the "Amount of security systems is not the same". And you should
look over your shoulder for escaped raptors!

[[[ code('b735dbfeb1') ]]]

Copy all of that and repeat for `Dinosaur`. Change the class name, and I'll change
the alias to be consistent. Update the message to say "dinosaurs" and this time -
thanks to the default arguments in `buildEnclosure()` - there should be 3.

[[[ code('e00a8115f3') ]]]

Ok team! We're done! Try the test!

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

It works! We're geniuses! Nothing could ever go wrong! Run the test again:

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

It fails! Suddenly there are *2* security systems in the database! And each time
you execute the test, we have more: 3, 4, 5! It's easy to see what's going on:
each test adds more and more stuff to the database.

As soon as you talk to the database, you have a new responsibility: you need
to control *exactly* how the database looks.

Let's talk about that next.
