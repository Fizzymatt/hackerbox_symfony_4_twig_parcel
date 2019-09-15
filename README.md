# An example of using Parcel.js with Symfony 4 and the Twig templating system #

## Purpose ##

I made this project as part of a tutorial that describes how to use [Parcel.js](https://parceljs.org/) with [Symfony 4](https://symfony.com/4) and the [Twig](https://twig.symfony.com/doc/2.x/intro.html) templating system.

**NOTE: this project has only been tested on OSX.**

## Instructions ##

### Prerequisites ###

- A local installation of the [Composer](https://getcomposer.org/) dependency manager
- A local installation of the latest stable [NodeJs](https://nodejs.org)

### Install dependencies ###

Navigate to the project root and run the following command:

```bash
composer install
```

```bash
npm install
```

```bash
npm install parcel-bundler -g
```

## Running the project in development mode (including file watching) ##

```bash
composer run-local-dev
```

## Running the project in production mode (minification, but no file watching) ##

```bash
composer run-local-prod
```
