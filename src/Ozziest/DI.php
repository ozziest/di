<?php namespace Ozziest;

use Exception, ReflectionClass;

class DI {
    
    private static $list;
    
    public static function set($name, $callback)
    {
        if (isset(self::$list) === false)
        {
            self::$list = [];
        }
        
        self::$list[$name] = $callback;
    }
    
    public static function resolve($name)
    {
        $class = new ReflectionClass($name);
        $constructor = $class->getConstructor();
        
        $resolved = [];
        
        if ($constructor !== null)
        {
            foreach ($constructor->getParameters() as $index => $param)
            {
                $paramType  = $param->getClass()->name;
                $dependency = self::$list[$paramType];
                if (isset($dependency) === false)
                {
                    if (class_exists($paramType) === false)
                    {
                        throw new Exception("DI couldn't resolve the dependency: ".$paramType);
                    }
                    array_push($resolved, DI::resolve($paramType));
                } else {
                    array_push($resolved, DI::resolve($dependency));
                }
            }
            
        }
        
        return $class->newInstanceArgs($resolved);
    }    
    
    public static function getDependencies()
    {
        return self::$list;
    }
    
}

