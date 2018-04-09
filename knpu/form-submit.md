# Testing a Form Submit

New feature request! On the homepage, management wants a form where they can choose
an enclosure, write a dinosaur spec - like "Large herbivore" and submit! Behind
the scenes, we will create that new `Dinosaur` and put it into the `Enclosure`.

Since we're now functional-testing pros, let's get right to the test! Add
`public function testItGrowsADinosaurFromSpecification()`. And as usual, steal some
code from earlier and paste it on top. You can start to see how some of this could
be refactored to a `setUp` method.

[[[ code('d739df56f7') ]]]

After creating the client, add `$client->followRedirects()`. Normally, when our
app redirects, Symfony's Client does *not* follow the redirect. Sometimes that's
useful... but this line makes it behave like a normal browser.

[[[ code('f03eba2ae6') ]]]

## Filling in the Form Fields

To fill out the form fields, first we need to *find* the form. Do that with
`$form = $crawler->selectButton()` and pass this the *value* of the button that
will be on your form. How about "Grow dinosaur". Then call `->form()`.

[[[ code('8b3e64d69f') ]]]

We now have a `Form` object. No, not Symfony's normal Form object from its form system.
This is from the `DomCrawler` component and its job is to help us fill out its fields.

So let's think about it: we will need 2 fields: an `enclosure` select field and
a `specification` text box. To fill in the first, use `$form['enclosure']` - the
`enclosure` part is whatever the `name` attribute for your field will be. If you're
using Symfony forms, usually this will look more like `dinosuar[enclosure]`.

Then, because this will be a `select` field, use `->select(3)`, where 3 is the value
of the `option` element you want to select. Do this again for a `specification` field.
Setting this one is easier: `->setValue('large herbivore')`.

[[[ code('517e55a8ca') ]]]

Honestly, I don't *love* Symfony's API for filling in forms - I like Mink's better.
But, it works fine. When the form is ready, submit with `$client->submit($form)`.
That will submit to the correct URL and send all the data up!

[[[ code('4bd34b30c6') ]]]

But... now what? What should the user see after submitting the form? Well... we
should probably redirect *back* to the homepage with a nice message explaining
what just happened. Use `$this->assertContains()` to look for the text
"Grew a large herbivore in enclosure #3" inside `$client->getResponse()->getContent()`.

[[[ code('77c7715c63') ]]]

Test, done! Copy the method name and *just* run this test:

```terminal-silent
./vendor/bin/phpunit --filter testItGrowsADinosaurFromSpecification
```

Perfect! It fails with

> The current node list is empty.

This is a really common error... though it's not the *most* helpful. It basically
means that some element could not be found. 

## Code the Form

With the test done, let's code! And... yea, let's take a shortcut! In the `tutorial/` directory,
find the `app/Resources/views/_partials` folder, copy it, and paste it in *our*
`app/Resources/views` directory.

[[[ code('5a4612fbb4') ]]]

Then, at the top of `index.html.twig`, use it: `include('_partials/_newDinoForm.html.twig')`.

[[[ code('0be6c62621') ]]]

The form is really simple: it's not even using Symfony's form system! You can see
the `name="enclosure"` select field where the value for each option is the enclosure's
id. Below that is the `name="specification"` text field and the "Grow dinosaur" button
the test relies on.

For the submit logic, go back into the `tutorial/` directory, find `DefaultController`
and copy all of the `growAction()` method. Paste this into *our* `DefaultController`.
Oh, and we need a few `use` statements: re-type part of `@Method` and hit tab to
add its `use` statement. Do the same for `DinosaurFactory`.

[[[ code('0be6c62621') ]]]

Ok, it's happy! Sure, the code is lacking the normal security and safeguards we expect
when using Symfony's form system... but it's only a dinosaur park people! We *do*,
however, have the success flash message!

So if we haven't messed anything up, it should work. Try the test!

```terminal-silent
./vendor/bin/phpunit --filter testItGrowsADinosaurFromSpecification
```

Yes! It passes! We just confirmed that this form works before we ever even loaded it in
a browser. That's pretty cool.

So that's the power of functional tests. And I find them *especially* powerful when
using Mink and testing that my JavaScript works.

Ok guys, just *one* more topic left, and it's *fun*! Continuous integration! You
know, the fancy term that means: let the robots run your tests automatically!
