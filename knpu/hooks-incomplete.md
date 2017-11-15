# Hooks: setUp, tearDown & Skipping Tests

We can *also* use the TDD refactor step to improve our tests! Eventually, we're
going to have a *lot* of test methods inside `DinosaurFactoryTest`. And *each* one
will need to create the `DinosaurFactory` object. If that class eventually has some
constructor arguments, that's going to be a pain!

## The setUp Hook

Add a new `$factory` property and give it some PHPDoc: this will be a `DinosaurFactory`
object. Then - here's the magic part - create a new `public function setUp()`.
Inside, set the property to a `new DinosaurFactory`.

[[[ code('c9473eafa6') ]]]

Back in our test method, use the new property. Yep, this *will* work... but only
thanks to a bit of PHPUnit magic. If you have a method that's exactly called `setUp`,
PHPUnit will automatically call it *before* each test.

[[[ code('eb58d7c0df') ]]]

If you have *multiple* test functions, that means that `setUp` will be called before
each test *method*. This will make sure that the `$factory` property is a new, *fresh*
`DinosaurFactory` object for *every* test. And that's *really* important: each test
should be *completely* independent of each other. You never want one test to rely
on something a different test set up first. Why? Because later, we'll learn how to
execute just *one* test at a time - which is *really* useful for debugging.

## Other Hooks: tearDown, setUpAfterClass, etf

There are a few other *magic* methods like this. The most common is `tearDown()`,
which is the opposite of setUp. It's still called once per test, but *after*
the test is executed. It's meant for cleanup, and we'll talk more about it later.

Two other useful hook methods are `setUpBeforeClass()` and `tearDownAfterClass`.
Instead of being called before or after *every* test, these are called *once* for
the *entire* class. They're less common, but if you need to setup something global
or *static*, this is the place to do it.

Oh, and one last, lesser-known hook method is `onNotSuccessfulTest`. Sometimes I'll
use that to print extra debugging info.

Ok, make sure the tests still pass!

```terminal-silent
./vendor/bin/phpunit
```

Perfect!

## Marking Tests as Incomplete

Our dinosaur park guests are *really* excited about seeing some triceratops! But...
we can't grow them yet - the scientists are still working on that dino DNA.

But *eventually*, we're going to add a `growTriceratops` method to `DinosaurFactory`.
To make sure we don't forget about this, let's *start* the test: `testItGrowsATriceratops`.
But I don't *really* want this test to exist... and fail - that's lame. Instead,
add `$this->markTestIncomplete('Waiting for confirmation from GenLab')`.

[[[ code('326f2b806a') ]]]

Try it!

```terminal-silent
./vendor/bin/phpunit
```

Nice! It's not a failure... just a clear marker to remind us that we have work to do!

## Skipping Tests

A *similar* thing you can do is *skip* tests. Try this: add a new method:
`testItGrowsABabyVelociraptor()`. Create a *tiny* velociraptor - adorable! - and
make sure it's length is correct.

[[[ code('fc99234394') ]]]

This will *totally* work. But let's pretend that, inside the `growVelociraptor()`
method, we use some class or PHP extension that the user may or may not have installed.
Check to see if some imaginary `Nanny` class exists. If it doesn't, we can't
run the test! So mark it as skipped: there's nobody to watch the baby raptor!

[[[ code('b915eba512') ]]]

```terminal-silent
./vendor/bin/phpunit
```

When you run the tests now... cool! An I for incomplete and S for skipped.

I don't use `markTestSkipped()` in my own apps - it's a bit more useful when
you're building some reusable library and need to write tests for optional features
that use optional libraries. It's used all the time inside Symfony's core.

Next! I want to talk about my *favorite* feature in PHPUnit: data providers!
