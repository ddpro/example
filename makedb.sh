#!/bin/sh

#
# Build a test database
# MIT License
# (c) Del 2015 http://www.babel.com.au/
# No Rights Reserved
#

#
# Set up local environment
#
. ./.env

#
# Ensure that dependencies are installed
#
if [ -f composer.lock ]; then
    composer install
else
    composer update
fi

#
# Create the test database, adjust the root password as required below.
#
echo "Creating new ${DB_DATABASE} database and assigning permissions to ${DB_USERNAME}"
mysql -u root --password=${DBA_PASSWORD} << EOFDB  > /dev/null 2>&1
SET FOREIGN_KEY_CHECKS=0;
DROP DATABASE IF EXISTS ${DB_DATABASE};
CREATE DATABASE ${DB_DATABASE} CHARACTER SET utf8;
GRANT ALL ON ${DB_DATABASE}.* TO ${DB_USERNAME}@localhost IDENTIFIED BY '${DB_PASSWORD}';
EOFDB

# Run migrations and seeds
php artisan migrate
php artisan db:seed
php artisan keylists:loadtimezones
php artisan keylists:loadiso3166countries
php artisan keylists:loadusdrates
php artisan cache:clear
php artisan view:clear

# Clear old data
/bin/rm -rf storage/framework/views/*
/bin/rm -rf storage/logs/*
