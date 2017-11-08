# PHPUnit: Secure the Park

Let me paint you a scary picture:

It's Friday night. It's stormy. The office is empty and you're deploying fresh code
straight to production. Suddenly, an alarm! What? The fences are down!? The dinosaurs are
escaping!? Somehow, your beautiful code contained a bug. And as the raptors
surround you, one thought keeps coming back: if only you had written tests.

I hate bugs, I hate fixing emergencies on production, and I *especially* hate being
eaten by raptors.

It's time to go pro with coding... and that means, learning to test! And not *just*
because we hate running from dinosaurs. We want to write code that is
thoughtfully-designed and have the ability to add *new* features with confidence.

## Hello Dinosaur Park

To make this dream come alive, you should *totally* code along with me. Download
the course code from this page. After unzipping the file and turning the fences
back on, you should find a `start/` directory that has the same code you see here.
Open up the `README.md` file for setup instructions and directions on how to catch
the last boat off the island before the storm.

The last step is to find a terminal, move into your project, and run:

```terminal
./bin/console server:run
```

to start the built-in PHP web server. In your browser, go to `http://localhost:8000`
to find... well... nothing! Just, "Welcome to Dinosaur Park". Instead of creating
a park full of dinosaurs and *then* worrying about security... ahem... we don't
have *any* code yet. We're going to build this dino factory *and* write tests all
at the same time.

## Installing PHPUnit

The de facto standard tool for testing in PHP is PHPUnit. Open a new terminal tab.
Install it with:

```terminal
composer require --dev phpunit/phpunit
```

This will obviously download the PHPUnit library into your `vendor/` directory.
But mostly, you will interact with PHPUnit as an executable. When this finishes,
you can now run:

```terminal
./vendor/bin/phpunit
```

Hi PHPUnit! And hello Sebastian Bergmann and other contributors! There are *no* tests yet
but I already feel like we're making friends.

## Write some Tests

Let's write our first test. But, uh, don't worry about *what* we're testing yet -
let's just experiment a little.

Create a `tests/` directory and inside, another `AppBundle/Entity` directory.
We'll talk about this structure soon, but first we have dinosaurs to contain!

Add a new PHP class: `DinosaurTest`, and give it a namespace: `Tests\AppBundle\Entity`.
Make sure you *extend* a class: `TestCase` from PHPUnit.

[[[ code('586ad0bcad') ]]]

To actually make a test, create a public function called `testThatYourComputerWorks`.
We're giving it that name because, inside, we're going to say `$this->assertTrue(false)`.

[[[ code('69ed4aa286') ]]]

If this test *passes*, you'll know to throw your computer out of the window and buy
a new one. Let's find out. To run the tests, find your terminal, and re-run PHPUnit:

```terminal-silent
./vendor/bin/phpunit
```

Yes! It fails! My computer gets to live! It failed asserting that false is true on
`DinosaurTest` line 11.

## Test Rules & Best Practices

Ok, let's talk about the basic *rules* of writing a PHPUnit test. First, you can
*technically* put your test classes *anywhere*... but.. you've gotta admit that
`tests/` is a *pretty* good place. Actually, in a Symfony project, you automatically
start with a `phpunit.xml.dist` file. Well, in Symfony 4, this is added when you
install `phpunit`. We'll talk more about this file later... but PHPUnit reads this
automatically. And... check it out! *It* says that our tests all live in... `tests/`.
That's how PHPUnit is able to find our `DinosaurTest`.

Second, our test has a `namespace`... but that's not really important. In a Symfony
project, your `composer.json` file has an `autoload-dev` section that basically
says that anything in `tests/` should start with the namespace `Tests`. No big deal.

Let's get to the *really* important stuff, because PHPUnit *does* have a few crucial
rules. First, your test class *must* extend `TestCase` *and* end in the word `Test`.
Second, all of your test methods must be `public` and *start* with the word `test`.
When you run PHPUnit, it basically looks for all classes ending in `Test` and all
public functions inside *starting* with `test`.

Got it? Good... because the storm is coming, and we've got work to do. Delete the
fake test. Let's start coding.
