!#/etc/php/7.2/fpm -q
<?php
include "/var/www/html/airbnb-mock-server-joy/pdos/DatabasePdo.php";
include "/var/www/html/airbnb-mock-server-joy/pdos/IndexPdo.php";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
//fcmSend('cferhGt65vA:APA91bGtgP2D7gI4-Uzt6KYuVbet8vSbINUZl3ozdKrIR9ObFjw9JSV-cRqd44D7WOja--l_ki6Xs6m3mxgZEAMCjYSg4J3CE5Ozpl3Zrr2JSTtADpKA8lA6xy6BtJQAT25I_beUB3fY');
$fcmRes = json_decode(json_encode(getFcmToken()));
$cnt = count(getFcmToken());
for ($i = 0; $i <= $cnt; $i++) {
    $res->result = fcmSend($fcmRes[$i]->fcmToken);
}



?>