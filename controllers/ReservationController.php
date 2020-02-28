!#/etc/php/7.0/fpm -q
<?php
include "/var/www/html/airbnb-mock-server-joy/pdos/DatabasePdo";
include "/var/www/html/airbnb-mock-server-joy/pdos/IndexPdo.php";
//fcmSend('cferhGt65vA:APA91bGtgP2D7gI4-Uzt6KYuVbet8vSbINUZl3ozdKrIR9ObFjw9JSV-cRqd44D7WOja--l_ki6Xs6m3mxgZEAMCjYSg4J3CE5Ozpl3Zrr2JSTtADpKA8lA6xy6BtJQAT25I_beUB3fY');
reservationAlert();

?>