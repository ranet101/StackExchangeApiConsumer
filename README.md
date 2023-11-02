# StackExchange api consumer
An StackExchange api consumer with ddbb cache system.
## Ecosystem
### Folder/file structure
* php-fpm
    * Dockerfile 
* mysql
    * data
    * Dockerfile
    * ddbb_seed.sql
* src
    * app code
* .env
* default.conf
* docker-compose.yml   

### Infrastructure
Uses docker with nginx, php, mysql as db_seeder containers. Deploy and system launch config is especified in _docker-compose.yml_. Below a service description list:

_web_\
Uses nginx as web server and it's configurated using _./default.conf_

_php-fpm_\
Php core and pdo_mysql lib is configurated using _./php-fpm/Dockerfile_ 

_mysql_\
Mysql serevr. It's configurated using _./mysql/Dockerfile_

_db_seeder_\
Database seed with ddbb structure and test data _./mysql/ddbb_seed.sql_.

All these services are configurable via _.env_ variables and is not necesary to touch them. Use _.env_ file.

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

DB_SEED=./mysql/ddbb_seed.sql
```
It's also posible to edit _docker-compose.yml_ file directly, but is not recomended.

### Installation
Clone repo
```
git clone https://github.com/ranet101/StackExchangeApiConsumer.git
```
Install/launch containers
```
cd StackExchangeApiConsumer
sudo docker compose up -d
```

### System and server managment
Put online all servers configured in _docker-compose.yml_ file
```
sudo docker compose up -d
```
*The _-d_ option launchs system in background. Removing it you will see the systyem stdrout.\

Shutdown all servers
```
sudo docker compose down
```

If config is changed you must recreate containers
```
sudo docker compose up --force-recreate --build -d
```
Connect to docker bash to execute artisan commands
```
sudo docker compose exec php-fpm bash
```

## App
### Instalation
Install Laravel dependencies. From project folder type:
```
sudo chmod -R 777 src
cd src 
sudo composer install
```
rename .env.example as .env. In _./src_ folder type:
```
cp .env.example .env
```
### Tests
To launch tests you must connect to php-fpm bash, then launch them. In porject folder type the following to nnter container prompt:
```
sudo docker compose exec php-fpm bash
```
Once connected you will be in _/var/www/html_ image path. Launch all test typing:
```
php artisan test
```
You can pass just a test suite. It will try all tests in folder _./src/tests/[testsuite]_
```
php artisan test --testsuite=Feature
```
You can filter by testClass. It will try all tests in _./src/tests/[testsuite][test].php_
```
php artisan test --filter=AppTest
```
You can filter by testClass. It will launch concrete test from _./src/tests/[testsuite][test].php_
```
php artisan test --filter AppTest::                        
```
Test list:
* Suite Feature
    * Apptest
        * **_appResponds()_**: Checks if base url responds statusCode 400
        * **_apiResponds()_**: Checks if base api url responds statusCode 404
* Suite Unit
    * ApiTest
        * **_tagParamError()_**: Checks if tag param error is working
        * **_dateFromFormatError()_**: Checks if dateFrom format error is working
        * **_dateToFormatError()_**: Checks if dateTo format error is working
        * **_dateFromGtDateTo()_**: Checks if dateFrom > dateTo error is working

### Error codes
When api responds an error the repsonds is in the following format
```
{"error":true,"errorCode":[Int errorCode],"msg":[String error message]}
```
#### Codes
group by tens
* **_20_** group is for param error 
    * **_20_**: Tag param error test
    * **_21_**: Date format error test
    * **_22_**: Date diff error test
