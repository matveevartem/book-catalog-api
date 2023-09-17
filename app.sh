#/bin/bash

. ./.env

php_wait() {
    until [ "$res" = "999" ]
    do
        echo "$res"
        res=$(docker exec $PHP_CONTAINER echo 999)
        sleep 1
    done
}

db_wait() {
    until [ "$res" = "999" ]
    do
        echo "$res"
        res=$(docker exec "$DB_CONTAINER" echo 999)
        sleep 1
    done
}

docker_up() {
    docker-compose up -d
}

docker_down() {
    docker-compose down
}

start() {
    evvinit
    docker_up
    php_wait
    db_wait
}

dbinit() {
    rm -rf ./initdb
    mkdir -p initdb
    chmod o+rX ./initdb
    echo "CREATE DATABASE ${DB_NAME}_test;" > ./initdb/create_test_db.sql
    chmod 644 ./initdb/*
}

evvinit() {
    cp .env ./app/.env
}

migrate() {
    docker exec "$PHP_CONTAINER" /app/yii migrate/up --migrationPath=@app/modules/v1/migrations --interactive=0
}

migrate_test() {
    docker exec "$PHP_CONTAINER" /app/tests/bin/yii migrate/up --migrationPath=@app/modules/v1/migrations --interactive=0
}

stop() {
    docker_down
}

test() {
    docker exec "$PHP_CONTAINER" /app/vendor/bin/codecept run
}

require() {
    docker exec "$PHP_CONTAINER" composer install
}

install() {
    paths=$(ls -d ./app/modules/*)
    for i in "${paths[@]}"; do 
        cd ${paths[@]}/bin
        ./install.sh
    done
}

init () {
    dbinit
    start
    sleep 3
    require
    sleep 1
    install
    sleep 1
    migrate
    sleep 1
    migrate_test
}

console() {
    docker exec "$PHP_CONTAINER" yii books/list
}

ready_message() {
    echo -e "\nService \033[32m\"$APP_NAME\"\033[0m avaliable on url \033[32mhttp://localhost:$PHP_PORT\033[0m\n"
}

usage_message() {
    echo "Usage: app.sh [init|start|stop|test|console]"
    echo "Starting app.sh for the first time may take a few minutes"
}

case "$1" in
    start)
        start
        ready_message
        ;;
    stop)
        stop
        ;;
    init)
        init
        ready_message
        ;;
    test)
        test
        ;;
    console)
        console
        ;;
    *)
        usage_message
    ;;
esac
