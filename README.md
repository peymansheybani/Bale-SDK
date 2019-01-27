<div style="direction:rtl;">
# Bale-SDK
 کتابخانه برای ارتباط ربات پیام رسان بله
===

این کتابخانه صرفا برای ارسال انواع پیام ها به کانال یا کاربر در پیام رسان بله می باشد.

برای استفاده شما ابتدا کتابخانه را دریافت نمایید :

```bash

composer require peyman/bale-sdk

```

خب شما موفق شدید

شما برای ارسال پیام ابتدا باید شناسه کانال یا کاربر را دریافت نمایید
برای این کار شما باید متد کد زیر را استفاده نمایید :

توضیح اینکه شما ابتدا باید ربات ساخته شده را در کانال خود اضافه کنید ولی مدیر نکنید.

```php

require "../vendor/autoload.php";

/**
 *  SET YOUR TOKEN FOR USE SEND MESSAGE TYPES
 */
$Bale = new \Vicente\Bale\Bale("YOUR TOKEN");

/**
 * hears GET TYPE AND USER ID AND ACCESS HASH
 */
$Bale->hears(function($user){
	print_r($user);
});


```

پس از اجرای کد بالا شما یه جیسون دریافت خواهید کرد که سه مقدار زیر را باید استفاده نمایید.

* id    // شناسه کانال یا کاربر
* accessHash // کد دسترسی مخصوص کانال یا کاربر
* type  



توضیح :

بعد از دریافت اطلاعات بالا شما ربات عضو شده در کانال را مدیر کنید.
در قسمت type بالا شما برای ارسال به کانال باید نوع را Group
و برای ارسال به کاربر برابر با User باشد.

خب بعد از دریافت اطلاعات بالا شما میتوانید با استفاده از کد زیر پیام متنی ارسال نمایید.

```php

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

```

توضیح :
در مثال بالا 
peerUsers
را با استفاده از مقادیر دریافتی از متد hears
پر نمایید.


برای ارسال پیام فایل یا عکس از کد زیر استفاده نمایید.

```php

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

```

</div>


 



