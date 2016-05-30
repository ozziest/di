<?php namespace Ozziest;

use Exception, ReflectionClass;

class DI {
    
    private static $list;
    
    public static function bind($name, $callback)
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
                if (isset(self::$list[$paramType]) === false)
                {
                    if (class_exists($paramType) === false)
                    {
                        throw new Exception("DI couldn't resolve the dependency: ".$paramType);
                    }
                    array_push($resolved, DI::resolve($paramType));
                } else {
                    if (is_string(self::$list[$paramType]))
                    {
                        array_push($resolved, DI::resolve(self::$list[$paramType]));
                    } 
                    else 
                    {
                        $callable = self::$list[$paramType];
                        array_push($resolved, $callable());
                    }
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

