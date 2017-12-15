# Functional Tests

The last type of test is called a *functional* test. And it's *way* different than
what we've seen so far. With unit and integration tests, we call methods
on our code and test the output. But with a functional test, you command a browser,
which surfs to your site, clicks on links, fills out forms and asserts things it sees
on the page. Yep, you're testing the interface that your users *actually* use.

Oh, and functional tests also apply if you're building an API. It's the same idea:
you would use an HTTP client to make real HTTP requests to your API and assert the
output.

## LiipFunctionalTestBundle

First, to give us some magic, I want to install a special bundle: Google for
LiipFunctionalTestBundle.

This bundle is *not* needed to write functional tests. But, it has a collection
of optional, extra goodies!

Copy the composer require line, move over to your terminal, and paste:

```terminal-silent
composer require --dev liip/functional-test-bundle
```

## Functional Test Setup

Functional tests *look* like unit tests at first: they use PHPUnit in the exact
way we've been seeing. But instead of writing one test class per PHP class,
you'll usually create one test class per *controller* class.

It doesn't have much yet, but we're going to functionally test our homepage. Since
the code behind this lives in `DefaultController`, let's create a `Controller`
directory in `tests` and add a new `DefaultControllerTest` class.

But now, instead of extending `TestCase` or `KernelTestCase`, extend `WebTestCase`.
But wait! There are two! The normal base class is the one from `FrameworkBundle`.
*It* actually extends `KernelTestCase`, which means we have all the same tools
as integration tests. But, it adds a few methods to help create a *client* object:
a special object we'll use to make requests into our app.

Today we'll choose `WebTestCase` from LiipFunctionalTestBundle. No surprise, this class
*itself* extends the normal `WebTestCase`. Then, it adds a bunch of optional magic.

[[[ code('e311abbc97') ]]]

## TDD & The Functional Test

Let's add the first test: `public function testEnclosuresAreShownOnTheHomepage()`.
Right now, the homepage is empty. But in a minute, we're going to render all of
the enclosures. So let's do a little TDD testing! Start by creating a client with
`$client = $this->makeClient()`. This method comes from LiipFunctionalTestBundle,
but is just a wrapper around Symfony's normal `static::createClient()`. The version
from the bundle just adds some optional authentication magic.

[[[ code('69e8c3793a') ]]]

Next, make a request! `$crawler = $client->request('GET', '/')` to go to the homepage.
We'll talk more about this `Crawler` object in a few minutes. Then, the simplest test
is to say `$this->assertStatusCode(200)` and pass `$client`. But even this is
just a shortcut to make sure 200 matches `$client->getResponse()->getStatusCode()`.

[[[ code('99da6035e7') ]]]

And yea... the first part of the test is done! This *at least* makes sure our page
isn't broken!

## Finishing Installing LiipFunctionalTestBundle

But before we try it, we need to finish installing the bundle. Copy the 3 bundle
lines, open `AppKernel` and paste them there. 

[[[ code('595f248672') ]]]

We also need to add one line to `config_test.yml`.

[[[ code('b67c3b59d3') ]]]

If you're using Symfony Flex, these steps should eventually be done for you. I say
eventually, because - at this moment - Symfony 4 support is still being added to
the bundle.

Ok! Let's try it! Find your terminal, run phpunit, and point it at the new controller:

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Controller/DefaultControllerTest.php
```

Yes! It passes!

## Symfony's Client Versus Mink Versus Others

But... what just happened exactly? Did our code just make a *real* HTTP request
to our app... just like if we refreshed it in the browser? Well... not *quite*.

Remember: in a functional test, we use PHP to command a browser and tell it to go
to a page, click on links and fill out forms. But, there are *multiple* libraries
that give us this superpower. We're using Symfony's `BrowserKit` client... mostly
because it's built into Symfony and easy to start using. But, there are others.
My favorite is called Mink, which is used behind the scenes with Behat. We have
a tutorial all about Behat, with big sections devoted to Mink. So, check that out.

***SEEALSO
Learn all about Mink and Behat: https://knpuniversity.com/screencast/behat
***

So... what's the difference between Symfony's `BrowserKit` and Mink? With `BrowserKit`,
you're not *actually* making a real HTTP request to your app. Nope, you're making
a "fake" request directly into your code. Honestly, that doesn't matter much. And
actually, it makes setup a bit easier: we didn't need to configure that our site
lived at `http://localhost:8000` or anything like that.

But, `BrowserKit` has one big disadvantage: you can't test JavaScript functionality.
Nope, since these are fake requests, your JavaScript simply doesn't run! This is
the main reason why I prefer Mink: it *does* allow you to run your code in a real
browser... *with* JavaScript.

For the next few chapters, we *are* going to use Symfony's BrowserKit Client. But,
most of the concepts transfer well to other test clients, like Mink. And you'll
still be able to use most of the magic from LiipFuntionalTestBundle. If you have
questions about this, just ask in the comments!

Next, let's talk about this `$crawler` object and how we can use it to dive into
the HTML of the page!
