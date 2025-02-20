#!/bin/bash

# Update package lists
apt-get update

# Install required dependencies
apt-get install -y unzip

# Install Composer
curl -sS https://getcomposer.org/installer | php

# Move Composer to a globally accessible location
mv composer.phar /usr/local/bin/composer

# Start the Apache server
apache2-foreground
