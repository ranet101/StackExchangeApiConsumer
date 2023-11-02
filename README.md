# StackExchange api consumer
An StackExchange api consumer with ddbb cache system.
## Ecosystem
### Folder/file structure
* php-fpm
    * Dockerfile 
* mysql
    * data
    * Dockerfile
* src
    * app code
* .env
* default.conf
* docker-compose.yml   

### Infrastructure
Uses docker with nginx, php and mysql containers.
* Deploy and system launch config is especified in _docker-compose.yml_
* Nginx is configurtaed using _./default.conf_ 
* Php is configurated using _./php-fpm/Dockerfile_ 
* Mysql is configurated using _./mysql/Dockerfile_\

All these services are configurable via _.env_ file and is not necesary to touch them. Use _.env_ file.

### Configuration (.env)
Database parameters, servers and paths can by configurated within editing _.env_ file
```
COMPOSE_PROJECT_NAME=fe_ecosystem

APP_PORT=80
APP_CODE_PATH=./src
APP_NGINX_CONF=./default.conf
APP_PHP_VERSION=8.2

MYSQL_VERSION=5.7
MYSQL_DATABASE=stackexchangeapicache
MYSQL_USER=stackexchangeapiuser
MYSQL_PASSWORD=zAwhJrHTsxZIpoF
MYSQL_ROOT_PASSWORD=TK5mDzheFSX8lhwhsmrRIqTwr2cfI
MYSQL_PORT=3306
MYSQL_DATA_VOLUME=./mysql/data
```
It's also posible to edit _docker-compose.yml_ file directly, but is not recomended.
## Install
Clone repo
```
git clone https://github.com/ranet101/StackExchangeApiConsumer.git
```
Install/launc containers
```
cd StackExchangeApiConsumer
sudo docker compose up -d
```
## App