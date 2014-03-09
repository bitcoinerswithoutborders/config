#!/bin/bash

case "$1" in
  start)
		echo "Starting hhvm"
        hhvm -m daemon -p 80 -c /var/www/hhvm.hdf
		echo "[Ok]"
        ;;
  stop)
		echo "Killing hhvm with pid `cat /var/www/hhvm.pid`"
        kill -SIGTERM `cat /var/www/hhvm.pid`
		echo "[OK]"
        ;;
  restart)
		echo "Killing hhvm with pid `cat /var/www/hhvm.pid`"
        kill -SIGTERM `cat /var/www/hhvm.pid`
        echo "Starting hhvm"
        hhvm -m daemon -p 80 -c /var/www/hhvm.hdf
		echo "[OK]"
        ;;
  *)
        echo "Usage: /var/www/hhvm.sh {start|stop|restart}"
        exit 1
esac

exit 0
