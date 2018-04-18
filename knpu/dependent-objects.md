# Handling Object Dependencies

Now that we're building *all* these dinosaurs... we need a place to keep them! Right
now they're running free! Terrorizing the guests! Eating all the ice cream! 
We need an `Enclosure` class that will hold a collection of dinosaurs.

You guys know the drill, start with the test! Create `EnclosureTest`. 

We don't want any surprise dinosaurs inside!

Create the `new Enclosure()` and then check that `$this->assertCount(0)`
matches `$enclosure->getDinosaurs()`.

[[[ code('14578c6a71') ]]]

Ok, good start! Next, inside `Entity`, create `Enclosure`. This will eventually
be a Doctrine entity, but don't worry about the annotations yet. Add a `private $dinosaurs`
property. And, like normal, add `public function __construct()` so that we can
initialize that to a new `ArrayCollection`.

[[[ code('3b418db08f') ]]]

Back on the property, I'll add `@var Collection`. That's the interface
that `ArrayCollection` implements.

[[[ code('626283a751') ]]]

Now that the class exists, go back to the test and add the `use` statement.
Oh... and PhpStorm doesn't like my `assertCount()` method... because I forgot to
extend `TestCase`!

[[[ code('595a3bfa8e') ]]]

If we run the test now, it - of course - fails:

```terminal-silent
./vendor/bin/phpunit
```

In `Enclosure`, finish the code by adding `getDinosaurs()`, which should return a
`Collection`. Summon the tests!

[[[ code('bbd80cab2c') ]]]

```terminal-silent
./vendor/bin/phpunit
```

We are green! I know, this is simple so far... but stay tuned.

## Adding the Annotations

Before we keep going, since the tests are green, let's add the missing Doctrine annotations.
With my cursor inside `Enclosure`, I'll go to the Code->Generate menu - or Command+N
on a mac - and select "ORM Class". That's just a shortcut to add the annotations
above the class.

[[[ code('4e3f15de5a') ]]]

Now, above the `$dinosaurs` property, use `@ORM\OneToMany` with `targetEntity="Dinosaur"`,
`mappedBy="enclosure"` - we'll add that property in a moment - and `cascade={"persist"}`.

[[[ code('90d9fe48af') ]]]

In `Dinosaur`, add the other side: `private $enclosure` with `@ORM\ManyToOne`.
Point *back* to the `Enclosure` class with `inversedBy="dinosaurs"`.

[[[ code('a33af48e2a') ]]]

That should *not* have broken anything... but run the tests to be sure!

```terminal-silent
./vendor/bin/phpunit
```

## Dependent Objects

Testing that the enclosure starts *empty* is great... but we need a way to add
dinosaurs! Create a new method: `testItAddsDinosaurs()`. Then, instantiate a `new Enclosure()`
object.

[[[ code('61b4ae5265') ]]]

Design phase! How should we allow dinosaurs to be added to an `Enclosure`? Maybe...
an `addDinosaur()` method. Brilliant!  `$enclosure->addDinosaur(new Dinosaur())`.

[[[ code('764f971462') ]]]

And *this* is where things get interesting. For the *first* time, in order to test
one class - `Enclosure` - we need an object of a *different* class - `Dinosaur`.
A unit test is *supposed* to test *one* class in *complete* isolation from
all other classes. We want to test the logic of *Enclosure*, not `Dinosaur`.

This is why *mocking* exists. With mocking, instead of instantiating and passing
*real* objects - like a real `Dinosaur` object - you create a "fake" object that
*looks* like a `Dinosaur`, but isn't. As you'll see in a few minutes, a mock object
gives you a lot of control.

## Mock the Dinosaur?

So... should we *mock* this `Dinosaur` object? Actually... no. I know we haven't
even *seen* mocking yet, but let me give you a general rule to follow:

> When you're testing an object (like `Enclosure`) and this requires you to create
> an object of a *different* class (like `Dinosaur`), *only* mock this object if
> it is a *service*. Mock *services*, but don't mock simple model objects.

Let me say it a different way: if you're organizing your code well, then all classes
will fall into one of two types. The first type - a *model* class - is a class whose
job is basically to hold data... but not do much work. Our entities are model classes.
The second type - a *service* class - is a class whose main job is to do *work*,
but it doesn't hold much data, other than maybe some configuration. `DinosaurFactory`
is a service class.

As a rule, you *will* want to mock *service* classes, but you do *not* need to mock
*model* classes. Why not? Well, you *can*... but usually it's overkill. Since model
classes tend to be simple and just hold data, it's easy enough to create those objects
and set their data to whatever you want.

If this does not make sense yet, don't worry. We're going to talk about mocking
*very* soon.

Let's add one more dinosaur to the enclosure. And then check that `$this->assertCount(2)`
equals `$enclosure->getDinosaurs()`.

[[[ code('7844a01543') ]]]

Try the test!

```terminal-silent
./vendor/bin/phpunit
```

Of course, it *fails* due to the missing method. Open `Enclosure` and create
`public function addDinosaur()` with a `Dinosaur` argument. When you finish, try
the tests again:

[[[ code('69083c2f19') ]]]

```terminal-silent
./vendor/bin/phpunit
```

Oh, and one last thing! Instead of `$this->assertCount(0)`, you can use
`$this->assertEmpty()`... which just sounds cooler. It works the same.

[[[ code('3562244356') ]]]

Ok, *now* let's talk exceptions!
