# TDD in Practice

Let's put TDD in practice!

I want to add a new `getSpecification()` method to the `Dinosaur`
class that will return a string description - like:

> Velociraptor carnivorous dinosaur is 5 meters long

TDD says: write that test first! Add `public function testReturnsFullSpecificationOfDinosaur()`.
Create a new dinosaur, but don't set any data on it. Let's test the default string:
`Unknown non-carnivorous dinosaur is 0 meters long` should equal `$dinosaur->getSpecification()`.

Test done! Step 2 is to write the *minimum* amount of code to get this test to pass.
In `Dinosaur`, add `public function getSpecification()`. What's the smaller amount
of code we can write? I know! Return the hardcoded string!

Genius! Ok, try the test!

```terminal
./vendor/bin/phpunit
```

Ha! It passes! The third step to TDD is refactor... but I don't think we need to
in this case.

Wait, what? You don't like my hardcoded stirng? I know, returning a hardcoded string
is *silly*... and I don't do this in real life. But it highlights an important thing
with TDD: keep your code simple. Don't make it unnecessarily fancy or cover unnecessary
use-cases. If you *do* have an edge-case you want to cover, add the test first,
*then* code for it.

## Adding another Case

Actually, let's do that now: add a new test method: `testReturnsFullSpecificationForTyrannosaurus`.
Ok, I want each `Dinosaur` to have a *genus* - like Tyrannosaurus - and a flag that
says whether or not it's carnivorous. These will be used in `getSpecification()`.
Create a `new Dinosaur()` and pass `Tyrannosaurus`, and `true` for carnivorous...
because T-Rex's love to eat people.

Set its length to 12. This time, the specification should be:

> Tyrannosaurus carnivorous dinosaur is 12 meters long

## Finishing getSpecification()

Ok, test done! Let's write the code! Start in `Dinosaur`: I'll add a `__construct()`
method with a `$genus = 'Unknown` argument  and `$isCarnivorous = false`. Add these
two properties to the class. I'll go to Command -> Generate - or press Command+N
on a Mac - and select "ORM Annotations" to add annotations above each method. We
don't technically need those right now... but it'll save us time later.

Down in the constructor, set both properties to their values. The default values
for each argument match our first test.

In `getSpecification()`, we can't really fake things anymore. Return `sprintf()`
and the original string, but replace the variable parts with `%s`, `%s` and `%d`.

Then pass `$this->genus`, `$this->isCarnivorous` to print `carnivorous` or `non-carnivirous`,
and then `$this->length`.

Perfect! Find your terminal and run the tests!

```terminal-silent
./vendor/bin/phpunit
```

Passing! Ok, step 3! Refactor! And this time... I will! Let's include the word
`carnivorous` in the string. Then below, just print `non-` when needed. I don't even
need to *think* about whether or not I made any mistakes. Just run the tests!

```terminal-silent
./vendor/bin/phpunit
```

I love it! Testing gives you *confidence*!

Next! Let's create a `DinosaurFactory` - because that sounds *awesome* - test it,
and learn about some PHPUnit hooks.
