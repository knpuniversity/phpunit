# CircleCI Artifacts

The *hardest* thing about CI is when tests fail on CircleCI, but pass locally. When
you have a lot of functional tests, this will happen more often than you think. Usually,
it's a timing issue: you click to open a JavaScript modal and then click a link *in*
that modal. This works locally... but for some reason that modal loads a *little*
bit slower in CircleCI. Your test fails because you try to click the link too quickly.
We talk about this in detail in our [Behat tutorial](https://knpuniversity.com/screencast/behat/javascript-waiting).

The "Rebuild with SSH" option is *great* for this. But an even *better* tool is
artifacts. Very simply, artifacts are a way for you to save data - like logs
or browser screenshots when a test fails - and make it accessible from the web
interface. Imagine seeing 4 test failures and seeing 4 *screenshots* right on the
UI of what the browser looked like the moment those tests failed! We actually have
a [blog post](https://knpuniversity.com/blog/circle-ci-behat-screenshots) about
getting this setup. That post uses CircleCI version 1.0 - but once we talk about
artifacts, you should be able to translate to version 2 without a problem.

## Artifacts in Action

Let's see artifacts in action. Go back to the config file. At the end of the
`phpunit` command add `--log-junit ~/phpunit/junit.xml`.

[[[ code('6678541037') ]]]

This flag tells PHPUnit to output some logs in a standard "JUnit" format. This is
basically a detailed diagnostic of what happened during the tests.

Now, add two more steps: `store_test_results` with a `path` option set to `~/phpunit`.
And another one called `store_artifacts` with that same option.

[[[ code('14a222b93c') ]]]

Let's commit this first, trigger the build, and *then* talk. Commit wildly... then push!

## Understanding CircleCI Steps

A CircleCI build consists of these "steps", and each step uses a built-in step "type".
The most common and useful type is `run`. But we're also using `checkout` near the
top and now `store_test_results` and `store_artifacts`. These are all explained on
that config reference page.

`store_artifacts` is the simpler of the two: whatever files we store as an artifact
will become available for us to see & download via the web UI - or API. That means
that we'll be able to see the `junit.xml` file... or any logs or screenshots we choose
to store.

The `store_test_results` is also really cool. Thanks to this, CircleCI will parse
the `junit.xml` file and *learn* things about your tests: like how *long* they took
to run and their favorite color is... err... maybe not that one.

Anyways, let's go find our build! It passed! Wow, and it only took 48 seconds!

First, look under "Artifacts". Yea! Here is our `junit.xml` file. It's not super
attractive, but you get the point. On KnpU, this is full of screenshots for any tests
that failed.

Now, click on "Test Summary". Cool! 29 tests and 0 failures. And it even knows which
tests are the *slowest*.

Go back and look at the previous build - build #3. The "Test Summary" part was *empty*!
This data was filled in thanks to the `store_test_results` step. It's not mission-critical,
but it's free functionality!

## Other CI Uses

By the way, you can also use continuous integration for other things beyond tests,
like enforcing code standards. By installing the [php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer),
you could easily make your build *fail* if someone pushes code that doesn't follow
the standards.

And... we're done! Thanks for traveling along with me, dodging dinosaurs, and putting
them back into their Enclosures. It's a thankless job, but somebody has to do it.

With testing as a part of your toolkit, your life will be *so* much better. Tests
allow us to create features faster and code more aggressively. They give us the confidence
that we're not going to break something important on the site. And you guys know me:
I'm a pragmatist. I don't test for some philosophical reason about code quality.
I test because it allows me to ship a high-quality app with *confidence*.

And besides, using continuous integration is *super* fun! If that's not reason enough to 
write tests, I don't know what is.

Ok guys, seeya next time!
