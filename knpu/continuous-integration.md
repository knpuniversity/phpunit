# Continuous Integration: Activate the Robots

Great news! We have a growing test suite! Bad news! Nobody *actually* likes to run
the tests! Sure, they only take 4 seconds now. But in a real app - with integration
tests and functional tests - the entire suite may take 5 minutes, or 10 minutes...
or an hour. No joke!

In practice, I *only* run the specific tests that I'm currently working with. And
that's fine! Because we at KnpU use continuous integration. It's a *must*. Yep, each
time we push to any branch, a bunch of friendly robots checkout our code, run our
tests, and report back. This keeps *us* coding, and we learn about failures as quickly
as possible.

Oh, and continuous integration can do other cool stuff too... like deploy!

## Hello CircleCI

There are a few tools for continuous integration. If you want to host it yourself,
Jenkins is the way to go. But if you want easy setup, you can use Travis CI or our
favorite, CircleCI!

And actually, CircleCI even has a free plan. Hey CircleCI - that's *super* nice of
you!

Before we setup our project, we need to host our code somewhere. Head over to GitHub
and create a new repository, give it a name, and submit. Copy the 2 lines to push
to an existing repository and move over to your terminal. Make sure to commit all
your changes so far - I already did that. Then, paste!

Back on the browser... we have a repo!

## CircleCI Initial Setup

On CircleCI, make sure you've got your personal organization selected in the upper
left. Then, go to projects, "Add Project" and find the new repository. If you don't
see it, try refreshing. There it is! Click "Setup Project".

Awesome! We *are* going to use version 2.0 of their platform: it's all based on
Docker and is super trendy. PHP is already selected as the language, so we can just
click the "Copy to clipboard" button.

Basically, the *only* thing we need to do is create a `config.yml` file with instructions
on how to build our project: what container image to use, what tools we need
installed, and what commands run the tests. CircleCI summons the robot army and
takes care of the rest.

## Bootstrapping .circleci/config.yml

Over in our editor, create a `.circleci` directory with a `config.yml` file inside.
Paste!

[[[ code('10ad6dac7c') ]]]

Woh! This is great! CircleCI is *super* powerful... but it can be a little confusing
at first. That's probably why they gave us this amazing starter config! It uses
a recent PHP image. The `-browsers` part means it comes pre-installed with tools
that help you test in a browser... like if you're using Mink. That's awesome!

It also installs the composer dependencies, does some smart caching to speed up
builds, and executes PHPUnit. Actually, that's the only thing I want to change
right now: use `./vendor/bin/phpunit` instead of the globally installed version.

[[[ code('e1d95c2181') ]]]

Let's see what happens! In the terminal, add the directory, create a commit, and
push!

```terminal-silent
git add .circleci
git commit -m "adding CircleCI config - Woo"
git push origin master
```

This won't activate our first build *yet*, but we *do* have a functional config
file. And that means we can click "Start Building". Deep breath. Do it!

This installs a webhook on GitHub so that every push will automatically trigger a
build. And because CircleCI is so friendly, it even started our first build.

## Where is Composer?

And... within 2 seconds, it failed! Geez! It *did* start the environment, which means
it built the container image. Sometimes the image will be cached - it was this time.
When that happens, it's *super* fast. Then, it checked out our code and... huh!
It failed because composer is missing?

That's especially weird because this is *their* default config! The fix is mysterious.
Ready for it? Remove the `.5` from the image name. 

[[[ code('645a0cf66a') ]]]

In your terminal, commit this - "Using a different image" and push to origin master:

```terminal-silent
git add -u
git commit -m "Using a different image"
git push origin master
```

This *should* trigger build #2. Click on master and... there it is! So... why did
we do that? It's actually a bug with CircleCI. For some reason, *some* of their images
are missing composer. From a bit of debugging I did earlier, I found out that the
7.1 image *has* composer, but the 7.1.5 is missing it. Weird!

Anyways, this time you can see it build the image: it was *not* cached. And awesome!
It's downloading our composer deps! And saving cache and... woh!

PHPUnit ran! And... it *almost* passed. The failures are all the same:

> Unable to open database file

Of course! Remember: our test database is stored in `var/data`. But since none
of this is committed, there *is* no `var/data` directory. That means that sqlite
file can't be created.

For better or worse, this is the flow when you setup continuous integration: make
some tweaks, push, wait, debug and repeat. But! If you have a *really* tricky problem,
you can actually "rebuild with SSH access". This runs the build again, but then
keeps the container alive after and gives you SSH access. That's an *amazing* way
to run some commands and find out what's going wrong.

Back in `config.yml`, add a new `run` line: `mkdir var/data`.

[[[ code('b39776b0e3') ]]]

You know the drill: find your terminal, commit that change and push!

## CircleCI Reference

We're not going to go into deep detail about the CircleCI config. But, if you Google
for "CircleCI Config Reference", you'll find an [awesome page](https://circleci.com/docs/2.0/configuration-reference/)
on their documentation. 

And woh! CircleCI is *powerful*. In our [Ansistrano](https://knpuniversity.com/screencast/ansistrano)
tutorial, we used CircleCI and workflows to *deploy* our code. The tests would run
first, and *if* they passed, it would trigger a second "deploy" job. Cool stuff!

Go back to the CircleCI page and find the latest build. Ha! It *passed*!

In about five minutes, our project has continuous integration!

Next, let's look at one more cool thing with CircleCI: artifacts... which are
test-debugging gold.
