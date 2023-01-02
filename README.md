# Symfony backend API showcase

## Development
To start up the app use simple
```bash
make up
```

### To run fixture upon DB
```bash
make db-run-fixtures
```

Makefiles are used heavily in this repository, so if you're tring to do something, it will most likely be already scripted in Makefile.

### How to make new features?
Always use feature branches. Notice, that only master branch is here, that's becasue, all of the features developed in this repository are going to be deployed as separate feature onto UAT / Pre-Prod Environment. And when feature is tested it's gonna be merged into master, and all of the commits after last tag are ready for new release candidate.

## Architecture used
This will be developed mainly using Domain Driven Design, for simplicity and to unify common design patterns. Please follow DDD & Hexa Principles and do not try to hack you way to the code. It will just make it worse for the future.

## Tech. Used
- Symfony flex
- MariaDB
- Prometheus
