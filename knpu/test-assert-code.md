# Tests, Assertions & Coding

So... we don't really have much code to test yet! That might feel weird: when I
started testing, I wanted to write the code first, and *then* test that it worked.

But actually, you can do it in the *opposite* order! There's a hipster methodology
called Test Driven Development - or TDD - that says you should write the *tests*
first and *then* your code. We'll talk more about TDD in a few minutes.

## Imagining Your Future Code

But yea! That's what we're going to do. We need to use our imagination. Let's
imagine that in the `Entity` directory, we're going to need a `Dinosaur` class.
And each `Dinosaur` will have a length property, along with `getLength()` and `setLength()`
methods. So, in `DinosaurTest`, we might want to test that those methods work
correctly.

Actually, testing getter and setter methods is not something I *usually* do in
my code... because they're *so* simple. But, it's a *great* place to get started.

## Test Directory Structure

Oh, and *now* it might be a bit more obvious *why* we called this class `DinosaurTest`
and put it in an `AppBundle/Entity` directory. As a best-practice, we usually make
our `tests/` directory match the structure of `src/`, with one test class per source
class. But not all classes will need a test... and there will be some exceptions when
we talk about integration and functional tests!

## Testing getLength & setLength

Ok, let's test! Create a new `public function testSettingLength()`. The method
needs to start with `test`, but after that, give it a clever description that will
help you recognize what the method is supposed to do.

[[[ code('e76c4a7db8') ]]]

Now, even though we *don't* have a `Dinosaur` class, we're going to *pretend* like
we do. Ok... `$dinosaur = new Dinosaur()`. Then, `$this->assertSame()` that zero
is `$dinosaur->getLength()`.

[[[ code('692f4f14dc') ]]]

## We <3 Assertions

This tests that - if we don't set a length - it defaults to 0. PHPUnit has a *ton*
of these `assert` functions. Google for "PHPUnit Assertions" to find an appendix
that talks *all* about them. I'd say there is a plethora of them and you'll learn them
as you go, so no need to memorize all of these. There will *not* be a pop quiz at the
end.

For `assertSame()`, the first argument is the *expected* value and the second is
the *actual* value. `assertSame()` is *almost* the.... same as the *most* popular
assert function: `assertEquals()`. The only difference is that `assertSame()` also
makes sure the *types* match.

And honestly, you could just use `$this->assertTrue()` for *everything*:
`0 === $dinosaur->getLength()`.

But, using *specific* assert methods will give you better error messages when things
fail.

## Coding & Testing

Set the length: `$dinosaur->setLength(9)`. And then assert that it equals 9.

[[[ code('aa3cff502a') ]]]

Perfect! Our test is done! I know... kinda strange, right? By writing the test first,
it forces us to think about *how* we want our `Dinosaur` class to look and act...
instead of just diving in and hacking it together.

We *know* the test will fail, but let's try it anyways! Run:

```terminal
./vendor/bin/phpunit
```

Yay!

## Adding the Dinosaur Entity

Time to make that test pass! If you downloaded the course code, then you should have
a `tutorial/` directory with a `Dinosaur` class inside. Copy that and paste it
into the *real* `Entity` directory.

[[[ code('cbe858e9ed ') ]]]

This is just a simple class with a `length` property. It *does* have Doctrine annotations,
but that's not important! Sure, we will *eventually* be able to save dinosaurs to
the database, but our test doesn't care about that: it just checks to make sure
setting and getting the length works.

Let's add those methods: `public function getLength()` that returns an int. And
`public function setLength()` with an int argument. Set the `length` property.

[[[ code('a6e7836d8d') ]]]

Back in `DinosaurTest`, add the `use` statement. Ah, PhpStorm is as happy as a
raptor in a kitchen!

[[[ code('17f8b906c5') ]]]

Ok, find your terminal and... test!

```terminal-silent
./vendor/bin/phpunit
```

Yes! Celebration time! This is our very *first* - of *many* passing tests!

## Testing for Bugs

Let's add one more quickly: imagine that a bug has been reported! Gasp! People are
saying that if they create a `Dinosaur` of length 15, by the time it is born and
grows up, it's smaller than 15! The dinos are shrinking! Probably a good thing.

Let's add a test for this: `public function testDinosaurHasNotShrunk`. Start the
same as before: `$dinosaur = new Dinosaur()`, and `$dinosaur->setLength(15)`.

[[[ code('8a44c84aa6') ]]]

And *just* to make things more interesting, imagine that it's OK if the dinosaur
shrinks a little bit... it just can't shrink *too* much. The guests want a thrill! 
In other words, `$this->assertGreatherThan(12, $dinosaur->getLength())`. 

[[[ code('e06f1044f5') ]]]

You can also add an optional message as the last argument to *any* assert function.
This will display when the test fails... which can sometimes make debugging easier.

Ok, try the test!

```terminal-silent
./vendor/bin/phpunit
```

Because our code is *actually* perfect, it passes! But if you make it fail temporarily
and run the test again... there's our message, along with the normal failed assertion text.

Hey! In just a few minutes, we wrote our first test and *even* used test-driven
development! It's time to learn more about that... and all the different *types*
of tests you can write.
