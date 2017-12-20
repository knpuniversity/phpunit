# Loading Fixtures References

Despite all our precautions, we still *sometimes* have enclosures with *no* security.
Yea... a lot of people are getting eaten, a lot of lawsuits - very expensive. To
help with this, I want to add an "Alarm" button on the homepage next to any enclosures
that do *not* have active security.

Because this sounds pretty important, let's write the test first. Add
`public function testThatThereIsAnAlarmButtonWithoutSecurity()`. Copy the fixture
and request code from before and paste it here. But, at the end of `loadFixtures()`,
add `getReferenceRepository()` and assign this to a new `$fixtures` variable.

[[[ code('5416d13f6d') ]]]

## What are Fixture References?

Here's the deal: if you look in the fixtures, you can see that the first two Enclosures
do *not* have any security. You can *also* see that we're using some sort
of "reference" system. This allows us to store a specific object in memory so that
we can re-use it somewhere else. For example, in `LoadSecurityData`, we get the
`herbivorous-enclosure` object out and *add* security! We're safe from those wild
veggie eating dinos!

It does the same for `carnivorous-enclosure`... but then adds two Security objects
that are both *inactive*. Doh! Yep, this means that the `carnivorous-enclosure` is
the only `Enclosure` that is *not* secure. In the test, our goal is to assert that,
on the homepage, *this* exact Enclosure has the alarm button.

And we planned ahead for this! Remember, in the template, we added an `enclosure-{id}`
to each `tr` element. So if we can get the actual id value of the Carnivorous Enclosure,
it will be *really* easy to find its `tr` element and look for the alarm button.
The reference system gives us that power!

Yep, we can fetch the exact `Enclosure` object by saying
`$enclosure = $fixtures->getReference('carnivorous-enclosure')`. Next, create a
`$selector` variable set to `sprintf('#enclosure-%s .button-alarm')` and `$enclosure->getId()`.
We'll expect the alarm button to have this class.

[[[ code('3392c0e01a') ]]]

Finish the test! `$this->greaterThan(0, $crawler->filter($selector)->count())`.

[[[ code('33c392920f') ]]]

I love it! So first, of course, make sure the test fails. Copy the method name
and run phpunit with the `--filter` option:

```terminal-silent
./vendor/bin/phpunit --filter testThatThereIsAnAlarmButtonWithoutSecurity
```

Awesome!

## Adding the Alarm Button

So let's code! In `index.html.twig`, add one more `<td>`: `if enclosure.isSecurityActive()`
with `else` and `endif`.

[[[ code('071ceac244') ]]]

If security *is* active, we rock! Add a cute lock icon and say "Security active".
Yep, just sit back and enjoy some Jolt soda: nobody is getting eaten today!

[[[ code('31121dbb11') ]]]

But if security is *not* active, ah crap! Add the button with the `button-alarm`
class that the test is looking for. And say "Sound alarm!!!".

[[[ code('673f00bb87') ]]]

That should be it! Run the test:

```terminal-silent
./vendor/bin/phpunit --filter testThatThereIsAnAlarmButtonWithoutSecurity
```

Ha! It passes! 

## Debugging Functional Tests

But... what if it *didn't* pass? Well... the errors wouldn't be very helpful: it
would basically just say that 0 is not greater than 0. When things fail, the trick
is to go *above* the failure and `dump($client->getResponse()->getContent())`. If
you're using Flex, make sure to install the `var-dumper` package.

Now when you run the test, it will *at least* print out the HTML body. By the way,
with a little bit of clever coding, you can hook into the `onNotSuccessfulTest` method
and have the last response content printed automatically when a test fails. I'll
leave that as a challenge for you. But, ask us in the comments if you have any
questions.

Ok, there's *one* more thing I want to talk about with functional tests: filling
out and submitting a form.
