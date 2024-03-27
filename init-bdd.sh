#!/bin/bash

set -xe

docker-compose up -d

docker exec api /opt/lampp/htdocs/ressources/init-bdd.sh
docker exec auth /opt/lampp/htdocs/ressources/init-bdd.sh
