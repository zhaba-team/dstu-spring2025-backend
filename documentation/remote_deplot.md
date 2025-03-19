скопировать cp .env.example .env

заменить параметры 

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:16/qPxkRHQKV2PP0DaUtTrzys589KXOLAMoMwuheNdY=
APP_DEBUG=true
APP_URL=http://localhost

SERVER_NAME=http://localhost - домен указать

APP_NAMESPACE=templ

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

выполнить make up-prod

дальше прописать команды

composer install

php artisan key:generate

php artisan storage:link

php artisan migrate

php artisan db:seed

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

