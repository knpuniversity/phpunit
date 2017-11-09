# Mocking with Prophecy

Peach unit obviously has a marking system built into it that there are actually
other marking libraries out there. One is called prophecy. And it's really fun
and it comes with the unit. So how to take us through testing this exact same
class using prophecy. Ultimately they're doing the same things behind the
scenes. But then you can pick which ever one you like better. Plus create a new
test called. Enclosure. Builder service. Prophecy. Test. Mentis extend the
normal test case. With the same test method test it builds. And. Persist.
Enclosure. And quite literally we're just learning to. Adapt this code over
here over to way the way that prophecy does it. So first instead of this arrow
create mock we're going to say it equals this all prophesies. And they're going
to pass it. The magic interface calling one class.

So that starts pretty similar. Next we need to expect that to persist Nothing
is only called once and that's passed in the enclosure. Object as an argument.
Here's the big difference with prophecy. Since we. Want to do. Since we want to
control things related to persist method. We're actually going to say e an
arrow persist. We're going to pretend like the the manager object. The end
really is the entity manager and call the persisting method on its. Now since
we as a persistent have. A specific argument here we will actually pass.
Arguments. Colon type. And say enclosure colon corner class. I want to talk
more about the argument thing in a second. Then since we want this to be called
exactly once. We can say. Should be. Call. Times. 1. Now I understand you're
not getting any of completion here prophecies is super magic library.

And so unfortunately you're not going to get the auto completion scene need to
be a little bit more careful but it's kind of fun. So next. When you do x.
Expect that flush is called at least once. So basically we just pretend that.
We're calling the function in error and flush. And then we'll say.

Should be called. So it should be called at least one time.

So in addition to should be called Times and should we call. There's also
should it not be called. And a sure method that receives a callback and then
you can do your own custom logic. Arts and need to create the dinosaur factory.
Will start the same way our factory equals this arrow prophesies. That a sort
of factory call and call and class. Here. We need to make sure that the growth
from specification method is called exactly two times with a string argument
and returns a dinosaur. So we're doing everything we can on this mock. Sitting
down a factory. That will call grow from the specifications on it. Now here's
how this works. If you don't care what arguments are passed to your method what
prophecy. Just leave this blank. But if you do care what arguments are passed
through it you're actually going to pass those arguments one by one.

So if there were three arguments we passed foo comma bar comma bass then it
would make sure that exactly those three arguments are passed to this method.
Where things get tricky is when you don't want to you can. We. When you can't.
Tell it exactly what argument we passed. Instead you want to check to make sure
it's a certain object or a certain type. In this case we want to make sure that
it is just a string. The. We use the same argument calling Cohen. Type. And.

Pass.

There are a few other methods on type. The most important one is any. If you
don't care what argument is passed. And another call that and then you pass
that a call back so that you can. Do a custom check on it. Now as soon as you
specify. One argument. You need to specify the rest of the arguments as well.
All right. Next. We need to make sure this is called two times. So we know we
can say should it be called times 2. And then we need to control its return
value to make sure turns into dinosaur object. So that's actually the saying it
will return. To dinosaur. In addition to what we turn there's also will throw
if should throw an exception. And will we just pass a call back which again
allows you guys to do custom logic to control the return.

And. Yeah that's it. The rest of the test I'm going to copy. And then paste.
And then I'll retake. Because you know the service that we get the use
statement on top for it. Now the one other thing that will. Bite you with
prophecy is that once you're finally ready to pass in your marks you need to
call you feel on the. Face of it it turns it from this sort of mock builder
object into the true mock object.

And that should be it. Let's flip over.

And run our test. And they pass. So there you go. You can use props see which
is a little bit more fun and weird. Or you can stick to the classic. Each unit
marking framework.
