# Exceptions Part 2: Adding Fence Security

Dinosaurs, check! Enclosures, check! But... we forgot to add *security* to the
enclosures! Ya know, like *electric* fences! Dang it, I *knew* we forgot something.
The dinosaurs have been escaping their enclosure and... of course, terrorizing the
guests. The investors are not going to like this...

Inside `Enclosure`, add a new `securities` property: this will be a collection of
`Security` objects - like "fence" security or "watch tower". We'll create that class
in a minute. Anyways, if this collection is *empty*, there's no security! So we
*cannot* let people put dinosaurs here.

[[[ code('d9f05a061d') ]]]

Let's create another custom exception class: `DinosaursAreRunningRampantException`.
This time, make sure it extends `\Exception`.

[[[ code('91aecb41d3') ]]]

Perfect!

## Testing the Dinosaurs don't Run Ramptant

Inside `EnclosureTest`, add a new method: `testItDoesNotAllowToAddDinosToUnsecureEnclosures`.
And yea... this is pretty simple: just create the `new Enclosure()`, and then add
the dinosaur. But first, this time, I want to test for the exception *class* and
exception message. You can do *both* via annotations, or right here with
`$this->expectException(DinosaursAreRunningRamptantException::class)` and
`$this->expectExceptionMessage('Are you craaazy?!?')`.

Below that, add a `new Dinosaur()`.

[[[ code('5e2137021a') ]]]

Nice! Except... yea... this is going to make *all* of our tests fail: none of those
Enclosures have security. Let's worry about that later: focus on *this* test.

In fact, copy the method name and find your terminal. To avoid noise, I want to
run *only* this *one* test. You can do that with `./vendor/bin/phpunit --filter`
and then the method:

```terminal-silent
./vendor/bin/phpunit --filter testItDoesNotAllowToAddDinosToUnsecureEnclosures
```

Awesome! One test and one failure. We'll talk more about `--filter` soon!

## Adding the Security Class

Ok, step 2 of TDD: code! First, we need a `Security` class. If you downloaded the
course code, you should have a `tutorial/` directory with a `Security` class inside.
Paste that into our `Entity` directory.

[[[ code('4a1d8f2106') ]]]

It's pretty simple: it has a `name`, an `isActive` boolean and a reference to the
`Enclosure` it's attached to.

Speaking of `Enclosure`, initialize its `$securities` property to a `new ArrayCollection`.
Oh, and on the property, add `@var Collection|Security[]`.

[[[ code('e1cf1d17fa') ]]]

Really, this will be a `Collection` instance. But the `Security[]` part tells our
editor that this is a collection of *Security* objects. And that will give *us*
better auto-completion. Which we can only enjoy if we get this dino security going,
so let's get to it!

## Throwing the Exception

Down in `addDinosaur()`, we need to know if this `Enclosure` has at least *one*
active security. Add a method to help with that: `public function isSecurityActive()`.
I'm making this public *only* because I already know I'm going to use it later
outside of this class.

Set this to return a `bool` and then loop! Iterate over `$this->securities` as `$security`.
And if `$security->getIsActive()`, return `true`. If there are *no* active securities,
run for your life! And also return `false` at the bottom.

[[[ code('0cea42fef6') ]]]

Finish things in `addDinosaur()`: if not `$this->isSecurityActive()`, throw
a new `DinosaursAreRunningRampantException()`. And remember, we're checking for an
exact message: so use the string from the test.

[[[ code('db03791d38') ]]]

Ok, I think we're done! Go tests go!

```terminal-silent
./vendor/bin/phpunit --filter testItDoesNotAllowToAddDinosToUnsecureEnclosures
```

Yes! It's now *impossible* to add a `Dinosaur` to an Enclosure... unless there's
some security to keep it inside.

## Adding Annotations

We've reached the *third* step of TDD once again: refactor. Actually, I don't need
to refactor, but now is a *great* time to add the missing Doctrine annotations.
Above the `$securities` property, add `@ORM\OneToMany()` with `targetEntity="Security"`
and `mappedBy="enclosure"`. `enclosure` is the name of the property on the other
side of the relation. Finish it with `cascade={"persist"}`.

[[[ code('a5e895210b') ]]]

Ok, this *one* test still passes... but what about the rest? Run them:

```terminal
./vendor/bin/phpunit
```

Ah! We have *so* many `DinosaursAreRunningRampantException` errors! Yep, we knew
this was coming: our *existing* tests need security.

To make this easy, inside `Enclosure`, add a `bool $withBasicSecurity` argument.
Then, if this is true, let's add some basic security! `$this->addSecurity()` - we'll
create this method next - `new Security('Fence', true)` - for `isActive` -
and then `$this` for the Enclosure.

[[[ code('2246f542e0') ]]]

Add the missing method `public function addSecurity()`, append the securities array
and... we're done!

[[[ code('a69b7b9dec') ]]]

Inside `EnclosureTest`, the first test method does *not* need security: it never
adds any dinosaurs. But the next three do: pass `true`, `true` and `true`.

[[[ code('99c7a5f151') ]]]

Let's do the tests!

```terminal-silent
./vendor/bin/phpunit
```

Yes! This is *amazing*! We just created a dinosaur park *with* security. What a
novel idea!
