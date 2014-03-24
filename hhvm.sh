#!/bin/bash

function startHHVM {
  echo "Looking if hhvmd is started"

  if [ -e /docker/config/hhvm.pid ] ; then
    pid=$(cat /docker/config/hhvm.pid)
    echo "hhvm is running already. pid = $pid"
  else
    echo "Starting hhvm."
    hhvm -m daemon -p 80 -c /docker/config/hhvm.hdf
    echo "Daemon Started."
  fi
  return 1
}

function stopHHVM {
  if [ -e /docker/config/hhvm.pid ] ; then
    pid=$(cat /docker/config/hhvm.pid)
    echo "Killing hhvm with pid $pid"
    kill -SIGTERM ${pid}
    rm /docker/config/hhvm.pid -f
  else
    echo "hhvm is not running."
  fi
  return 1
}


case "$1" in
  start)
    startHHVM
    echo "[Ok]"
    ;;

  stop)
    stopHHVM
    echo "[OK]"
    ;;

  update)
    echo "Running hhvmd update"
    cd /docker/config/
    git pull
    echo "hhvmd updated, restarting hhvm daemon now"
    stopHHVM
    startHHVM
    echo "[OK]"
    ;;

  restart)
    stopHHVM
    startHHVM
    echo "[OK]"
    ;;

  *)
    echo "Usage: hhvmd {start|stop|restart|update}"
    exit 1
esac

exit 0
