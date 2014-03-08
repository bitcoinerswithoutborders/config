hhvm-config
===========

this contains the hhvm config we are currently playing around with.

install process on fedora, very crude, be careful!
first install hhvm.
then: 
    
    su
    cd /var/www
    git clone https://github.com/bitcoinerswithoutborders/hhvm-config.git .
    git clone bwb wordpress repository, not yet online, instead:
    mkdir /var/www/bwb && cd /var/www/bwb
    wget https://wordpress.org/latest.zip
    unzip latest.zip .
    mv wordpress/* .
    rm ./wordpress -rf
    
    
after those steps there will be a /var/www/bwb/ directory, housing all the wordpress files.
since this should be achieved with composer and some other nifty tools the pipeline for this part is not done yet.
just downloading wordpress and putting it into the folder should work as well though.

config tested with:
wordpress 3.8.1 multisite - everything basically works, some rewrites missing

newest version of fpdf - successfully renders pdf populated out of a folder of files.

PROBLEMS:
/wp-admin/, /wp-admin/network/ -> rewrite wont work, need to manually append index.php.
