<center>
    <img src="img2.jpg" width="924" height="600">
</center>

# File Database

## Description
This is a file database that allows you to store data in a file as json data and retrieve it later like a database. 
It is a simple and easy to use database that can be used for small projects. It is not recommended to use this database for large projects.
You can store data as json. You can also store data in a file.

## Features
- Create a table
- Drop tables
- Update a table
- Create a model
- Create a model with migration
- Create a migration
- Run migrations
- Run fresh migrations

## Little knowledge before start
    
If you are familiar with the laravel framework then you can easily use this package.
This package uses the laravel filesystem to store the data in a file. Under the hood it uses the [Laravel Collection](https://laravel.com/docs/10.x/collections) class to manipulate the data. 
So you can use all the methods of the Collection class to work with data. Although some methods are already implemented in the package with every Model you create.



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
    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */
            \Tusharkhan\FileDatabase\FileDatabaseServiceProvider::class,
        /*
         * Application Service Providers...
         */
```

- run the below command


```bash
    php artisan vendor:publish --tag="fdb-config"
```

### Database
 
#### Create Migration

```bash
    php artisan fdb:migration name={migration_file_name}
```

- name: Name of the migration file
- To ceate a new table use --create={table_name} option like below
```bash
    php artisan fdb:migration name={migration_file_name} --create={table_name}
```
- To update a table use --update={table_name} option like below
```bash
    php artisan fdb:migration name={migration_file_name} --update={table_name}
```
- To drop a table use --drop={table_name} option like below
```bash
    php artisan fdb:migration name={migration_file_name} --drop={table_name}
```

#### Run Migration

- Run all the migrations
```bash
    php artisan fdb:migrate
```
- Run a fresh migration
```bash
    php artisan fdb:migrate --fresh
```


## Model

### Create Model
For creating a model you can use the below command

```bash
    php artisan fdb:model name={model_name}
```

If you want to create a model with migration then you can use the --m option like below

```bash
    php artisan fdb:model name={model_name} --m
```

