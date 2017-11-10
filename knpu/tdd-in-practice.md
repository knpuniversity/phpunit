# TDD in Practice

Let's put TDD into practice!

I want to add a new `getSpecification()` method to the `Dinosaur`
class that will return a string description - like:

> Velociraptor carnivorous dinosaur is 5 meters long

TDD says: write that test first! Add `public function testReturnsFullSpecificationOfDinosaur()`.
Create a new dinosaur, but don't set any data on it. Let's test the default string:
`Unknown non-carnivorous dinosaur is 0 meters long` should equal `$dinosaur->getSpecification()`.

[[[ code('0bd829480d') ]]]

Test done! Step 2 is to write the *minimum* amount of code to get this test to pass.
In `Dinosaur`, add `public function getSpecification()`. So... what's the smallest
amount of code we can write? We can just return a hardcoded string!

[[[ code('34f2dc2197') ]]]

Genius! Ok, try the test!

```terminal
./vendor/bin/phpunit
```

Ha! It passes! The third step to TDD is refactor... which I don't think is needed
in this case.

Wait, what? You *don't* like my hardcoded string? Looks like you're missing the last
boat back to the mainland. Just kidding ... I know, returning a hardcoded string
is *silly*... and I don't do this in real life. But it shows off an important thing
with TDD: keep your code simple. Don't make it unnecessarily fancy or cover unnecessary
use-cases. If you *do* have an edge-case that you want to cover, add the test first,
and *then* code for it.

## Adding another Case

Actually, let's do that now: add a new test method: `testReturnsFullSpecificationForTyrannosaurus`.
I want each `Dinosaur` to have a *genus* - like Tyrannosaurus - and a flag that
says whether or not it likes to eat people... I mean whether or not it's carnivorous.
These will be used in `getSpecification()`. Create a `new Dinosaur()` and pass
`Tyrannosaurus`, and `true` for carnivorous... because T-Rex's *love* to eat people.

Set its length to 12. This time, the specification should be:

> Tyrannosaurus carnivorous dinosaur is 12 meters long

[[[ code('ce35dbd573') ]]]

## Finishing getSpecification()

Test done! Let's write some code! Start in `Dinosaur`: I'll add a `__construct()`
method with a `$genus = 'Unknown'` argument  and `$isCarnivorous = false`. Add these
two properties to the class. I'll go to the Code menu and then to Generate - or press 
Command+N on a Mac - select "ORM Annotations" to add annotations above each method. 
We don't technically need those right now... but it'll save time later.

[[[ code('950ccb46a6') ]]]

Down in the constructor, set both properties to their values. The default values
for each argument match our first test.

[[[ code('6e9510294c') ]]]

In `getSpecification()`, we can't really fake things anymore. Return `sprintf()`
and the original string, but replace the variable parts with `%s`, `%s` and `%d`.

Then pass `$this->genus`, `$this->isCarnivorous` to print `carnivorous` or `non-carnivorous`,
and then `$this->length`.

[[[ code('9cd9d0258c') ]]]

Perfect! Find your terminal and run the tests!

```terminal-silent
./vendor/bin/phpunit
```

Passing! Now to step 3... refactor! And this time... I will! Let's include the word
`carnivorous` in the string. Then below, just print `non-` if needed. I don't even
need to *think* about whether or not I made any mistakes. Just run the tests!

[[[ code('6182e84a63') ]]]

```terminal-silent
./vendor/bin/phpunit
```

I *love* it! Testing gives you *confidence*!

Next! Let's create a `DinosaurFactory` - because that sounds *awesome*.
