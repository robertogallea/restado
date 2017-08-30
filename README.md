# restado
PHP and Laravel library for managing Tado system

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robertogallea/restado.svg?style=flat-square)](https://packagist.org/packages/robertogallea/restado)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jeroennoten/Laravel-AdminLTE/master.svg?style=flat-square)](https://travis-ci.org/jeroennoten/Laravel-AdminLTE)
[![Total Downloads](https://img.shields.io/packagist/dt/robertogallea/restado.svg?style=flat-square)](https://packagist.org/packages/jeroennoten/Laravel-AdminLTE)


This package provides a simple interface towards the public Tado Thermostat System API. It wraps the web methods available for authenticating users and retrieve information from the local devices. 

Currently, information are only readable, soon I will extend the library in order to edit settings.

The package is also integrated within Laravel.

 1. [Installation](#1-installation)
 2. [Updating](#2-updating)
 3. [Usage](#3-usage)
 4. [Supported Methods](#4-supported-methods)
 5. [Issues, Questions and Pull Requests](#5-issues-questions-and-pull-requests)
 
 ## 1. Installation
 
 1. Require the package using composer:
 
     ```
     composer require robertogallea/restado
     ```
     
2. Add the service provider to the `providers` in `config/app.php`:

    > Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider

    ```php
    Robertogallea\Restado\RestadoServiceProvider::class,
    ```     
    
3. Add the alias to the `aliases` in `config/app.php`:
    
    ```php
    'Restado' => Robertogallea\Restado\Facades\Restado::class,    
    ```
    
4. Add the following variables to your .env file
    ```php
    TADO_CLIENT_ID=<TADO_APP_ID>       // defaults to public-api-preview
    TADO_SECRET=<TADO_APP_SECRET_KEY>  // defaults to 4HJGRffVR8xb3XdEUQpjgZ1VplJi6Xgw                                                      
    TADO_USER=<TADO_USER>
    TADO_PASS=<TADO_PASSWORD>  
    ```
    
    
## 2. Updating

1. To update this package,  update the composer package:

    ```php
    composer update robertogalea/restado
    ```    
    
## 3. Usage    
To use this package you should use the method of the Restado facade. 

1. Obtain a valid token for your session:

    ```php
    $token = Restado::authorize();
    ``` 
    
2. Use a method to get the related information:
    
    ```php
    $me = Restado::me($token);
    ```     
    
each method return an object containing the data from the server. Currently the API is not officially documented, the only reference I found is at this page: http://blog.scphillips.com/posts/2017/01/the-tado-api-v2/

 
## 4. Supported Methods
Currently these methods are supported:
- authorize();
- Restado::me($token);
- getHome($token,$home_id);
- getHomeWeather($token,$home_id);
- getHomeDevices($token,$home_id);
- getHomeInstallations($token,$home_id);
- getHomeUsers($token,$home_id);
- getHomeMobileDevices($token,$home_id);
- getHomeMobileDeviceSetting($token,$home_id,$mobile_device_id);
- getHomeZones($token,$home_id);
- getHomeZoneState($token,$home_id,$zone_id);
- getHomeZoneCapabilities($token,$home_id,$zone_id);
- getHomeZoneEarlyStart($token,$home_id,$zone_id);
- getHomeZoneOverlay($token,$home_id,$zone_id);
- getHomeZoneScheduleActive($token,$home_id,$zone_id);
- getHomeZoneScheduleAway($token,$home_id,$zone_id);
- getHomeZoneScheduleTimetableBlocks($token,$home_id,$zone_id,$timetable_id,$pattern=null);
- identifyDevice($token,$device_id);        

## 5. Issues, Questions and Pull Requests

You can report issues and ask questions in the [issues section](https://github.com/robertogallea/restado/issues). Please start your issue with `ISSUE: ` and your question with `QUESTION: `

If you have a question, check the closed issues first.

To submit a Pull Request, please fork this repository, create a new branch and commit your new/updated code in there. Then open a Pull Request from your new branch. Refer to [this guide](https://help.github.com/articles/about-pull-requests/) for more info.