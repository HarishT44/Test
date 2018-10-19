<?php
	$to = "harisasi1998@gmail.com";
	$subject = "My subject";
	$txt = "Hello world!";
	$headers = "From: iucedu@yahoo.com" . "\r\n" .
	"CC: hsirah44@gmail.com";

	mail($to,$subject,$txt,$headers);
?>
