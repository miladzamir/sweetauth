# sweet auth

![image](https://www.logogala.com/images/uploads/gallery/sweet.png)

[![Latest Stable Version](https://poser.pugx.org/miladzamir/sweetauth/v)](//packagist.org/packages/miladzamir/sweetauth) [![Total Downloads](https://poser.pugx.org/miladzamir/sweetauth/downloads)](//packagist.org/packages/miladzamir/sweetauth) [![Latest Unstable Version](https://poser.pugx.org/miladzamir/sweetauth/v/unstable)](//packagist.org/packages/miladzamir/sweetauth) [![License](https://poser.pugx.org/miladzamir/sweetauth/license)](//packagist.org/packages/miladzamir/sweetauth)

## ✨ Features
- **Build mobile number authentication.** Very Fast
- **Customize all routes.** Change to the way you like
- **Customize all views.** replace your view file

## 🐛Requirements

 * PHP version 7.1 or higher
 * Laravel <= 7.4
 * [Orange Package](github.com/miladzamir/orange)
 * [Laravel Ui Package V2.*](https://github.com/laravel/ui)

## 🔨Installation:

### 1. Composer
```
composer require miladzamir/sweetauth
```

### 2. Add the ServiceProvider
Open the file config/app.php
```php
"providers": {
    ...
    MiladZamir\SweetAuth\SweetAuthServiceProvider::class,
    ...
},
```

### 3. Publish vendor resources
```
php artisan vendor:publish
```

### 4. Migrate tables
```
php artisan migrate
```

### 🎓Explanation:
>You can do your personalization by changing the \config\swauth.php file or resources\views.

##### _default Routes_:
- YourDomain.io/login
- YourDomain.io/register
- YourDomain.io/forget

**And now you do not have to do anything! You have a mobile number authentication system :)**

_ENJOY 🍻:)_
