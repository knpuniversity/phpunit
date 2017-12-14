# DomCrawler: Epic Beast of the Night

Our test is *already* pretty cool. This is called a smoke test: with just
a *tiny* bit of code, we're at *least* making sure the homepage doesn't have a
huge error!

And now... stop! Before we write any more tests, we need to ask ourselves a question:
does the feature we're building *need* a test? We're going to add a list of all of
the enclosures on the homepage. That doesn't sound too scary, so I might not test
this in the real world. We *will* test it... yea know... because this is a tutorial
on testing. But my point is: think before you test!

## Writing the Enclosure Test

Ok, back to TDD! Our homepage is blank... but *soon* it will have a list of all of
the enclosures in the database!

In the test, we need to think about how this might look. Let's add `$table = $crawler->filter()`
and then a CSS selector: `.table-enclosures`. I'm saying that, when we build this
page, we should create an element with this class. The `$crawler` object is a bit
similar to the `jQuery` function in JavaScript: by using its `filter()` method, it's
*really* good at finding elements via CSS. The `$table` variable is *itself* another
`Crawler` object, which represents the table element.

[[[ code('17570f1bac') ]]]

Now, we can `assertCount()` that 3 is equal to `$table->filter('tbody tr')`. In other
words, inside the table, we expect there to be 3 rows. Why 3? Well... I just made
that up! Just like with integration tests, we're going to need to take control of
the database so that we know *exactly* what's inside. More on that soon!

[[[ code('af608c6f28') ]]]

Try the test now:

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Controller/DefaultControllerTest.php
```

Yay! It fails! That means we are ready to code!

## Coding up the Feature

Open `DefaultController` and query the database for all the enclosures:
`$this->getDoctrine()->getRepository(Enclosure::class)->findAll()`. Use this to
pass a new `enclosures` variable into Twig.

[[[ code('ae022d338a') ]]]

Now open that template! It's in `app/Resources/views/default/index.html.twig`.
I'll add an h3, the table with `class="table-enclosures"` and a `tbody`.

[[[ code('ae022d338a') ]]]

Inside, start looping! `for enclosure in enclosures`. For the `<tr>`, I'm going
to give each a unique id. This will help us write a *different* test in a few minutes.

[[[ code('714cb6a13a') ]]]

And now... let's print some stuff! Like the `Enclosure #`, and on the next column,
"Contains" then `enclosure.dinosaurCount` dinosaurs. Rawr!

[[[ code('f6717e640f') ]]]

PhpStorm is angry... and it's right! We don't have `getId()` or `getDinosaurCount()`
methods yet.

Open up `Enclosure`. Near the top, at `getId()`: it should return a nullable int.
And at the bottom, create a `public function getDinosaurCount()` that will return
an `int`. Return `$this->dinosaurs->count()`.

[[[ code('d9f685a01f') ]]]

So... does the page work? It should! Try the tests!

```terminal-silent
./vendor/bin/phpunit tests/AppBundle/Controller/DefaultControllerTest.php
```

Ah! Failure because the actual size one does not match expected size 3. Check out
the homepage in the browser: we have *7* enclosures! This is the same problem we
had with integration test: we're not taking control of the data in the database.
So... we really have *no* idea how many enclosures will be in the list! Our main
database has 7... and apparently our test database has only one.

Let's fix this!
