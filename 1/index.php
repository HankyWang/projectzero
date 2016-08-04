<?php
    $wechatObj = new wechatCallbackapiTest();
    if (isset($_GET['echostr'])) {
        $wechatObj->valid();
    }
    else{
        $wechatObj->responseMsg();
    }

    class wechatCallbackapiTest
    {
        public function valid()
        {
            $echoStr = $_GET["echostr"];
            if($this->checkSignature()){
                echo $echoStr;
                exit;
            }
        }
        private function checkSignature()
        {
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce     = $_GET["nonce"];
            $token     = 'weixin';
            $tmpArr    = array($token, $timestamp, $nonce);
            sort($tmpArr);
            $tmpStr = implode('', $tmpArr );
            $tmpStr = sha1( $tmpStr );
            if( $tmpStr == $signature ){
                return true;
            }
            else{
                return false;
            }
        }
        public function responseMsg()
        {
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
            if (!empty($postStr)){
                $postObj      = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername   = $postObj->ToUserName;
                $keyword      = trim($postObj->Content);
                $time         = time();
                $textTpl      = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
                if( $keyword == "time" || strtolower( $keyword ) == "时间" )
                {
                    $msgType    = "text";
                    $contentStr = date("Y-m-d H:i:s",time());
                    $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                if ($keyword === '菜单' || strtolower( $keyword ) === 'menu')
                {
                    $msgType    = 'text';
                    $contentStr = "欢迎使用菜单功能：\n输入号码即可查找号码归属地";
                    $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                if (is_numeric($keyword) && strlen($keyword) === 13)
                {
                    include('numberinfo.php');
                    $msgType    = 'text';
                    $contentStr = getPhoneNumInfo($keyword);
                    $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
            }
            else{
                echo "";
                exit;
            }
        }
    }
?>