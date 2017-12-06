# The Important CLI Options & phpunit.xml.dist

Find your terminal. But *this* time, run phpunit with a `-h` option:

```terminal
./vendor/bin/phpunit -h
```

Woh! That is a *lot* of options. Ok, let's talk about *every* single one of them.
Just kidding! I've never even used most of these options! But there are a few *awesome*
flags that will be *very* useful.

Google for "PHPUnit cli" to find their page about this. It's a bit prettier than
reading the terminal. At the top of the output, it says that you can pass one or
more files or directories. That's useful to run just *one* test class or all the
classes in one directory. For example, we could run just the `DinosaurFactoryTest`:

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Factory/DinosaurFactoryTest.php
```

## The Symfony PHPUnit Bridge

Oh, and before I forget, Google for "Symfony PHPUnit Bridge" to find a special
component that lives in Symfony.com: `symfony/phpunit-bridge`. 

This is a wrapper around PHPUnit that adds a couple of extra features like deprecation
reporting that will tell you about deprecated code paths that you're using during
your tests.

***TIP
In Symfony 4, this is the officially-recommended way to use PHPUnit. You should
install this instead of installing PHPUnit directly.
***

Basically, after you install this, you'll use `vendor/bin/simple-phpunit` to activate
it. It supports all the same options.

## The --filter Option

Back on the PHPUnit docs, my *favorite* option by far is `--filter`. This let's
you run just *one* test method, and it's *critical* when you're trying to debug
*one* test.

If you scroll down, the docs show a bunch of examples. Usually, I copy the method
name I'm testing, pass `--filter` and then paste that name. But you can get a lot
fancier.

Let's try a few! First, re-run the test with another flag: `--debug`:

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Factory/DinosaurFactoryTest.php --debug
```

The output now tells us *which* tests are running. Let's run *just* one of them:

```terminal
./vendor/bin/phpunit --filter testItGrowsADinosaurFromASpecification --debug
```

And... yes! It ran *three* tests, because this one method has a data provider. But
sometimes, you'll need to debug *just* one test case of a provider. Surround the
method name in quotes, and then add `#1`:

```terminal-silent
./vendor/bin/phpunit --filter 'testItGrowsADinosaurFromASpecification #1' --debug
```

Ah, *so* cool! You can also use `@default response` - that's the test case that we
gave a special name.

```terminal-silent
./vendor/bin/phpunit --filter 'testItGrowsADinosaurFromASpecification @default response' --debug
```

For the *longest* time, I didn't know you could do this. I *love* it.

## Stopping on Failure or Error

If you're running a *lot* of tests, you can tell PHPUnit to stop *immediately*
when one of them has an error or fails... instead of waiting for *all* of them
to finish running.

To do that, use the `--stop-on-failure` and `--stop-on-error` options:

```terminal-silent
./vendor/bin/phpunit --stop-on-failure --stop-on-error
```

We don't have any errors - yes! - but you get the idea!

## The phpunit.xml.dist File

There are *many* other options... but you can do even *more* in the configuration
file! And we already have one! PHPUnit automatically looks for a `phpunit.xml`
file and then a `phpunit.xml.dist` file.

This configures a few *really* important things... like `bootstrap`. Thanks to this,
PHPUnit requires the autoloader before running the tests. But there is so much
more you can do: tweak `php.ini` settings, set environment variables, configure
test suites or tweak code coverage setup.

Most of the time, you'll have just one test suite... which means that all the test
are always executed. But you could, for example, separate your unit, integration
and functional tests into different suites so that you could run them independently.
That's kind of cool, because integration and functional tests are much slower than
unit tests.

Let's do one quick example: add a test suite called `entities` and set its directory
to `tests/*Bundle/Entity`.

To run this suite, use:

```terminal
./vendor/bin/phpunit --testsuite entities --debug
```

It runs *only* those tests.

Ok, enough of this! Let's get back to work and talk about integration tests: what
they are, and when they can save your life.
