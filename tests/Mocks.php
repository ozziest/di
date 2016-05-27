<?php 

interface IDB {};
interface IModel {};
interface IRepository {};

class MyDB implements IDB {}

class MyModel implements IModel {
    
    private $db;
    
    public function __construct(IDB $db)
    {
        $this->db = $db;
    }
    
    public function save()
    {
        return 'saved!';
    }
    
    public function getDBInstance()
    {
        return $this->db;
    }
    
}

class MyRepository implements IRepository {
    
    public function __construct(IModel $model)
    {
        
    }
    
}

class MyController {
    
    public function __construct(IRepository $model)
    {
        
    }
    
}

class MyOtherController {
    
    private $model;
    
    public function __construct(MyModel $model)
    {
        $this->model = $model;
    }
    
    public function save()
    {
        return $this->model->save();
    }
    
    public function getDBInstance()
    {
        return $this->model->getDBInstance();
    }
    
}