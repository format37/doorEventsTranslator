<?php
$token	= '';
$botUrl = "https://api.telegram.org/bot".$token."/sendPhoto?chat_id=".$_GET['user'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
curl_setopt($ch, CURLOPT_URL, $botUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, array("photo" => "@".$_GET['photoUrl'],));
$output = curl_exec($ch);
print $output;
?>