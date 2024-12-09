<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# How to use it
## Clone this repository.
Use the command of git to clone this repository
```
git clone https://github.com/JhonCODEOWO/escpos_pruebas.git
```

## Install dependencies
Install all dependencies of npm and composer.
```
npm install
php composer install
```

## Configurating the environment

### Adding database data
Just add a name for the database in the .env file and your credentials for that conection.

### Adding IP and PORT
This project make a conection to the printer by IP, so if you want use this method just add the IP of your print and the port inside the .env file. If your print doesn't have network conection you should to use USB conection instead. Make sure to read doc of escpos library here https://github.com/mike42/escpos-php.

## Create the database and inject data
This project includes migrations to make a table example, you can use it but it's simple, so if you want use it just execute te commands. I will create the table in you database.
```
php artisan migrate --seed
```

## Launching the project

### In dev mode
If you want make changes to the code in watch mode you should exec one of these two commands
```
npm run dev //Use it if the project is served by apache
composer run dev //Use it if you're using a Laravel command
```

### With Laravel
If you don't have a server like Apache you should to use a Laravel commando to deploy and use the project
```
php artisan serve --port=a_free_port
```

## Results.
Now you just should to make a HTTP request to the root route of the application, it should do a print to your printer and a download of a .raw file that you can use in develoment with emulators and check the results of the print without a physic printer.
