<?php
/**
 *
 * @author Hank Wang <hankvistawang@yahoo.com>
 */

  require('../src/Wechat.php');
  require('../src/RegexTools.php');


  /**
   * 微信公众平台演示类
   */
  class MyWechat extends Wechat {

    /**
     * 用户关注时触发，回复「欢迎关注」
     *
     * @return void
     */
    protected function onSubscribe() {
      $this->responseText('谢谢关注ProjectZero公众号');
    }

    /**
     * 用户取消关注时触发
     *
     * @return void
     */
    protected function onUnsubscribe() {
      $this->responseText('谢谢关注'); 
    }

    /**
     * 收到文本消息时触发，回复收到的文本消息内容
     *
     * @return void
     */
    protected function onText() {
      $RegexCheck = new RegexTools(false,null);
      $subject = $this->getRequest('content');

      //不需要返回输入文本信息
      
      //需要返回输入文本信息
      //
      //Mobile Information
      if ($RegexCheck->is_mobile($subject)) {
        require_once('../api/mobile.php');
        $resultStr = getMobile($subject);
        $this->responseText($resultStr);
      }

      if ($RegexCheck->Keyword("时间", $subject) || $RegexCheck->Keyword("time", $subject)) {
        $resultStr = '现在时间是: '.date("Y-m-d H:i:s",time());
        $this->responseText($resultStr);
      }

      // if ($RegexCheck->Keyword(""))


      //Url News Item
      if ($RegexCheck->is_url($subject)) {
        require_once('../api/url.php');
        $urlinfo = new UrlInfo($subject);
        $items = array( 
          new NewsResponseItem( $urlinfo->getTitle(), $urlinfo->getTitle(), $urlinfo->getPic(), $urlinfo->getUrl() ) 
        );
        $this->responseNews($items);
      }

      //Email Contents
      if ($RegexCheck->is_email($subject)) {
        $this->responseText('接收到了E-mail地址信息：');
      }

      
    }

    /**
     * 收到图片消息时触发，回复由收到的图片组成的图文消息
     *
     * @return void
     */
    protected function onImage() {
      $items = array(
        new NewsResponseItem('标题一', '描述一', $this->getRequest('picurl'), $this->getRequest('picurl')),
        new NewsResponseItem('标题二', '描述二', $this->getRequest('picurl'), $this->getRequest('picurl')),
      );

      $this->responseNews($items);
    }

    /**
     * 收到地理位置消息时触发，回复收到的地理位置
     *
     * @return void
     */
    protected function onLocation() {
      //$num = 1 / 0;
      // 故意触发错误，用于演示调试功能

      $this->responseText('收到了位置消息：' . $this->getRequest('location_x') . ',' . $this->getRequest('location_y'));
    }

    /**
     * 收到链接消息时触发，回复收到的链接地址
     *
     * @return void
     */
    protected function onLink() {
      $this->responseText('收到了链接：' . $this->getRequest('url'));
    }

    /**
     * 收到未知类型消息时触发，回复收到的消息类型
     *
     * @return void
     */
    protected function onUnknown() {
      $this->responseText('收到了未知类型消息：' . $this->getRequest('msgtype'));
    }

  }

  $wechat = new MyWechat('weixin', TRUE);
  $wechat->run();
