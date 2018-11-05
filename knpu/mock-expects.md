# Mocks: expects() Assert Method is Called Correctly

Go back to `DinosaurFactory`. Time to create another bug! Comment out the length
line again. This time, *do* call the method... but instead of the spec, just pass
`foo`. Whoops! We're calling the right method... but we've passed the wrong argument!

What happens to the tests?

```terminal-silent
./vendor/bin/phpunit
```

Yep... they pass! *If* this possibility frightens you more than the sound of raptor
claws on the door... We can also cover this in the test.

In addition to saying that `getLengthFromSpecification()` should return 20, you
can *also* say that the method must be called exactly *once* or with some *exact*
arguments. Then, if the method is *not* called once or is called with different
arguments, the test will *fail*.

Move the `method()` call onto the next line. Then add `->expects($this->once())`.
The method must *now* be called *exactly* once.

[[[ code('0da3213364') ]]]

Then, after `method()`, add `->with($spec)`. This `with()` function is pretty sweet:
if the real method accepts three arguments, then you'll pass those three arguments
to `with()`. In this case, if the value passed to the first argument of
`getLengthFromSpecification()` does *not* match `$spec`, the test will fail.

[[[ code('1a62bf21b3 ') ]]]

This *should* finally kill the test. Try it!

```terminal-silent
./vendor/bin/phpunit
```

Yes! Failure because, for `getLengthFromSpecification()`, `large herbivore` does
not match the actual value: `foo`.

Awesome! Move back to `DinosaurFactory`, and re-fix the length line. Double-check
that this fixes things. It does!

[[[ code('fd49228939') ]]]

This is *really* cool stuff. But you should *not* use it everywhere. Remember:
at this point, we're really testing how the internal code of the method is written.
The more we do this, the more often the tests will break when really... they shouldn't.
Basically, we're micro-managing our own code!

For example, what if we refactor the method and decide to call `getLengthFromSpecification()`
two times? The tests will break! Sure, our code might now be a little inefficient...
but as long as we *still* create the correct Dinosaur, shouldn't the tests pass?
You need to decide how strict each test should be.

## Asserting Different Number of Method Calls

And if you *don't* care how many times a method is called, you can use
`$this->any()` instead. Back on the Test Doubles documentation, search for `once()`...
and find the next result until you see a list of "matchers". 

These are classes, but there's a shortcut to use each, like `$this->any()`,
`$this->never()`, `$this->atLeastOnce()` and `$this->exactly()`.

## Smarter Argument Asserts

You can also do a little bit of magic for the `with()` method. Go back to the docs
and search for "anything". Cool! This is an example where the method should be
called with *three* arguments. But instead of passing the exact values, we assert
that the first argument is greater than zero, the second is a string that contains
the word "Something" and we don't care *at all* what is passed as the third argument.

Search once more for `callback()`. This is the most *powerful* option: you create
your *own* callback and do whatever logic you want to determine if the argument
passed is valid.

We've got mocking down! But it's *so* important that I want to go through
one more, fully-featured and classic example.
