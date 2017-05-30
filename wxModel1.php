<?php

class wxModel 
{

	public function valid() 
	{

		$echoStr = $_GET["echostr"];

		if ( $this->checkSignature() ) {

			echo $echoStr;

			exit;
		}
	}

	private function checkSignature() 
	{

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
}
