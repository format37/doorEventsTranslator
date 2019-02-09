<?php
$group='';

/* PUT данные приходят в потоке ввода stdin */
$putdata = fopen("php://input", "r");

/* Открываем файл на запись */
$filename="".uniqid().".jpg";
$fp = fopen($filename, "w");

/* Читаем 3 MB данных за один раз
   и пишем в файл */
while ($data = fread($putdata, 3000000))
  fwrite($fp, $data);

/* Закрываем потоки */
fclose($fp);
fclose($putdata);

//send to telegram and remove file
file_get_contents("http://scriptlab.net/telegram/bots/relaybot/relayPhoto.php?user=$group&photoUrl=scriptlab.net/telegram/bots/relaybot/$filename");
unlink($filename);
?>
