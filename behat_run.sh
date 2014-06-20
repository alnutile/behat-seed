#!/bin/sh

TEST=$1
if [[ $TEST == 'all' ]]
then
  TEST=''
fi

STOP=$2
if [[ $STOP == 'stop' ]]
then
  STOP='--stop-on-failure'
fi

echo Running tests tests/features/$TEST
#refresh database?
#php artisan migrate:refresh --seed
bin/behat $STOP --config tests/behat.yml tests/features/$TEST
