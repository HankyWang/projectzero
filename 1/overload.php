<?
/**
* OVERLOAD
*/
class Car
{
  private ary = array();

  public function __set($key, $val)
  {
    $this->ary[$key] = $val;
  }

  public __get($key)
  {
    if (isset($this->ary[$key]))
    {
      return $this->ary[$key];
    }
    return null;
  }

  public __isset($key)
  {
    return (isset($this->ary[$key]));
  }

  public __unset($key)
  {
    unset($this->ary[$key]);
  }

  public __call($name, $arg)
  {
    if (name == 'SpeedUp')
    {
      if (isset($this->ary['speed']))
      {
        $this->speed += 10;
      }
    }
  }
}
$car = new Car();
$car->speed = 10;
$car->SpeedUp();
echo $car->speed;
?>