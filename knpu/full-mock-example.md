# Full Mock Example

Mocking is *so* important... and honestly... pretty fun. I think we should code through
another example. In some ways... an even *better* and more common example.

Here's the setup: we're going to need a lot of dinosaurs, a lot of enclosures and
even more security. Instead of creating these by hand *each* time a new batch of
adorable dinosaurs arrives, let's create a service that can do it all for us.

If you downloaded the source code, then in the `tutorial/` directory, you should
have an `EnclosureBuilderService` class. Copy that and paste it into our `Service`
directory. This has just one public function: you pass that number of security systems
and the number of dinosaurs, and *it* takes care of creating those security systems,
creating the dinosaurs and putting everything together inside a new `Enclosure`.

[[[ code('e0ca2be24d') ]]]

For this... we're going to cheat and *not* do TDD because... well... I *just* gave
you the code. So let's add the test: in the `Service` directory, create a new
`EnclosureBuilderServiceTest`. And inside, `public function testItBuildsAndPersistsEnclosure()`.

[[[ code('26ed5045de') ]]]

And *this* time, let's make sure it `extends TestCase` from PHPUnit. At first,
the test is pretty simple: create a `new EnclosureBuilderService()`. This has two
required constructor arguments... but let's ignore those at first and finish the
test. Add `$enclosure = $builder->buildEnclosure()` with, how about, 1 security system
and 2 dinosaurs. 

[[[ code('a2a2539c0f') ]]]

Below this, just assert that this has the right stuff: `$this->assertCount()` that
1 matches the count of `$enclosure->getSecurities()`. That method does not exist
yet. And then `assertCount()` that 2 matches the count of `$enclosure->getDinosaurs()`.

[[[ code('6e49136f40') ]]]

We *could* test more, but this is pretty good! It tests that the core functionality
works correctly. Later, if we think of some edge-case that could happen, we can
add more.

Ok, find the `Enclosure` class, scroll to the bottom, and add the missing
`public function getSecurities()`, which should return a `Collection`. Return
`$this->securities`.

[[[ code('2842ad62b0') ]]]

## Adding the Basic Mocks

Other than the missing constructor arguments, the test looks happy! But somehow,
we need to pass the builder an `EntityManagerInterface` and a `DinosaurFactory`.
These are both services, so they should be *mocked*, instead of created manually.
That becomes even *more* obvious if you think about *trying* to create these objects.
The `EntityManager` requires a database connection... and we definitely do *not*
want to instantiate all of that. And even `DinosaurFactory` *itself* requires a
`DinosaurLengthDeterminator`... so creating a new factory would take some work...
*too* much work.

You can start to see why mocking makes life so much easier.

Back in the test, add `$em = $this->createMock()`. The argument expects an `EntityManagerInterface`.
So that's what we'll use here: `EntityManagerInterface::class`. Yep, you can *totally*
mock an interface. Then add `$dinosaurFactory = $this->createMock(DinosaurFactory::class)`.

[[[ code('d007987461') ]]]

Pass both arguments into new `EnclosureBuilderService()`.

[[[ code('99ec626885') ]]]

I'm not worried about controlling the return values: I'm trying to do as little
work as possible so that the test will run and the asserts at the bottom can do
their job. It *may* turn out that we *do* need to control some return values so
that the function can run... but... let's find out! Run the tests:

```terminal-silent
./vendor/bin/phpunit
```

The test *fails*! We're expecting some actual size 1 to match 2, on line 20. For
some reason, we're only getting back *one* `Dinosaur`... even though we passed *2*
as the argument.

Open `EnlosureBuilder` and scroll down to `addDinosaur()`. Ah! There's a *bug* in
my code already! The `$numberOfDinosaurs` argument is not used: we always add just
*one* dinosaur.

That's great! The simple test caught the bug and the fix is easy.

## Asserting growFromSpecification is Called Twice

But! If we want, we could also make the test a bit tougher before fixing this. In
the test, add `$dinoFactory->expects($this->exactly(2))` and then
`->method('growFromSpecification')`.

[[[ code('f464f3396f') ]]]

We could stop here: we don't *need* to also call `->with()`. But if you *do* want
to assert that the correct argument is passed, you can. Well actually, the exact
argument is random. So the best we can do is use `$this->isType('string')`.

In practice, I think adding `with()` in this situation is a bit overkill. But it
*always* depends.

Ok, I want to see these errors! Comment out the assert at the bottom. Any test failures
from mocking will come *after* the test finishes running successfully. Try the tests!

```terminal-silent
./vendor/bin/phpunit
```

Awesome! Translating from robot-speech, this says:

> Expectation failed for method `growFromSpecification()`: we expected it to be
> called two times, but was actually called 1 time.

That's cool! Uncomment the "assert" in the test. Now, go into the service and fix
my bug! Add a `for` loop where `$i = 0; $i < $numberOfDinosaurs; $i++`. Move *all*
that dino code inside.

[[[ code('eb0508768e') ]]]

Move back to your terminal and, test!

```terminal-silent
./vendor/bin/phpunit
```

We're green! But... there's something interesting going on. *And*, our test is weak
in one important way... there's still a bug in `EnclosureBuilderService`! And our
tests are missing it!
