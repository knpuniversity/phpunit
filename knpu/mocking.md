# Mocks & Test Doubles

We're testing `DinosaurFactory`... but it *needs* a `DinosaurLengthDeterminator`!
This happened before, when the `Enclosure` required a `Dinosaur` object. In *that*
case, instead of *mocking* the `Dinosaur` object, we just created it. Remember the
rule? If the object you need is a simple *model* object, just create it. If it's
a *service*, then mock it.

Well... `DinosaurLengthDeterminator` *is* a service: it's a class that does work.
So we're going to mock it. This is pretty typical for constructor arguments, which
tend to be services.

By "mocking", I mean that we're going to pass an object that *looks* and smells like
a `DinosaurLengthDeterminator`, but... isn't. Mocks are easier to create than the
real objects, and their methods are "faked": if the *real* class queries the database
or makes API calls, the mock will do nothing.

## Creating the Mock Object

Let's do it! `$mockLengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class)`.
Pass that as the first argument.

[[[ code('6a4fc18e22') ]]]

Before we talk about this, find your terminal, and run the tests:

```terminal-silent
./vendor/bin/phpunit
```

Whoa! They still fail... but the error message is different: failed asserting that
0 is equal to 10 or greater than 10. Find line 81 of the test. Oh, this 0 is actually
referring to `$dinosaur->getLength()`.

So... interesting... all the dinosaur lengths are being set to zero. Here's why:
when you create a mock, it creates a new class in memory that extends the original,
but overrides *every* method and simply returns `null`. That means, when we call
`getLengthFromSpecification()`, it does *not* execute this code. Nope, this function
in the mocked class returns null.

Well, actually, that's not *entirely* true. In this case, the length is 0. That's
thanks to the return type on the method. But basically, all the methods return "nothing".
A mock is a "zombie" version of the original object.

## The Mock Builder

I'll hold command and click `createMock()` to see that function. Behind the scenes,
mocks are created with a mock *builder*. And sometimes, you'll want to use *that*
instead, because it gives you a bit more control. As you can see, by default, the
constructor is skipped when creating the mock... which is pretty sweet, because you
*don't* need to worry about the constructor arguments of a class.

Also, by default, *all* methods are mocked. But you can use the `setMethods()` function
to only mock *some* methods.

By the way, the most common word you're going to hear for this object is a *mock*.
But technically, there are a number of different terms: dummies, stubs, spies and
mocks. They all mean *slightly* different things. And technically, what we've created
is a *dummy*... which is just a bit insulting!

Anyways, if you want to learn what these terms *really* mean, you can check out a
series of articles written by Andrew, our course co-author at this link:
http://www.ifdattic.com/dummy-test-double-using-prophecy/.

Anyways, I'll use the word *mock* to keep things simple.

## Removing the Length Tests

Ok, back to the test. By creating the mock, we fixed the original error. But now,
all of the length tests are failing! But... wait a second. In a unit test, we should
*only* worry about testing the logic of `DinosaurFactory`. And... well... `DinosaurFactory`
no longer has *any* logic related to lengths! That calculation is done - and *tested* -
in `DinosaurLengthDeterminator`!

In other words, we shouldn't even be *testing* the length! Completely delete the
"huge" test. For the *other* spec test, we *do* still need to check that the `isCarnivorous`
logic is correct, but we don't need the length stuff! Remove the second argument:
`expectedIsLarge`. And then remove the asserts for it.

[[[ code('516025ae0c') ]]]

In the data provider, remove the second argument from each test case.

[[[ code('52d6d63e4f') ]]]

Try the tests again!

```terminal-silent
./vendor/bin/phpunit
```

Woh! They're fixed! The tests *pass*! And this wasn't a hack: our test is now
*correctly* only worried about testing the logic inside the factory class itself.

But! There's a lot more you can do with mocks - they're not *just* dummy objects.
They can be trained!
