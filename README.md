### Простой трекер задач 

Приложение разработано в качестве тестового задания.
Использованы фреймворки Laravel, Vue.js, Bootstrap.

В системе есть 2 типа пользователей: исполнители и администраторы.

Администраторы могут добавлять новые задачи, а так же, удалять и редактировать задачи, которые еще не были взяты в работу.
Исполнители и администраторы могут выполнять задачи. 
После завершения задачи исполнителем, она отправляется на проверку администратором. 
Администратор может принять задачу или вернуть в работу. 
Принятая задача получает статус завершенной. 
Если администратор выполнил задачу, то она сразу попадает в статус завершенной, минуя проверку.

По завершенным задачам, доступна простая статистика.

Приветственную страницу Laravel удалять не стал, сам трекер задач, доступен после авторизации.

#### Установка
Клонируем репозиторий в нужную директорию

```git clone git@github.com:Eugene-Kei/test-laravel-vue.git my-project```

Переходим в указанную директорию и запускаем установку через composer

```composer install```

Создаем файл .env копируя его из .env.example

```cp .env.example .env```

Открываем файл .env и прописываем настройки подключения к базе данных

Запускаем миграции

```php artisan migrate```

Заполняем базу данных демонстрационными данными

```php artisan db:seed```

Эта команда добавит 1 администратора, 5 исполнителей и 10 задач

Генерируем APP_KEY

```php artisan key:generate```

Запускаем установку фронтенда с помощью npm

```npm i``` 

Сборка фронтенда если требуется

```npm run dev``` 
или
```npm run prod``` 

Пароль для всех демо пользователей `password`

Email смотрите в базе данных, в таблице `users`
