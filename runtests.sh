#!/bin/sh

#
# Command line runner for unit tests for composer projects
# (c) Del 2015 http://www.babel.com.au/
# No Rights Reserved
#

#
# Set up local environment
#
for file in deploy/jenkins/*; do
    TARGETFILE=`basename $file | sed -e 's;+;/;g' -e 's/DOT/\./g'`
    if [ ! -f $TARGETFILE ]; then
        echo "Copying $file to ${TARGETFILE}"
        cp $file ${TARGETFILE}
    fi
done
. ./.env

#
# Create the test database.  This also updates dependencies.
#
./makedb.sh

#################################################################################
#
# codeception test runner
#
#################################################################################

#
# To generate a cest test for functional, do this:
#
# codecept generate:cest functional CestName
#

#
# Clean up after any previous test runs
#
rm -rf tests/_output
mkdir -p tests/_output documents
rm -f documents/coverage.xml documents/phpunit.xml
rm -f storage/logs/*.log

vendor/bin/codecept run functional,unit --xml --coverage-html --coverage-xml

if [ -d tests/_output/coverage ]; then
    rm -rf documents/coverage-html
    mv tests/_output/coverage documents/coverage-html
fi

if [ -f tests/_output/coverage.xml ]; then
    mv tests/_output/coverage.xml documents/coverage.xml
fi

if [ -f tests/_output/report.xml ]; then
    mv tests/_output/report.xml documents/phpunit.xml
fi
