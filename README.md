# DDPro Example Application

[![StyleCI](https://styleci.io/repos/65351271/shield)](https://styleci.io/repos/65351271)
[![Latest Stable Version](https://poser.pugx.org/ddpro/example/version.png)](https://packagist.org/packages/ddpro/example)
[![Total Downloads](https://poser.pugx.org/ddpro/example/d/total.png)](https://packagist.org/packages/ddpro/example)

This is an example application using the DDPro packages.  The packages used include:

* https://github.com/ddpro/admin

## How To Build This

You can use these steps to build a new application using these packages or you can use some
of the steps as indicated below to incorporate the admin panel and other packages into your
own existing application.

### Build New

The instructions to install Laravel and build a new application are here: https://laravel.com/docs/5.1/installation

The path that I took was to build a new application using composer:

    composer create-project laravel/laravel example "5.1.*"

### Incorporate DDPro Admin

The DDPro Admin instructions are here: https://github.com/ddpro/admin/blob/master/docs/installation.md

The steps that I took were:

* composer require

    composer require ddpro/admin

* Edit the config/app.php file to include the service provider:

    'providers' => [
        DDPro\Admin\AdminServiceProvider::class,
    ]

* Publish the assets, configuration, etc, from the DDPro classes:

    php artisan vendor:publish --force

### Configure DDPro Admin

Configuring DDPro Admin is mostly done by editing the configuration file in config/administrator.php, which
is published by running `php artisan vendor:publish` above.  The only changes that I made were:

* Change the permission() function to return true.  This means that the example application needs no logins.
* Create the menu array with the list of model configuration files that are configured in config/administrator.

### Create Database Configuration

    cp .env.example .env

Then edit the .env file to contain the correct database parameters, etc.

### Create DDPro Admin Configuration Files

There is a basic data model created by the migration files in database/migrations, and the corresponding
model files in app/Models.

In addition to these, the files in config/administrator and config/administrator/settings have been created
to configure the DDPro Admin model configuration.  See [the instructions here](https://github.com/ddpro/admin/blob/master/docs/model-configuration.md) for more details on how to do that including the structure and contents of a model configuration file.


### Deployment

I created a [simple deployment script and files in the deploy directory](/deploy/README.md) which can be used to deploy the application including all of the dependencies.

## Codeception

I have used [codeception](http://codeception.com/) as a test framework.  I haven't made any great effort to achieve a high level of test coverage, this is only an example application after all.  To create the test harness follow these steps:

* Include the following lines in your composer.json file, and run composer update:

```
    "require-dev" : {
        "codeception/codeception": "~2.1",
        "phpspec/phpspec" : "~2.1",
        "fzaninotto/faker": "~1.4" 
    },
```

Remove any dependency you have on phpunit, because codeception will require its own preferred version of phpunit, and including a dependency on your version may cause dependency conflicts.

You can bootstrap the entire codeception suite including the configuration files and the tests folder using this command:

```
    vendor/bin/codecept bootstrap
```

However for the most part you can copy the codeception suite from another project into your project (everything under the tests directory plus the top level codeception.yml file).

### Codeception Configuration

The codeception configuration is stored in yml files – one at the top level (codeception.yml) and the others at the lower levels (acceptance.suite.yml, functional.suite.yml and unit.suite.yml). It's possible to add suites to codeception ([see here](http://codeception.com/docs/reference/Commands) and each suite will have its own yml configuration file.

The phpunit.xml file is not used.

The important things to configure in the files are:

* codeception.yml – change the whitelist of files to include for code coverage in coverage: whitelist: include. This should include all of your source code files but not your views, database migrations, test scripts, etc.
* acceptance.suite.yml – this is mostly commented out. To build an acceptance suite means setting up an internal browser and a remote URL. See the codeception documentation for more details.
* functional.suite.yml – ensure that the Laravel5 module is enabled, and you may want the REST module as well for API tests (although these could be run from a separate API suite).

### Adding New Test Suites

In addition to the standard acceptance / functional / unit test suites, you may want to create additional test suites. To create a test suite use this command:

```
    vendor/bin/codecept generate:suite api
```

Replace `api` by the test suite name.

After adding any test suite check the *.suite.yml config files, and then run:

```
    vendor/bin/codecept build
```

You should run codecept build every time there is a change to one of the yml configuration files.

### Adding New Test Cases to a Suite

In most cases we are running functional tests, generated as Cest classes. To create one of these use this command:

```
    vendor/bin/codecept generate:cest functional MyApiTest
```

Replace `functional` by the test suite name, e.g. "api" if you want to generate an API test.

For more information see [the command reference](http://codeception.com/docs/reference/Commands)

The description of a test cest class [is given here](http://codeception.com/docs/07-AdvancedUsage) Alternatively you can copy existing cest classes from other projects and modify them to suit.
