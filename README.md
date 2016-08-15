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

### Create Database Configuration

### Create Environment Files

### Build Database

