<?
/**
* OVERLOAD
*/
class Car
{
  private $ary = array();

  public function __set($key, $val)
  {
    $this->ary[$key] = $val;
  }

  public function __get($key)
  {
    if (isset($this->ary[$key]))
    {
      return $this->ary[$key];
    }
    return null;
  }

  public function __isset($key)
  {
    if (isset($this->ary[$key]))
      return true;
    return false;
  }

  public function __unset($key)
  {
    unset($this->ary[$key]);
  }

  public function __call($name, $arg)
  {
    if ($name == 'SpeedUp')
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
echo "<br />";
$truck = new Car();
var_dump(isset($truck->speed));
?>