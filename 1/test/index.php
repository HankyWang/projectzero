<?php
class WechatCallBack{
    private function signature_check($token) {//验证签名
  $signature = $_GET['signature'];
  $timestamp = $_GET['timestamp'];
  $nonce = $_GET['nonce'];
  $sigature_arr = array($token,$timestamp,$nonce);
  sort($sigature_arr);
  if($signature == sha1(implode($sigature_arr))){
    return 1;
  }
  else{
    return 0;
  }
}
public function valid(){
    $echoStr = $_GET["echostr"];
            if(signature_check('weixin')){
                echo $echoStr;
                exit;
            }
}

public function MessageResopnd() {
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    if(!empty($postStr)){
        $postObj      = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromusername = $postObj->FromUserName;
        $tousername = $postObj->ToUserName;
        $time = time();
        $cotent = trim($postObj->Content);
        $textTpl      = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";

        if (preg_match('/.*(time|时间).*/', $content)) {
            $msgType = "text";
            $data_time = date("Y-m-d h:i:s",time());
            $result = sprintf($textTpl,$fromusername,$tousername,$time,$msgType,$data_time);
          echo $result;
       }
        else if (preg_match('/.*(歌|song).*/', $content)) {
            $msgType = "text";
            $recommand_song = "信仰";
            $result = sprintf($textTpl,$fromusername,$tousername,$time,$msgType,$recommand_song);
            echo $result;
        }
        else if (preg_match('/.*(书|book).*/', $content)) {
            $msgType= "text";
            $recommand_book = "解忧杂货店";
            $result = sprintf($textTpl,$fromusername,$tousername,$time,$msgType,$recommand_book);
            echo $result;
        }

     }
}   
}
$wechatObj = new WechatCallBack();
    if (isset($_GET['echostr'])) {
        $wechatObj->valid();
    }
    else{
        $wechatObj->MessageResopnd();
    }
?>