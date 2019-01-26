<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 22/01/19
 * Time: 10:35
 */

namespace Vicente\Bale\Message;


interface Message {
	/**
	 * دریافت ساختار پیام
	 *
	 * @return array
	 */
	public function getMessage();
}