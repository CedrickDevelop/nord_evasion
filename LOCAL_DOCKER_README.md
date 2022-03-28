#Local Docker Compose

## Dependency :
This Docker Compose stack needs Adimeo's local docker environnement. It can be found there : https://github.com/Core-Techs-Git/adimeo_docker_local

## Docker Compose global commands

### Start stack (in background with "-d")
    docker-compose up -d

### Stop stack
    docker-compose down

##DB common commands

### To dump DB
    docker exec nord_evasion_db sh -c 'exec mysqldump -uroot -proot nord_evasion' > $PWD/dump.sql

### To restore DB
    docker exec -i nord_evasion_db sh -c 'exec mysql -uroot -proot nord_evasion' < $PWD/dump.sql


## Composer and Drush common commands

### Access PHP container shell
    docker exec -it nord_evasion_php sh

### Launch Composer commands
    docker exec nord_evasion_php composer install
    docker exec nord_evasion_php composer require drupal/module_name
    ...

### Launch Drush commands
    docker exec nord_evasion_php drush cr
    docker exec nord_evasion_php drush updb
    ...
