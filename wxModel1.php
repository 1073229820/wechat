<?php

	/*class wxModel
	{

		public function valid()
		{

			$echoStr = $_GET['echoStr'];

			if ($this->checkSignature) {

				echo $echoStr;
				exit;
			}
		}

		private funcjtion checkSignature()
		{

			if (!defined("TOKEN")) {

				throw new Exception('TOKEN is not defined!');
			}

			$singnature = $_GET['singnature'];

			$timestamp = $_GET["timestamp"];

			$nonce = $_GET["nonce"];

			$token = TOKEN;

			$tmpArr = array($token, $timestamp, $nonce);

			sort($tmpArr, SORT_STRING);

			$tmpStr = implode($tmpArr);

			$tmpStr = shal($tmpStr);

			if ( $tmpStr == $singnature ) {

				return true;
				
			} else {

				return false;
			}

		}
	}*/

    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

      /*
     * 验证服务器地址的有效性*/
    private function checkSignature()
    {
        /*
        1）将token、timestamp、nonce三个参数进行字典序排序
        2）将三个参数字符串拼接成一个字符串进行sha1加密
        3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
         */
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];

        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;

        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
