<?php
  class WechatAPI {

    private function http_curl($url, $type = 'get', $res = 'json', $arr = ''){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $timeout = 5;
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
      if ($type == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
      }
      $contents = curl_exec($ch);
      if ($res == 'json') {
        if ( curl_errno($ch) ) {
          return curl_error($ch);
        } else {
          return json_decode($contents,true);
        }
      }
      curl_close($ch);
    }


    public function getAccessToken() {
      session_start();
      if ( $_SESSION['access_token'] && $_SESSION['expire_time'] > time() ){
        echo $_SESSION['access_token'];
        return $_SESSION['access_token'];
      } 
      else {
        $appid = 'wxef284a104b046b24';
        $appsecret = 'c76fadf12613c1ebe4076f52bee92432';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $res = $this->http_curl($url, 'get','json');
        $access_token = $res['access_token'];
        $_SESSION['access_token'] = $access_token;
        $_SESSION['expire_time'] = time() + 7000;
        echo $access_token;
        return $access_token;
      }
    }

    public function defineMenu() {
    //  header('content-type:text/html;charset=utf-8');
      $access_token = $this->getAccessToken();
      $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
      $postArr = array(
              'button' =>array(
                array(
                  'name' => 'menu1',//urlencode('菜单1'),
                  'type' => 'click',
                  'key' =>'item1',
                  ),  
                array(
                  'name' => 'menu2',
                  'sub_button' => array(     //fuck this typo
                    array(
                      'name' => 'menu21',
                      'type' => 'click',
                      'key' => 'menu21',
                    ),
                    array(
                      'name' => 'menu22',
                      'type' => 'view',
                      'url' => 'https://www.baidu.com',
                    )
                  )
                ),
                array(
                  'name' => 'menu3',
                  'type' => 'view',
                  'url' => 'http://cn.bing.com'
                ),
              )
      );
      $postJson = urldecode( json_encode( $postArr ) );
      var_dump($postJson);
      $res = $this->http_curl($url,'post','json',$postJson);
      echo "<hr />";
      var_dump($res);
    }
  }//class end
  $ex = new WechatAPI();
  $ex->defineMenu();

