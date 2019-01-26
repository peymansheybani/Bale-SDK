<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 21/01/19
 * Time: 12:42
 */

require "../vendor/autoload.php";

/**
 *  SET YOUR TOKEN FOR USE SEND MESSAGE TYPES
 *
 *  $property string YOUR TOKEN
 */
$Bale = new \Vicente\Bale\Bale("YOUR TOKEN");

/**
 *  SET TYPE USER AND ID USER AND ACCESS HASH
 *
 *  $property array TYPE  [Group,User]
 *  $property string ID   (user_id get from method hears)
 */
$peerUser = new \Vicente\Bale\Peer\PeerUsers("TYPE","ID","ACCESS HASH");

/**
 *  GET PARAMS FOR SEND TEXT MESSAGE
 *
 *  $property string YOUR MESSAGE
 */
$textMessage = new \Vicente\Bale\Message\TextMessage('YOUR MESSAGE');

try {

	/**
	 * send METHOD FOR SEND TYPES OF MESSAGE
	 */
	$send = $Bale->send( $textMessage, $peerUser->getPeer() );

} catch ( \Vicente\Bale\Exception\MessageException $e ) {

	return "SERVER ERROR";

}

