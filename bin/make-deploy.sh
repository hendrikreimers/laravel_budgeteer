#! /bin/bash

source ./install-prod.sh
rm ./_deploy/budgeteer.tar.bz2
rm ./database/db.sqlite
touch ./database/db.sqlite
tar cjf /tmp/budgeteer.tar.bz2 .
mv /tmp/budgeteer.tar.bz2 ./_deploy/
