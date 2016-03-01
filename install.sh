# INSTALL BOOT2DOCKER
if ! type "boot2docker" > /dev/null; then
    echo "Downloading boot2docker"
    curl -L# https://github.com/boot2docker/osx-installer/releases/download/v1.7.0/Boot2Docker-1.7.0.pkg > b2d.pkg

    echo "Installing boot2docker"
    sudo installer -pkg b2d.pkg -target /
    rm -rf b2d.pkg

    echo "Creating virtual machine"
    boot2docker init
else
    echo "boot2docker already installed"
fi

# BOOT VM
echo "Booting virtual machine"
boot2docker up
eval "$(boot2docker shellinit)"

# INSTALL DOCKER-COMPOSE
if ! type "docker-compose" > /dev/null; then
	echo "Downloading/installing docker-compose"
	curl -L# https://github.com/docker/compose/releases/download/1.3.1/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
	chmod +x /usr/local/bin/docker-compose
else
	echo "docker-compose already installed"
fi

# BUILD CONTAINERS
echo "Building containers"
docker-compose build

# COPY ENVIRONMENT VARIABLES
cp www/api/.env.example www/api/.env

# INSTALL COMPOSER DEPENDENCIES
docker-compose run composer install

# RUN MIGRATIONS
docker-compose run artisan migrate

# INSERT DATA INTO DATABASE
docker-compose run artisan db:seed

#GENERATE CIPHER KEY
docker-compose run artisan key:generate

# APPLY PERMISSIONS FOR DEVELOPMENT
cd www/api && sudo chmod -R 777 storage && sudo chmod -R 777 bootstrap/cache && cd -

# RUN CONTAINERS
echo "Running containers"
docker-compose up -d

# NOTICES
echo ""
echo "Set the following hosts in you /etc/hosts file"
echo "192.168.59.103 api.test.com"
echo "192.168.59.103 admin.test.com"
echo "192.168.59.103 frontend.test.com"
echo ""

echo "Happy hunting!"
