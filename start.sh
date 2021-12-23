#!/usr/bin/env bash

docker-compose up -d
docker-compose run consumer ./console queue:consume
