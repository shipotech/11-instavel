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
<br>
[LazySizes](https://github.com/aFarkas/lazysizes)
<br>

## Live Demo
[http://instavel.herokuapp.com/home](http://instavel.herokuapp.com/home)


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
######PD: please, use the "database.sql" file, to guide you if you want to store emojis and spanish characters. ("DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;")<br>

##Create your Google Drive API keys
Detailed information on how to obtain your API ID, secret and refresh token:

[Getting your Client ID and Secret](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/1-getting-your-dlient-id-and-secret.md)<br>
[Getting your Refresh Token](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/2-getting-your-refresh-token.md)<br>
[Getting your Root Folder ID](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/3-getting-your-root-folder-id.md)<br>

###Important: 
Download JSON credentials file and save it on (storage/app/) with name: 
#####client_secret.json

[more info click here](https://quantizd.com/google-drive-client-api-with-laravel/)

##Update .env file
  Add the keys you created to your .env file and set google as your default cloud storage. You can copy the .env.example file and fill in the blanks.
##### Setting google drive for storage the images
FILESYSTEM_CLOUD=google
GOOGLE_APP_ID=instavel
GOOGLE_CLIENT_ID=xxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=xxxx
GOOGLE_REFRESH_TOKEN=xxxx
###### #Images Folders (example: 1hUo0FLkZD9G6DmBz07AcNs2XJXyGy_nT)
GOOGLE_FOLDER_LARGE_IMAGES=id_of_created_large_images_folder_in_your_drive
GOOGLE_FOLDER_MEDIUM_IMAGES=id_of_created_medium_images_folder_in_your_drive
GOOGLE_FOLDER_MOBILE_IMAGES=id_of_created_mobile_images_folder_in_your_drive
GOOGLE_FOLDER_TINY_IMAGES=id_of_created_tiny_images_folder_in_your_drive
###### #Users Folders
GOOGLE_FOLDER_MOBILE_USERS=id_of_created_mobile_users_folder_in_your_drive
GOOGLE_FOLDER_TINY_USERS=id_of_created_tiny_users_folder_in_your_drive
<br>

#### [More information about "How to connect Google Drive API with Laravel"](https://quantizd.com/google-drive-client-api-with-laravel/) 

If you want to contact me, please send an e-mail to:

[shipotech@gmail.com](mailto:shipotech@gmail.com)
<br>

## Previews
<p align="center">
<img src="https://i.ibb.co/TK5VN60/Captura-de-pantalla-de-2019-03-16-20-44-53.png" alt="Captura-de-pantalla-de-2019-03-16-20-44-53" border="0">
<br><br>
<img src="https://i.ibb.co/JtgR7m2/Captura-de-pantalla-de-2019-03-16-20-44-58.png" alt="Captura-de-pantalla-de-2019-03-16-20-44-58" border="0">
<br><br>
<img src="https://i.ibb.co/nwhzZQX/Captura-de-pantalla-de-2019-03-16-20-45-20.png" alt="Captura-de-pantalla-de-2019-03-16-20-45-20" border="0">
<br><br>
<img src="https://i.ibb.co/XDQvyQF/Captura-de-pantalla-de-2019-03-16-20-52-31.png" alt="Captura-de-pantalla-de-2019-03-16-20-52-31" border="0">
<br><br>
<img src="https://i.ibb.co/Sf6LSv0/Captura-de-pantalla-de-2019-03-16-20-46-02.png" alt="Captura-de-pantalla-de-2019-03-16-20-46-02" border="0">
<br><br>
<img src="https://i.ibb.co/HYBBX7b/Captura-de-pantalla-de-2019-03-16-20-46-27.png" alt="Captura-de-pantalla-de-2019-03-16-20-46-27" border="0">
<br><br>
<img src="https://i.ibb.co/QKpKdqC/Captura-de-pantalla-de-2019-03-16-20-47-28.png" alt="Captura-de-pantalla-de-2019-03-16-20-47-28" border="0">
<br><br>
<img src="https://i.ibb.co/xfN3pTs/Captura-de-pantalla-de-2019-03-16-20-48-23.png" alt="Captura-de-pantalla-de-2019-03-16-20-48-23" border="0">
<br><br>
<img src="https://i.ibb.co/wJQZ07z/Captura-de-pantalla-de-2019-03-16-20-47-17.png" alt="Captura-de-pantalla-de-2019-03-16-20-47-17" border="0">
</p>

<br>

## Linkedin

[https://www.linkedin.com/in/mario-montano-129917179/](https://www.linkedin.com/in/mario-montano-129917179/)
<br>

## License

Instavel is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).