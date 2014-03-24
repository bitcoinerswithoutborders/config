#!/bin/bash

hhvmd stop

echo "Removing /docker/config/vendor"
rm -rf /docker/config/vendor

echo "Removing /docker/config/hhvm.pif"
rm -f /docker/config/hhvm.pid

echo "Removing /docker/log"
rm -rf /docker/log/

echo "Removing /docker/config/bwb"
rm -rf /docker/config/bwb
