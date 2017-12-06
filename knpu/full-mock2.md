# Full Mock Example: the Sequel

There's something interesting going on. We're mocking the `growFromSpecification()`
method... but we are *not* controlling its return value. And, the `addDinosaur()`
method *requires* a `Dinosaur` object. So... how is that working? I mean, doesn't
a mocked method return `null` by default? Shouldn't this blow up?

Back in the test, at the bottom, add `dump($enclosure->getDinosaurs()->toArray())`.
Let's see what that looks like! 

[[[ code('46ef04e583') ]]]

Run the tests:

```terminal-silent
./vendor/bin/phpunit
```

Woh! It holds 2 items... which are *mock* `Dinosaur` objects! That's really cool!
Thanks to the PHP 7 return type on `growFromSpecification()`, PHPUnit is smart enough
to create a *mock* `Dinosaur` and return that, instead of null.

That's not normally a detail you need to think about, but I want you to realize
it's happening. We don't really need to, but if we want, we *could* add
`->willReturn(new Dinosaur())`.

[[[ code('1ea150d6df') ]]]

This time, the `dump()` from the test shows *real* `Dinosaur` objects. Rawr! Take
the dump out of the test.

## The Bug: Unsaved Enclosure

Ok, there's one more bug hiding inside `EnclosureBuilderService`. The *whole* point of
the method is that we can call it and it will create the `Enclosure` *and* save it
to the database. But look! That never happens! We inject the entity manager...
and then... never use it! Whoops!

The *return* value of this method *is* correct... but really... we *also* care that
the method did something *else*. We want to *guarantee* that `persist()` and `flush()`
are called.

Back in the test, add `$em->expects($this->once())` with `->method('persist')`.
We know that this should be called with an instance of an `Enclosure` object. We
don't know exactly *which* `Enclosure` object, but we can check the type with
`$this->isInstanceOf(Enclosure::class)`.

[[[ code('08ca676aad') ]]]

Try the test!

```terminal-silent
./vendor/bin/phpunit
```

There's the failure: `persist` should be called 1 time, but was called 0 times.

Back in `Enclosurebuilder`, add `$this->entityManager->persist($enclosure)`.

[[[ code('36475cf945') ]]]

Of course, the `flush()` call is still missing. In the test, check for that:
`$em->expects($this->atLeastOnce())->method('flush')`.

[[[ code('e383a24582') ]]]

You could also use `$this->once()`... calling `flush()` multiple times isn't
a problem... but it *is* a bit wasteful. Make sure the test fails before we fix it:

```terminal-silent
./vendor/bin/phpunit
```

It *does*. In the builder, add `$this->entityManager->flush()` and then... run the tests. They pass!

[[[ code('410aab007c') ]]]

Thanks to mocking, we just created a *killer* test. Just remember: if the object
you need is a service, mock it. If it's a simple model object, that's overkill:
just create the object normally.