# ReMusic

https://youtube.com/shorts/q2IjKk_yYT8?feature=share


Despues de un git clone se debera crear una base de datos para que se conecte mysql y configurar el .env. Despues se necesitan los siguentes comandos:
```
composer update
```
```
php artisan migrate
```
```
npm install
```
Una vez se enciende el servidor de mysql local ya se podra iniciar el server.

```
npm run dev
```
```
php artisan serve
```
```
php artisan queue:work --timeout=3600
```