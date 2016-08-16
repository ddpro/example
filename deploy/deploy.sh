#!/bin/sh

#
# software deployment script -- run via jenkins or from the command line
# MIT License
# (c) Del 2015 http://www.babel.com.au/
# No Rights Reserved
#
# Dependencies:
#
# * A successful minimal + base install must have been run on the target server.
# * Either apache or nginx.
# * php must be installed on the target server
# * composer must be installed on the target server and available in the default search path
# * root access must be available to the target server.  We assume that there is a ssh
#   public key allowing the user that is running this script to log in as root on the target
#   server.
# * If there is a gulpfile.js in the application root then we assume that npm is installed and
#   executable on the target server (npm for CentOS is in the EPEL repository).
# * If there is a bower.json file in the application root then we assume that bower is installed
#   and executable on the target server.
#
# usage: deploy.sh server.name
#

SCRIPT=`readlink -f $0`
DIRNAME=`dirname $SCRIPT`
STARTDIR=`dirname $DIRNAME`

##################################################################################
# Get config
##################################################################################

if [ $# -ne 1 ]; then
    echo "usage: $0 servername"
    exit 1
fi
TARGET=$1

cd $STARTDIR
if [ ! -f deploy/$TARGET.conf ]; then
    echo "No config file available: deploy/${TARGET}.conf"
    exit 1
fi

cd $STARTDIR
. deploy/${TARGET}.conf
echo "Deploying to ${TARGETUSER}@${TARGETSERVER}:${TARGETDIR}"

. deploy/sources.conf
echo "Deploying ${SOURCES}"

##################################################################################
# Build server infrastructure directories
##################################################################################

#
# Check user account
#
cd $STARTDIR
echo "Checking ${TARGETUSER} account and creating if required"
ssh root@${TARGETSERVER} "
    if [ ! -d /home/${TARGETUSER} ]; then
        adduser -c 'Web site owner' -G $WEBGROUP $TARGETUSER
        mkdir -p /home/${TARGETUSER}/.ssh
        cp /root/.ssh/authorized_keys /home/${TARGETUSER}/.ssh
        chown -R ${TARGETUSER} /home/${TARGETUSER}
    fi
"

#
# Set up deployment directories
#
echo "Setting up target directories $TARGETDIR and $TARGETSTORAGE"
ssh root@${TARGETSERVER} "
    mkdir -p $TARGETDIR
    mkdir -p $TARGETSTORAGE
    chown -R ${TARGETUSER} $TARGETDIR
    chgrp -R ${WEBGROUP} $TARGETDIR
"

##################################################################################
# Deploy web site software
##################################################################################

#
# Make a backup before starting
#
if [ "$TARGETDEPLOYDB" != "new" ]; then
    echo "Backing up existing web files and database on $TARGETSERVER"
    BACKDATE=`date '+%Y%m%d_%H%M'`
    DIR=`basename $TARGETDIR`
    BACKDIR=${BACKDATE}_${DIR}
    ssh root@${TARGETSERVER} "
        cd $TARGETDIR
        cd ..
        mkdir -p backups
        cp -a $TARGETDIR backups/$BACKDIR
        if [ "$DBBACKUP" = "yes" ]; then
            mysqldump -u $TARGETDBUSER --password=$TARGETDBPASS -h ${TARGETDBHOST} ${TARGETDBNAME} | gzip > backups/${BACKDATE}_${TARGETDBNAME}.sql.gz
        else
            echo "Database backup disabled on $TARGETSERVER. Change DBBACKUP=yes in your config file to enable"
        fi
    "
fi

#
# Deploy web software files
#
cd $STARTDIR
echo "Syncing web files to $TARGETDIR"
rsync -vaz --delete $SOURCES ${TARGETUSER}@${TARGETSERVER}:${TARGETDIR}

#
# Deploy modified config files
#
echo "Deploying config files in ${STARTDIR}/deploy/${TARGETSERVER}"
cd ${STARTDIR}/deploy/${TARGET}
for file in *; do
    TARGETFILE=`echo $file | sed -e 's;+;/;g' -e 's/DOT/\./g'`
    echo "Copying $file to ${TARGETSERVER}:${TARGETDIR}/${TARGETFILE}"
    scp $file ${TARGETUSER}@${TARGETSERVER}:${TARGETDIR}/${TARGETFILE}
done

#
# Install root config files.
#
echo "Installing root configuration files on ${TARGETSERVER}"
cd ${STARTDIR}/deploy/root/${TARGET}
for file in *; do
    TARGETFILE=`echo $file | sed 's;+;/;g'`
    echo "Copying $file to ${TARGETSERVER}:/${TARGETFILE}"
    scp $file root@${TARGETSERVER}:/${TARGETFILE}
done

#
# Web user config post install
#
ssh ${TARGETUSER}@${TARGETSERVER} "
    cd $TARGETDIR
    if [ -f composer.lock ]; then
        composer install
    else
        composer update
    fi
    if [ -f bower.json ]; then
        bower install
    fi
    if [ -f gulpfile.js ]; then
        npm install --quiet --save-dev gulp
        npm install --quiet
        ./node_modules/.bin/gulp
    fi
"

##################################################################################
# Deploy database
##################################################################################

if [ "$TARGETDEPLOYDB" = "new" ]; then
    echo "Creating new database"
    #
    # Drop and recreate the database to ensure it's clean.
    #
    ssh ${TARGETUSER}@${TARGETSERVER} "
        cd ${TARGETDIR}
        mysql -u root --password=$TARGETDBAPASS -h ${TARGETDBHOST} << EOFDB
        SET FOREIGN_KEY_CHECKS=0;
        DROP DATABASE IF EXISTS ${TARGETDBNAME};
        CREATE DATABASE ${TARGETDBNAME} CHARACTER SET utf8;
        GRANT ALL ON ${TARGETDBNAME}.* TO ${TARGETDBUSER}@localhost IDENTIFIED BY '${TARGETDBPASS}';
EOFDB
    "
fi

#
# Run the database migration.
#
if [ "$TARGETDEPLOYDB" != "none" ]; then
    echo "Running database migration"
    ssh ${TARGETUSER}@${TARGETSERVER} "
        cd ${TARGETDIR}
        chmod -R g-w .
        php artisan migrate
    "
fi

#
# Run the database seed only on a new database.
#
if [ "$TARGETDEPLOYDB" = "new" ]; then
    echo "Running database seed"
    ssh ${TARGETUSER}@${TARGETSERVER} "
        cd ${TARGETDIR}
        php artisan db:seed
    "
fi

#
# Reset permissions
#
echo "Fixing permissions"
ssh root@${TARGETSERVER} "
    chown -R ${TARGETUSER} ${TARGETDIR}
    chgrp -R ${WEBGROUP} ${TARGETDIR}
    chmod -R g-w ${TARGETDIR}
    chmod -R g+rX ${TARGETDIR}
    chmod -R o-rwx ${TARGETDIR}
    find ${TARGETDIR} -type d -exec chmod g+s {} \;
    chown -R ${WEBUSER} ${TARGETSTORAGE}
    chgrp -R ${WEBGROUP} ${TARGETSTORAGE}
    chmod -R g+rwX ${TARGETSTORAGE}
    chmod -R o-rwx ${TARGETSTORAGE}
    find ${TARGETSTORAGE} -type d -exec chmod g+ws {} \;
"
