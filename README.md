# ReMusic

https://youtube.com/shorts/q2IjKk_yYT8?feature=share

## Instrucciones de Instalacion:

Despues de un git clone se debera crear una base de datos para que se conecte laravel y configurar el .env con la informacion. 

Se necesita tener instalado Python, los siguentes paquetes son necesarios:
- https://pypi.org/project/music21/
- https://pypi.org/project/oemer/

Los siguentes comandos terminaran de configurar el server de Laravel:
```
composer update
```
```
php artisan migrate
```
```
php artisan key:generate
```
```
php artisan storage:link
```
```
npm install
```
```
npm run build
```

Una vez se enciende el servidor de mysql local ya se podra iniciar el server con los siguentes comandos.

```
npm run dev
```
```
php artisan serve
```
```
php artisan queue:work --timeout=36000
```
En el caso de quererlo correr en alguna red en vez de correrlo para desarollo local, se requiere lo siguente con los cambios competentes.
```
php artisan serve --host 0.0.0.0 --port=8000
```

## Otros proyectos usados:
- https://github.com/opensheetmusicdisplay/opensheetmusicdisplay
- https://github.com/cifkao/html-midi-player
- https://github.com/ianberman/MusicXML-to-MIDI-Converter/
- https://github.com/BreezeWhite/oemer
- https://github.com/cuthbertLab/music21
