<?php
$json = file_get_contents('php://input');
$action = json_decode($json, true);
$message	= $action['message']['text'];
$chat		= $action['message']['chat']['id'];
$user		= $action['message']['from']['id'];
$token		= '';
$message = strtolower($message);
$AnswerText	= '';
if (substr($message,0,18)=='/relayurl@relaybot'||substr($message,0,9)=='/relayurl') $AnswerText	= "https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chat."%26text=this%2520is:%250a1.%2520simple%250a2.%2520example";
if (substr($message,0,19)=='/lockedurl@relaybot'||substr($message,0,10)=='/lockedurl') $AnswerText	= "http://scriptlab.net/telegram/bots/relaybot/relaylocked.php?token=".$token."%26chat=".$chat."%26text=example";
if (substr($message,0,18)=='/photourl@relaybot'||substr($message,0,9)=='/photourl') $AnswerText	= "http://scriptlab.net/telegram/bots/relaybot/relayPhoto.php?user=$chat%26photoUrl=scriptlab.net/wp-content/themes/twentyseventeen/assets/images/header.jpg";
if (substr($message,0,15)=='/token@relaybot'||substr($message,0,6)=='/token') $AnswerText	= $token;
if (substr($message,0,14)=='/user@relaybot'||(substr($message,0,5)=='/user'&&strlen($message)==5)) $AnswerText	= $user;
if (substr($message,0,15)=='/group@relaybot'||substr($message,0,6)=='/group') $AnswerText	= $chat;
if ($AnswerText!='') file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat.'&text='.$AnswerText);
?>