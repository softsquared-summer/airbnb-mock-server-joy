<?php

require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));

function reservationUpdate()
{
$pdo = pdoSqlConnect();
$query = "UPDATE houseRv SET status = 3 WHERE status = 2 && checkIn < CURRENT_TIMESTAMP;";

$st = $pdo->prepare($query);
$st->execute();
//    $st->execute();
$st->setFetchMode(PDO::FETCH_ASSOC);
$res = $st->fetchAll();

$st = null;
$pdo = null;
}