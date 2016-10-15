# Laravel Configuration Extension
An extension for the standard Laravel's `Config` class that enables developers to create and manipulate configuration files at runtime, so that configuration values are persistent across multiple requests instead of calling `Config::set()` on every request.

## General Purpose
The standard `Config` class has no method to create nor to save new configuration files so, I made this simple package just to do these do things.

### Support
This package is supported in Laravel versions 5.0, 5.1, 5.2 and hopefully 5.3.
And of course the package is meant to be used with the `file` driver of `Config`.

### Installation
1. Use composer to install it as follows:
```
composer require grey-dev-0/laravel-config
```

2. Modify the `config/app.php` file.

For Laravel 5.0<br/>
Add this entry to the `providers` array.
````php
'GreyDev\ConfigExtension\ConfigExtensionProvider'
````

Modify the `Config` value in the `aliases` array to this:
 ````php
 'GreyDev\ConfigExtension\ConfigExtensionFacade'
 ````

For Laravel 5.1+<br/>
Add this entry to the `providers` array.
````php
GreyDev\ConfigExtension\ConfigExtensionProvider::class
````

 Modify the `Config` value in the `aliases` array to this:
 ````php
 GreyDev\ConfigExtension\ConfigExtensionFacade::class
 ````
 
 That's it you're good to go.
 
 ### Usage
 Along with other default `Config` methods like `get` and `set`, this package adds two extra methods `create` for creating new configuration file with the data you enable the users to set and, `save` which saves an existing or a new configuration value to an existing configuration file.
 
 ````php
 # To create a new file you can do like the following.
 Config::create('myConfigFile', [
  'key1' => 'something',
  'key2' => [
   'deepData' => 'deepValues'
  ],
  'key3' => 123,
  'key4' => true
 ]);
 
 # To save a value into an existing configuration file.
 Config::save('myConfigFile.key4', false);
 Config::save('myConfigFile.keyX', 5.2);
 ````
 
 After running the code above you'll find a file in your `config` folder with the name `myConfigFile.php` containing the following data:
 ````php
 return [
   'key1' => 'something',
   'key2' => [
    'deepData' => 'deepValues'
   ],
   'key3' => 123,
   'key4' => false,
   'keyX' => 5.2
 ];
 ````
 
 ### Notes
 This package does **not** clear opcache if it's used so new configuration values might not be applied on the next requests until you clear it manually. In case if opcache is used make sure to call `clear_opcache()` before using `create` or `save` methods.
 
 **License:** MIT.