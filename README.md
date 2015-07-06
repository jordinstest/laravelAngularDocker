# LaravelAngularDocker

## Laravel specific Docker set-up. 

### Getting started

#### Requirements 
Make sure you have a CoreOS VM or on OSX boot2docker installed and running. Also make sure you have docker-compose installed. 

1. docker-compose build
2. docker-compose up
3. cp -r www/api/.env.example www/api/.env
4. docker-compose run composer install && docker-compose run artisan migrate

Set up your vhosts:

```
# Test Project
192.168.59.103 api.test.com
192.168.59.103 admin.test.com
192.168.59.103 frontend.test.com
```

Visit http://ewanvalentine.io/running-laravel-and-angularjs-on-docker/ for more info. 
