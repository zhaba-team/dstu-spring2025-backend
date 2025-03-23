### Развернуть проект на проде

* Склонировать проект
* выполнить ```make init-prod```
* выполнить все действия из [видео](https://www.youtube.com/watch?v=d8NiAbqb6aI)


Если вы используете сиды в которых лежит юзер с ролью разраба
то надо сменить его данные

войти в тинкер - php artisan tinker и прописать свои данные

```php
$password = 'Your_password';
$user = User::findOrFail(1);
$user->fill([
'password' => Hash::make($password),
'email' => 'your_mail@gmail.com',
])->save();
```
