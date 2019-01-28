<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 20/01/19
 * Time: 14:25
 */

require "../vendor/autoload.php";

/**
 *  SET YOUR TOKEN FOR USE SEND MESSAGE TYPES
 */
$Bale = new \Vicente\Bale\Bale("YOUR TOKEN");

/**
 * hears GET TYPE AND USER ID AND ACCESS HASH
 */
$Bale->hears(function($user){
	echo $user;
});

