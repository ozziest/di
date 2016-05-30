<?php 

use Ozziest\DI;

class UnitTest extends PHPUnit_Framework_TestCase {
    
    public function test_set()
    {
        DI::bind('IName', 'MyName');
        $this->assertEquals(1, count(DI::getDependencies()));
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage DI couldn't resolve the dependency: IRepository
     */
    public function test_resolve_irepository_exception()
    {
        $instance = DI::resolve('MyController');
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage DI couldn't resolve the dependency: IModel
     */
    public function test_resolve_imodel_exception()
    {
        DI::bind('IRepository', 'MyRepository');
        $instance = DI::resolve('MyController');
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage DI couldn't resolve the dependency: IDB
     */
    public function test_resolve_idb_exception()
    {
        DI::bind('IModel', 'MyModel');
        $instance = DI::resolve('MyController');
    }

    public function test_resolve_ok()
    {
        DI::bind('IDB', 'MyDB');
        $instance = DI::resolve('MyController');
        $this->assertInstanceOf('MyController', $instance);
    }

    public function test_resolve_noninterface_exception()
    {
        $instance = DI::resolve('MyOtherController');
        $this->assertInstanceOf('MyOtherController', $instance);
        $this->assertEquals('saved!', $instance->save());
        $this->assertInstanceOf('MyDB', $instance->getDBInstance());
    }
    
    public function test_bind_function()
    {
        DI::bind('OtherModel', function () {
           return new OtherModel("my_string");
        });
        $instance = DI::resolve('MyFunction');
        $this->assertInstanceOf('MyFunction', $instance);
    }

}