#!/usr/bin/env bash

docker-compose down
docker-compose up -d
docker-compose run consumer ./console queue:consume

#this is a comment that will cause a merge conflict
