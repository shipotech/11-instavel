<p align="center"><img src="https://i.ibb.co/TT8zhNT/logoo.png"></p>
 
## About Instavel 

<strong>Instavel</strong> is a basic application with similarity to Instagram only for educational purposes. 
<br><br>
Designed using:
HTML, CSS, JavaScript, Jquery, Ajax, PHP
<br>
[MDBootstrap Pro (Jquery)](https://mdbootstrap.com)
<br> 
[Laravel](https://laravel.com)
<br>
[MySQL](https://www.mysql.com)
<br>
[Google Drive API](https://developers.google.com/drive/api/v3/about-sdk?hl=es-419)

## Instructions:
1- Clone the repo and cd into it <br>
2- `composer install` <br>
3- Rename or copy .env.example file to .env <br>
4- Enter your database credentials in your .env file <br>
5- `php artisan migrate` <br>
6- `npm install` <br>
7- `npm run dev` <br>
8- `php artisan key:generate` <br>
9- `composer require laravel/socialite` <br>
10- `composer require google/apiclient` <br>
######PD: please, use the "database.sql" file, to guide you if you want to store emojis. ("DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;")<br>

##Create your Google Drive API keys
Detailed information on how to obtain your API ID, secret and refresh token:

[Getting your Client ID and Secret](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/1-getting-your-dlient-id-and-secret.md)<br>
[Getting your Refresh Token](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/2-getting-your-refresh-token.md)<br>
[Getting your Root Folder ID](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/3-getting-your-root-folder-id.md)<br>

##Update .env file
  Add the keys you created to your .env file and set google as your default cloud storage. You can copy the .env.example file and fill in the blanks.
##### Setting google drive for storage the images
FILESYSTEM_CLOUD=google<br>
GOOGLE_APP_ID=instavel<br>
GOOGLE_CLIENT_ID=xxxx.apps.googleusercontent.com<br>
GOOGLE_CLIENT_SECRET=xxxx<br>
GOOGLE_REFRESH_TOKEN=xxxx<br>
GOOGLE_FOLDER_USERS=id_of_created_users_folder_in_your_drive(example: 1hUo0FLkZD9G6DmBz07AcNs2XJXyGy_nT)<br>
GOOGLE_FOLDER_IMAGES=id_of_created_images_folder_in_your_drive
<br>

#### [More information about "How to connect Google Drive API with Laravel"](https://quantizd.com/google-drive-client-api-with-laravel/) 

If you want to contact me, please send an e-mail to:

[shipotech@gmail.com](mailto:shipotech@gmail.com)
<br>

## Previews
<p align="center">
<img src="https://i.ibb.co/2t0zwnw/Captura-de-pantalla-de-2019-02-20-23-51-56.png" alt="Captura-de-pantalla-de-2019-02-20-23-51-56" border="0">
<br><br>
<img src="https://i.ibb.co/MS9q9wm/Captura-de-pantalla-de-2019-02-20-23-52-06.png" alt="Captura-de-pantalla-de-2019-02-20-23-52-06" border="0">
<br><br>
<img src="https://i.ibb.co/W51yJVP/Captura-de-pantalla-de-2019-02-20-23-52-21.png" alt="Captura-de-pantalla-de-2019-02-20-23-52-21" border="0">
<br><br>
<img src="https://i.ibb.co/wYsSNgf/Captura-de-pantalla-de-2019-02-20-23-49-01.png" alt="Captura-de-pantalla-de-2019-02-20-23-49-01" border="0">
<br><br>
<img src="https://i.ibb.co/R4vMJNc/Captura-de-pantalla-de-2019-02-20-23-49-09.png" alt="Captura-de-pantalla-de-2019-02-20-23-49-09" border="0">
<br><br>
<img src="https://i.ibb.co/4Y7GZXp/Captura-de-pantalla-de-2019-02-20-23-49-21.png" alt="Captura-de-pantalla-de-2019-02-20-23-49-21" border="0">
<br><br>
<img src="https://i.ibb.co/PGXCrQw/Captura-de-pantalla-de-2019-02-20-23-49-27.png" alt="Captura-de-pantalla-de-2019-02-20-23-49-27" border="0">
<br><br>
<img src="https://i.ibb.co/12YsDCD/Captura-de-pantalla-de-2019-02-20-23-49-36.png" alt="Captura-de-pantalla-de-2019-02-20-23-49-36" border="0">
<br><br>
<img src="https://i.ibb.co/vBKcKYG/Captura-de-pantalla-de-2019-02-20-23-56-13.png" alt="Captura-de-pantalla-de-2019-02-20-23-56-13" border="0">
<br><br>
<img src="https://i.ibb.co/N11Qn2J/Captura-de-pantalla-de-2019-02-20-23-56-21.png" alt="Captura-de-pantalla-de-2019-02-20-23-56-21" border="0">
<br><br>
<img src="https://i.ibb.co/Hp0t3xp/Captura-de-pantalla-de-2019-02-20-23-56-31.png" alt="Captura-de-pantalla-de-2019-02-20-23-56-31" border="0">
<br><br>
<img src="https://i.ibb.co/cxfRhc3/Captura-de-pantalla-de-2019-02-20-23-57-20.png" alt="Captura-de-pantalla-de-2019-02-20-23-57-20" border="0">
<br><br>
</p>

<br>

## Linkedin

[https://www.linkedin.com/in/mario-montano-129917179/](https://www.linkedin.com/in/mario-montano-129917179/)
<br>

## License

Instavel is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).