#!/bin/bash

set -xe

docker-compose up -d

sleep 2

cp conf api/ressources
cp conf auth/ressources

docker exec api /opt/lampp/htdocs/ressources/init-bdd.sh
docker exec auth /opt/lampp/htdocs/ressources/init-bdd.sh

sleep 2

docker-compose restart
