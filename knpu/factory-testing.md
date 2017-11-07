# Factory Testing

Ok: our dinosaur park is going to be *huge*! Like, dinosaurs *everywhere*. So we
can't keep creating dinosaurs by hand. Nope, we need a `DinosaurFactory`!

You guys know the drill: start with the test. I think the *class* should eventually
live in a `Factory` directory, so create a `Factory` folder inside `tests`. Then,
add a new PHP class. But, wait! PhpStorm isn't auto-filling the namespace. That's
annoying!

Let's fix it! Go into the PhpStorm Preferences and search for Composer. Ah, find
the Composer section. This is a really cool feature - I don't know why it's not
enabled by default. Click to select your `composer.json` path, and then make sure
the "Synchronize IDE Settings" check box is checked.

Woh! The entire `tests/` directory just turned green... like a dinosaur! PhpStorm
reads the `autoload-dev` section of `composer.json` and *now* knows what namespace
to use. Create a new PHP class again: `DinosaurFactoryTest`. 

Make it extend the usual `TestCase` from PHPUnit. And add a new method:
`public function testItGrowsAVelociraptor()`.

## Planning the Design

Ok, let's think about the *design* of this new class. There are a few dinosaurs
that people just *love* - like velociraptors, tyrannosaurus and triceratops. To
grow those quickly, I think it would be cool to add methods on `DinosaurFactory`
like `growVelociraptor()`. Each method would already know the correct genus name
and `isCarnivorous` value... so the *only* argument we need is `$length`.

## Add the Test

Awesome! Let's start using this imaginary class. First, create it:
`$factory = new DinosaurFactory()`. Then, `$dinosaur = $factory->growVelociraptor()`
and pass in the length.

Next, add some basic checks: `$this->assertInstanceOf()` to make sure that
this returns a `Dinosaur::class` instance. We can also use `$this->assertInternalType()`
to make sure that a `string` is what we get back from `$dinosaur->getGenus()`.

Let's also check that value exactly - it should match `Velociraptor`. And
make sure that 5 is the length.

Perfect! There's one cool thing you may not have noticed: we're now *indirectly*
testing some of the methods on `Dinosaur`. Yep, if we have a bug in `getGenus()`
or `getLength()`, we'll discover that here... even if we don't have a test *specifically*
for them. This is a good thing to keep in mind when trying to decide what to test.
Sure, having a specific test for `getLength()` is the *strongest* way to ensure
it keeps working. But since that method is pretty simple... *and* since it's indirectly
tested here, that's more than enough in a real project.

Ok, step 1 of TDD is done! Let's run the test to make sure it fails:

```terminal-silent
./vendor/bin/phpunit
```

## Coding up DinosaurFactory

Yes! Let's code! Create the new `Factory` directory, then the class inside:
`DinosaurFactory`. With TDD, writing the code is easy: we already know the method's
name, its arguments and *exactly* how it should behave. Add `public function growVelociraptor`.
We know this needs a `$length` argument and that it will return a `Dinosaur` object.

Create the new `Dinsaur` object inside and pass it `Velociraptor` and true for
the `isCarnivorous` argument. Set the length to `$length` and return that fresh,
terrifying dinosaur!

Back in `DinosaurFactoryTest`, add the `use` statement for the new class.

Ok, run the tests!

```terminal
./vendor/bin/phpunit
```

Woh! It fails! 

> Undefined method Dinosaur::getGenus()

That makes sense! And PhpStorm was trying to warn us. This is actually really cool:
TDD helps you to think about what methods you need and what methods you do *not*
need. We *could* have automatically added getter and setter methods for every property
in `Dinosaur`. But, that's totally unnecessary! Less methods means less opportunity
for bugs: only add methods when you need them.

Add the `getGenus()` method and return that property. Try the tests again:

```terminal-silent
./vendor/bin/phpunit
```

They pass!

## Refactor!

And that means it's time to refactor! Since we're going to eventually create a
*lot* of dinosaurs, let's create a new private function called `createDinosaur()`
with three arguments: `$genus`, `$isCarnivorous` and `$length`.

Use those on the `new Dinosaur()`.

Above in `growVelociraptor()`. return `$this->createDinosaur()` and pass
`Velociraptor`, `true` and the length.

And because this has a test, *it* will tell us if we made any mistakes. But I
doubt that... try the test!

```terminal-silent
./vendor/bin/phpunit
```

Explosion!

> Return value of DinosaurFactory::growVelociraptor must be a dinosaur: null returned

Whooops. I forgot my return value. Let's even add a return-type for that method.

This is the power of test-driven development... and testing in general.

```terminal-silent
./vendor/bin/phpunit
```

*Now* the tests pass.

Next, let's talk about a few *hooks* in PHPUnit that we can use to organize our
test setup.
