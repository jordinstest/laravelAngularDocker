# LaravelAngularDocker

## Laravel specific Docker set-up. 

### Getting started

The first time you want to run the application, use the install script:    

`sudo sh install.sh`    

This will install boot2docker and docker-compose (if not already installed locally) and will set up the containers and run the necessary dependency installs / migrations.

To stop the vm/docker: `sh down.sh`    
To start the vm/docker: `sh up.sh`

###Set up your vhosts

```
# Test Project
192.168.59.103 api.test.com
192.168.59.103 admin.test.com
192.168.59.103 frontend.test.com
```


### Run frontend tests
```
cd www/frontend
karma start
```


### Run backend tests
```
docker exec -it $WORKER_ID /bin/bash
./phpunit --bootstrap /var/www/api/bootstrap/autoload.php /var/www/api/tests/component/IngredientTest.php
```

