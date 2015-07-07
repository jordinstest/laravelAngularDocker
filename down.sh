# STOP CONTAINERS
echo "Stopping containers"
docker-compose stop

# SHUTDOWN VM
echo "Shutting down virtual machine"
boot2docker stop

# NOTICES
echo ""
echo "Down and out"