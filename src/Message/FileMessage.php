<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 22/01/19
 * Time: 10:43
 */

namespace Vicente\Bale\Message;


use Vicente\Bale\Bale;
use Vicente\Bale\Exception\MessageException;

class FileMessage implements Message {

	private $address = "";
	private $params  = [];

	public function __construct() {
		$this->address = Bale::$address;
	}

	/**
	 * @inheritdoc
	 */
	public function getMessage() {
		return $this->params;
	}

	/**
	 * @param string    $path آدرس فایل
	 * @param callable  $callback تابع خروجی
	 * @param string    $message متن پیام
	 *
	 * @throws MessageException
	 */
	public function sendFiles($path,$callback,$message = "") {
		if(!($size = filesize($path)))
			throw new MessageException("مسیر فایل اشتباه است.");


		$this->getUploadUrl($size,function ($uploadInfo) use($path,$message,$callback){


			$uploadInfo = json_decode($uploadInfo,true);
			$upload = $this->uploadFile($uploadInfo["body"]["url"],$path);

			if(!$upload)
				throw new MessageException("خطا در آپلود تصویر");

			$params = $this->setPhotoParams($uploadInfo,$path,$message);

			if(!empty($params))
			{
				$callback($params);
				$this->params = $params;
				return true;
			}else
				return false;



		});
	}

	private function getUploadUrl($size,$callback){

		\Ratchet\Client\connect($this->address)->then(function($conn) use($size,$callback) {
			/**
			 * @var \Ratchet\Client\WebSocket $conn
			 */
			$conn->on('message', function($msg) use ($conn,$callback) {
				$callback($msg);
				$conn->close();
			});
			$crc = "201";
			$params = [
				'service' => 'files',
				'$type' => 'Request',
				'body' => [
					'crc' => $crc,
					'size' => $size,
					'$type' => 'GetFileUploadUrl',
					'isServer' => false,
					'fileType' => 'file'
				],
				'id' => "0"
			];

			$conn->send(json_encode($params));

		}, function ($e) {
			echo "test";
			echo 'خطا در اتصال به سرور'.$e->getMesssage();
		});

	}


	private function uploadFile($url,$path){

		$body = fopen($path, 'r');
		$client = new \GuzzleHttp\Client();
		$request = $client->request("PUT",$url,['body' => $body]);

		if($request->getStatusCode() == 200)
			return true;
		else
			return false;

	}

	private function setPhotoParams($info,$path,$message){

		if($image = getimagesize($path)){
			$thumb = [
				"thumb" => "None",
				'width' => 80,
				'height' => 80,
			];
			$ext = [
				"height" => $image[1],
				'$type' => "Photo",
				"width" => $image[0]
			];

			$mime   = $image["mime"];
		}else{
			$thumb = null;
			$ext = null;
			$ext_width = null;
			$ext_height = null;
			$width  = null;
			$height = null;
			$mime   = mime_content_type($path);
		}

		$name = pathinfo($path);
		$size = filesize($path);

		$params = [
			"checkSum" => "checkSum",
			"mimeType" => $mime,
			"fileSize" => strval($size),
			"fileId" => $info["body"]["fileId"],
			"algorithm" => "algorithm",
			"fileStorageVersion" => 1,
			"\$type" => "Document",
			"accessHash" => strval($info["body"]["userId"]),
			"caption" => [
				"\$type" => "Text",
				"text" => $message
			],
			"thumb" => $thumb,
			"ext" => $ext,
			"name" => $name["filename"]
		];

		return $params;

	}


}