<?php

//READ

//READ


function userSelect($no)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no as userNo, firstName, lastName, gender, birthday, email, phone FROM user WHERE no = ?;";

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
    $query = "SELECT no as userNo,
       firstName as firstName,
       image,
       info,
       concat(DATE_FORMAT(createdAt, '%Y'), '년', ' ', DATE_FORMAT(createdAt, '%m'), '월') as createdDate,
       location,
       school,
       job,
       language
FROM user WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$no]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];

}


function userCreate($phone, $firstName, $lastName, $birthday, $email, $pw)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO user (no, phone, firstName, lastName, birthday, email, pw, createdAt) VALUES (null, ?, ?, ?, ?, ?, password(?), CURRENT_TIMESTAMP);";

    $st = $pdo->prepare($query);
    $st->execute([$phone, $firstName, $lastName, $birthday, $email, $pw]);

    $st = null;
    $pdo = null;

}

function userUpdate($no, $phone, $firstName, $lastName, $gender, $birthday, $email)
{
    $pdo = pdoSqlConnect();
    $query = "UPDATE user SET phone = ?, firstName = ?, lastName = ?, gender = ?, birthday = ?, email = ?, updatedAt = CURRENT_TIMESTAMP WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$phone, $firstName, $lastName, $gender, $birthday, $email, $no]);

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

function houseHost($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userNo as hostNo
FROM house WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];

}

function experienceHost($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userNo as hostNo
FROM experience WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];

}

function isValidLastname($_str)
{
    $lastname = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]{1,30}|[a-zA-Z]{2,10}$/u', $lastname);
}

function isValidFirstname($_str)
{
    $firstname = $_str;

    return preg_match('/^[\x{AC00}-\x{D7A3}]{1,30}|[a-zA-Z]{2,10}$/u', $firstname);
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
    $phone = preg_replace('/^01([0|1|6|7|8|9]?)([0-9]{3,4})([0-9]{4})$/',"\\1-\\2-\\3" ,$_str);

    return preg_match('/^01([0|1|6|7|8|9]?)-?([0-9]{3,4})-?([0-9]{4})$/', $phone);
}

function isValidPw($_str)
{
    $pw = $_str;
    $num = preg_match('/[0-9]/u', $pw);
    $eng = preg_match('/[a-z]/u', $pw);
    $spe = preg_match("/[\!\@\#\$\%\^\&\*]/u", $pw);

    if (strlen($pw) < 10 || strlen($pw) > 30) {
        return array(false, 206, "비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 10자리 ~ 최대 30자리 이내로 입력해주세요.");
        exit;
    }

    if (preg_match("/\s/u", $pw) == true) {
        return array(false, 207, "비밀번호는 공백없이 입력해주세요.");
        exit;
    }

    if ($num == 0 || $eng == 0 || $spe == 0) {
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

function isValidDate($_str)
{
    $date = $_str;

    return preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $date);
}

function isValidGuest($_str)
{
    $guest = $_str;

    return preg_match('/(^[1-9]{1}$|^[1-4]{1}[0-9]{1}$|^50$)/m', $guest);
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

function phoneExist($phone)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM user WHERE phone = ?) AS exist;";

    $st = $pdo->prepare($query);
    $st->execute([$phone]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);

}


function isValidUser($id, $pw)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM user WHERE email = ? AND pw = ?) AS exist;";


    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$id, $pw]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);

}

function houseExist($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM house WHERE no = ?) AS exist;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);

}

function experienceExist($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT * FROM experience WHERE no = ?) AS exist;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);

}

function experienceReservationExist($experienceNo, $userNo, $date)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(SELECT eR.userNo
    FROM experienceRv eR
left outer join experience e on eR.experienceNo = e.no
WHERE experienceNo = ? && eR.userNo = ? && date = ?) AS exist;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo, $userNo, $date]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return intval($res[0]["exist"]);

}

function dateGap($sdate,$edate){

    $sdate = str_replace("-","",$sdate);

    $edate = str_replace("-","",$edate);

    for($i=$sdate;$i<=$edate;$i++){

        $year       = substr($i,0,4);

        $month = substr($i,4,2);

        $day     = substr($i,6,2);

        if(checkdate($month,$day,$year)){

            $date[$year."-".$month."-".$day] = $year."-".$month."-".$day;

        }

    }

    return $date;

}
//function houseImage($houseNo)
//{
//    $pdo = pdoSqlConnect();
//    $query = "SELECT no as imageNo,
//       image as imageUrl,
//       case when content is null
//           then ''
//           else content
//           end as imageContent,
//       sequenceNo
//FROM image WHERE houseNo = ?
//order by sequenceNo;";
//
//    $st = $pdo->prepare($query);
//    $st->execute([$houseNo]);
//    //    $st->execute();
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st = null;
//    $pdo = null;
//
//    return $res;
//}

function houseSearch($userNo, $search, $guest, $houseType, $bed, $room, $bathroom, $facilities, $buildingType, $rule, $location, $language)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT DISTINCT h.no as houseNo,
       case when houseType = '개인실'
           then concat(h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '객실'
           then concat(h.buildingType, ' ', h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '다인실'
           then concat(h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '전체'
           then concat(h.buildingType, ' ', h.houseType, ' · 침대 ', h.bed, '개')
           end as houseInfo,
       case when review.staravg is null
           then 0
           else review.staravg
           end as starAvg,
       case when review.reviewCnt is null
           then 0
           else review.reviewCnt
           end as reviewCnt,
       h.name as houseName,
       image.images as houseImages,
       case when EXISTS(SELECT no FROM saveList WHERE userNo = ? && houseNo = h.no)
           then 1
           else 0
           end as isSave
FROM house h
left outer join (
    SELECT i.houseNo, group_concat(i.image) as images

    FROM image i
    left outer join house h on i.houseNo = h.no
    group by houseNo

    ) image on h.no = image.houseNo
left outer join houseFacilities hf on h.no = hf.houseNo
left outer join facilities f on hf.facilitiesNo = f.no
left outer join (SELECT r.houseNo, r.content
    FROM house h
    left outer join rule r on h.no = r.houseNo
    ) rule on rule.houseNo = h.no
left outer join (
    SELECT u.no, u.image, u.firstName, u.language
    FROM user u
           ) host on  h.userNo =  host.no
left outer join (
    SELECT rv.houseNo, count(*) as reviewCnt, ROUND(avg(r.star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    group by rv.houseNo
           ) review on  h.no =  review.houseNo
WHERE h.sido REGEXP concat('^', ?)
  AND h.guestCnt >= ?
  AND h.houseType REGEXP concat('^', ?)
  AND h.bed >= ?
  AND h.room >= ?
  AND h.bathroom >= ?
  AND f.name REGEXP concat('^', ?)
  AND h.buildingType REGEXP concat('^', ?)
  AND rule.content REGEXP concat('^', ?)
  AND (h.gu REGEXP concat('^', ?) || h.dong REGEXP concat('^', ?))
  AND host.language REGEXP concat('^', ?);";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $search, $guest, $houseType, $bed, $room, $bathroom, $facilities, $buildingType, $rule, $location, $location, $language]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseImage($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT group_concat(image) as imageUrl
FROM image WHERE houseNo = ?
group by houseNo;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function houseInfo($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT h.no as houseNo,
       h.name as houseTitle,
       u.image as hostImage,
       case when h.dong is null
           then concat(h.gu, ', ', h.sido, ', ', h.country)
           else concat(h.dong, ', ', h.gu, ', ', h.sido, ', ', h.country)
           end as houseLocation,
       concat('호스트: ', u.firstName, '님') as houseHost,
       concat(h.buildingType, '의 ', h.houseType) as houseType,
       concat('인원 ', guestCnt, '명 · 침실 ', room, '개 · 침대 ', bed, '개 · 공동 사용 욕실', bathroom,'개') as houseSummary,
       case when h.checkInMethod is not null
           then concat('셀프 체크인\r\n',h.checkInMethod, '을 이용해 체크인하세요.')
           end as houseCheckIn,
       h.info as houseInfo,
       detail as houseDetail,
       concat('최소 숙박 가능일: ', h.stayMin) as minimumStay,
       h.checkIn as checkIn,
       h.checkOut as checkOut,
       h.pricePerNight as pricePerNight
FROM house h
left outer join user u on h.userNo = u.no
WHERE h.no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function houseFacilities($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT hf.no as facilitiseNo,
       f.name as facilitisename,
       f.content as facilitiseinfo,
       f.tag as facilitisekinds
FROM houseFacilities hf
left outer join (
    SELECT no, name, content, tag
    FROM facilities f
           ) f on f.no = hf.facilitiesNo
WHERE hf.houseNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseRoom($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no as roomNo,
       concat(name,'\r\n',beds) as bedType
FROM room WHERE houseNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseEvaluation($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT h.no as houseNo,
       case when total.staravg is null
           then 0
           else total.staravg
           end as starAvg,
       case when total.reviewcnt is null
           then 0
           else concat(total.reviewcnt, '개')
           end as reviewCnt,
       case when checkin.staravg is null
           then 0
           else checkin.staravg
           end as starCheckin,
       case when com.staravg is null
           then 0
           else com.staravg
           end as starCommunication,
       case when accuracy.staravg is null
           then 0
           else accuracy.staravg
           end as starAccuracy,
       case when location.staravg is null
           then 0
           else location.staravg
           end as starLocation,
       case when clean.staravg is null
           then 0
           else clean.staravg
           end as starClean,
       case when val.staravg is null
           then 0
           else val.staravg
           end as starValue
    FROM house h
    left outer join (
    SELECT rv.houseNo, count(*) as reviewcnt, ROUND(avg(star), 2) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    group by rv.houseNo
           ) total on  h.no =  total.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '체크인'
    group by rv.houseNo
           ) checkin on  h.no =  checkin.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '의사소통'
    group by rv.houseNo
           ) com on  h.no =  com.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '정확성'
    group by rv.houseNo
           ) accuracy on  h.no =  accuracy.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '위치'
    group by rv.houseNo
           ) location on  h.no =  location.houseNo

    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '청결도'
    group by rv.houseNo
           ) clean on  h.no =  clean.houseNo

    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '가치'
    group by rv.houseNo
           ) val on  h.no =  val.houseNo
    where h.no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

//function houseReview($houseNo, $pageNo)
//{
//    $pdo = pdoSqlConnect();
//    $query = "SELECT r.no,
//       rv.userNo as guestNo,
//       u.image as guestimg,
//       u.lastName as guestname,
//       concat(DATE_FORMAT(r.createdAt, '%Y'), '년', ' ', DATE_FORMAT(r.createdAt, '%m'), '월') as date,
//       r.content as reviewcontent,
//       h.userNo as hostNo,
//       case when r.reply is null
//           then null
//           else host.image
//           end as hostimg,
//       case when r.reply is null
//           then null
//           else concat(host.lastName, '님의 답변:')
//           end as hostname,
//       case when r.reply is null
//           then null
//           else r.reply
//           end as hostreply,
//       case when r.reply is null
//           then null
//           else concat(DATE_FORMAT(r.replycreatedAt, '%Y'), '년', ' ', DATE_FORMAT(r.replycreatedAt, '%m'), '월')
//           end as replydate
//
//
//    FROM houseReview r
//    left outer join houseRv rv on r.houseRvNo = rv.no
//    left outer join house h on rv.houseNo = h.no
//    left outer join user u on rv.userNo = u.no
//    left outer join (
//    SELECT DISTINCT u.no, u.image, u.lastName
//    FROM house h
//    left outer join user u on h.userNo = u.no
//           ) host on  h.userNo =  host.no
//    where h.no = :houseNo
//    order by r.createdAt LIMIT :startedAt,:size;";
//
//    $posts_num = 7;
//
//    // 전체 리뷰 수 구하기
//    $sql = "SELECT count(*) as reviewcnt
//    FROM houseReview r
//    left outer join houseRv rv on r.houseRvNo = rv.no
//    left outer join house h on rv.houseNo = h.no
//    where h.no = ?";
//    $result = $pdo->prepare($sql);
//    $result->execute([$houseNo]);
//    $number_of_rows = $result->fetchColumn();
//    $page_seq = $pageNo;
//    if($pageNo == 1){
//        $page_start = 0;
//    } else {
//        $page_start = $posts_num * $page_seq;
//    }
//
//    //LIMIT 에 변수가 안들어가서 설정
//    $pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
//
//    $st = $pdo->prepare($query);
//    $st -> bindParam(":houseNo", $houseNo);
//    $st -> bindParam(":startedAt", $page_start);
//    $st -> bindParam(":size", $posts_num);
//    $st -> execute();
//    //    $st->execute();
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st = null;
//    $pdo = null;
//
//    return $res;
//}
//
//function totalPage($houseNo)
//{
//    $pdo = pdoSqlConnect();
//    $query = "SELECT count(*) as reviewcnt
//    FROM houseReview r
//    left outer join houseRv rv on r.houseRvNo = rv.no
//    left outer join house h on rv.houseNo = h.no
//    where h.no = ?";
//
//    $posts_num = 7;
//
//
//    $st = $pdo->prepare($query);
//    $st -> execute([$houseNo]);
//    $number_of_rows = $st->fetchColumn();
//    $total_page_num = ceil($number_of_rows/$posts_num);
//    //    $st->execute();
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st = null;
//    $pdo = null;
//
//    return $total_page_num;
//}

function houseReview($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT r.no,
       rv.userNo as guestNo,
       u.image as guestImg,
       u.firstName as guestName,
       concat(DATE_FORMAT(r.createdAt, '%Y'), '년', ' ', DATE_FORMAT(r.createdAt, '%m'), '월') as date,
       r.content as reviewContent,
       h.userNo as hostNo,
       case when r.reply is not null
           then concat('호스트의 응답\r\n', r.reply)
           end as hostReply


    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    left outer join user u on rv.userNo = u.no
    where h.no = ?
    order by r.createdAt;";

    $st = $pdo->prepare($query);
    $st -> execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//function totalPage($houseNo)
//{
//    $pdo = pdoSqlConnect();
//    $query = "SELECT count(*) as reviewcnt
//    FROM houseReview r
//    left outer join houseRv rv on r.houseRvNo = rv.no
//    left outer join house h on rv.houseNo = h.no
//    where h.no = ?";
//
//    $posts_num = 7;
//
//
//    $st = $pdo->prepare($query);
//    $st -> execute([$houseNo]);
//    $number_of_rows = $st->fetchColumn();
//    $total_page_num = ceil($number_of_rows/$posts_num);
//    //    $st->execute();
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st = null;
//    $pdo = null;
//
//    return $total_page_num;
//}

//function houseHost($houseNo)
//{
//    $pdo = pdoSqlConnect();
//    $query = "SELECT u.no as hostNo,
//       u.image as hostImage,
//       u.lastName as hostName,
//       u.location as hostLocation,
//       concat(DATE_FORMAT(u.createdAt, '%Y'), '년', ' ', DATE_FORMAT(u.createdAt, '%m'), '월') as hostSingup,
//       case when hosthouse.totalreview is null
//           then concat(0, '개')
//           else concat('후기 ' , FORMAT( hosthouse.totalreview, 0 ), '개')
//           end as totalReview,
//       u.info as hostInfo,
//       h.contact as hostContact,
//       u.language as language
//FROM house h
//left outer join user u on h.userNo = u.no
//left outer join (SELECT h.userNo, COUNT(r.no) as totalreview
//FROM house h
//left outer join houseRv hr on h.no = hr.houseNo
//left outer join houseReview r on hr.no = r.houseRvNo
//GROUP BY h.userNo
//    ) hosthouse on u.no = hosthouse.userNo
//WHERE h.no = ?;";
//
//    $st = $pdo->prepare($query);
//    $st->execute([$houseNo]);
//    //    $st->execute();
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st = null;
//    $pdo = null;
//
//    return $res[0];
//}

function houseLocation($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT case when h.dong is null
           then concat(u.firstName, '님의 숙소는 ', h.gu, ',', h.sido, ',', h.country, '에 있습니다.')
           else concat(u.firstName, '님의 숙소는 ', h.dong, ',',  h.gu, ',', h.sido, ',', h.country, '에 있습니다.')
           end as location,
       h.circumstance,
       h.transportation,
       h.longitude,
       h.latitude
FROM house h
left outer join user u on h.userNo = u.no
WHERE h.no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function houseNotice($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no as noticeNo,
       content as noticeContent,
       case when detail is null
           then ''
           else detail
           end as noticeDetail,
       tag as noticeTag
FROM rule 
WHERE houseNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseSurcharge($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT hs.no as surchargeNo,
       s.name as surchargeName,
       case when hs.detail is null
           then concat('₩', format(hs.price, 0))
           else concat('₩', format(hs.price, 0), ' ', hs.detail)
           end as surchargeDetail
FROM houseSurcharge hs
left outer join surcharge s on hs.surchargeNo = s.no
WHERE hs.houseNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//function experienceImage($experienceNo)
//{
//    $pdo = pdoSqlConnect();
//    $query = "SELECT no as imageNo,
//       image as imageUrl,
//       case when content is null
//           then ''
//           else content
//           end as imageContent,
//       sequenceNo
//FROM image WHERE experienceNo = ?
//order by sequenceNo;";
//
//    $st = $pdo->prepare($query);
//    $st->execute([$experienceNo]);
//    //    $st->execute();
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st = null;
//    $pdo = null;
//
//    return $res;
//}

function experienceSearch($userNo, $search, $guest, $priceMin, $priceMax, $time, $language)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT DISTINCT e.no as experienceNo,
       i.image as repImage,
       c.title as categoryName,
       e.title as experienceTitle,
       concat('1인당 ₩', format(e.pricePerGuest, 0), '부터') as experiencePrice,
       case when total.staravg is null
           then 0
           else total.staravg
           end as starAvg,
       case when total.reviewcnt is null
           then (0)
           else total.reviewCnt
           end as reviewcnt,
       concat(e.playtime, '시간 · ', offer.offeritems, ' 포함') as experienceInfo,
       case when EXISTS(SELECT no FROM saveList WHERE userNo = ? && experienceNo = e.no)
           then 1
           else 0
           end as isSave
FROM experience e
    left outer join image i on e.no = i.experienceNo
    left outer join category c on e.categoryNo = c.no
    left outer join (
    SELECT rv.experienceNo, count(*) as reviewcnt, ROUND(avg(star), 2) as staravg
    FROM experienceReview r
    left outer join experienceRv rv on r.experienceRvNo = rv.no
    left outer join experience e on rv.experienceNo = e.no
    group by rv.experienceNo
           ) total on  e.no =  total.experienceNo
    left outer join (
    SELECT experienceNo, group_concat(tag SEPARATOR ', ') as offeritems
    FROM offeritem
    group by experienceNo
           ) offer on  e.no =  offer.experienceNo
WHERE sequenceNo = 1 && tag = 'host'
  AND e.sido REGEXP concat('^', ?)
  AND e.groupMax >= ?
  AND case when ? = 0 && ? = 0
           then e.pricePerGuest >= 0
           when ? >= 0 && ? > 0
           then e.pricePerGuest between ? and ?
           end
  AND case when ? = 0
           then e.start >= '00:00:00'
           when ? = 1
           then e.start < '12:00:00'
           when ? = 2
           then e.start >= '12:00:00'
           when ? = 3
           then e.start >= '00:00:00'
           when ? = 4
           then e.start >= '17:00:00'
           when ? = 5
           then e.start < '12:00:00' || e.start >= '17:00:00'
           when ? = 6
           then e.start >= '12:00:00'
           when ? = 7
           then e.start >= '00:00:00'
           end
  AND e.language REGEXP concat('^', ?);";
    $st = $pdo->prepare($query);
    $st->execute([$userNo, $search, $guest, $priceMin, $priceMax, $priceMin, $priceMax, $priceMin, $priceMax, $time, $time, $time, $time, $time, $time, $time, $time, $language]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function experienceImage($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT group_concat(image) as imageUrl
FROM image WHERE experienceNo = ? && tag = 'host'
group by experienceNo;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function experienceInfo($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT e.no as experienceNo,
       e.title as title,
       concat(review.staravg, ' (', review.reviewcnt, ')') as evaluation,
       concat(e.sido, ', ', e.country) as juso,
       c.title as category,
       concat(e.playtime, '시간') as playtime,
       concat('최대 ', e.groupMax, '명') as personnel,
       offer.offeritems as inclusion,
       e.language as offerLanguage,
       e.info as program,
       u.image as hostImage,
       u.firstName as hostName,
       e.introduce as hostIntroduce,
       e.prerequisite as guestprerequistie
FROM experience e
left outer join user u on e.userNo = u.no
left outer join category c on e.categoryNo = c.no
left outer join (
    SELECT experienceNo, group_concat(tag SEPARATOR ', ') as offeritems
    FROM offeritem
    group by experienceNo
           ) offer on  e.no =  offer.experienceNo
left outer join (
    SELECT count(*) as reviewcnt, ROUND(avg(r.star), 2) as staravg
    FROM experienceReview r
    left outer join experienceRv rv on r.experienceRvNo = rv.no
    left outer join experience e on rv.experienceNo = e.no
    group by rv.experienceNo
           ) review on  e.no =  offer.experienceNo
WHERE e.no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function experienceOffer($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no as offeritemNo,
       items,
       tag
FROM offeritem
WHERE experienceNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function experienceLocation($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT sido,
       locationInfo as info,
       longitude,
       latitude
FROM experience
WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function experienceReview($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT r.no,
       rv.userNo as guestNo,
       u.image as guestImg,
       u.firstName as guestName,
       concat(DATE_FORMAT(r.createdAt, '%Y'), '년', ' ', DATE_FORMAT(r.createdAt, '%m'), '월') as date,
       r.star as reviewStar,
       r.content as reviewContent,
       case when r.reply is not null
           then concat('호스트의 응답\r\n', r.reply)
           end as hostReply


    FROM experienceReview r
    left outer join experienceRv rv on r.experienceRvNo = rv.no
    left outer join experience e on rv.experienceNo = e.no
    left outer join user u on rv.userNo = u.no
    left outer join (
    SELECT DISTINCT u.no, u.image, u.firstName
    FROM experience e
    left outer join user u on e.userNo = u.no
           ) host on  e.userNo =  host.no
    where e.no = ?
    order by r.createdAt;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function experienceEvaluation($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT e.no as experienceNo,
       case when total.staravg is null
           then 0
           else total.staravg
           end as starAvg,
       case when total.reviewcnt is null
           then (0)
           else total.reviewcnt
           end as reviewCnt
    FROM experience e
    left outer join (
    SELECT rv.experienceNo, count(*) as reviewcnt, ROUND(avg(star), 2) as staravg
    FROM experienceReview r
    left outer join experienceRv rv on r.experienceRvNo = rv.no
    left outer join experience e on rv.experienceNo = e.no
    group by rv.experienceNo
           ) total on  e.no =  total.experienceNo
    where e.no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseCalendar($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT checkIn,
       checkOut
FROM houseRv
WHERE houseNo = ? && status = 1
order by checkIn;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseReservation($userNo, $houseNo, $checkIn, $checkOut, $guestCnt, $totalPrice)
{
    $pdo = pdoSqlConnect();

    $query = "INSERT INTO houseRv (no, userNo, houseNo, checkIn, checkOut, guestCnt, totalPrice, createdAt) VALUES (null, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP);";
    $st = $pdo->prepare($query);
    $st->execute([$userNo, $houseNo, $checkIn, $checkOut, $guestCnt, $totalPrice]);

    $st = null;
    $pdo = null;
}

function notAvailableExperience($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT date
    FROM experienceRv eR
left outer join experience e on eR.experienceNo = e.no
WHERE experienceNo = ? && status = 1
group by date, groupMax
having SUM(guestCnt) = groupMax;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function availableExperience($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT SUM(guestCnt) as totalGuestCnt, date, e.groupMax
    FROM experienceRv eR
left outer join experience e on eR.experienceNo = e.no
WHERE experienceNo = ? && status = 1
group by date, groupMax
having totalGuestCnt < groupMax;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function experienceGuestCnt($experienceNo, $date)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT SUM(guestCnt) as totalGuestCnt, groupMax
    FROM experienceRv eR
left outer join experience e on eR.experienceNo = e.no
WHERE experienceNo = ? && date = ?
group by date;";

    $st = $pdo->prepare($query);
    $st->execute([$experienceNo, $date]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function experienceReservation($userNo, $experienceNo, $date, $guestCnt, $totalPrice, $guest)
{
    $pdo = pdoSqlConnect();

    try{

        $pdo->beginTransaction();

        $query = "INSERT INTO experienceRv (no, userNo, experienceNo, date, guestCnt, totalPrice, createdAt) VALUES (null, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP);";
        $st = $pdo->prepare($query);
        $st->execute([$userNo, $experienceNo, $date, $guestCnt, $totalPrice]);
        $last_id = $pdo->lastInsertId();


        for ($i = 0; $i < count($guest); $i++) {
            $query = "INSERT INTO experienceGuest (no, experienceRvNo, lastName, firstName, email, createdAt) VALUES (null, ?, ?, ?, ?, CURRENT_TIMESTAMP);";
            $st = $pdo->prepare($query);
            $st->execute([$last_id, $guest[$i]->lastName, $guest[$i]->firstName, $guest[$i]->email]);
        }

        $pdo->commit();

    }
//Our catch block will handle any exceptions that are thrown.
    catch(Exception $e){
        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        //echo $e->getMessage();
        //Rollback the transaction.
        $pdo->rollBack();
    }
}

function reservationList($userNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT eR.no as reservationNo,
       e.no as no,
       '체험' as category,
       u.image as hostImage,
       e.sido as location,
       e.title as name,
       eR.guestCnt as guestCnt,
       image.imageUrl,
       concat(DATE_FORMAT(eR.date, '%Y'), '년 ', DATE_FORMAT(eR.date, '%c'), '월 ', DATE_FORMAT(eR.date, '%e'), '일')
           as date,
       eR.createdAt
FROM experienceRv eR
left outer join experience e on eR.experienceNo = e.no
left outer join user u on e.userNo = u.no
left outer join (SELECT experienceNo, SUBSTRING_INDEX(group_concat(image), ',', 1) as imageUrl
FROM image
group by experienceNo) image on e.no = image.experienceNo
WHERE eR.userNo =? && eR.status =1
UNION ALL
SELECT hR.no as reservationNo,
       h.no as no,
       '숙소' as category,
       u.image as hostImage,
       concat(h.sido, ' ', h.gu) as location,
       h.name as name ,
       hR.guestCnt as guestCnt,
       image.imageUrl,
       concat(DATE_FORMAT(hR.checkIn, '%Y'), '년 ', DATE_FORMAT(hR.checkIn, '%c'), '월 ', DATE_FORMAT(hR.checkIn, '%e'), '일', ' ~ ',
           DATE_FORMAT(hR.checkOut, '%Y'), '년 ', DATE_FORMAT(hR.checkOut, '%c'), '월 ', DATE_FORMAT(hR.checkOut, '%e'), '일')
           as date,
       hR.createdAt
FROM houseRv hR
left outer join house h on hR.houseNo = h.no
left outer join user u on h.userNo = u.no
left outer join (SELECT houseNo, SUBSTRING_INDEX(group_concat(image), ',', 1) as imageUrl
FROM image
group by houseNo) image on h.no = image.houseNo
WHERE hR.userNo =? && hR.status =1
ORDER BY createdAt";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $userNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function pastReservationList($userNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT eR.no as reservationNo,
       e.no as no,
       '체험' as category,
       u.image as hostImage,
       e.sido as location,
       e.title as name,
       eR.guestCnt as guestCnt,
       image.imageUrl,
       concat(DATE_FORMAT(eR.date, '%Y'), '년 ', DATE_FORMAT(eR.date, '%c'), '월 ', DATE_FORMAT(eR.date, '%e'), '일')
           as date,
       eR.createdAt
FROM experienceRv eR
left outer join experience e on eR.experienceNo = e.no
left outer join user u on e.userNo = u.no
left outer join (SELECT experienceNo, SUBSTRING_INDEX(group_concat(image), ',', 1) as imageUrl
FROM image
group by experienceNo) image on e.no = image.experienceNo
WHERE eR.userNo =? && eR.status =2
UNION ALL
SELECT hR.no as reservationNo,
       h.no as no,
       '숙소' as category,
       u.image as hostImage,
       concat(h.sido, ' ', h.gu) as location,
       h.name as name ,
       hR.guestCnt as guestCnt,
       image.imageUrl,
       concat(DATE_FORMAT(hR.checkIn, '%Y'), '년 ', DATE_FORMAT(hR.checkIn, '%c'), '월 ', DATE_FORMAT(hR.checkIn, '%e'), '일', ' ~ ',
           DATE_FORMAT(hR.checkOut, '%Y'), '년 ', DATE_FORMAT(hR.checkOut, '%c'), '월 ', DATE_FORMAT(hR.checkOut, '%e'), '일')
           as date,
       hR.createdAt
FROM houseRv hR
left outer join house h on hR.houseNo = h.no
left outer join user u on h.userNo = u.no
left outer join (SELECT houseNo, SUBSTRING_INDEX(group_concat(image), ',', 1) as imageUrl
FROM image
group by houseNo) image on h.no = image.houseNo
WHERE hR.userNo =? && hR.status =2
ORDER BY createdAt";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $userNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseList($search)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT GROUP_CONCAT(DISTINCT sido) AS existLocation 
FROM house 
WHERE sido REGEXP concat('^', ?);";

    $st = $pdo->prepare($query);
    $st->execute([$search]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function experienceList($search)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT GROUP_CONCAT(DISTINCT sido) AS existLocation
FROM experience
WHERE sido REGEXP concat('^',?);";

    $st = $pdo->prepare($query);
    $st->execute([$search]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}


function createSaveList($userNo, $houseNo, $experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO saveList (no, userNo, houseNo, experienceNo, createdAt) VALUES (null, ?, ?, ?, CURRENT_TIMESTAMP);";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $houseNo, $experienceNo]);

    $st = null;
    $pdo = null;
}


function selectSaveList($userNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT case when e.sido is not null
           then concat(e.sido, ' 체험')
           when h.sido is not null
           then concat(h.sido, ' 숙소')
           end as saveLocation,
       count(*) as saveCnt
FROM saveList s
left outer join experience e on e.no = s.experienceNo
left outer join house h on h.no = s.houseNo
WHERE s.userNo = ?
group by saveLocation;";

    $st = $pdo->prepare($query);
    $st->execute([$userNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}


function houseSaveList($userNo, $location)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT DISTINCT h.no as houseNo,
       case when houseType = '개인실'
           then concat(h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '객실'
           then concat(h.buildingType, ' ', h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '다인실'
           then concat(h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '전체'
           then concat(h.buildingType, ' ', h.houseType, ' · 침대 ', h.bed, '개')
           end as houseInfo,
       case when review.staravg is null
           then 0
           else review.staravg
           end as starAvg,
       case when review.reviewCnt is null
           then 0
           else review.reviewCnt
           end as reviewCnt,
       h.name as houseName,
            concat('₩', h.pricePerNight, '/박') as housePrice,
            image.images as images,
       case when EXISTS(SELECT no FROM saveList WHERE userNo = ? && houseNo = h.no)
           then 1
           else 0
           end as isSave
FROM house h
left outer join (
    SELECT i.houseNo,group_concat(i.image SEPARATOR ',') as images

    FROM image i
    left outer join house h on i.houseNo = h.no
    group by houseNo

    ) image on h.no = image.houseNo
left outer join houseFacilities hf on h.no = hf.houseNo
left outer join facilities f on hf.facilitiesNo = f.no
left outer join (SELECT r.houseNo, r.content
    FROM house h
    left outer join rule r on h.no = r.houseNo
    ) rule on rule.houseNo = h.no
left outer join (
    SELECT u.no, u.image, u.firstName, u.language
    FROM user u
           ) host on  h.userNo =  host.no
left outer join (
    SELECT rv.houseNo, count(*) as reviewCnt, ROUND(avg(r.star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    group by rv.houseNo
           ) review on  h.no =  review.houseNo
WHERE h.sido REGEXP concat('^', ?)
  AND EXISTS(SELECT no FROM saveList WHERE userNo = ? && houseNo = h.no);";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $location, $userNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}


function experienceSaveList($userNo, $location)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT e.no as experienceNo,
       i.image as repImage,
       c.title as categoryName,
       e.title as experienceTitle,
       concat('1인당 ₩', format(e.pricePerGuest, 0), '부터') as experiencePrice,
       case when total.staravg is null
           then 0
           else total.staravg
           end as starAvg,
       case when total.reviewcnt is null
           then (0)
           else total.reviewCnt
           end as reviewcnt,
       concat(e.playtime, '시간 · ', offer.offeritems, ' 포함') as experienceInfo,
       case when EXISTS(SELECT no FROM saveList WHERE userNo = ? && experienceNo = e.no)
           then 1
           else 0
           end as isSave
FROM experience e
    left outer join image i on e.no = i.experienceNo
    left outer join category c on e.categoryNo = c.no
    left outer join (
    SELECT rv.experienceNo, count(*) as reviewcnt, ROUND(avg(star), 2) as staravg
    FROM experienceReview r
    left outer join experienceRv rv on r.experienceRvNo = rv.no
    left outer join experience e on rv.experienceNo = e.no
    group by rv.experienceNo
           ) total on  e.no =  total.experienceNo
    left outer join (
    SELECT experienceNo, group_concat(tag SEPARATOR ', ') as offeritems
    FROM offeritem
    group by experienceNo
           ) offer on  e.no =  offer.experienceNo
WHERE sequenceNo = 1
  AND e.sido REGEXP concat('^', ?)
  AND EXISTS(SELECT no FROM saveList WHERE userNo = ? && experienceNo = e.no);";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $location, $userNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}


function allSaveList($userNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT DISTINCT h.no as houseNo,
       case when houseType = '개인실'
           then concat(h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '객실'
           then concat(h.buildingType, ' ', h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '다인실'
           then concat(h.houseType, ' · 침대 ', h.bed, '개')
           when houseType = '전체'
           then concat(h.buildingType, ' ', h.houseType, ' · 침대 ', h.bed, '개')
           end as houseInfo,
       case when review.staravg is null
           then 0
           else review.staravg
           end as starAvg,
       case when review.reviewCnt is null
           then 0
           else review.reviewCnt
           end as reviewCnt,
       h.name as houseName,
            concat('₩', h.pricePerNight, '/박') as housePrice,
            image.images as images,
       case when EXISTS(SELECT no FROM saveList WHERE userNo = ? && houseNo = h.no)
           then 1
           else 0
           end as isSave
FROM house h
left outer join (
    SELECT i.houseNo,group_concat(i.image SEPARATOR ',') as images

    FROM image i
    left outer join house h on i.houseNo = h.no
    group by houseNo

    ) image on h.no = image.houseNo
left outer join houseFacilities hf on h.no = hf.houseNo
left outer join facilities f on hf.facilitiesNo = f.no
left outer join (SELECT r.houseNo, r.content
    FROM house h
    left outer join rule r on h.no = r.houseNo
    ) rule on rule.houseNo = h.no
left outer join (
    SELECT u.no, u.image, u.firstName, u.language
    FROM user u
           ) host on  h.userNo =  host.no
left outer join (
    SELECT rv.houseNo, count(*) as reviewCnt, ROUND(avg(r.star), 1) as staravg
    FROM houseReview r
    left outer join houseRv rv on r.houseRvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    group by rv.houseNo
           ) review on  h.no =  review.houseNo
WHERE h.sido REGEXP concat('^')
  AND EXISTS(SELECT no FROM saveList WHERE userNo = ? && houseNo = h.no);";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $userNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}



function deleteSaveList($userNo, $houseNo, $experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "DELETE FROM saveList WHERE userNo = ? && houseNo = ? || experienceNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userNo, $houseNo, $experienceNo]);

    $st = null;
    $pdo = null;
}

function createHouseReview($reservationNo, $content, $goodpoint, $star)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO houseReview (no, houseRvNo, content, goodpoint, star, createdAt) VALUES (null, ?, ?, ?, ?, CURRENT_TIMESTAMP);";

    $st = $pdo->prepare($query);
    $st->execute([$reservationNo, $content, $goodpoint, $star]);

    $st = null;
    $pdo = null;

}

function createExperienceReview($reservationNo, $content, $star)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO experienceReview (no, experienceRvNo, content, star, createdAt) VALUES (null, ?, ?, ?, CURRENT_TIMESTAMP);";

    $st = $pdo->prepare($query);
    $st->execute([$reservationNo, $content, $star]);

    $st = null;
    $pdo = null;

}

function getFcmToken()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT fcmToken
FROM user
left outer join houseRv hR on user.no = hR.userNo
WHERE DATEDIFF(hR.checkIn,CURRENT_DATE) = 1;";

    $st = $pdo->prepare($query);
    $st->execute();
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function fcmSend($to){   //  Fcm Token 을 받아 알림 푸시
    $apiKey = 'AAAAcXRtS2c:APA91bE_tByQzJXaZ3vgpUh8TMAfywkJ9GrRTP2e-hMIj4uLq04WK_b_M5uRzY4jWkfOhi0GTH2S9tJhXRKAnyAQzThsiQWa-geX6hRJuuEIFwBoBoYs5cu0xzy8Xs9YGINqPmdU3LtE';

    $title = "예약 알림";
    $body = "숙소예약일까지 하루남았습니다. 예약된 숙소를 확인하세요!!";
    $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
    $arrayToSend = array('to' =>  $to, 'notification' => $notification, 'priority' => 'high');

    $json = json_encode($arrayToSend);
    $headers = array('Authorization: key='.$apiKey, 'Content-Type: application/json');

    $url = 'https://fcm.googleapis.com/fcm/send';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);

}

function reservationAlert(){   //  Fcm Token 을 받아 알림 푸시
    $fcmRes=json_decode(json_encode(getFcmToken()));
    $cnt = count(getFcmToken());
    for($i=0;$i<=$cnt;$i++){
        fcmSend($fcmRes[$i]->fcmToken);
    }

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
