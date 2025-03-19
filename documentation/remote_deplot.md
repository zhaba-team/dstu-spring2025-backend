если вы используете сиды в которых лежит юзер с ролью разраба

то надо сменить его данные

войти в тинкер - php artisan tinker

прописать свои данные

$password = 'Your_password';
$user = User::findOrFail(1);
$user->fill([
'password' => Hash::make($password),
'email' => 'your_mail@gmail.com',
])->save();

https://www.youtube.com/watch?v=d8NiAbqb6aI

для прода юзать make команды с перффиксом prod
