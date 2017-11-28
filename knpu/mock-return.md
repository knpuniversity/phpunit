# Mocks: Control the Return Value

*We* know that in `DinosaurFactoryTest`, we don't need to worry about testing the
length anymore because that's done inside DinosaurLengthDeterminator's test. Every
test class can stay focused. Which is important when there's dinosaurs running around.

But... what if we accidentally *forgot* to call the length determinator? Like, we
temporarily set the length to a hardcoded value... but forgot to fix it! Well, if
you run your tests... surprise! They pass.

If the possibility of making this mistake scares you... don't worry! This is something
we can test for!

## willReturn()

Open up `DinosaurFactoryTest`.

When you create a mock object, by default, PHPUnit overrides *all* of its methods
and makes each return `null`... or maybe zero or an empty string, depending on the
return type of the function. But, you can *teach* your mock object to return *different*
values. You can say:

> Hey! When somebody calls this method, don't run the real logic, but *do*
> return this value.

*Then*, we can test that *this* value *is* in fact set as the length.

To get this setup, create a new property called `lengthDeterminator`. And then
set our mock onto that. This will give us access to the mock down inside the test
functions.

[[[ code('18f553dff6') ]]]

To get auto-completion, add `@var` and then `\PHPUnit_Framework_MockObject_MockObject`.

[[[ code('82409a0a5d') ]]]

Now, scroll down to the specification test. *Before* we call `growFromSpecification`,
we can *train* the length determinator. How? Use `$this->lengthDeterminator->method()`
and then `getLengthFromSpecification`: this is the name of the method that we call
and want to control.

[[[ code('b630ba5944') ]]]

Next, chain *off* of that with `->willReturn(20)`.

[[[ code('87b984e77f') ]]]

That's it! *Whenever* that method is called, it will return 20. And that means, at
the bottom, we can assert that 20 should match `$dinosaur->getLength()`.

[[[ code('fe010015f5') ]]]

If it does *not*... something is fishy! Try the tests!

```terminal-silent
./vendor/bin/phpunit
```

Yes! They *fail*! Go back to `DinosaurFactory`, and fix the bad length code.

[[[ code('75f0a13258') ]]]

Run the tests again! Of course *now*, they pass.

## More ways to Return

This makes our test more *strict*. You might think that's *definitely* great! But...
that's not *always* true! Instead of simply testing the return value of the method,
we're testing *how* the code is written internally... which in some ways, we should
*not* care about: that's the business of the function. All *we* are *supposed* to
care about is the return value. Writing stricter tests take more time, and will break
accidentally more often.

So whether or not you will choose to control the return value of a mock is up to
you. Sometimes, when something is *super* important, a strict test is *awesome*.
And also, pretty often, you'll *need* to control the return value to even make your
method *work*.

In addition to `willReturn`, there are a few other ways to control the return value. 

Google for "phpunit willreturn" and look for the "Test Doubles" documentation. Look
inside this page for `willReturn()` to find a few examples. Another method is
`returnValueMap()`... which is a little weird, but allows you to map different
return values for different input *arguments*. That is important if you call the
same method multiple times with different values.

Oh, and in this case, the code is `->will()` and then `$this->returnValueMap()`.
But there's also a single method called `willReturnValueMap()`: each of these return
methods can be called with both styles.

There's also one called `willReturnCallback()` where you can pass a callback
and return whatever value you want. It's got the power of the value map... but is
way less weird.

Ok, there's *one* more cool thing you can do with a mock: let's see it next!
