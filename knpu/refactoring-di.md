# Refactoring & Dependency Injection

In `DinosaurFactory`, we made a fancy private function `getLengthFromSpecification`.
It's a *great* function. *So* great, that now, I want to be able to use it from
*outside* this class.

To do that... and of course... to help us get to mocking, let's refactor this method
into its own class. Create a new `Service` directory in `AppBundle`. And then a new
class called `DinosaurLengthDeterminator`. That's a fun name.

Copy `getLengthFromSpecification()`, remove it, and paste it here. Make the method
`public` and re-type `Dinosaur` to get the `use` statement.

[[[ code('b75cdac2bd') ]]]

We *already* have a bunch of tests in `DinosaurFactoryTest` that make sure each
specification string gives us the right length. In `tests`, create that same
`Service` directory and a new `DinosaurLengthDeterminatorTest`. We're going to
migrate the existing length tests to this class.

Add `public function testItReturnsCorrectLengthRange()` with `$spec`, `$minExpectedSize`
and `$maxExpectedSize`.

[[[ code('8ac822f6da') ]]]

This test will be similar to the one in `DinosaurFactoryTest`, but a bit simpler:
it *only* needs to test the length. Create a new determinator. And then set
`$actualSize` to `$determinator->getLengthFromSpecification($spec)`.

[[[ code('be22193c2e') ]]]

To make sure this is within the range, add `$this->assertGreaterThanOrEqual()`.
Oh wait! No auto-completion! Bah! Extend `TestCase`!

[[[ code('ab017706c4') ]]]

*Now* add `$this->assertGreaterThanOrEqual()` with `$minExpectedSize` and `$actualSize`.
You need to read this... backwards: this asserts that `$actualSize` is greater than
or equal to `$maxExpectedSize`.

Repeat that with `$this->assertLessThanOrEqual()` and `$maxExpectedSize, $actualSize`.

[[[ code('0ec9ad7978') ]]]

## Adding the Length Data Provider

The *real* work is done in the data provider. Add `public function getSpecLengthTests()`.
If you look at `DinosaurFactoryTest`, the `getSpecificationTests()` already has great
examples. Copy those, go back to the new test, and paste. We need *almost* the same
thing: just change the comments to specification, min length and max length. 

Then, for a large dinosaur, it should be between `Dinosaur::LARGE` and `DINOSAUR::HUGE - 1`.
For a small dinosaur, the range is 0 to `Dinosaur::LARGE - 1`. Copy the large dino
range and use that for the last one too,

[[[ code('18b6a76864') ]]]

We can *also* move the huge dinosaur tests here. Copy them, move back, and paste!
This time, the range should be `Dinosaur::HUGE` to 100. Copy that and use it for
all of them.

[[[ code('3b81da6187') ]]]

And *finally*, hook this all up with `@dataProvider getSpecLengthTests()`. I'll
even fix my typo!

[[[ code('a612de89e2') ]]]

Perfect! Because we deleted some code, the `DinosaurFactory` is temporarily broken.
So let's execute *just* this test:

```terminal
./vendor/bin/phpunit tests/AppBundle/Service/DinosaurLengthDeterminatorTest.php
```

It passes!

## Refactoring to use a Dependency

Time to fix the factory and get those dinosaurs growing again! The
`getLengthFromSpecification()` method is gone. To use the new determinator class,
use dependency injection: add `public function __construct()` with a `DinosaurLengthDeterminator`
argument. I'll press alt+enter and select "Initialize fields" as a shortcut to create
the property and set it below.

[[[ code('8e2a72e21d') ]]]

Back in `growFromSpecification()`, use `$this->lengthDeterminator` to call the
method.

[[[ code('f25f20ba30') ]]]

And... that's it! We haven't run the tests yet, but this class now *probably* works
again. You need to pass in a dependency, but as long as you do that, it's all basically
the same.

Run *all* the tests:

```terminal-silent
./vendor/bin/phpunit
```

Woh! That is a *lot* of failures - all with the same message:

> Too few arguments passed to `DinosaurFactory::__construct()` on `DinosaurFactoryTest`
> line 18.

Scroll up to line 18. Of course: we're missing the constructor argument to the factory
in our test.

For the *second* time, we have *dependent* objects. The object we're testing -
`DinosaurFactory` - is *dependent* on another object - `DinosaurLengthDeterminator`.
We're going to fix this with a *mock*.
