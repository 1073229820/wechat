<?php

class wxModel 
{

	//接口配置信息，此消息需要你有自己的服务器资源，填写的URL需要正确响应发送的TOKEN验证
	public function valid() 
	{

		$echoStr = $_GET["echostr"];

		if ( $this->checkSignature() ) {

			echo $echoStr;

			exit;
		}
	}




	/* 验证服务器地址的有效性*/
	private function checkSignature() 
	{
		/*1）将token、timestamp、nonce三个参数进行字典序排序
        2）将三个参数字符串拼接成一个字符串进行sha1加密
        3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
         */

		if (!defined("TOKEN")) {

			throw new Exception('TOKEN is not defined!');
		}

		$signature = $_GET["signature"];

		$timestamp = $_GET["timestamp"];

		$nonce = $_GET["nonce"];

		$token = TOKEN;

		$tmpArr = array($token, $timestamp, $nonce);

		sort($tmpArr, SORT_STRING);

		$tmpStr = implode($tmpArr);

		$tmpStr = sha1($tmpStr);

		if ( $tmpStr == $signature ) {

			return true;
		} else {

			return false;
		}
	}




	public function responseMsg() 
	{
		//php版本<5.6 $GLOBALS  php版本>7.0用file_get_contents('php://input') 来获取微信服务器发送的数据
		// $postStr = $GLOBALS["HTTP_RAM_POST_DATA"];

		$postStr = file_get_contents('php://input');

		if (!empty($postStr)) {

			libxml_disable_entity_loader(true);

			//将接收过来的数据转换成对象
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

			$tousername = $postObj->ToUserName;

			$fromusername = $postObj->FromUserNam;

			$msgtype = $postObj->MsgType;

			$keyword = trim($postObj->Content);

			//判断msgtype类型 text文本类型
			if ($msgtype == 'text') {

				//判断关键字，根据关键字自定义回复
				if ($keyword == '图文') {

					$arr = array(

						array(

							'title'=>'习近平厚植绿水青山 描绘美丽中国新画卷',
							'description'=>'绿色，象征着生命。绿色发展，是对山川草木生命之延替的期盼，更是对人类经济社会可持续发展的追',
							'picurl'=>'http://cms-bucket.nosdn.127.net/catchpic/f/f7/f7fa4d678213ac5a272f38c82cc059e5.jpg?imageView&thumbnail=550x0',

							'url'=>'http://news.163.com/17/0605/17/CM6DC02T000189FH.html'

						),

						array(

							'title'=>'30天3名纪检干部被通报 一人被指"泄露审查信息"',
							'description'=>'今日中午，黑龙江省纪委原常委宋川严重违纪被“双开”。据悉，宋川被指“违反政治纪律，串供和转移、隐匿证据，对抗组织审查……违规干预司法',
							'picurl'=>'http://dingyue.nosdn.127.net/tQPU0dC8i2TRJFmjpdD4PFzBTMPmKWNFyzj3iQhGA=b2E1496666318265transferflag.png',

							'url'=>'http://news.163.com/17/0605/20/CM6OMS0R0001875N.html'

						),

						array(

							'title'=>'王卫的底牌，顺丰凭什么能打败不可一世的菜鸟"',
							'description'=>'6月3日凌晨时分，顺丰、菜鸟达成协议，当天中午12时起，双方全面恢复业务合作和数据传输，这意味着持续了两天的顺丰菜鸟之争',
							'picurl'=>'http://dingyue.nosdn.127.net/tQPU0dC8i2TRJFmjpdD4PFzBTMPmKWNFyzj3iQhGA=b2E1496666318265transferflag.png',

							'url'=>'http://tech.163.com/17/0605/07/CM5BAC0H00097U7R.html'

						),


					);

					$textTpl = <<<EOT
								<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<ArticleCount>%s</ArticleCount>
									<Articles>
EOT;
					$str = '';
					
					foreach($arr as $v) {

						$str.='<item>';
						$str.='<Title><![CDATA['.$v['title'].']]></Title>'; 
						$str.='<Description><![CDATA['.$v['Description'].']]></Description>';
						$str.='<PicUrl><![CDATA['.$v['picurl'].']]></PicUrl>';
						$str.='<Url><![CDATA['.$v['url'].']]></Url>';
						$str.='</item>';
					}	
									
					$textTpl .= $str;

					$textTpl .= '</Articles></xml>';
					
					$time = time();

					$msgtype = 'news';	

					$num == count($arr);	

					$restr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $num);

					echo $restr;
				}
			}
		}
	}
}
