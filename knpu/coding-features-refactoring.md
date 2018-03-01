# Coding, Adding Features, Refactoring

Ok, let's code! And remember: don't over-think things: just focus on getting each
test to pass. Let's start with the *second* test, the default values.

## Attacking Test #1

Inside `DinosaurFactory`, I'll paste a few default values: we'll use `$codeName`
as the genus, because these are *experimental* dinosaurs, set the `$length` to be
a small dinosaur, and create leaf-eating friends.

[[[ code('d0b36a05e2') ]]]

Yep, with these values, our second test should be happy. Finish the function:
`$dinosaur = $this->createDinosaur()` with `$codeName`, `$isCarnivorous` and `$length`.
Then, return `$dinosaur`. Oh... and it doesn't really matter... but let's move this
function up: I like to have my *public* functions *above* private ones.

[[[ code('6946e9ce72') ]]]

Ok, that should be enough to get *one* test to pass. Run 'em:

```terminal-silent
./vendor/bin/phpunit
```

Yes! Failure... *dot*... failure.

## Attacking Test #2

Keep going! Let's work on the *last* test next: if the spec has the word *large*
in it, it should be a large dinosaur. That's easy enough: inside the method: use
`stripos` to check if the `$specification` contains `large`. Because if it *does*...
we need a bigger length! Generate a random number between the `LARGE` constant and
100... which would be a *horrifyingly* big dinosaur.

[[[ code('8ab52099db') ]]]

And *just* like that, another test passes!

## Attack Test #3

This is fun! It's like, every time I write a line of code, Sebastian Bergmann is 
*personally* giving me a high five!

Ok, the *last* test is one where the spec includes the word `carnivorous`. What's
the *quickest* way to get this test to pass? Just copy the `if` statement, paste
it, change the string to `carnivorous` and set `isCarnivorous` to `true`.

[[[ code('2f6b80c829') ]]]

And now... thanks to the *power* of TDD... they *all* pass! That felt *great*.

## We Want HUGE Dinosaurs

And management already *loves* this feature. But... they don't think the dinosaurs
are *big* enough. Now, they want to use the word "huge" to grow mouth-gaping dinosaurs!
They've gone mad!

No problem! Thanks to the power of data providers, we can just add more test cases!
Or... if you feel like this method is already doing enough, you can create another
test. Let's do that: `testItGrowsAHugeDinosaur()` with *only* a `$specification`
argument. Grow the dino with `$dinosaur = $this->factory->growFromSpecification()`.
Then, check to make sure it's *huge* with `$this->assertGreaterThanOrEqual()`.

[[[ code('9d41e96c00') ]]]

Oh, but we need to define what *huge* means. Back in `Dinosaur`, add `const HUGE = 30`.
And management decided to make the large dinosaurs a bit smaller - set `LARGE`
to 10.

[[[ code('80f3141a2e') ]]]

Use the constant in the test and compare it with `$dinosaur->getLength()`.

[[[ code('3be90129cc') ]]]

## Huge Data Provider

With the test function done, create the data provider: `getHugeDinosaurSpecTests()`.
Just like before, make this return an array. Each individual test case will *also*
be an array like last time, but now with only one item inside. Test for `'huge dinosaur`,
then also `huge dino`, just the word `huge` and, of course, `OMG` and... the scream
Emoji!

[[[ code('7f144e3956') ]]]

Back on the test method, connect it to the provider: `@dataProvider getHugeDinosaurSpecTests`.

[[[ code('1070537026') ]]]

Ok, let's watch some tests fail! Go Sebastian go!

```terminal-silent
./vendor/bin/phpunit
```

Beautiful failures! Five new test cases and five new failures. Time to code!

In `DinosaurFactory`, this method is going to start getting ugly... but I don't care!
Remember, our main job is to get the tests to pass, *not* to write really fancy code.
TDD helps keep us focused.

First, update the `large` if statement to make sure it creates large, but not
HUGE dinosaurs. We could have updated our test *first* before making this change.

[[[ code('08bbc838a1') ]]]

Now, let's handle the HUGE dinos. Copy the `large` if statement, change the search
text to `huge`, and generate a length between `HUGE` and 100.

[[[ code('2100b82a42') ]]]

Run the tests!

```terminal-silent
./vendor/bin/phpunit
```

Easy! 3 of the 5 already pass: just OMG and the screaming Emoji left! Copy the `huge`
if statement and paste two more times. Use `OMG` on the first and the screaming Emoji
for the second.

[[[ code('8d4eca0cc5') ]]]

I know... there's *so* much duplication! It's *so* ugly. But... I don't care! I
love it because the tests *do* pass!

## Refactoring our Ugly Code

And *that* means we've reached step 3 of TDD: refactor! I don't *actually* love
ugly code - it's just that it wasn't time to worry about it yet. TDD helps you focus
on writing your business logic correctly *first*, and *then* on improving the code.

So let's makes this better. Actually, if you downloaded the course code, then you should
have a `tutorial/` directory with a `DinosaurFactory.php` file inside. Copy the
`private function` from that file, find *our* `DinosaurFactory`, and paste at
the bottom.

[[[ code('172d42eac9') ]]]

This is still a bit complex, but it removes the duplication and makes the length
calculation more systematic. Copy the method name, scroll up, delete *all* that
ugly length logic... and just say `$length = $this->getLengthFromSpecification($specification)`.

[[[ code('36141b7bee') ]]]

My new code *probably* doesn't contain any bugs... but you should *totally* not
trust me! I mess up all the time! Just run the tests.

```terminal-silent
./vendor/bin/phpunit
```

Ha! It works! And you doubted me....

Next! What if you need to test that a method throws an *exception* under certain
conditions? Like... if you try to put a T-Rex in the same enclosure as a nice,
friendly Brontosaurus. Let's find out!
