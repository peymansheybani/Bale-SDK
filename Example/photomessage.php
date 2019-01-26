<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 22/01/19
 * Time: 14:49
 */

require "../vendor/autoload.php";

/**
 *  SET YOUR TOKEN FOR USE SEND MESSAGE TYPES
 */
$Bale = new \Vicente\Bale\Bale("YOUR TOKEN");

/**
 *  SET TYPE USER AND ID USER AND ACCESS HASH
 */
$peerUser = new \Vicente\Bale\Peer\PeerUsers("Group","1661462554","-2072671474748044026");

/**
 * NEW FILE CLASS FOR SEND FILE OR IMAGE
 */
$file = new \Vicente\Bale\Message\FileMessage();

/**
 * sendFiles IS METHOD GET PARAMS FOR USE SEND FILE OR IMAGE
 */
$fileMessage = $file->sendFiles("PATH OF YOUR IMAGE OR YOUR FILE",function ($params) use($Bale,$peerUser){

	/**
	 * send METHOD FOR SEND TYPES OF MESSAGE
	 */
	$Bale->send($params,$peerUser->getPeer());


},"MESSAGE FOR SEND WITH FILE OR IMAGE");
