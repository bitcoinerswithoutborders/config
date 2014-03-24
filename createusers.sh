#!/bin/bash

function createUser {
  echo $1
  useradd $1
  pass=$(makepasswd -m 42)
  echo $pass | passwd $1
  echo "please copy the password from the next line, it will not be saved anywhere! make sure not to include the spaces around the password!"
  echo "Created User with Username: $1 and password: | $pass |"
}

createUser $1
