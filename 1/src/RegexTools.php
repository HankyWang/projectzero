<?php

/**
* @param 
*
* 
*/
class RegexTools 
{

  private $fixMode     = null;
  private $isMatch     = false;
  private $ReturnResult    = false;
  private $Matches = array();
  private $validate    = array(  
    'email'  => '/^[a-zA-Z0-9](\w|\.|-)*@(\w+\.)+([a-zA-Z]+)$/',
    'url'    => '#^(https?://)?(\w+\.)+[a-zA-Z]+([^.]*|/\w+\.\w+)$#',
    'mobile' => '/1[34578]\d{9}/',
    'require' => '/.+/',
    'logo' =>'/<(img.+?src|link.+?href) *= *[\"\'](.+?logo.*?\.(png|jpg|jpeg))[\"\'].*>/',
    'title' => '/<title>(.+)<\/title>/'
  );

  /**
   * @param str fixMode
   * @param bool ReturnResult
   */
  public function __construct($ReturnResult = false, $fixMode = null) {
    $this->ReturnResult = $ReturnResult;
    $this->fixMode = $fixMode;
  }

  /**
   * @param  str pattern 
   * @param  str subject
   * @return private function getResult
   */
  private function regex($pattern, $subject) {
    if (array_key_exists(strtolower($pattern), $this->validate)){
      $pattern = $this->validate[$pattern].$this->fixMode;
    }
    $this->ReturnResult ? preg_match_all($pattern, $subject, $this->Matches) : $this->isMatch = preg_match($pattern, $subject) === 1;
    return $this->getResult();
  }

  private function getResult(){
    if ($this->ReturnResult) {
      return $this->Matches;
    }
    else {
      return $this->isMatch;
    }
  }

  /**
   * @param  bool 
   * @return void
   */
  public function toggleReturn($bool = null) {
    if (empty($bool)) {
      $this->ReturnResult = ! $this->ReturnResult;
    }
    else {
      $this->ReturnResult = is_bool($bool) ? $bool : (bool)$bool;
    }
  }

  /**
   * @param  str fixmode
   * @return void
   */
  public function setFixMode($fixmode) {
    $this->fixMode = $fixmode;
  }

  public function is_email($str) {
    return $this->regex('email', $str);
  }

  public function is_mobile($str) {
    return $this->regex('mobile', $str);
  }

  public function is_url($str) {
    return $this->regex('url', $str);
  }

  public function startwith($prefix, $str) {
    return $this->regex('/^'.$prefix.'/', strtolower($str));
  }

  public function endwith($affix, $str) {
    return $this->regex('/'.$affix.'$/', strtolower($str));
  }

  public function Keyword($keyword, $str) {
    return $this->regex('/'.$keyword.'/', strtolower($str));
  }
  public function noEmpty($str) {
    return $this->regex('require', $str);
  }

  public function show(){
    print($this->fixMode);
    echo '<hr />';
    var_dump($this->ReturnResult);
  }
}
