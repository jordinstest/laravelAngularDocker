# BOOT VM
echo "Booting virtual machine"
#boot2docker up
#eval "$(boot2docker shellinit)"

# RUN CONTAINERS
echo "Running containers"
docker-compose up -d

# NOTICES
echo ""
echo "Up and atom"
