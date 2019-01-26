<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 22/01/19
 * Time: 10:02
 */

namespace Vicente\Bale\Message;


use Vicente\Bale\Bale;
use Vicente\Bale\Exception\MessageException;

class TextMessage extends Bale implements Message {

	private $message = '';

	public function __construct( $message ) {
		$this->message = $message;
	}

	/**     *
	 * @return array
	 * @throws MessageException
	 */
	public function getMessage() {
		if ( ! $this->message ) {
			throw new MessageException( "لطفا پیام خود را وارد کنید." );
		}

		return [
				'$type' => "Text",
				'text'  => $this->message

			];
	}
}