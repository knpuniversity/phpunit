# TDD & Unit, Integration & Functional Tests

## Unit, Functional & Integration Tests

Before we get back to coding... we need to talk about just a *little* bit of theory!
No, don't run away! Give me just 2-ish minutes!

So, there are actually *three* different *types* of tests, and we're going to try
them all. The first is a unit test - that's what we've created. In a unit test,
you test one specific function on a class. It's the *purest* way to test: you call
a function with some input, and test the return value. We'll learn more about this
later, but each unit test is done in *isolation*. If, for example, a class needs a
database connection, we're actually going to *fake* that database connection so
that we can focus on testing *just* the logic of the class itself.

The second type of test is an *integration* test... or at least, that's my name
for it. An integration test is basically a unit test: you call functions and check their
return values. But now, instead of faking the database connection, you'll use the
*real* database connection. We'll talk about when and why this is useful later.

The third type of test is a *functional* test. In our world, this basically means
that you're writing a test where you programmatically command a browser. Yep, you 
literally write PHP code that tells a browser to go to a page, click a link, fill
out a form, click submit, and then assert that some text appears on the next page.

More on *all* of these things later.

## How much to Test?

Another question is how *much* you should test. Does every function need a unit
test? Does every page and every validation error of every form need a functional
test? Absolutely not! That sounds worse than a raptor claw across a chalkboard!

Especially if you're new to testing, don't worry: a *few* tests is way better than
none. And honestly, I think many people create *too* many tests. I follow a simple
rule: if it scares me, I test it. Too many tests take extra time, add little value,
and slow you down later when they fail after you've made a minor change.

In our app, we've tested the `getLength()` and `setLength()` methods. These do *not*
scare me. In the real world, I would not test them.

## Test-Driven Development

A few minutes ago, I mentioned the term "Test-Driven Development" or TDD. TDD
breaks coding into three steps. First, create the test. Second,
write the *minimum* amount of code to get that test to pass. And third, now that
your tests are passing, you can safely refactor your code to make it fancier.

So, test, code, refactor: these are the steps we're going to follow. Do I *always*
use TDD in my real projects? Um... yes!? No, not really: I'm not a purist. Heck,
sometimes you don't even need a test! Gasp! But yea, usually, if I plan to write
a test for a new feature I'm working on I'll follow TDD.

Oh, and TDD is about *more* than just making sure you have a lot of tests. As you'll
see, it forces you to *think* about how you want to design your code.

Enough theory! Let's try it already!
