# Test Fixtures & Fast Databases!

In practice, the *hardest* thing about functional testing isn't all the stuff about
clicking links or filling out forms. Nope, the toughest thing is taking control of
the database!

## To Fixture or Not to Fixture?

To do this, there are two big philosophies! First, like with integration tests, we
can decide to always start the database empty. And then, if we need data - like we
need to add some Enclosures to the database - we will add that data *inside* the
test method itself. This is how I normally code. It's not super fancy, and it means
that you need to do extra work in each test to create the exact data you need. But,
it *also* means that each test reads like a complete story. For example, at the top
of this test, you would be able to see that we created 3 Enclosure objects. Then,
at the bottom, it will make sense *why* we're *expecting* to see 3 rows in the table.

The second philosophy, which is a bit simpler, is to load data fixtures. This is
what we're going to do: but I'll mention how things would be different if you want
to use the first philosophy.

## Adding Data Fixtures

First, install the DoctrineFixturesBundle:

```terminal
composer require --dev doctrine/doctrine-fixtures-bundle
```

If you downloaded the course code, in the `tutorial/` directory, you should have
a `DataFixtures` directory. Copy that into your `AppBundle`. 

[[[ code('282cbfe430') ]]]

[[[ code('e61f1496b0') ]]]

These two classes build 3 Enclosures and also add some security to them. But,
part of this code is using a `setEnclosure()` method on `Dinosaur`... and that doesn't exist! 
Open `Dinosaur`, scroll to the bottom, and add it: `public function setEnclosure()` 
with an `Enclosure` argument. Set that on the property.

[[[ code('de052ca604') ]]]

Awesome! Once the bundle finishes downloading open ``AppKernel``. And inside the
`if` statement, add `new DoctrineFixturesBundle()`. If you're using Flex, this step
will have already been done for you automatically.

[[[ code('5cc58fd931') ]]]

We haven't hooked the fixtures into our tests yet, but we can at least try them!
Run:

```terminal
php bin/console doctrine:fixtures:load
```

Go check out the browser! Yes! The fixtures gave us 3 enclosures. That's why I wrote
our test to expect 3 rows. If we can load the fixtures when the test runs, we're
in business!

## Loading Fixtures in the Test

Fortunately, LiipFunctionalTestBundle gives us a really nice way to do this. At
the top of the test method, add `$this->loadFixtures()` and pass an array of the
fixture classes you want to load: `LoadBasicParkData::class` and `LoadSecurityData::class`.

[[[ code('301b4e4268') ]]]

If you're going to use the same set of fixtures for all your test methods, then
moving this to `setUp()` is a great choice.

Run the tests!

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Controller/DefaultControllerTest.php
```

They work! They pass, over and over again!

So, how would things be different if you did *not* want to load fixtures? Well,
you *will* still want to empty the database. So, you could use the same trick as
the integration tests. Or, you could call `$this->loadFixtures()` with an empty array.

Of course, the tests fail. That's because `loadFixtures()` empties the database...
but then doesn't load *anything* into it. 

Remember, if you choose this philosophy, you're now responsible for creating the
data you need. How? The same way you always do: create some `Enclosure` objects
and then persist them with the EntityManager. And since we're *still* ultimately
extending `KernelTestCase`, we already know how to get the EntityManager: with
`self::$kernel->getContainer()->get('doctrine')->getManager()`.

## Test Base Classes

Actually, it would be *great* if we had a shortcut like `$this->getEntityManager()`
for *all* our test classes. We won't do it in this tutorial, but I *highly* recommend
creating your *own* base test class with extra shortcut methods. Typically, I'll
have one base test class for integration tests - which extends `KernelTestCase` -
and if necessary, another for my functional tests, which extends `WebTestCase`. You
can also use traits to share code even better.

## Faster Database Loading

The LiipFunctionalTestBundle has two other tricks. First, if you're using
SQLite, then *it* automatically builds the schema for you. Check this out: delete
the database file:

```terminal-silent
rm var/data/test.sqlite
```

Bye bye database schema! But, when you run the tests, they still pass! When you
load the fixtures, it creates the schema too. Thanks friends!

The second trick lives in `app/config/config_test.yml`. Add a new option:
`cache_sqlite_db` set to `true`.

[[[ code('a46d945176') ]]]

Visually... this doesn't make any difference. BUT! Behind the scenes, cool things
are happening. Each time you call `loadFixtures()`, it loads the fixtures and then
*caches* the database file. The next time you call `loadFixtures()` with the same
arguments, it instantly re-uses that cached database file.

Check this out: to simulate loading a lot of fixtures, add a `sleep(5)` in one of
them. Now, run the test:

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Controller/DefaultControllerTest.php
```

Yea... it's *slow*. The bundle detected the change we made and was smart enough
to know that it needed to reload the fixtures. But the second time... zoom! It's
super fast.

The *coolest* part is that all of this database and fixture-handling stuff from
LiipFunctionalTestBundle can be used even if you decide to use a different client -
like Mink - instead of Symfony's BrowserKit.

Next, let's look at one more trick you can do with fixtures.
