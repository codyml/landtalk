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

Modifying Custom Fields
-----------------------
The Land Talk WordPress theme defines many groups of custom fields with ACF that are used throughout the site.  These fields are tightly integrated with the site code in many places and the site will break if the fields are configured incorrectly.  ACF saves fields in the WordPress database by default, but because of the tightly-coupled relationship between the fields and the rest of the site, it's advantageous to keep the field definitions in code and under version control as well.  ACF will save field definitions as JSON files if an `acf-json` directory is present in the theme directory, which we've added.  However, some care must still be taken when editing fields to ensure that the field definitions are correctly saved and read from the code:

1. **Never edit fields on the production instance.**  Field edits made on the production site are saved to the live database and to the live site's `acf-json` directory, and while developers who pull the latest live site database for local development will see the updated fields, those changes won't be under version control and can lead to confusion when developers attempt to collaborate on field modifications.  To make it more difficult to accidentally edit fields on the production instance, the "Options" page has a "Production Instance" setting that removes the "Custom Fields" menu item from the admin panel; this setting should be set to "Yes" for production sites.
2. **Edit fields in your local dev environment, but only after syncing the latest changes from the code.**  Though it will save field group edits to files in the `acf-json` directory, ACF will only edit fields that have a record in the WordPress database.  If you've edited fields locally before or are using an old database dump for local development, database records for field groups may already exist, and these records must be manually updated with any recent changes other developers have made that are present in the code to avoid conflicts.  To update this record to prepare for editing fields, first make sure you're working off of the latest commit.  Then, in the Custom Fields section of the admin panel, look for a "Sync available" view at the top of the page after "All" and "Active" but before "Search."  If one is present, this means that the code has updates that need to be applied to the local database.  Click "Sync available," select all field groups, then select "Sync" from "Bulk Actions" and click "Apply."  You can now edit fields, and you should see that any changes you make generate modifications to files in the `acf-json` directory.  Be sure to commit these modifications so other developers can see and work with them.
3. **To update the production instance's fields with your locally-made changes, all you need to do is upload the new code.**  Assuming no one edits the production site's custom fields, the production database will have no field group records and the fields will be based entirely off the content of the JSON files in `acf-json`.  Simply upload the new theme and the fields will update.

For more information on why we use the above workflow, the following is a brief summary of how ACF handles field groups in the database and the code.  When a new field group is created, it's saved in the database and as a new JSON file in `acf-json`, and both the database record and the JSON file are given a timestamp.  Field updates update both the database record and the JSON file, and field deletions delete the database record and the JSON file.  ACF renders all field groups that are present either in the database or as JSON files.  If a field group is present both in the database and as JSON (identified by field key) but with different content, the definition with the most recent timestamp is used.

However, even though fields defined only in JSON will be active and working on the site, they will not appear in the "Field Groups" view of the Custom Fields admin page: only fields defined in the database appear in "Field Groups."  Furthermore, if a field group is in the database but a more recently-edited version is saved as JSON, the "Field Groups" section will show the older database version, and editing that field group will then overwrite the JSON with those edits applied to the older database version, causing the other edits saved in JSON will be lost.

The Sync feature is meant to avoid this problem: when JSON files have newer definitions for a field group that's either already defined in the database but has an older timestamp or isn't in the database at all, a "Sync available" view will appear.  Syncing field groups will update the database record for a field group with the content of the JSON file, or create the database record if the group doesn't exist in the database.s

Note about `./landtalk-custom-theme/class-acf-field-taxonomy_hacked.php`
------------------------------------------------------------------------
To enable ACF's front-end form to allow unauthenticated users to add taxonomy terms, the only solution I could find was to hack one of ACF's internal classes.  This file is the modified version of `wp-content/advanced-custom-fields-pro/includes/fields/class-acf-field-taxonomy.php`; if reinstalling ACF Pro, you'll need to replace the original version of the file with this hacked version.  This has only been found to work on ACF Pro version 5.6.7.
