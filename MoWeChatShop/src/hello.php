<?php
/**
 * 微信公众平台 PHP SDK 示例文件
 *
 * @author NetPuter <netputer@gmail.com>
 */

  require('Wechat.php');

  define("TOKEN", "mirrorhammermirror");
  define("AESKEY", "bNSqauFhpNTQlf6VdmlCWbWNC6LbK7nhEnIYJtEq5Dr");
  define("APPID", "wx89dd7af41a638f02");
  define("DEBUG", "false");

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
      $this->responseText('欢迎来到小莫的服装店。话不多说，既然关注了就是小莫的人了ヽ(✿ﾟ▽ﾟ)ノ
       \n想入小莫的群请添加微信[jessica].
       \n回复"小莫是谁"可以看到小莫的前世今生
       \n回复"小莫在哪"可以看到小莫店铺的具体位置
       \n回复自己的位置可以查询自己到店铺的路线哦
       \n待施工');
    }

    /**
     * 用户已关注时,扫描带参数二维码时触发，回复二维码的EventKey (测试帐号似乎不能触发)
     *
     * @return void
     */
    protected function onScan() {
      $this->responseText('二维码的EventKey：' . $this->getRequest('EventKey'));
    }

    /**
     * 用户取消关注时触发
     *
     * @return void
     */
    protected function onUnsubscribe() {
      // 「悄悄的我走了，正如我悄悄的来；我挥一挥衣袖，不带走一片云彩。」
    }

    /**
     * 上报地理位置时触发,回复收到的地理位置
     *
     * @return void
     */
    protected function onEventLocation() {
      $this->responseText('收到了位置推送：' . $this->getRequest('Latitude') . ',' . $this->getRequest('Longitude'));
    }

    /**
     * 收到文本消息时触发，回复收到的文本消息内容
     *
     * @return void
     */
    protected function onText() {
        $receiveMsg = $this->getRequest("content");
        if(strpos($receiveMsg,"小莫是谁")>=0){
            $this->responseText("小莫是一家新开的网红店铺,专门售卖服装成品");
        }
      $this->responseText('收到了文字消息：' . $this->getRequest('content'));
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
      $num = 1 / 0;
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
     * 收到语音消息时触发，回复语音识别结果(需要开通语音识别功能)
     *
     * @return void
     */
    protected function onVoice() {
      $this->responseText('收到了语音消息,识别结果为：' . $this->getRequest('Recognition'));
    }

    /**
     * 收到自定义菜单消息时触发，回复菜单的EventKey
     *
     * @return void
     */
    protected function onClick() {
      $this->responseText('你点击了菜单：' . $this->getRequest('EventKey'));
    }

    /**
     * 分析消息类型，并分发给对应的函数
     *
     * @return void
     */
    public function run() {
          switch ($this->getRequest('msgtype')) {

              case 'event':
                  switch ($this->getRequest('event')) {

                      case 'subscribe':
                          $this->onSubscribe();
                          break;

                      case 'unsubscribe':
                          $this->onUnsubscribe();
                          break;

                      case 'SCAN':
                          $this->onScan();
                          break;

                      case 'LOCATION':
                          $this->onEventLocation();
                          break;

                      case 'CLICK':
                          $this->onClick();
                          break;

                  }

                  break;

              case 'text':
                  $this->onText();
                  break;

              case 'image':
                  $this->onImage();
                  break;

              case 'location':
                  $this->onLocation();
                  break;

              default:
                  break;

          }
     }

  }

  $wechat = new MyWechat(array(
      'token' => TOKEN,
      'aeskey' => AESKEY,
      'appid' => APPID,
      'debug' => DEBUG
  ));
  $wechat->run();
