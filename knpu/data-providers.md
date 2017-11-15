# Data Providers!

Park management has just *dreamt* up a new, fancy feature: they want to be able
to create a new dinosaur... just by *describing* it. They want to be able to
say:

	Large friendly carnivorous dinosaur

and then, poof! Our `DinosaurFactory` will figure out *exactly* what type of dino
to grow and make it.

## New Feature, New Test

This means we need a new method in `DinosaurFactory` and *that* means we need a
test. How about: `itGrowsADinosaurFromASpecification()`, where "specification" is
the word we'll use for this "dinosaur description".

[[[ code('96da1f7756') ]]]

The API for this future method will be simple: `$dinosaur = $this->growFromSpecification()`
and pass it some string, like `large carnivorous dinosaur`. Maybe we should have included
the word 'friendly'....meh, probably not necessary.

Now, add some assertions! Like, `$this->assertGreaterThanOrEqual()` that the dinosaur
is 20 meters or longer. Actually, instead of hardcoding that value, open up the
`Dinosaur` class and add a `const LARGE = 20`. Use that inside the test.

[[[ code('62691eeb94') ]]]

Then, `assertTrue` that `$dinosaur->isCarnivorous()` and give that a custom failure
message.

[[[ code('3d46f286fb') ]]]

Ok! That's a nice-looking test! Before I even try it, let's *start* the code.
In `DinosaurFactory`, add `public function growFromSpecification()` with a string
argument. This will return a `Dinosaur`.

[[[ code('07bf1c0d41') ]]]

Now, our test looks happier... except apparently we do *not* have a `Dinosaur::isCarnivorous()`
method. That's awesome! Another example of *not* adding a method until we need
it... which is now. At the bottom of `Dinosaur`, add `public function isCarnivorous()`
and return the property.

[[[ code('0954269647') ]]]

Perfect! Our test - and even some of our *code* - is ready. Run it:

```terminal
./vendor/bin/phpunit
```

Whoo! It fails! So... time to code, right?

## Testing Many Input at Once

Well... hold on! Because... this is going to be painful! So far, we're just testing
*one* string. But this is going to be a complex function... we're going to need to
test *a lot* of specifications, like "small herbivore", "huge dinosaur" or maybe
even "tiny, adorable, flesh-eating carnivorous dino". To do that, we're going to
need to copy and paste this method, over and over again.

Unfortunately... there's no better option. Pff, kidding! Of course there is! Data
providers!

## Hello Data Providers

Data providers let you run the *same* test in a loop: passing different *arguments*
each time.

First, create a new public function called `getSpecificationTests()`. Yep, this
method does *not* start with the word `test`. That's because its job is *not* to
be a test: it's to *provide* the different test cases that we want to try.

[[[ code('d0c09ca62d') ]]]

Let's code this first: it will make more sense when you see all the pieces working
together. Return an array. Then, I'll add some comments: `specification`, `is large`
and `is carnivorous`.

Copy the specification from above. Then, inside the array, create *another* array
with that string, then `true` and `true`, because we *expect* this dinosaur to
be large and carnivorous. This will be the *first* test case: we want to test that
this spec will create a large, carnivorous dinosaur.

[[[ code('d7e435558b') ]]]

Add another item to the array with a completely ridiculous spec: `give me all the cookies!!!`.
This time, use `false` and `false`. Management told us that if they say something
crazy, the `DinosaurFactory` should *default* to creating small, herbivore dinosaurs...
which seems like a pretty safe idea.

Add one last test case: `large herbivore`, which we expect to be large `true` and
carnivorous `false`.

[[[ code('de492d6022') ]]]

## Hooking up the Data Provider

Ok! We're not done yet... but once we are, PHPUnit will call our test method one
time for *each* item in the array... so three times in total. On each call, it will
pass the values as the arguments. So add three arguments: `$spec`, `$expectedIsLarge`
and `$expectedIsCarnivorous`.

[[[ code('eb2b919440') ]]]

Pass the dynamic spec to `growFromSpecification()`. The `greaterThanOrEqual` assert
will now need to *vary*, depending on whether or not we're expecting a large or small
dinosaur. Add `if $expectedIsLarge`. In that case, use the same assert. Else, copy
that line, but use `assertLessThan()`.

[[[ code('3f6f65e751') ]]]

Finally, use `assertSame()` at the bottom to assert that `$expectedIsCarnivorous()`
matches `$dinosaur->isCarnivorous()`.

[[[ code('fa6a903d7d') ]]]

Phew! Ok, the test will *not* pass yet... but I like errors! Try the tests:

```terminal-silent
./vendor/bin/phpunit
```

> Too few arguments to testItGrowsADinosaurFromASpecification(): 0 passed and 3 expected.

That makes sense: normally, you are *not* allowed to have *any* arguments to your
test methods. But with a data provider, you can! We just need to hook it up. How?
Above the test method, add `@dataProvider getSpecificationTests`.

[[[ code('0d9d38d13c') ]]]

Woo! Now, it will call the test *three* times: once for the first data set, passing
these as the first, second and third arguments, then a second time, and a third.
Check it out:

```terminal-silent
./vendor/bin/phpunit
```

Yay! Failures! But, *3* failures! And they're labeled as `with data set #0`, `#1`
and `#2`... because us programmers like to count from 0.

This is *awesome*. Oh, and if you *want* to, you can assign an array key to any
test, like `default response` for the second test. *Now* when you run the test,
the second failure is called `default response`. I actually do this a lot - it helps
figure out *which* test is actually failing.

Now that we have our three test cases, it's time to move on to Step 2 of TDD and
make these pass one-by-one.
