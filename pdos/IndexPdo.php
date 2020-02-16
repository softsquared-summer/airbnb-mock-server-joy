<?php

//READ

//READ


function userSelect($no)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no, last_name, first_name, gender, birthday, email, phone FROM user WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$no]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];

}

function profile($no)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no, info, location, school, job, language FROM user WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$no]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];

}


function userCreate($phone, $last_name, $first_name, $birthday, $email, $pw)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO user (no, phone, last_name, first_name, birthday, email, pw, createdAt) VALUES (null, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP);";

    $st = $pdo->prepare($query);
    $st->execute([$phone, $last_name, $first_name, $birthday, $email, $pw]);

    $st = null;
    $pdo = null;

}

function userUpdate($no, $phone, $last_name, $first_name, $gender, $birthday, $email)
{
    $pdo = pdoSqlConnect();
    $query = "UPDATE user SET phone = ?, last_name = ?, first_name = ?, gender = ?, birthday = ?, email = ?, updatedAt = CURRENT_TIMESTAMP WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$phone, $last_name, $first_name, $gender, $birthday, $email, $no]);

    $st = null;
    $pdo = null;

}

function profileUpdate($no, $image, $info, $location, $school, $job, $language)
{
    $pdo = pdoSqlConnect();
    $query = "UPDATE user SET image = ?, info = ?, location = ?, school = ?, job = ?, language = ?, updatedAt = CURRENT_TIMESTAMP WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$image, $info, $location, $school, $job, $language, $no]);

    $st = null;
    $pdo = null;

}

function isValidLastname($_str)
{
    $lastname = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]{1,10}|[a-zA-Z]{2,10}$/u', $lastname);
}

function isValidFirstname($_str)
{
    $firstname = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]{1,10}|[a-zA-Z]{2,10}$/u', $firstname);
}

function isValidBirthday($_str)
{
    $birthday = $_str;

    return preg_match('/^(19[0-9][0-9]|20\d{2})(0[0-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])$/', $birthday);
}

function isValidEmail($_str)
{
    $email = $_str;

    return preg_match('/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i', $email);
}

function isValidPhone($_str)
{
    $phone = $_str;

    return preg_match('/^01([0|1|6|7|8|9]?)-?([0-9]{3,4})-?([0-9]{4})$/', $phone);
}

function isValidPw($_str)
{
    $pw = $_str;
    $num = preg_match('/[0-9]/u', $pw);
    $eng = preg_match('/[a-z]/u', $pw);
    $spe = preg_match("/[\!\@\#\$\%\^\&\*]/u",$pw);

    if(strlen($pw) < 10 || strlen($pw) > 30)
    {
        return array(false, 206,"비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 10자리 ~ 최대 30자리 이내로 입력해주세요.");
        exit;
    }

    if(preg_match("/\s/u", $pw) == true)
    {
        return array(false, 207, "비밀번호는 공백없이 입력해주세요.");
        exit;
    }

    if( $num == 0 || $eng == 0 || $spe == 0)
    {
        return array(false, 208, "영문, 숫자, 특수문자를 혼합하여 입력해주세요.");
        exit;
    }

    return array(true);
}

function isValidLocation($_str)
{
    $location = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]|[a-zA-Z]$/u', $location);
}

function isValidSchool($_str)
{
    $school = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]|[a-zA-Z]$/u', $school);
}

function isValidJob($_str)
{
    $job = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]|[a-zA-Z]$/u', $job);
}

function UserNo($email)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no FROM user where email = ?;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$email]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function userExist($email)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM user WHERE email = ?) AS exist;";

    $st = $pdo->prepare($query);
    $st->execute([$email]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);

}


function isValidUser($id, $pw){
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM user WHERE email = ? AND pw = ?) AS exist;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$id, $pw]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st=null;$pdo = null;

    return intval($res[0]["exist"]);

}


// CREATE
//    function addMaintenance($message){
//        $pdo = pdoSqlConnect();
//        $query = "INSERT INTO MAINTENANCE (MESSAGE) VALUES (?);";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message]);
//
//        $st = null;
//        $pdo = null;
//
//    }


// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }
