#!/bin/bash

case "$1" in
  start)
		echo "Starting hhvm"
        hhvm -m daemon -p 80 -c /docker/config/hhvm.hdf
		echo "[Ok]"
        ;;
  stop)
		echo "Killing hhvm with pid `cat /docker/config/hhvm.pid`"
        kill -SIGTERM `cat /docker/config/hhvm.pid`
		echo "[OK]"
        ;;
  restart)
		echo "Killing hhvm with pid `cat /docker/config/hhvm.pid`"
        kill -SIGTERM `cat /docker/config/hhvm.pid`
        echo "Starting hhvm"
        hhvm -m daemon -p 80 -c /docker/config/hhvm.hdf
		echo "[OK]"
        ;;
  *)
        echo "Usage: hhvmd {start|stop|restart}"
        exit 1
esac

exit 0
