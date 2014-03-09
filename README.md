hhvm-config
===========

DONT USE THIS REPO DIRECTLY!
=======
Use http://github.com/bitcoinerswithoutborders/installer instead to get a dev environment set up for you.

this contains the hhvm config and the composer.json we are currently playing around with.

config version 0.0.2 with:

wordpress 3.8.1 - sub domain multisite, staticfiles, url rewrites all work.

newest version of fpdf - successfully renders pdf populated out of a folder of files, successfully routes the page to index.php

composer.json added, not working correctly yet.

config version 0.0.1:

wordpress 3.8.1 multisite - everything basically works, some rewrites missing

newest version of fpdf - successfully renders pdf populated out of a folder of files.

PROBLEMS:
/wp-admin/, /wp-admin/network/ -> rewrite wont work, need to manually append index.php.


composer.json is wip.

