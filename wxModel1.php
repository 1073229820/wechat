<?php

	class wxModel
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
	}
