# Mock: returns & expects

We know that in dinosaur factory test we don't need to worry about testing more
length because that's done inside Danise are meant to terminate for. Every
class and test focus just on their own logic. But.

It is factory. What if.

We accidentally never call you like the Terminator. And we sent the link to
some different van on accident. Well. If you go over and run your tests
surprise they pass.

Yea sort of.

Well that's not good. If this possibility scares you enough. Then this is
something that we can actually test for a test to make sure. That. The.

Return value from the late determinator is actually set onto the dinosaur. Go
to a dinosaur factory test.

When you create mark by the it over us all the methods and just returns no or
whatever value the return type is. But you can actually teach. Your mock object
to return different values. You can say hey. When somebody calls this method
always return this value. That's how we're going to do. First create a new
property called The Terminator. And then set our mock onto that property. So
that we have access to it down inside of her functions. To get all completion.
I'm going to add a. Var that this is a mock object. Scroll down to find the
specification test. So before we call girl from specification we can train our
late the Terminator. By saying this like the terminator aero method. And then
passing get length. From specification. We're passing it the method that we
expect to be called on the left turn. Then we can change off of that and say
we'll return. 20. That's it. Now

when ever we call that method it will return the value to one instance that's
returned the value 20 down here. We should be able to say this same. That 20 x
equals Danise will get less. So we're testing to make sure that the return
value from that nothing is actually set.

On a dinosaur. Now protests. And they pass.

This makes our test that much tighter. So it's going to daß factory. In
footbath the original code. Change that the eternal protests in the past. Now I
don't always do this. Whether or not you. Decide to control the return value
for it in your mouth. It depends on the logic in your class and how much of
your class you want to test. In addition to will return. There's actually a
bunch of other things you can to let Will return map. Where you can actually.
Pass an array. Map. From the argument that's passed to get from specification
to the valley. So you can make different.

Specifications return different values. Google for PC units. Will return. To
finally test double chapter. I'll search for will return. So you can see the
example. Will return foo here in a few places. And if you actually search for
return value map you'll see a different example.

So whenever you have them when will return is actually a shortcut for error.
We'll then this error return. So you see in this case you can call return
value. Map this section creating a map that says. That when the arguments a b
and c are passed it should return d s e f and g are passed as you return H. And
the shortcut for this is just this arrow is will return value. And there are a
number of other ones like will return a callback where you give it a callback
and that callback is passed the arguments that are passed to the method and
even will throw exception. So most the time that use will return but you do
have some extra flexibility to give different return values based on the
arguments. So there's one other thing that you can do with the mark.

Go back to your daß factory and let's make another bug. Comment out our
existing Like line. And let's call get mine from specification. But this time
must pass foo. So here is that we've called the method resetting the length on
the d'Azyr battery. But we didn't actually pass the correct arguments to get
length from spec.. So what happens when you run tests trap.

They pass. So if you care you can actually start adding assertions to your mark
so you can say not only.

Do I want get length from specification to return 20 but you can actually say
it must be called once and it must be called with these arguments. And if it's
not that's a test failure. The way you do that. Is this.

A move method onto the next line and start with arrow expects this arrow. Once.
That says this method should be called exactly one time. And now pass with.

It I'll pass it. Spech. With. Is.

A method that takes all of the arguments that shouldn't be called in that
method. If those arguments don't match exactly then the test will fail. If you
have two or three arguments you would actually just say a comma and then the
next.

The next argument after it. So now run our tests they fail.

And they fail actually for two reasons. And they fail because. The calling of
getting through certification. We expected large herbivores to be passed and
food was passed. So now we have a failure to go back and we can fix our code.
Perfect. Now we don't always do this because really at this point we're. The
more you add these assertions the more brittle the more you're testing the more
brittle your code becomes. At some point you need to actually try to feature
manually to see if it works. But I will do these type of a search when it's
critically important my application has to be called like. Now in addition to.

That instead of calling this error once it you can actually call this arrow
any. If you don't care how many times something's called this arrow. Never at
least once once in exact to. Feedback. The doctor answered for once. You will
see that. If you find a few more times you'll see a list of different classes
and these are the shortcuts any Never at least once once. Exactly. Exactly. For
doing with argument. Usually go past the exact arguments but you can also do
things that are a little more flexible. You can say. Go back to docs and search
for anything.

So you can actually say this arrow anything or this greater than zero or this
string arrow contains. So this is checking the first second and third arm is
for those things. There's always this error call back where you can add your
own custom logic to make sure the argument is passed correctly. In this case
it's checking the first argument is greater than zero. The second argument
contains the string something. The third argument has our own custom logic
inside that.
