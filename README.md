Land Talk on WordPress
======================

About
------------
This repository contains the custom code for the [Land Talk](http://www.landtalk.org) website.  The site is packaged as a WordPress theme, which must be installed and activated in a WordPress installation running a recent version of WordPress.

Required WordPress Plugins
--------------------------
WordPress must have the following plugins installed prior to activation of the site theme for the site to function properly:
- [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/)
- [ACF reCAPTCHA Field](https://wordpress.org/plugins/advanced-custom-fields-recaptcha-field/)

Bundling Front-End Assets
-------------------------
Bundling front-end assets for local development and deploys requires [Node.js/NPM](https://nodejs.org/en/).  With Node/NPM installed, run `npm install` to install dependencies.  Then, for local development, run `npm run watch` to watch the `./static-src` folder for changes and automatically re-bundle front-end assets with debug info.  To bundle front-end assets for production, run `npm run build`.  Note that bundled front-end assets are not tracked by version control, so a fresh clone of the repository will not be ready for deploy until front-end assets have been bundled.

Local Development
-----------------
To run a local WordPress server with the Land Talk custom theme automatically installed, install [Docker](https://www.docker.com), then run `docker-compose up` and wait for image building and setup to complete.  Then, visit [localhost:8000](http://localhost:8000), set up WordPress, and activate the Land Talk custom theme.  Run `npm run watch` at the same time to ensure that front-end assets are up to date.  You can find the local WordPress installation in `./dev-env/wordpress`.  To reset the database, delete `./dev-env/mysql`.

Local Database
--------------
Docker runs a MySQL image with a full MySQL database for the WordPress installation.

To restore the local database from a MySQL dump, place the dumpfile in `./dev-env/dumps`, access the `mysql` container with `docker-compose exec mysql bash`, then run `mysql -u root -proot wordpress < /dumps/file-to-import.sql`.

To dump the local database for upload to a remote server, run `docker-compose exec mysql bash`, then run `mysqldump -u root -proot wordpress > /dumps/exported-file.sql`.  You'll find the exported file in `./dev-env/dumps`.

Deploying
---------
To deploy, first cancel the static asset watch and run `npm run build`.  Then, if you have FTP access to the server, replace the remote `wp-content/themes/landtalk-custom-theme` directory with the local `./landtalk-custom-theme` directory.

If you don't have FTP access to the server, do the following:
1.  Create a Zip archive of the `./landtalk-custom-theme` directory.
2.  In the WordPress admin panel, go to the Appearance > Themes page and click the Activate button on a different theme.
3.  Click on the Land Talk custom theme and click the Delete button in the lower-right.
4.  Click the Add New button, click the Upload Theme button, and navigate to the Zip archive created in step 1.
5.  Activate the newly-uploaded theme.

Note about `./landtalk-custom-theme/class-acf-field-taxonomy_hacked.php`
------------------------------------------------------------------------
To enable ACF's front-end form to allow unauthenticated users to add taxonomy terms, the only solution I could find was to hack one of ACF's internal classes.  This file is the modified version of `wp-content/advanced-custom-fields-pro/includes/fields/class-acf-field-taxonomy.php`; if reinstalling ACF Pro, you'll need to replace the original version of the file with this hacked version.  This has only been found to work on ACF Pro version 5.6.7.
