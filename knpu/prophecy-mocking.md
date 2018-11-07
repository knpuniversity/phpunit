# Mocking with Prophecy

PHPUnit has a mocking system. But it's not the *only* mocking library available.
There are two other popular ones: Mockery & Prophecy. They all do the same thing,
but each has its own *feel*.

I really like Prophecy, *and* it comes with PHPUnit automatically! So let's redo
the `EnclosureBuilderTest` with Prophecy to see how it feels.

Create a new class called `EnclosureBuilderServiceProphecyTest`. It will extend the
normal `TestCase` and we can give it the same method: `testItBuildsAndPersistsEnclosure()`.

[[[ code('52f3f5715d') ]]]

## Mocking Prophecy Style

Let's translate the PHPUnit mock code into Prophecy line-by-line. To create
the `EntityManager` mock, use `$this->prophesize(EntityManagerInterface::class)`.
That's pretty similar.

[[[ code('c4446c7f50') ]]]

Next, we need to assert that `persist()` will be called `once()` and that it is passed
an `Enclosure` object. *This* is where things get different... and pretty fun...
Instead of thinking of `$em` as a mock, pretend it's the *real* object. Call
`$em->persist()`. To make sure this is passed some `Enclosure` object, pass
`Argument::type(Enclosure::class)`.

[[[ code('0b37dfefc9') ]]]

We'll talk more about how these arguments work in a minute. Then, because we want
this to be called exactly once, add `shouldBeCalledTimes(1)`.

[[[ code('db040cdf5b ') ]]]

Oh, and notice that I am *not* getting auto-completion. That's because Prophecy is
a super magic library, so PhpStorm doesn't really know what's going on. But actually,
there are two *amazing* PhpStorm plugins that - together - *will* give you auto-completion
for Prophecy... and many other things. They're called "PHP Toolbox" and "PHPUnit Enhancement".
I learned about these *so* recently, that I didn't have them installed yet for this
tutorial. Thanks for the tip Stof!

Next, we need to make sure `flush()` is called at least once. That's easy:
`$em->flush()->shouldBeCalled()`.

[[[ code('88fe8ece14') ]]]

Don't you love it? In addition to `shouldBeCalledTimes()` and `shouldBeCalled()`,
there is also `shouldNotBeCalled()` and simply `should()`, which accepts a callback
so you can do custom logic.

## Mocking the DinosaurFactory

Let's keep moving: add the `DinosaurFactory` with `$dinoFactory = $this->prophesize()`
and `DinosaurFactory::class`.

[[[ code('13ceb602ff') ]]]

Here, we need to make sure that the `growFromSpecification` method is called exactly
two times with a string argument and returns a dinosaur. Ok! Start with
`$dinoFactory->growFromSpecification()`. 

Here's how the arguments part *really* works. If you don't care what arguments are
passed to the method, just leave this blank. But if you *do* care, then you need
to pass *all* of the arguments here, as if you were *calling* this method.

For example, imagine the method accepts *three* arguments. If we passed `foo`,
`bar`, `baz` here, this would make sure that the method was called with exactly
these three args.

Our situation is a bit trickier: we don't know the *exact* argument, we only know
that it should be a string. To check that, use `Argument::type('string')`.

[[[ code('3a9fdff1a5') ]]]

There are a few other useful methods on this `Argument` class. The most important
is `Argument::any()`. You'll need this if you want to assert that *some* of your
arguments match a value, but you don't care what value is passed for the *other*
arguments.

The most powerful is `that()`, which accepts an all-powerful callback as an argument.

Next, this method should be called 2 times. No problem: `->shouldBeCalledTimes(2)`.
And finally, it should return a new `Dinosaur` object. And that's the same as in
PHPUnit: `->willReturn(new Dinosaur())`. The other 2 useful functions are `willThrow()`
to make the method throw an exception and `will()`, which accepts a callback so you
can completely control the return value.

[[[ code('879051c19f') ]]]

And... yea! That's it! I'll copy the rest of the test and paste it. Re-type the `e`
on `EnclosureBuilderService` to add the `use` statement on top.

[[[ code('2005ae57f4') ]]]

## Revealing the Prophecy

There's *one* other tiny difference in Prophecy. First, I'll break this onto multiple 
lines so it looks nicer. When you finally pass in your mock, you need to call
`->reveal()`. On a technical level, this kind of turns your "mock builder" object
into a true mock object. On a philosophical Prophecy level, this *reveals the prophecy*
that the prophet prophesized.

Fun, right? If that made no sense - it's ok! The Prophecy documentation - while being
a little strange - is really fun and talks a lot more about dummies, stubs, prophets
and other things. If you're curious, it's worth a read.

Ok, that should be it! Find your terminal and run the test:

```terminal-silent
./vendor/bin/phpunit
```

They pass! Right on the first try. So that's Prohecy: it's a bit more fun than PHPUnit
and is also quite popular. If you like it better, use it!

Next, there are *many* options you can pass to the phpunit command. Let's learn
about the most important ones... so that we can ignore the rest.
