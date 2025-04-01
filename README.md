Тестовое задание
---

## Требования для запуска

---

 - Docker
 - Make

---

## Запуск проекта

---

### При наличии make.

#### Запуск проекта:
```bash
    make up
```

#### Остановка проекта:
```bash
    make down 
```

#### Доступ к composer:
```bash
    make composer {command}
```

#### Доступ к artisan:
```bash
    make artisan {command}
```

---

### При отсутствии make.

#### Запуск проекта:
```bash
    docker build -t tech-app -f ./docker/php.Dockerfile . && \ 
    docker compose up -d --force-recreate --remove-orphans
```
#### Остановка проекта:
```bash
    docker compose down --rmi local
```

#### Доступ к composer:
```bash
    docker compose exec app composer {command}
```

#### Доступ к artisan:
```bash
    docker compose exec app php artisan {command}
```
---

## Используемые образы:

- tech-app - собираемый образ для локальной разработки
- mysql:latest - база данных
- redis:latest - NoSQL БД + кэш

## Описание

Много всего сделано на скорою руку, так что многого не ожидайте 

1. За загрузку файла отвечает роут `(POST) api/upload` - ожидает file
2. За получение данных отвечает роут `(GET) api/rows` - возвращает массив объектов Row
3. В процессе участвуют две Jobs одна разбивает файл на чанки вторая импортирует данные в базу данных
4. Каждое поле проходит валидацию и если она прошла то записывается в базу данных, если нет то в файл лога.
5. Весь проект упакован в докере для легкого запуска и проверки.

По тестам, не понятно что тут тестировать, но написал пару feature тестов для проверки роутов и валидации данных,
тесты запускаются in memory `make artisan test -- --env=testing`.

Про laravel-echo тоже немного не понял что конкретно нужно, так что не ищите реализации нет. :-) 
