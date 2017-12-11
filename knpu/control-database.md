# Clearing the Database

Each time we run the test, it adds more and more entries to the database. Our test
is *not* reliable: it *depends* on what the database looks like when it starts. The
solution is simple: we *must* control the data in the database at the start of every
test.

## Creating a Test Database

Step one to accomplishing this is to use a *different* database for our test environment.
Actually, this is mostly for convenience: using the same database for testing
and development is annoying. One minute, you're coding through something awesome
in your browser, then you run your tests, then back in the browser, all your nice
data is gone or totally different! Isolation in this instance is nice.

To do that, go back to `config_test.yml`. In a Symfony 4 Flex application, you
should create a `config/packages/test/doctrine.yaml` file since this will contain
Doctrine configuration that you *only* want to use in the `test` environment.

Inside, anywhere, add `doctrine`, `dbal` then `url` set to
`sqlite:///%kernel.project_dir%/var/data/test.sqlite`.

[[[ code('a607433445') ]]]

This will override the settings in `app/config/config.yml` - the stuff under `doctrine`.
With the new config, we're completely replacing this stuff and saying "Hey! Use an
sqlite, flat-file database!".

Why Sqlite? It's simple to setup and you can use some tricks to speed up your
tests. We'll see that in a few minutes.

Oh, and make sure you have the `%` sign at the *end* of `kernel.project_dir`!

Now, find your terminal and create the `var/data` directory:

```terminal-silent
mkdir var/data
```

Next, create the schema

```terminal
php bin/console doctrine:schema:create --env=test
```

And, congrats! You are the owner of a fancy new `var/data/test.sqlite` file!
Take good care of it.

## Clearing the Database before Tests

At this point, not much has changed really. Our tests will still pass *one* time,
but will fail each time after. We haven't *actually* fixed the problem yet!

How can we? The best way is to *fully* empty the database at the beginning of each
test. This would *certainly* put our database into a known state: empty! Then, if
we *do* need any data before running the test, we can manually add it *in* the test.
It's not super fancy, but it keeps everything really clear.

Like most good things in life, there are two ways to do this. First, if you downloaded
the course code, then in the `tutorial/tests` directory, you'll find an
`EnclosureBuilderServiceIntegrationTest.php` file. Copy the `truncateEntities()`
method and paste that into your test class.

[[[ code('48ab68cf6e') ]]]

This is simple: pass the method an array of entities and it will empty them.

You might want to call this at the top of every test method. But another great option
is to override `setUp()` and add it there. Let's empty all three entities:
`Enclosure`, `Security` and `Dinosaur`.

[[[ code('5e36e601f6') ]]]

For this method to work, we need a `getEntityManager()` method. At the bottom,
add `private function getEntityManager()`. Then, copy our logic from above, paste
it here, and add `return`. And since you know I *love* auto-completion, I'll add
a `@return EntityManager`.

[[[ code('f6e8793399') ]]]

This makes `truncateEntities()` happy! And we can even use `getEntityManager()` above.

[[[ code('976fdff42a') ]]]

Oh, and it's *really* important that we call `self::bootKernel()` *before* we
try to access any services. The best thing to do is remove it from the test method
and add it to `setUp()`.

[[[ code('17bc7a2473') ]]]

Done! Try the tests:

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

We got it! We can run them over, and over, and over again. Always green!

## Using Data Fixtures

This was the more manual way to clear the database, and it gives you a bit more
control. Another option is to use Doctrine's DataFixtures library.

First, install it:

```terminal
composer require doctrine/data-fixtures --dev
```

When this finishes, we can delete all the logic in `truncateEntities()`... because
*now* we have a fancy "purger" object: `$purger = new ORMPurger()` and pass in the
entity manager.

Then... `$purger->purger()`. And yea... that's it! We can remove the `$entities`
argument and stop passing in the array.

[[[ code('e3ec65fc99') ]]]

This loops over all of your entity objects and deletes them one by one. It will even
delete them in the correct order to avoid foreign key problems. But, if you have
two entities that *both* have foreign keys pointing at each other, you may still
have problems.

But, this works! The tests still pass.

Before we move on, I want to show you one cool, weird trick with integration tests:
I call it "partial" mocking.
