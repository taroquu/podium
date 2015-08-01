# Introduction #

Podium CMS is presently released only for proof of concept and preview. The system is unfinished and should not be used in production.


# System Requirements #

Podium CMS requires the following

  * Apache Web Server 2.2 or later with both mod\_rewrite and .htaccess overrides enabled
  * PHP 5.3 or later
  * MySQL 5.5.15 or later

Podium may function with earlier version of MySQL or Apache but this is not tested. No earlier PHP version can be used.

# Installation #
  * Download the Podium CMS ZIP from the downloads page.
  * Extract the contents
  * Place the PodiumCMS directory into an Appache accessible directory (for example /var/www or C:\Program Files\Apache Software Foundation\Apache2.2\htdocs)
  * Ensure that _PodiumCMS/cache_ and _PodiumCMS/media_ are writable
  * Create a new database for Podium to use
  * Update PodiumCMS/config/picon.xml with your database details
  * Using phpMyAdmin or similar, run either [podium.sql](http://podium.googlecode.com/svn/tags/0.1alpha/sql/podium.sql) OR [helix.sql](http://podium.googlecode.com/svn/tags/0.1alpha/sql/helix.sql) to create the database structure and insert some data. podium.sql contains the bare minimum for a website, helix.sql contains a very simple sample website.
  * Navigate to http://localhost/PodiumCMS to view the site
  * Navigate to http://localhost/PodiumCMS/admin to view the admin portal