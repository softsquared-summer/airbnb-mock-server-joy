!#/etc/php/7.2/fpm -q
<?php
include "/var/www/html/airbnb-mock-server-joy/pdos/DatabasePdo.php";
include "/var/www/html/airbnb-mock-server-joy/pdos/IndexPdo.php";

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));

function houseReservationUpdate()
{
$pdo = pdoSqlConnect();
$query = "UPDATE houseRv SET status = 2 WHERE status = 1 && checkIn < CURRENT_TIMESTAMP;";

$st = $pdo->prepare($query);
$st->execute();
//    $st->execute();
$st->setFetchMode(PDO::FETCH_ASSOC);
$res = $st->fetchAll();

$st = null;
$pdo = null;
}

function experienceReservationUpdate()
{
    $pdo = pdoSqlConnect();
    $query = "UPDATE experienceRv SET status = 2 WHERE status = 1 && date < CURRENT_TIMESTAMP;";

    $st = $pdo->prepare($query);
    $st->execute();
//    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
}


?>