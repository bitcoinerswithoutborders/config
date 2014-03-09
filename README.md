##hhvm-config

#####DONT USE THIS REPO DIRECTLY!


Use http://github.com/bitcoinerswithoutborders/installer instead to get a dev environment set up for you.

this repo contains the hhvm config and the composer.json we are currently playing around with.

it will automatically be loaded using the dockerfile in the installer above.


#####Contents of this repo:

######hhvm.hdf:
a config file for http://hhvm.com that has all the settings needed to run wordpress. its not in production use yet though and not tested thouroughly, works on local install.

######hhvm.repo:
the file containing the fedora repo information for the facebook hhvm repo. this allows automated install through the dockerfile in the installer package

######hhvm.sh:
shell file to start, stop and restart the hhvm.
uses hhvm.pid in the same folder hhvm.sh is executed and the globally installed hhvm

######composer.json:
loads some php libraries needed to use wp-cli,

loads wordpress from https://github.com/wordpress/wordpress

######composer.lock
has the versions we use to test in it.

######src dir:
has the composer install scripts, those will later also invoke wp-cli to create the blogs, plugins, images and other content of our installs as well as default content.

######templates dir:
holds a wp-config sample file that will be used to generate our wp-config.php files.

######.gitignore
sets all the directories the composer creates to be ignored by git.
