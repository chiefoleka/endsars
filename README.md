# Tracking our SARS encounters
Following the recent outcry by thousands of Nigerians especially young people, [Endsars](https://endsars.org.ng) was launched to help people report their stories so we have enough evidence for legal actions towards stopping SARS.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. This project is build with PHP/Laravel and JavaScript/Vue so it would help a lot if your local machine is setup to run `php`

### Prerequisites

To successfully install this project, you need to have
* git
* composer
* node
* npm

### Installing
First, clone this project into a working directory accessible by your local server.

```
$ git clone https://github.com/chiefoleka/endsars
$ cd endsars
```

Install the project with composer 

```
composer install
```

Copy `.env.example` to `.env`

Install the node modules for the project

```
npm install
npm run dev
```

Generate your Laravel key

```
$ php artisan key:generate
```

### Setup
Create a database, setup your `.env` file to use your database, run migrations and seed the database

```
php artisan migrate
php artisan db:seed --class=ActionSeeder
php artisan db:seed --class=ActionSeederUpdate
php artisan db:seed --class=LocationSeeder

```

Start the application

```
$ php artisan serve
```


## Additional Features
* Anti-Spam
* Parser to determine context of tweets received from twitter
* Realtime graph/charts to display data
* Extending stories to include legal actions/activities around police station
* Tracking people who are missing as a result of SARS

## Contributing

To contribute, you need to have knowledge of PHP/Laravel and/or JavaScript/Vue as they are the primary tools used for developing this project.
Also, it would be great if you understand how best to build the parser to determine context of tweets. If you have used Api.ai extensively and understand it well, that would be fantastic.

Feel free to send me a message, open an issue and get working right away.





