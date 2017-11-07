# setUp, tearDown & Skipping Tests

That is the power of test driven development and tests in general. Now around
the test. It passes. So another thing you might factor is actually the test
itself because you might write the test really quickly at first and then
refactor it to be a little bit better. So eventually we're going to have a lot
of different methods inside this one test class so creating the factory inside
each method may become tedious especially if eventually we have constructor
arguments. So one thing you can do. Is actually create a. Factory.

Property. I'll put a little documentation of this is going to be a dancer
factory instance. Then. Create a new function of public function. Set. Up. And.
Inside there say this error factory equals new factory.

Then down below remove your factory line and use that property r. Here is
what's going on the set up method is special. If you have a method called set
up exactly then the unit will automatically call that method. Before each test.
In other words if we had multiple test functions it will call set up method.
Before each of those. That make sure that the factory property is set and that
it's set to a new dinosaur factory for each of our tests. Because our
individual tasks should be completely independent of each other. You never want
one test to be dependent on another test being run. So the set up method is
perfect for that. There are a few other methods which are special. The most
common one is tear down which is the opposite of set up. It's called. Once per
test.

After running the test and want to talk more about tear down later. There are
two important ones are set up before class and tear down after class. These are
the same as set up and tear down. Except that they're only called once per
class. So instead of being called before each test it's called once and then
all of your tests are run and then after all of your tests have run it calls
tear down after class. These are less common but if you need to set up
something that is global or static then that's a perfect place to do it. One
last method that I use occasionally is on not successful test. If you have that
method then if any of your tests fail it calls that method and then maybe you
can do some sort of extra printing the screen or saving up some logs so that
it's easier for you to debug your tests. So after this revaluing we go back.
And our tests still. Pass.


Sort a dinosaur factory grows a Lhasa Raptor's eventually. 

We're going to grow triceratops. But honestly the scientists are still working on the triceratops. It's not safe. 

To grow them yet. So eventually we're going to have that method and I don't want to forget to test it. So I'm going to add a function called test. It. Proves a. Triceratops. I don't want to code this yet. So instead I'm just going to say this. Test. Incomplete. We can give it a message. Waiting for confirmation. From Gen lab. 

That feature that he uses occasionally it's just a nice way to put a marker in. So they don't forget that you have incomplete tests a little to do for later. Another thing you can do is e-mail which is more common if you're building a library and less common than building your code is to skip the tests which is something you would do if. A test requires a certain ph P version or a certain ph extension or a certain library that the user may or may not have installed. So let's for example create test. It grows a baby velociraptor. In this case. Will grow a velociraptor but a tiny one. That will assert that it has the right length. Of one. Now let's pretend that internally inside this function This requires some extra class which we maybe now have. Some sort of and some code here and say if not class exists. Manny. Then we can say this Mark test. Skit. And with the message of. 

There's nobody to watch the baby. So 

in your application code if you're testing something you should probably have the dependencies or the stuff that you need. So I would normally fail but sometimes this makes sense in. 

Reusable third party applications. In this case there is our incomplete and are skipped. If you do use the skip thing is also a cool way to use the annotations. Up here you can annotate things. Like. App requires Petris 7.2. 

Or app requires OS Linux to test things for Linux versus Windows. So 

there's actually some pretty cool stuff you can do. 