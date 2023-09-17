## Структура приложения
  - **/app** - Yii2 проект
  - **/php** - файлы для сборки php контейнера

## Установка и первый запуск приложения
  ```bash
  $ git clone https://github.com/matveevartem/book-catalog-api.git project_dir
  ```
  ```bash
  $ cd project_dir
  ```
  ```bash
  $ cp .env-dist .env
  ```
  ```bash
  $ ./app.sh init
  ```

## Последующие запуски приложения
  ```bash
  $ cd project_dir
  ```
  ```bash
  $ ./app.sh start
  ```

## Остановка приложения
  ```bash
  $ cd project_dir
  ```
  ```bash
  $ ./app stop
  ```

## Запуск тестов приложения
  ```bash
  $ cd project_dir
  ```
  ```bash
  ./app.sh test
  ```

## Вывод списка книг в консоли
  ```bash
  $ cd project_dir
  ```
  ```bash
  ./app.sh console
  ```

## API спецификация
  [Перейти на swaggerhub](https://app.swaggerhub.com/apis/WWWARTEMMATVEEV/BookCatalogAPI/1.0)

## Дополнительно
  - У вас на машине должен быть установлен docker и docker-compose
  - Первый запуск может занять несколько минут.

    Обязательно дождаться сообщения вида **```Service "APP_NAME" avaliable on url http://localhost:PHP_PORT```**
  - При желании можно изменить порты apache и postgres, авторизационные данные, которые будут установленны для postgres (user, password), а так же имена для контейнеров. Для этого нужно отредактироваать файл **.env** в корне проекта.

## PS
  - Api реализовано в виде модуля и максимально автономно от основного Yii2 приложения
  - При выполнении команды ``./app.sh init``  автоматически прописывается в конфигурационные файлы **config/web.php** и **config/console.php**, а так же создаются ссылки на тесты модуля и применяются его миграции.

## PS PS
  - Возможно не везде прописал phpdoc
