# Dependency Injection Resolver

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