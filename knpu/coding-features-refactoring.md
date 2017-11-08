# Coding, Adding Features, Refactoring

Ok, let's code! And remember: don't over-think things: just focus on getting each
test to pass. Let's start with the *second* test, for the default values.

## Attacking Test #1

Inside `DinosaurFactory`, I'll paste a few default values: we'll use `$codeName`
as the genus, because these are *experimental* dinosaurs, set the `$length` to be
a small dinosaur, and create veggie-eating friends.

Yep, with these values, our second test should be happy. Finish the function:
`$dinosaur = $this->createDinosaur()` with `$codeName`, `$isCarnivorous` and `$length`.
Then, return `$dinosaur`. Oh... and it doesn't really matter... but let's move this
function up: I like to have my *public* functions *above* private ones.

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

And *just* like that, another test passes!

## Attack Test #3

This is fun! It's like, every time I write a line of code, Sebastian Bergmann is 
*personally* giving me a high five!

Ok, the *last* test is one where the spec includes the word `carnivorous`. What's
the *quickest* way to get this test to pass? Just copy the `if` statement, paste
it, change the string to `carnivorous` and set `isCarnivorous` to `true`.

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

Oh, but we need to define what *huge* means. Back in `Dinosaur`, management wants
add `const HUGE = 30`. Oh, and management decided to make the large dinosaurs a
bit smaller - set `LARGE` to 10.

Use the constant in the test and compare it with `$dinosaur->getLength()`.

## Huge Data Provider 😱

With the test function done, create the data provider: `getHugeDinosaurSpecTests()`.
Just like before, make this return an array. Each individual test case will *also*
be an array like last time, but with only one string inside. Test for `'huge dinosaur`,
then also `huge dino`, just the word `huge` and, of course, `OMG` and the scream
Emoji! 

Back on the test method, connect it to the provider: `@dataProvider getHugeDinosaurSpecTests`.

Ok, let's watch some tests fail! Go Sebastian go!

```terminal-silent
./vendor/bin/phpunit
```

Beautiful failures! Five new test cases and five new failures. Time to code!

In `DinosaurFactory`, this method is going to start getting a little ugly... but
that's OK for now! Remember, our job is to get the tests to pass, *not* necessarily
to write really fancy code. TDD helps keep us focused.

First, update the `large` if statement to make sure this creates large, but not
HUGE dinosaurs. We could have updated our test *first* before making this change.

Now, let's handle the HUGE dinos. Copy the `large` if statement, change the search
text to `huge`, and generate a length between `HUGE` and 100.

Run the tests!

```terminal-silent
./vendor/bin/phpunit
```

Easy! 3 of the 5 tests already pass: just OMG and a screaming Emoji left! Copy
the `huge` if statement and paste two more times. Use `OMG` on the first and the
screaming Emjoi for the second.

I know... there's duplication and it's ugly. But... I don't care! I love it because
the tests *do* pass!

## Refactoring our Ugly Code

And *that* means we've reached step 3 of TDD: refactor! I don't *actually* love
my ugly code - it's just that it wasn't time to worry about it yet. TDD helps
you focus on writing your business logic correctly *first*, and *then* on improving
the code.

So let's improve this. Actually, if you downloaded the course code, then you should
have a `tutorial/` directory with a `DinosaurFactory.php` file inside. Copy the
`private function` from that file, find *our* `DinosaurFactory`, and paste at
the bottom.

This is still a bit complex, but it removes the duplication and makes the length
calculation more systematic. Copy the method name, scroll up, delete *all* that
ugly length logic, and just say `$length = $this->getLengthFromSpecification($specification)`.

My new code *probably* doesn't contain any bugs... but you should *totally* not
trust me! Don't you see how often I make mistakes!? Just run the tests.

```terminal-silent
./vendor/bin/phpunit
```

Ha! It works! And you doubted me....

Next! What if you want to test to make sure that a method throws an *exception*
under certain conditions? Like... if you try to put a T-Rex in the same enclosure
as a nice, friendly Brontosaurus. Let's find out!
