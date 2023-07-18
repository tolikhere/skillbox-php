
If you're reading this now that mean one thing I didn't make refactoring.

I skipped a lot of validations, status codes and errors handling.

And therefore this API for the honest user that don't send any malicious data

It's still very raw code that need to refactor(add validations, annotation to methods, create Interfaces and more classes like Storage one for example, errors handling and so on).

And I shall do it in the nearest future so bear wth me.

I could use phpdotenv or phpmailer in this project but if it's not for production then why not to have a little fun?

In next update I want to implement parser for .env and map php.ini with settings for plain php mail function into docker container

**In `/src/app/Config.php` you can set your settings for DB**

## Ho to deploy the project
If you have docker installed on your machine 

Run code below to create containers for this project:
```
make up
```
All tables for this project in /migration file.

I made it executable, so you can run:
```
make create-tables
```

Also I included "Cloud Storage.postman_collection.json" for you to easily test this project with the help of the Postman.

Please don't use this code in production. I'm begging you.

---
### User's endpoints
| Method   | URLS        | Description                             | Example                       |
|----------|-------------|-----------------------------------------|-------------------------------|
| `GET`    | /user/      | Получить список пользователей (массив)  | /user/                        |
| `GET`    | /users/{id} | Получить JSON-объект с информацией о конкретном пользователе | /user/1  |
| `GET`    | /user/search/{email} | Поиск пользователя производится по email.           | /user/search/kratos@god.com |
| `POST`   | /user/      | Добавить пользователя                  | /user/                         |
| `PUT`    | /user/      | Обновить пользователя                  | /user/                         |
| `DELETE` | /user/{id}  | Удалить пользователя                   | /user/1                        |

#### Request Values:
Instead of `{id}` you can put any number that the table of users has.

Instead of `{email}` you can put any email that the table of users has.

For `POST` /user/
```
{
    "email": "kratos@god.com",
    "password: "boy"
}
```
For `PUT` /user/
```
{
    "id": 1,
    "email": "mortal@kombat.com",
    "password": "Test Your Might"
}
```
---
### Login, Logout, Reset Password endpoints
| Method   | URLS        | Description                             | Example                       |
|----------|-------------|-----------------------------------------|-------------------------------|
| `GET`    | /login      | Метод login принимает на вход email (логин) и пароль, производит проверку комбинации email и пароля в базе данных и в случае успеха создаёт новую сессию, идентификатор которой отправляется пользователю в виде cookie | /login?`password`=sub-zero&`email`=scorpion@friends.com                        |
| `GET`    | /logout     | Метод logout завершает текущую сессию | /logout  |
| `GET`    | /reset-password | Высылает ссылку на сброс пароля на указанный email пользователя | /reset-password?`email`=example@mail.com&`subject`=yourSubject&`message`=yourMessage  |

I don't think that I implemented `/reset-password` endpoint the right way. Next update I'll fix that (I will generate url for resetting password).
---
### Admin's endpoints
| Method   | URLS         | Description                                | Example                       |
|----------|--------------|--------------------------------------------|-------------------------------|
| `GET`    | /admin/user/ |     Список пользователей                   | /admin/user/                  |
| `GET`    | /admin/user/{id} | Информация по конкретному пользователю | /admin/user/1                 |
| `DELETE` | /admin/user/{id} | Удалить пользователя                   | /admin/user/1                 |
| `PUT`    | /admin/user/ |     Обновить информацию пользователя       | /admin/user/                  |

#### Request Values:
Instead of `{id}` you can put any number that the table of users has.

For `PUT` /admin/user/
```
{
    "id": 1,
    "email": "mortal@kombat.com",
    "password": "Test Your Might"
}
```
---
### Endpoints of Files
| Method   | URLS         | Description                                | Example                  |
|----------|--------------|--------------------------------------------|--------------------------|
| `GET`      | /file/     | Вывести список файлов                      | /file/                   |
| `GET`      | /file/{id} | Получить информацию о конкретном файле     | /file/1                  |
| `POST`     | /file/     | Добавить файл                              | /file/                   |
| `PUT`      | /file/     | Переименовать или переместить файл         | /file/                   |
| `DELETE`   | /file/{id} | Удалить файл                               | /file/1                  |
| `POST`     | /directory/ | Добавить папку (директорию)               | /directory/              |
| `PUT`      | /directory/ | Переименовать папку                       | /directory/              |
| `GET`      | /directory/{id} | Получить информацию о папке (список файлов папки) | /directory/1 |
| `DELETE`   | /directory/{id} | Удалить папк                          | /directory/1             |

#### Request Values:
##### **The most important that if you want to create a file or a directory in the root directory use `0` as a parent directory**
the root directory is 0. In DB it's just NULL!!!
Instead of `{id}` you can put any number of an appropriate table.

For `POST` /file/ use `multipart/form-data` in a html form for `enctype` attribute or `form-data` in `Postman`
```
{
    "file": "Zora.png",
    "dirId: "1"
}
```
For `PUT` /file/ If you want only change a file name use only `id` and `fileName` and vise versa
```
{
    "id": 1,
    "fileName": "Kratos.jpg",
    "dirId": "0"
}
```
For `POST` /directory/
```
{
    "dirName": "math",
    "parentId: "10"
}
```
For `PUT` /directory/
```
{
    "id": 1,
    "dirName": "Kratos.jpg",
}
```
---
### Endpoints of Files
| Method   | URLS                        | Description                                           | Example                  |
|----------|-----------------------------|-------------------------------------------------------|--------------------------|
| GET      | /files/share/{id}           | Получить список пользователей, имеющих доступ к файлу | /files/share/8           |
| PUT      | /files/share/{id}/{user_id} | Добавить доступ к файлу пользователю с id user_id     | /files/share/10/32       |
| DELETE   | /files/share/{id}/{user_id} | Прекратить доступ к файлу пользователю с id user_id   | /files/share/11/23       |

`{id}` is the id of an file

`{user_id}` is the id of an user
