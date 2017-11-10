# Full Mock Example

Mocking is so important that I want to look at another example in some ways an
even better example. So we're going to need a lot of dinosaurs. We're going to
need a lot of inclosures. Soon. So instead of creating those enclosures by hand
we're going to add a new service that helps us create enclosures with security
and dinosaurs. If you downloaded the source code. Then in the directory. You
should have an enclosure build or service. On top of that into our service
directory. This has one public function on it. Where you pass that number of
security systems. The number of dinosaurs in it takes care of creating the
security systems creating the dinosaurs and then putting everything together.
This is a one stop shop. For creating enclosures. Now in this case we're not
going to use TDD because I've already given you the class and it's actually
going to be pretty interesting. So let's create a test. In the service
directory a new. Enclosure builder service test.

Inside a test it builds and persists enclosure.

And this time let's make sure this extends our test case from Pietsch view. So
it's pretty simple. Let's create a builder. He calls new enclosure builder
service. You see this does have to require constructor arguments. Let's ignore
those for now and write test. Next saying closure equals and say the arrow Bill
enclosure and let's build one security system and two don't source. And down
below can just assert that there exist. A circuit count. That one is equal to.
Enclosure aero good securities. That method doesn't exist yet so we'll need to
create better socket. And then work out that two is equal to enclosure. Good
dinosaurs. And then let's go into closer.

And make sure we have a good security method. Paul. Functional. Security is.
Will we return a collection. And we'll return this air securities.

So our test oh then missing it's too concerned our audience is pretty happy. So
the two can start our tyrants are the answer the manager which we're going to
use to save the enclosure and the dinosaur factory which we use. To help create
the dinosaurs. These are pool services so they're perfect for mocking. Even
more than that if you try to create a city manager that requires a database
connection. We don't actually want our unit test to talk to the database and
even the dinosaur factory at this point it has a constructor argument. So
creating a dinosaur factory will be a little bit complex. You can start to see
how making an object makes life much much easier. So inside. Our test per se.
Yes because this way Mark. And we're expecting an entity manager interface.
Slut's mock the manager interface calling in class. And also create a factory.
As another box. Or a dinosaur factory called Call in class.

And pass them in down a factory as the two constructor arguments.

So I'm not worried about controlling any return values. I'm just trying to do
as little as possible to start our test. Because really these asserts down here
are pretty good. So change over. And run the tests. Well when they fail fail a
certain one matches to find one. So for some reason we're only getting back one
dinosaur. Even though we past two is the argument. Going to enclosure builders
service and go down to add dinosaur. I actually have a blog in our code. You
pass on the number of dinosaurs but we don't actually use that. We only add one
dinosaur. So this is cool. We already have a test so we can very easily fix the
code. But if we want to. We can actually add a little bit more logic to our.
Data olfactory mark to make this test even. Even tougher. What I mean is we can
actually make sure that that kind of factory. Is called two types. If we want
to.

Do that let's say the answer factory. Eric expects. This. Exactly to. Because
we're created to dinosaurs. And then math is. Grow from specification.

So now make sure that we have exactly two types. Now we don't need to pass
with. But we can also make sure if we want that this has passed a string we
don't know exactly what the string will be because it's random but we can
always check the type. To do that. We'll say this arrow is tongue. String. I
don't always do that but that's how you do it. Now if you can't really comment
on the last failure. The. Last count. You know like to see what this value
would look like expected failed for method name grows from specification. It
expected that grow from specification wasn't about 2 times. But it was actually
called Just once. That's. Cool. So pull the circuit back. And then let's go
into our incredible service and actually fix this. For loop for equals zero by
less than number of dinosaurs. I plus plus. We move all of this code. Inside.
Of that. Loop. And move back over.

Rather Yes. And the last.

But hold on a socket. Since the dinosaur factory is a mock.

And we're not controlling the return value. So. Normally. That means that that
method should return all. But if you look at the dinosaur method in enclosure.
This expects a dinosaur object so. That should be failing. So if return
girlfriend specifications return. No this should be failing. Let's see what's
going on there. Back in our test at the bar. Dock. Enclosure air get the
dinosaurs aero to Array. So we can see what it looks like. Then move over. And
run the test. Whoa. Is that right with two objects. But they're Mach objects.
Mark dinosaur. This is a really cool thing. An enclosure builder service. One
piece for unit calls grow from specification on or mock. It sees that that has
a return value of a dinosaur object. So instead of returning. No it actually
marks a dinosaur object and returns that.

That's not necessarily very important. I just want you to realize that's what
happens. Know reads the return types and make sure that your methods your
mocked methods actually return those things. We don't need you but if you want.
We will return the new dinosaur. And then when you're really tasked. You're
going to get back your actual dinosaur object.

I'll remove the up on the bottom. There's actually one last problem with our
enclosure and all the service.

The whole point of the service is that we can call it and it will create
enclosure in save that enclosure to the database. But. Look. That never
happens. We inject the into the manager but we forgot to actually save the
enclosure. This is actually pretty important. This is a big bug in our code. So
I want to make sure that we actually in Savir are closer to the database.

And that means I want to make sure that that persist map and flush methods are
called on the entity manager. So back in our tasks let's say E-M aero expects.
This arrow once. That the method persist is called. And we know that it should
be called with an instance of an enclosure object. We don't know exactly which
enclosure object we just want to make sure that is some type of enclosure
object. So we can say this arrow is instance of. Enclosure. I'm calling class.
Now that we have the tasks. Right there is our failure expected present to be
called 1 times actually call 0 times. So back into your builder service. At the
bottom will say this area and the manager will persist.

In closure. Of course the flush is also missing and that's also just as
important. So the tasks. That say iam air expects. This arrow at least once.
Method. Flush.

Is want to make sure this is called At least one time. We can also use that
once because calling flush multiple times is wasteful. But I'm just showing you
the different options. Find terminal.

Run the test. It fails on flush. So now we go back. To see this error and City
Manager wash.

And now our tests pass. So this is mocking. And the important thing to remember
with marking. Is that you should use it whenever the class we're testing
requires a different class. And that class is a service. If you're just a
simple model object. Then mocking those. In many cases is just overkill and not
needed. Remember we did that an. Enclosure test. That case we needed a dinosaur
class object that surpasses a simple model class so we just created it. We
could have mocked the dinosaur but it's just so simple that it's overkill.
