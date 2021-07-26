#!/bin/bash
# MyCinema CMS install initializer

echo "Starting MyCinema CMS install wizard..."

# check if docker-compose is installed
if ! command -v docker-compose &> /dev/null
then
    echo "docker-compose cannot be found. Please install it and try again."
    exit
fi

# check if npm is installed
if ! command -v npm &> /dev/null
then
    echo "npm cannot be found. Please install it and try again."
    exit
fi

cd www/Views 

# install node_modules
npm install
# build assets
npm run build

# start containers
docker-compose up --build -d