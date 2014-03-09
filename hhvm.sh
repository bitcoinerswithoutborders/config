#~ QUICK AND DIRTY, will throw exceptions and happily "continue"

case "$1" in
  start)
		echo "Starting hhvm"
        hhvm -m daemon -p 80 -c /var/www/hhvm.hdf
		echo "[Probably Ok... No tests have been done]"
        ;;
  stop)
		echo "Killing hhvm with pid `cat /var/www/hhvm.pid`"
        kill -SIGTERM `cat /var/www/hhvm.pid`
		echo "[Probably Ok... No tests have been done]"
        ;;
  restart)
		echo "Killing hhvm with pid `cat /var/www/hhvm.pid`"
        kill -SIGTERM `cat /var/www/hhvm.pid`
        echo "Starting hhvm"
        hhvm -m daemon -p 80 -c /var/www/hhvm.hdf
		echo "[Probably Ok... No tests have been done]"
        ;;
  *)
        echo "Usage: /var/www/hhvm.sh {start|stop|restart}"
        exit 1
esac

exit 0
