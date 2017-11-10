# CLI & Options

Board over to your terminal.

Then using a and xed you go a lot. And you've seen a few of the captions.

That chap hasn't dash H. Holy cow. Are there a lot of options. OK so.

They're out. One hundred and fifty options. But I'm going to go through the
absolute most important and useful ones. You can google for us see how I define
their documentation on this which is actually a lot more helpful than just that
help page. So first as you can see the usage up here is you can actually point
specific to a file or a number of files or a directory. And that's a way that
you can run just one test file. We've done that one time. For example with new
unit. Tests.

At ball factory d'Azyr factory and it just runs those tests. By the way. A bit
unrelated. But if you google for. Symphonie piece unit bridge. You'll find a
component that lives in Symphonie. Called Symphonie slash Puno bridge. This is
a wrapper around each unit that adds a couple of extra features like
deprecation reporting that will actually tell you what method calls you were
using. While running your tests that are deprecated which is really handy.
Basically

you install this and then instead of using vendor peach unit use it. Vendor
been simple PV unit.

All right. So going to the unit options probably the most useful one by far is
dash dash filter which is going to allow you to run just one specific test. If
you look down the documentation. And there are a bunch of examples so you can
give it a namespace a test method just a class just a test method. You can even
do things with data providers where you're showing the exact. Data. Number that
you want. This is so awesome because when you're debugging a test you want to
run only that one test will make debugging way easier. So let's try a few out.
First. Rerun the last man but do a dash dash and debug. If you do this. It'll
actually tell you exactly which test is right. Now for a vendor bent between.
Dash dash filter and that's run just the test.

It grows from specification method. Of Ass dash dash debug so we can see those
from. Just three tests. Remember this is. The test that has a date fire you see
our number 0. Our default response and our number one. So we can actually rerun
the command. Surround the filter with floats. And say number one to run it.
Just that one test. Or. At default response. To run just the one that's called
the far stops.

For a long time. I did not know that existed. That is awesome. What other
command line. Set of command line options. I like our dash dash stop on failure
and dash estop.

On Air is useful when you run your test in a whole bunch of them explode. You
want to just stop after the first one fails. And see what failed. Instead of
waiting to run all the tests are tests I'll pass.

But they didn't it would stop immediately. All right. The last thing I want to
talk about is. That passing these arguments if you have some common sometimes
passing these arguments can be a pain. And it actually has a configuration
file. It reads it automatically reads a speech unit at X and now file that
doesn't exist. It read The Vionnet that X and all that just file. Actually in
our product. We have that. This sets of a couple of important bits of
configuration. The most important is actually bootstrap. So this tells Pietsch
unit that when it starts it should require that vendors on the map. We need
that so that composers all of overworks that's what allows us to have access to
all of the classes. There are lots of other things you can do and here you can
actually set you up. And I said things. You can set environment variables that
you can read and some of your code and configure test suites which will do in a
second. You

can also control things for code coverage. So if you like to run code coverage
to see what percentage of your code is being covered by tests then you can do
it here. In this case this filter is basically saying ignore any resources
directory don't count those files towards code covers because those aren't
Pietsch classes.

To the test suite. We always have one. And because of the one test we it
basically means that all of our tests are going to be run at once. Something
that you can do is you might want to separate your unit integration and
functional tasks into different suites. And of course we'll talk more about
those test and second integration function tests and usually slower. So
sometimes it's nice to go from just the unit tests quickly. So just one
example. We can create a test we call entities. And we can make it test just.
Our entity directory. And I'm getting fancy with Star about Star Banville but
we could just put on all their. Command line. Can run a venerable unit. Dash
dash has sweet entities dash dash de-bug to see only those nine test run. Nax.
So there are many other things you can do.

Peach Veendam ex-member dazed and Seelye options. But. Don't waste your time.
This is basically what you need to know and you can find the rest of the stuff
later. Off to have fun. Install it PGE you Moji. Library. To get much more
interesting output than just these dots and apps and. All right. Next let's
talk about integration tests unit tests where we actually do talk to the
database or API. We do not mock our dependencies.
