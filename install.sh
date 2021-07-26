#!/bin/bash
# MyCinema CMS install initializer

echo "Starting MyCinema CMS install wizard..."

# check if docker-compose is installed
if ! command -v docker-compose &> /dev/null
then
    echo "docker-compose cannot be found. Please install it and try again."
    exit
fi

# start containers
docker-compose up --build -d