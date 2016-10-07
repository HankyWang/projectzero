<?php 
  /**
   * 
   */ 
  class UrlInfo {
    private $contents;
    private $picUrl;
    private $url;
    private $title;
    private $homepage;
    private $charset;
    public function __construct($str)
    {
      $this->url = $str;
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch, CURLOPT_URL, $str);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
      $this->contents  = curl_exec($ch);
      $this->picUrl = $this->getPic();
      $this->title = $this->getTitle();
      $pattern = '/([^\/]+)/';
      preg_match_all($pattern, $this->url, $matches);
      $this->homepage = $matches[0][0];
      $pattern = '/charset *= *([\w-]+)/';
      preg_match_all($pattern, $this->contents, $matches);
      $this->charset = $matches[1][0];
    }

    public function getTitle() {
      $pattern = '/<title>(.+)<\/title>/im';
      preg_match_all($pattern, $this->contents, $matches);
      $this->title = $this->charset == 'utf-8' ? $matches[1][0] : iconv($this->charset,"utf-8//IGNORE",$matches[1][0]);
      if (preg_match('/^(404|403|302|301)/', $this->title)) {
        $this->title = '微信端无法获取标题，请点击查看详情';
      }
      return $this->title;
    }

    public function getContent() {
      return $this->contents;
    }

    public function getUrl() {
      return $this->url;
    }

    public function getPic() {
      $pattern = '/<(img.+?src|link.+?href) *= *[\"\'](.+?logo.*?\.(png|jpg|jpeg))[\"\'].*>/';
      preg_match_all($pattern, $this->contents, $matches);
      $this->picUrl = empty($matches[2][0]) ? 'http://1.projectzero.applinzi.com/src/no_image.jpg' : $matches[2][0];
      if (preg_match('/^\/\//', $this->picUrl) == 1) {
        $this->picUrl = 'http:'.$this->picUrl;
      }
      if (preg_match('/^\/{1}\w/', $this->picUrl) == 1) {
        $this->picUrl = $this->homepage.$this->picUrl;
      }
      return $this->picUrl;
    }
  }
?> 