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

##### Mac OSX / Linux

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

`$ cp .env.example .env`

`$ vim .env`

set the sqlite database variable path `DB_DATABASE` to the file created above 

run the migration to import the necessary table structure

`$ php artisan migrate`

start the application 

`$ php -S localhost:8080 -t public/`

## API Reference

The URL Shortner API is organized around REST. Below is the list of endpoints.

### End Points

* [GET /](#get-urls)
* [POST /](#post-url)
* [POST {short_url}](#update-url)
* [GET {short_url}](#redirect-url)

### Get URLs

Get the list of all the URLs which includes (target url for desktop/mobile/table, counter, created) 

Example: (GET) http://example.com/

Response body:
 
    {
      "data": [
        {
          "desktop_url": "http://www.google.com/",
          "desktop_counter": "1",
          "mobile_url": "http://www.yahoo.com/",
          "mobile_counter": "0",
          "tablet_url": null,
          "tablet_counter": "0",
          "created": "1 minute ago"
        },
        {
          "desktop_url": "http://www.google.com/",
          "desktop_counter": "0",
          "mobile_url": "http://www.yahoo.com/",
          "mobile_counter": "0",
          "tablet_url": null,
          "tablet_counter": "0",
          "created": "19 seconds ago"
        }
      ]
    } 
    
### POST URL

Create new URL entry which returns short url as response
 
Example: (POST) http://example.com/ 

Params: 

| param name  | rules               | detail                             |
|-------------|---------------------|------------------------------------|
| desktop_url | required, valid url | target url for desktop user-agents |
| mobile_url  | optional, valid url | target url for mobile devices      |
| tablet_url  | optional, valid url | target url for tablet devices      |

Response Body: 

    {
      "short_url": "http://example.com/0lrPb"
    }
    
### Update URL

Update URL entry which returns updated url info as response
 
Example: (POST) http://example.com/L70nK 

Params: 

| param name  | rules               | detail                             |
|-------------|---------------------|------------------------------------|
| desktop_url | optional, valid url | target url for desktop user-agents |
| mobile_url  | optional, valid url | target url for mobile devices      |
| tablet_url  | optional, valid url | target url for tablet devices      |
    
Response Body:
    
    {
      "data": {
        "desktop_url": "http://carbon.nesbot.com/",
        "desktop_counter": "0",
        "mobile_url": null,
        "mobile_counter": "0",
        "tablet_url": null,
        "tablet_counter": "0",
        "created": "1 day ago"
      }
    }
    
### Redirect URL 

Redirect to target url according to the device used   

Example: (GET) http://example.com/L70nK 

Response Body:

Redirected to the target URL and see the content of the target page.    

## Run Tests
    
Inorder to run the tests, first need to install PHPUnit

#### Mac OSX / Linux

`$ wget https://phar.phpunit.de/phpunit.phar`

`$ chmod +x phpunit.phar`

`$ sudo mv phpunit.phar /usr/local/bin/phpunit`

#### Windows 

Refer to the [PHPUnit website](https://phpunit.de/manual/current/en/installation.html)

All the unit tests are inside the `tests/urlShortnerTest.php` file and can be run simply by the following command

`$ cd path/to/urlShortnerAPI-PHP`

`$ phpunit`