# URL Shortner Web Service in PHP

URL Shortening web service based on PHP [Lumen framework](http://lumen.laravel.com) 

## Install Dependencies

To run the web service, you will need

* PHP >= 5.6.4, as well as few PHP extensions (PDO, OpenSSL, MbString)
* Composer 

### Install PHP 

##### Mac OSX

Recommend using package manager [Homebrew](http://brew.sh/)

`/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

Next, you need to tell brew about "homebrew-php" so you can install PHP 7

`$ brew tap homebrew/dupes`

`$ brew tap homebrew/versions`

`$ brew tap homebrew/php`

`$ brew install php56`

##### Windows

Recommend all-in-one Windows distributions that contain Apache, PHP, MySQL and other applications in a single installation file, e.g. [XAMPP](https://www.apachefriends.org/index.html)

##### Linux (Ubuntu 14.04, 15.04, 15.10, and 16.04)

`$ sudo add-apt-repository ppa:ondrej/php`

`$ sudo apt-get update`

`$ sudo apt-get install php5.6`

### Install Composer

##### Mac OSX

`$ curl -sS https://getcomposer.org/installer | php`

`$ mv composer.phar /usr/local/bin/composer`

Now just run `composer` in order to run Composer 

##### Windows

Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe). It will install the latest Composer version and set up your PATH so that you can just call composer from any directory in your command line.

## Setup and run service

Checkout the latest version from github repo 

`$ git clone https://github.com/ahsanatiq/urlShortnerAPI-PHP.git`

`$ cd urlShortnerAPI-PHP`

install all the dependencies through the composer package manager

`$ composer install`

create the sqlite database anywhere on the system

`$ touch database/database.sqlite`

copy and open the application config file

`cp .env.example .env`

`vim .env`

set the sqlite database variable path `DB_DATABASE` to the file created above 

run the migration to import the necessary table structure

`php artisan migrate`

start the application 

`$ php -S localhost:8080 -t public/`

## API Reference

The URL Shortner API is organized around REST. Below is the list of endpoints.

### End Points

* [GET /](#get_urls)
* [POST /](#post_home.md)
* [GET {short_url}](#get_url.md)
* [POST {short_url}](#post_url.md)

### Get URLs

