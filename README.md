# ReMusic
[![es](https://img.shields.io/badge/lang-es-red.svg)](https://github.com/SanQuilmas/ReMusic/blob/main/README.es.md)

![](/ReMusic/Demo%20Images/ReMusic-Welcome.png)
![](/ReMusic/Demo%20Images/ReMusic-Create.png)
![](/ReMusic/Demo%20Images/ReMusic-Gallery.png)
![](/ReMusic/Demo%20Images/ReMusic-ShowDownload.png)

[See the first product introduction](https://youtube.com/shorts/q2IjKk_yYT8?feature=share)

## Installation Instructions:

After performing a `git clone`, you will need to create a database for Laravel to connect to and configure the `.env` file with the appropriate information.

You must have Python installed, along with the following required packages:
- [Music21](https://pypi.org/project/music21/)
- [Oemer](https://pypi.org/project/oemer/)

Run the following commands to complete the configuration of the Laravel server:
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

Once the local MySQL server is running, you can start the Laravel server with the following commands:

```
npm run dev
```
```
php artisan serve
```
```
php artisan queue:work --timeout=36000
```
If you wish to run the server on a network instead of local development, use the following command with the necessary adjustments:
```
php artisan serve --host 0.0.0.0 --port=8000
```

## Other Projects Used:
- [OpenSheetMusicDisplay](https://github.com/opensheetmusicdisplay/opensheetmusicdisplay)
- [HTML MIDI Player](https://github.com/cifkao/html-midi-player)
- [MusicXML-to-MIDI Converter](https://github.com/ianberman/MusicXML-to-MIDI-Converter/)
- [Oemer](https://github.com/BreezeWhite/oemer)
- [Music21](https://github.com/cuthbertLab/music21)
