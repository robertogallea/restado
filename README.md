# Restado
PHP and Laravel library for managing Tado system

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robertogallea/restado.svg?style=flat-square)](https://packagist.org/packages/robertogallea/restado)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jeroennoten/Laravel-AdminLTE/master.svg?style=flat-square)](https://travis-ci.org/jeroennoten/Laravel-AdminLTE)
[![Total Downloads](https://img.shields.io/packagist/dt/robertogallea/restado.svg?style=flat-square)](https://packagist.org/packages/robertogallea/restado)


This package provides a simple interface towards the public Tado Thermostat System API. It wraps the web methods available for authenticating users and retrieve information from the local devices. 

The package is also integrated within Laravel.

Since the API is currently officially undocumented, if you are aware of methods missing in this library, please inform me!


 1. [Installation](#1-installation)
 2. [Updating](#2-updating)
 3. [Configuration](#3-configuration)
 4. [Usage](#4-usage)
 5. [Supported Methods](#5-supported-methods)
 6. [Issues, Questions and Pull Requests](#6-issues-questions-and-pull-requests)
 
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
    TADO_HOME_ID=<TADO_HOME_ID>
    ```
    
    
## 2. Updating

1. To update this package,  update the composer package:

    ```php
    composer update robertogallea/restado
    ```    
    
## 3. Configuration
    
1. To use Restado, no further configuration is required. However, if you wish to tweak with config, publish the relative
 configuration file using the command

```php
php artisan vendor:publish --provider="Robertogallea\Restado\RestadoServiceProvider" --tag=config
```
    
## 4. Usage    
To use this package you should use the method of the Restado facade. 

1. Obtain a valid token for your session:

    ```php
    $access_token = Restado::authorize();
    ``` 
    
2. Use a method to get the related information, for example:
    
    ```php
    $me = Restado::me($access_token);
    ```     
    
each method returns an object containing the data from the server. Currently the API is not officially documented, the only reference I found is at this page: http://blog.scphillips.com/posts/2017/01/the-tado-api-v2/

 
## 5. Supported Methods
Currently these methods are supported:
- authorize();
- me($token);
- getHome($token);
- setHome($access_token, $settings);
- getHomeWeather($token);
- getHomeDevices($token);
- getHomeInstallations($token);
- getHomeUsers($token);
- getHomeMobileDevices($token);
- deleteHomeMobileDevice(token,$mobile_device_id)
- getHomeMobileDeviceSettings($token,$mobile_device_id);
- setHomeMobileDeviceSettings($token,$mobile_device_id,$settings)
- getHomeZones($token);
- getHomeZoneState($token,$zone_id);
- getHomeZoneDayReport($token,$zone_id,date);
- getHomeZoneCapabilities($token,$zone_id);
- getHomeZoneEarlyStart($token,$zone_id);
- setHomeZoneEarlyStart($token,$zone_id,$settings);
- getHomeZoneOverlay($token,$zone_id);
- setHomeZoneOverlay($token,$zone_id,$settings);
- deleteHomeZoneOverlay($token,$zone_id);
- getHomeZoneScheduleActiveTimetable($token,$zone_id);
- setHomeZoneScheduleActiveTimetable($token,$zone_id,$settings);
- getHomeZoneScheduleAway($token,$zone_id);
- setHomeZoneScheduleAway($token,$zone_id,$settings);
- getHomeZoneScheduleTimetableBlocks($token,$zone_id,$timetable_id,$pattern=null);
- setHomeZoneScheduleTimetableBlocks($token,$zone_id,$timetable_id,$pattern,$settings);
- identifyDevice($token,$device_id);        
- getTemperatureOffset($accessToken, $deviceid)
- setTemperatureOffset($accessToken, $deviceid, $settings)
- setDazzle($accessToken, $zoneid, $setting)
- setOpenWindowDetection($accessToken, $zoneid, $settings)
- isAnyoneAtHome($access_token);
- getPresenceLock($access_token);
- setPresenceLock($access_token, $settings);
- getEnergySavingsReport($access_token, $year, $month, $country_code);
- deleteEnergyIQMeterReading($access_token, $reading_id);
- addEnergyIQMeterReading($access_token, $settings);
- updateEnergyIQTariff($access_token, $settings);
- getEnergyIQMeterReadings($access_token);
- getEnergyIQTariff($access_token);
- getEnergyIQ($access_token);
- getAppUsersRelativePositions($token)

# Country code format for getEnergySavingsReport
To request an energy savings report via getEnergySavingsReport, you're required to pass a three-letter country code in accordance with [ISO 3166-1 alpha-3](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3)

## 6. Issues, Questions and Pull Requests

You can report issues and ask questions in the [issues section](https://github.com/robertogallea/restado/issues). Please start your issue with `ISSUE: ` and your question with `QUESTION: `

If you have a question, check the closed issues first.

To submit a Pull Request, please fork this repository, create a new branch and commit your new/updated code in there. Then open a Pull Request from your new branch. Refer to [this guide](https://help.github.com/articles/about-pull-requests/) for more info.
