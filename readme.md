# URL Shortner Web Service in PHP

URL Shortening web service based on PHP [Lumen framework](http://lumen.laravel.com) 

## Installation

To run the web service, you will need

* PHP >= 5.6.4, as well as few PHP extensions
* Composer 

### Install PHP 

##### Mac OSX

Recommend using package manager [Homebrew](http://brew.sh/)

`/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

Next, you need to tell brew about "homebrew-php" so you can install PHP 7

`$ brew tap homebrew/dupes`

`$ brew tap homebrew/versions`

`$ brew tap homebrew/php`

`brew install php70`

##### Windows

Recommend all-in-one Windows distributions that contain Apache, PHP, MySQL and other applications in a single installation file, e.g. [XAMPP](https://www.apachefriends.org/index.html)

##### Linux (Ubuntu 14.04, 15.04, 15.10, and 16.04)

`sudo add-apt-repository ppa:ondrej/php`

`sudo apt-get update`

`sudo apt-get install php7.0`

### Install Composer

##### Mac OSX

`curl -sS https://getcomposer.org/installer | php`

`mv composer.phar /usr/local/bin/composer`

Now just run `composer` in order to run Composer 

##### Windows

Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe). It will install the latest Composer version and set up your PATH so that you can just call composer from any directory in your command line.

## Setup and run service

Checkout the latest version from github repo 

`git clone `

