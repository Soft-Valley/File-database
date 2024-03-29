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
- Relationships between models

## Little knowledge before start
    
If you are familiar with the laravel framework then you can easily use this package.
This package uses the laravel filesystem to store the data in a file. Under the hood it uses the [Laravel Collection](https://laravel.com/docs/10.x/collections) class to manipulate the data. 
So you can use all the methods of the Collection class to work with data. Although some methods are already implemented in the package with every Model you create.

> [!TIP]
> Just like database you can create a table and store data in it. You can also create a model and use it to store data in a table. Main key concept is, you can think of a table as a file and a row as a json data.

So that you can easily understand the concept of this package. You can also define some relationships between the models. 



## For more information visit the [documentation](https://github.com/Soft-Valley/File-database/wiki)