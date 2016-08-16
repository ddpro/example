# example

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
