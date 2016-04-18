# Contributing to Oath Server Suite

## About

This document provides a set of best practices for contributions - bug reports, code submissions / pull requests, etc.

## Sources

This document is based on the open source document [Contributing to Open Source Projects](http://contribution-guide-org.readthedocs.org/) by  [Jeff Forcier](https://github.com/bitprophet).

## Submitting bugs

### Due diligence

Before submitting a bug, please do the following:

- Perform **basic troubleshooting** steps:
  - **Make sure you’re on the latest version.** If you’re not on the most recent version, your problem may have been solved already!  
  Upgrading is always the best first step.
  - **Try older versions.** If you’re already on the latest release, try rolling back a few minor versions (e.g. if on 1.7, try 1.5 or 1.6) and see if the problem goes away. This will help the devs narrow down when the problem first arose in the commit log.
  - **Try switching up dependency versions.** If the software in question has dependencies (other libraries, etc) try upgrading / downgrading those as well.
- **Search the project’s issue tracker** to make sure it’s not a known issue.

#### What to put in your bug report

Make sure your report gets the attention it deserves: bug reports with missing information may be ignored or punted back to you, delaying a fix. The below constitutes a bare minimum; more info is almost always better:

- **What PHP version** are you using?
- **Which additional core libraries and extensions** in which versions are available?
- **What operating system in which version are you on?** Again, more detail is better.
- **Which version of the software are you using?** Ideally, you followed the advice above and have ruled out (or verified that the problem exists in) a few different versions.
- **How can the developers recreate the bug on their end?** If possible, include a copy of your code, the command you used to invoke it, and the full output of your run (if applicable.)  
A common tactic is to pare down your code until a simple (but still bug-causing) “base case” remains. Not only can this help you identify problems which aren’t real bugs, but it means the developer can get to fixing the bug faster.

## Contributing changes

### Version control branching

Always **make a new branch** for your work, no matter how small. This makes it easy for others to take just that one set of changes from your repository, in case you have multiple unrelated changes floating around.

- A corollary: **don’t submit unrelated changes in the same branch / pull request!** The maintainer shouldn’t have to reject your awesome bugfix because the feature you put in with it needs more review.

**Base your new branch off of the appropriate branch** on the main repository:

- **Bug fixes** should be based on the branch named after the oldest supported release line the bug affects.
  - E.g. if a feature was introduced in 1.1, the latest release line is 1.3, and a bug is found in that feature - make your branch based on 1.1. The maintainer will then forward-port it to 1.3 and master.
  - Bug fixes requiring large changes to the code or which have a chance of being otherwise disruptive, may need to base off of `master` instead. This is a judgement call – ask the devs!
- **New features** should branch off of **the `master` branch.**
  - Note that depending on how long it takes for the dev team to merge your patch, the copy of `master` you worked off of may get out of date! If you find yourself ‘bumping’ a pull request that’s been sidelined for a while, **make sure you rebase or merge to latest `master`** to ensure a speedier resolution.

### Code formatting

**Follow the style you see used in the primary repository!** Consistency with the rest of the project always trumps other considerations. It doesn’t matter if you have your own style or if the rest of the code breaks with the greater community - just follow along.

PHP projects usually follow the [PHP Standards Recommendations guidelines](http://www.php-fig.org/psr/) (though many have minor deviations depending on the lead maintainers’ preferences.)

### Documentation isn’t optional

It’s not! Patches without documentation will be returned to sender. By “documentation” we mean:

- **Docstrings / DocBlocks** must be created or updated for public and private API methods.
- New features should ideally include **a brief description of business logic,** including useful example code snippets.
- All submissions should have **changelog styled commit and pull request messages** crediting the contributor and / or any individuals instrumental in identifying the problem.

### Tests aren’t optional

Any bugfix that doesn’t include a test proving the existence of the bug being fixed, may be suspect. Ditto for new features that can’t prove they actually work.

We’ve found that test-first development really helps make features better architected and identifies potential edge cases earlier instead of later. Writing tests before the implementation is strongly encouraged.

Sometimes testing is hard because it is not possible to create an environment on the developers machine to fulfill the softwares requirements in the middleware setup. For example installing imagick on Mac OS X could be a task straight out of hell. In this case it is useful to provide a out-of-the-box running machine setup like [docker](https://www.docker.com/) ot [vagrant](https://www.vagrantup.com/) and run tests on the virtual machine via the commandline interface.

## Contributing requirements

For development purposes there is a [vagrant](https://www.vagrantup.com/) setup included in the repo to fulfill the server side requirements easily. 

### Installation and testing example (Mac OS X)

#### Installation of vagrant

Get your vagrant version from [https://www.vagrantup.com/downloads.html](https://www.vagrantup.com/downloads.html) and run the installer. 

#### Starting the virtual machine and connect via SSH

```
cd php-oath-server-suite
vagrant up
vagrant ssh
```

#### Running the tests via command line interface

```
cd /var/www/php-oath-server-suite
phpunit --bootstrap vendor/autoload.php --configuration phpunit.xml.dist
```

## Full example

Here’s an example workflow for `php-oath-server-suite` hosted on Github, which is currently in version 3.0.12. Your username is `yourname` and you’re submitting a basic bugfix. 

### Preparing your Fork

- Hit ‘fork’ on Github, creating e.g. `yourname/php-oath-server-suite`
- Clone your project  

```
git clone git@github.com:yourname/php-oath-server-suite
```

- Create a branch

```
cd php-oath-server-suite
git checkout -b fix-issue-269 3.0.12
```

### Making your Changes

- Write tests expecting the correct / fixed functionality; make sure they fail.
- Hack, hack, hack.
- Run tests again, making sure they pass.
- Commit your changes

```
git commit -m "Changelog styled commit message crediting yourself"
```

### Creating Pull Requests

- Push your commit to get it back up to your fork

```
git push origin HEAD
```

- Visit Github, click handy “Pull request” button that it will make upon noticing your new branch.
- In the description field, write down issue number (if submitting code fixing an existing issue) or describe the issue + your fix (if submitting a wholly new bugfix).
- Hit ‘submit’! And please be patient - the maintainers will get to you when they can.

