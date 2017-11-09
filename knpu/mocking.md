# Mocks & Test Doubles

In that factory we have this fancy private function get length from
specification Let's pretend that we need to use this function somewhere else.
So we're going to factor this into its own service clocks. Create a new.
Service directory inside of our. Bundle and. How about a new class called
dinosaurian length determinator. That's a fun name. And then I'm just going to.
Copy.

And move that function into dinosaur length Terminator. We'll fix that class
later. Make it public. And then retake dinosaur to add the statement.

Now we already have a bunch of tests for this. So we're going to migrate those
over to a new test. Let's create a new service directory and or test. A
dinosaur. Length The Terminator. Test. That's a test called. Test. It returns.
Correct. Length range. This will take in the spec. And. Then how about a minute
expected size and a max expected size. And that's why.

This test is pretty easy. We need to create a new determinator.

And then I'll say actual size equals Terminator erro get length from
specification and pass inspect.

Now we need to make sure that's within this range. We can do that with. Cert.
We can do that with. And make sure you extend the test case. I always forget
that. But I remind If I don't get my autocomplete on my functions so let's say
this error asserts greater than or equal. That Mitt expected size.

Is greater than or equal the actual size. This certainly less than or equal the
max expected size. Is less than the actual size. I said that backwards. That
below the Trinity for this poll function spec length. Tests. Now we already
have a bunch of really nice data providers. If you look at our dinosaur factory
test we have our guest specification tests in our get huge dinosaur spec tests.
Bashing like happy that array. Go back in our test. And paste it. We mean
almost the same thing. But a set of specifications is large and is coniferous.
Specification min length. Max length. For a large dinosaur. We don't expect
that men like to be a large dinosaur. And then we'll make sure that it is. Not
a huge daß. So it's between large and huge minus one. For a small dinosaur.

It should be between 0. We could make our code return one. In or large.
Triteness with one. For the last example I'll copy the two values for large
sets also a large. For huge dinosaurs as we can move those in very easily as
well. So let's copy all these huge test case. Paste them here. And in this case
the value should be. Dinosaur's huge. Twin dinosaurs huge and 100. Let's copy
that. And paste those for the other values. And finally on top we can hope this
off with our data via annotation. And data provider. Get speckling. And I will
fix my typo on that method name. Perfect. So obviously our is our factories
temporarily broken because we remove some code. So let's just run this test.
Vendor been piece for unit tests at Bumble's service that is sort of like the
terminator test and it passes.

No surprise because we're just moving code around. Now here is where things get
interesting. Let's go into the dinosaur factory and fix things. There's no one
great get link from specification happen in this class. But now we can use that
data certainly determinator. 3d use the Panzi injection. And expect this to be
passed into our dinosaur factory. I'll press option. Alt Enter. And go to
initialize fields. As just a shortcut to create that property for me and set
it. Down below. We can now use this this arrow like the terminator arrow get
length from spec.. So that's a nice refactoring. Of course our tests are going
to be super broken. Run all tests. That's a lot of failures all with the same
message too few arguments.

Daß factor construct on Dancer factory test line 18. Suicide d'Azyr factory
test on line 18. We have our set up and of course we are missing the link. The
Terminator argument. This is similar to what we saw a few minutes ago. We have
an object that is dependent. On an object dinosaur factory that is dependent on
a another object. In this case the dinosaur. Terminator. We could create a real
dinosaur like the terminator object and pass that into this function. Into the
constructor and that would work. But. What if. Creating that Dannis a word like
determinator was really complex. Maybe it has many constructor arguments or one
of the dinosaur like determinator talks to a database or an API. These are not
things that we want to have happen in our test. Whatever the dinosaur length
the Terminator does we.

Aren't. Concerned about that here. Or one of the dentists or like determinator
has a bug in it. From a pure unit test standpoint. If there's a bug in the
downness or like the terminator it should not make the dinosaur factory test
fail our test should only be focused on testing the logic of dinosaur factory.
So instead of passing in a real dinosaur like the Terminator. Which has all
these potential problems we're going to pass in a fake object that looks and
smells like a dinosaur of like the Terminator. But. Is it. This is called a
mock. Created new. Mock like the Terminator. And say this arrow create mock.
Dinosaur like Terminator colon colon class. And then pass that in.

As the first argument. Before we talk about this. Go back over.

And run your tests. Whoa. They still fail. But. The error message is different
failed asserting that zero is equal to 10. Or is greater than 10. It's
basically the same message over and over again. This zero. Is actually
referring to.

The dinosaur at length. So interesting.

For some reason that dinosaurs lengths are all being set to zero. Here's why.
When we create a mock. Up quite. A whole command click to get into the Create
mock. Function.

Though it does aren't too important. Now.

When we create a mock it creates a new class in memory that extends the
downness certainly the Terminator but it overrides every single method in it.
And inside. Just returns no. So that means every method that we call a dinosaur
like determined here doesn't actually call the real functions he calls a fake
function that does nothing and returns no. Well actually it doesn't. In this
case. Our. When we call it length of specification it's returning 0. As you can
see because unit smart enough to read. Our. Return type. So it returns no or it
returns a zero for the integer. But basically it returns nothing. Now when you
create a mock. O command Quink integrate Mach because when he created mark it
actually uses a thing called a mock build up behind the scenes see and it
disables the original constructor so that she skips behind the constructor.

And there's a number of other options they can call McKeller. By default. As I
mentioned it will mark all of the methods on the object but you can actually
mock just some methods and not others. By the way the most common word you're
going to hear for this thing is a mock. But technically there are a number of
different terms dummies Stubbs spies in Mocs. They all mean slightly different
things. And if you want to learn about them you can check out the blog post on
our co-authors website that explains the difference between those. But you'll
hear me refer to Mark. All right so. Creating the mock fix our initial error
but now offer the length tests are failing. But. Wait a second. If we're
testing the logic of dinosaur factory only.

The daß factory doesn't do anything with length the length calculation is done
by them like the Terminator. In other words. We shouldn't need to test. Any of
the logic and daß factory because that's been done by a different class. In
that class should be tested. In other words I'm actually going to compute the
lead. Our dad has a huge stack test that's already tested in the dinosaur like
the Terminator. And for the. Other specifications dast we still do need to test
that he is carnivorous values done correctly but we don't need to test this.
The length of the dinosaur. Summoner move the second argument. The expected is
large. And then going to remove the asserts related to that. And then remove
that second argument from our data provided below. You don't need to worry
about testing this.

Time. When we do that. For back. Now. Our tests pass. This is because our diets
are factory test is only worried about testing the logic that it has in our
datacenter like determinator test. It. Is testing the actual subject line test.
Each test is classes done in isolation. That is a true unit test.

