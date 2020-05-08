<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About REST API

REST APIs are useful for all kinds of apps. They can be the back-end to a front-end web app, they can store data for a mobile app, or they can provide services to other apps or APIs. There are a lot of moving pieces to coding a RESTful API, but having the right tools can make it a lot easier. Laravel is one such tool—a great platform for building REST APIs.

## install 
    1, Clone project:
        git clone https://github.com/hungltph03955/RESTfulAPI.git 
     
    2, Switch to the repo folder:
        cd RESTfulAPI
    
    3, Install composer:
        composer install
    
    4, Coppy or save .env.example to .env:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_username(ex: root)
        DB_PASSWORD=your_password
    
    5, Migrate database:
        php artisan migrate 
        
    6, Seeding data:
        php artisan db:seed
    
    7, Start server:
        php artisan serve --port=3000
    
    8, Open check api doc:
        
        postman import file restfulapi.postman_collection.json
    
        
        
