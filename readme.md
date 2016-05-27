## Dependency Injection Resolver

[![Build Status](https://travis-ci.org/ozziest/di.svg)](https://travis-ci.org/ozziest/di)
[![Total Downloads](https://poser.pugx.org/ozziest/di/d/total.svg)](https://packagist.org/packages/ozziest/di)
[![Latest Stable Version](https://poser.pugx.org/ozziest/di/v/stable.svg)](https://packagist.org/packages/ozziest/di)
[![Latest Unstable Version](https://poser.pugx.org/ozziest/di/v/unstable.svg)](https://packagist.org/packages/ozziest/di)
[![License](https://poser.pugx.org/ozziest/di/license.svg)](https://packagist.org/packages/ozziest/di)

This is a simple dependency injection manager. 

> Do not use it on production.

### Installation 

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "ozziest/di": "dev-master"
    }
}
```

```
$ composer update
```

### Usage

```php 

class CustomModel {
    
    public function __construct(IDB $db)
    {
        
    }
    
}

class MyController {
    
    public function __construct(IModel $model, IRepository $repository, CustomModel $model)
    {
        
    }
    
}

Ozziest\DI::bind('IModel', 'MyModel');
Ozziest\DI::bind('IRepository', 'MyRepository');
Ozziest\DI::bind('IDB', 'MyDB');

$instance = Ozziest\DI::resolve('MyController');

// equals this
$instance = new MyController(
    new MyModel(), 
    new MyRepository(), 
    new CustomModel(new MyDB())
);
```