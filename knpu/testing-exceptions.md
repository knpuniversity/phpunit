# Testing Exceptions

The dinosaur enclosures are looking *great*. There's just one *minor* problem: people
keep accidentally putting nice, gentle veggie-eating dinosaurs into the same enclosure
as flesh-eating carnivores. The result is... well... *expensive*, and there's a
lot of cleanup too.

We need to prevent the meat eaters and the veggie eaters from being mixed inside
the same enclosure. In other words, if somebody tries to do this, we need to throw
an exception!

## The Custom Exception Class

It's optional, but let's create a custom exception class for this: `NotABuffetException`.
I'll even give this a default message: people need to understand how horrible this
is!

[[[ code('667bd9846b') ]]]

Making sure that this exception is thrown at the right time is *critical* to business.
So let's write a test: `testItDoesNotAllowCarnivorousDinosaursToMixWithHerbivores`.

Inside the method, create this terrifying situation: `$enclosure = new Enclosure()`
and `$enclosure->addDinosaur(new Dinosaur())`. By default, dinosaurs are *non-carnivorous*.
So now, let's add a predator: `new Dinosaur('Velociraptor')` and `true` for the
`isCarnivorous` argument.

[[[ code('57a2a6f870') ]]]

## Expecting an Exception

At this point, an exception *should* be thrown. So... how can we test for that?
By telling PHPUnit to *expect* an exception with... well... `$this->expectException()`
and then the exception class: `NotABuffetException::class`. Make sure you add this
*before* calling the final code.

[[[ code('018fdf90ba') ]]]

If we've done our work correctly, this should fail. Try the test!

```terminal
./vendor/bin/phpunit
```

Yes! Failed asserting that exception of type `NotABuffetException` is thrown.

Awesome! Let's go throw that exception! Inside `Enclosure`, at the bottom, add a
new `private function` called `canAddDinosaur` with a `Dinosaur` argument. This
will return a `bool`.

[[[ code('ec3c7b2a5b') ]]]

Here's some simple logic: `return count($this->dinosaurs) === 0`. So, if the enclosure
is empty, then it's *definitely* ok to add a dinosaur. Or, check to see if
`$this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous()`.
If they match, we're good!

[[[ code('b3787eaaa0') ]]]

Back in `addDinosaur()`, if not `$this->canAddDinosaur()`. Throw the exception!
Oh wait... make sure the class extends `\Exception`. My bad!

[[[ code('9ad44b270e') ]]]

*Now* throw that exception!

[[[ code('f97edca4fa') ]]]

Check the tests!

```terminal-silent
./vendor/bin/phpunit
```

Woo! We got it!

## expect Exceptions via Annotations

There's one other way to test for exceptions. It's really the same, but looks fancier.
Copy the test method and rename it so we can test for the *opposite* condition:
`testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure`. Wow that's
a long name!

[[[ code('8390ae3548') ]]]

Add the Velociraptor *first* and then remove `expectException`. Instead, add an
annotation: `@expectedException` followed by the full class. PhpStorm puts the short
name... so go copy the use statement and put it down here. Try it!

[[[ code('afc9ac3897') ]]]

```terminal-silent
./vendor/bin/phpunit
```

Yes! One more test passing.

I want to go through *one* more example next... and also add some security to the
enclosures. Our guests have been terrorized enough.
