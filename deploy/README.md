# Deployment Script

This is a simple software deployment script -- it can be run via jenkins or from the command line.

This is released under the MIT License.

Copyright (c) Del 2015 http://www.babel.com.au/

No Rights Reserved.  Do whatever you want with this, it's free.

## Usage

deploy.sh server.name

## Dependencies

* A successful minimal + base install must have been run on the target server.
* Either apache or nginx must be installed.
* php must be installed on the target server
* composer must be installed on the target server and available in the default search path
* root access must be available to the target server.  We assume that there is a ssh public key allowing the user that is running this script to log in as root on the target server.
* If there is a gulpfile.js in the application root then we assume that npm is installed and executable on the target server (npm for CentOS is in the EPEL repository).
* If there is a bower.json file in the application root then we assume that bower is installed and executable on the target server.

## Setup

This script relies on the following:

* A configuration file called TARGETSERVER.conf.  This contains the environment variables to drive the script.  See the example .conf file.
* A sources.conf file.  This contains a list of files and directories to be deployed.
* A directory called TARGETSERVER.  This is populated with files that are deployed on the target server after the source deployment is done, into the target deployment directory (TARGETDIR in the .conf file).
* A directory called root/TARGETSERVER.  This is populated with files that are deployed to the root of the filesystem on the target server.

The files in the TARGETSERVER and root/TARGETSERVER directories are named to a common convention, which is:

dir1+dir2+filename.ext

... where the file is to be deployed to dir1/dir2/filename.ext.  Directories can be nested to any level.  So, for example, the file root/server.name/etc+httpd+conf.d+virtual.conf is deployed to /etc/httpd/conf.d/virtual.conf on server.name.

