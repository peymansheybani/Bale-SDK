<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 20/01/19
 * Time: 14:02
 */

namespace Vicente\Bale;



use Vicente\Bale\Exception\MessageException;
use Vicente\Bale\Message\FileMessage;
use Vicente\Bale\Message\Message;
use Vicente\Bale\Message\TextMessage;

class Bale {

	private     static $address_socket = 'wss://api.Bale.ai/v1/bots/';
	private     static $token;
	public      static $address;

	private     $user_id;
	private     $accessHash;
	private     $username;



	public function __construct($token) {
		self::$token = $token;
		self::$address = self::$address_socket.self::$token;

	}


	/**
	 * با استفاده از این متد شما میتوانید مشخصات کاربری که پیامی ارسال کرده را دریافت نمایید.
	 * @param $callback
	 */
	public function hears($callback) {

		\Ratchet\Client\connect($this->setAddress())->then(function($conn)use($callback) {

			$conn->on('message', function($msg) use ($conn,$callback) {
				$result = json_decode($msg,true);

				$this->user_id = $result["body"]["peer"]["id"];
				$this->accessHash = $result["body"]["peer"]["accessHash"];
				$this->username = $result["users"][0][1]["username"];
				$user = [
					$this->user_id = $result["body"]["peer"]["id"],
					$this->accessHash = $result["body"]["peer"]["accessHash"],
					$this->username = $result["users"][0][1]["username"]
				];
				$callback($user);
				$conn->close();
			});

		}, function ($e) {

			return $e->getMessage();
		});

	}

	/**
	 * @param Message|string $message  پیام ارسالی
	 * @param $peer
	 *
	 * @return bool
	 * @throws Exception\MessageException
	 */
	public function send($message,$peer) {

		if($message instanceof TextMessage)
			$message = $message->getMessage();
		else if ($message instanceof FileMessage)
			$message = $message->getMessage();

		$params = [
			'peer' => $peer,
			'message' => $message
		];

		$message = $this->messageTemplate($params);



		\Ratchet\Client\connect(self::$address)->then(function($conn) use($message) {
			var_dump($conn->send(json_encode($message)));
			$conn->close();
		}, function ($e) {
			echo "خطا در ارتباط با سرور".$e->getMesssage();
		});

		return true;
	}

	/**
	 * ساختار جیسون ارسال پیام را درست می کند.
	 * @param $params
	 *
	 * @return array
	 */
	private function messageTemplate($params) {
		$i = 0;
		$rand    = ( date( "Ymd1His" ) );
		$message = [
			"\$type"  => "Request",
			"body"    => [
				"\$type"        => "SendMessage",
				"randomId"      => $rand,
			],
			"service" => "messaging",
			"id"      => "123456799"
		];


		$message["body"] += $params;

		return $message;
	}

}
