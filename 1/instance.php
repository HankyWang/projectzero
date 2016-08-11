<?php
  /**
  * when the __construct function is private ,the object must be instantiated by a public method
  */
  class Car
  {
    
    private function __construct()
    {
      echo 'object created';
    }
    public static $_object = NULL;
    public static function Instance()
    {
      if (empty(self::$_object))
      {
        self::$_object = new Car();

      }
      return self::$_object;
    }
  }
  $object = Car::Instance();
?>