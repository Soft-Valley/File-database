<center>
    <img src="img2.jpg" width="924" height="600">
</center>

# File Database

## Description
This is a file database that allows you to store data in a file and retrieve it later like a database. It is a simple and easy to use database that can be used for small projects. It is not recommended to use this database for large projects.
You can store data as json or as a string. You can also store data in a file or in memory. You can also encrypt the data you store.

## Installation
```bash
composer require tusharkhan/file-database
```

## Usage
For this package all the Models, Database has different folders. If you want to change the path of the folder then you can change it in the config file.
To publish the config file follow the below.

- go to config/app.php
- add the below line in the providers array
```php
    Tushar\FileDatabase\FileDatabaseServiceProvider::class,
```

- run the below command


```bash
    php artisan vendor:publish --provider="Tusharkhan\FileDatabase\FileDatabaseServiceProvider" --tag="fdb-config"
```

### Database