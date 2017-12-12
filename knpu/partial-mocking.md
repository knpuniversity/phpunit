# Partial Mocking

There's *one* more cool thing I want to show you with integration tests. It's kind
of a weird, unnatural mixture of unit tests and integration tests. I love it! I
call it partial mocking.

Right now, we're fetching the `EnclosureBuilderService` from the container. But
there's another option. Instead, create it manually - `new EnclosureBuilderService()` -
and pass in the dependencies manually. For example, pass `$this->getEntityManager()`
as the first argument.

[[[ code('56b74263af') ]]]

*Why* would we do this? It seems like more work! Because... if it's useful, we could
*mock* certain dependencies. Yep! Instead of fetching the `DinosaurFactory` from
the container, mock it: `$dinoFactory = $this->createMock(DinosaurFactory::class)`.

[[[ code('095a65414b') ]]]

Then, `$dinoFactory->expects($this->any())` - we don't really care - with
`->method('growFromSpecification')` and `->willReturn(new Dinosaur())`.

[[[ code('9e4b0d655c') ]]]

Pass *this* as the second argument. This isn't *particularly* useful in this situation.
But sometimes, being able to mock - and *control* - one or two dependencies in an
integration test is *really* awesome! 

[[[ code('f2b41940ee') ]]]

Ok, try the test!

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

Oh man! It fails! Weird! There is only 1 Dinosaur... but there should be 3! What's
going on? This is subtle: PhpUnit is smart enough to take this *one* dinosaur object
and return it each time `growFromSpecification()` is called. But to Doctrine, it
looks like we're asking it to save the same *one* `Dinosaur` object: not three *separate*
dinosaurs. The result would be a less than thrilling theme park.

The fix is to change this to `willReturnCallback()` and pass it a function. This
will be called each time `growFromSpecification()` is called. And since it is passed
a `$specification` argument, the callback also receives this. It's the best way to
return different values based on the arguments.

[[[ code('a047991a5a') ]]]

We don't need that in this case. We'll just say `return new Dinosaur()`. And that's
it! Try the tests again.

[[[ code('0ca16c4b9a') ]]]

```terminal-silent
./vendor/bin/phpunit --filter testItBuildsEnclosureWithTheDefaultSpecification
```

We got it! So integration tests are one of my favorite, favorite, *favorite* things
because they're *very* pragmatic. When I think about testing a class, here's the
logic I follow:

1. Does this class scare me? If the logic is simple, I don't test it. I *will*
   still make sure the new feature works through manual testing. And often,
   that's enough.

2. Can I unit test this class? If I mock all of the dependencies, is the scary logic
   still testable? For `DinosaurFactory`, the answer was yes: we mocked the
   `DinosaurLengthDeterminator`, but we were still able to test that the specification
   string is parsed correctly to create carnivorous and non-carnivorous dinosaurs.

3. If the class cannot be unit tested, then I write an integration test. This is
   pretty common in my apps: each individual "unit" is often pretty simple. But when
   you integrate them all together, that's scary enough to need a test.

Ok, on to functional testing!
