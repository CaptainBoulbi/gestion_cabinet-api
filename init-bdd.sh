#!/bin/bash

set -xe

docker-compose up -d

docker exec api /opt/lampp/htdocs/init-bdd.sh
docker exec auth /opt/lampp/htdocs/init-bdd.sh
