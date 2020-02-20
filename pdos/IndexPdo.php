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
    $phone = $_str;

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

function houseImage($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no,
       image,
       title
FROM image WHERE houseNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function houseInfo($houseNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT h.name as houseTitle,
       u.image as hostImage,
       concat(gu, ', ', sido, ', ', country) as houseLocation,
       concat('호스트: ', u.last_name, '님') as houseHost,
       concat(h.building_type, '의 ', h.house_type) as houseType,
       concat('인원 ', guest_cnt, '명 · 침실 ', room, '개 · 침대 ', bed, '개 · 공동 사용 욕실', bathroom,'개') as houseIn,
       h.info as houseInfo,
       detail as houseDetail,
       h.stay_min as minimumStay,
       h.check_in as checkIn,
       h.check_out as checkOut
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

function houseFacilities($houseNo, $tag)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT hf.no,
       f.name as facilitisename,
       f.content as facilitiseinfo,
       f.tag as facilitisekinds
FROM house_facilities hf
left outer join (
    SELECT no, name, content, tag
    FROM facilities f
           ) f on f.no = hf.facilitiesNo
WHERE hf.houseNo = ? && f.tag like ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo, $tag]);
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
    $query = "SELECT no, name, beds FROM room WHERE houseNo = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$houseNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function FacilitiesTag()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT tag FROM facilities GROUP BY tag;";

    $st = $pdo->prepare($query);
    $st->execute([]);
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
           end as star_total,
       case when total.reviewcnt is null
           then 0
           else concat(total.reviewcnt, ' ', '후기')
           end as reviewcnt,
       case when checkin.staravg is null
           then 0
           else checkin.staravg
           end as star_checkin,
       case when com.staravg is null
           then 0
           else com.staravg
           end as star_communication,
       case when accuracy.staravg is null
           then 0
           else accuracy.staravg
           end as star_accuracy,
       case when location.staravg is null
           then 0
           else location.staravg
           end as star_location,
       case when clean.staravg is null
           then 0
           else clean.staravg
           end as star_clean,
       case when val.staravg is null
           then 0
           else val.staravg
           end as star_value
    FROM house h
    left outer join (
    SELECT rv.houseNo, count(*) as reviewcnt, ROUND(avg(star), 2) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    group by rv.houseNo
           ) total on  h.no =  total.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '체크인'
    group by rv.houseNo
           ) checkin on  h.no =  checkin.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '의사소통'
    group by rv.houseNo
           ) com on  h.no =  com.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '정확성'
    group by rv.houseNo
           ) accuracy on  h.no =  accuracy.houseNo
    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '위치'
    group by rv.houseNo
           ) location on  h.no =  location.houseNo

    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
    left outer join house h on rv.houseNo = h.no
    where r.goodpoint = '청결도'
    group by rv.houseNo
           ) clean on  h.no =  clean.houseNo

    left outer join (
    SELECT rv.houseNo, ROUND(avg(star), 1) as staravg
    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
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
//       u.last_name as guestname,
//       concat(DATE_FORMAT(r.createdAt, '%Y'), '년', ' ', DATE_FORMAT(r.createdAt, '%m'), '월') as date,
//       r.content as reviewcontent,
//       h.userNo as hostNo,
//       case when r.reply is null
//           then null
//           else host.image
//           end as hostimg,
//       case when r.reply is null
//           then null
//           else concat(host.last_name, '님의 답변:')
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
//    FROM house_review r
//    left outer join house_rv rv on r.house_rvNo = rv.no
//    left outer join house h on rv.houseNo = h.no
//    left outer join user u on rv.userNo = u.no
//    left outer join (
//    SELECT DISTINCT u.no, u.image, u.last_name
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
//    FROM house_review r
//    left outer join house_rv rv on r.house_rvNo = rv.no
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
//    FROM house_review r
//    left outer join house_rv rv on r.house_rvNo = rv.no
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
       u.image as guestimg,
       u.last_name as guestname,
       concat(DATE_FORMAT(r.createdAt, '%Y'), '년', ' ', DATE_FORMAT(r.createdAt, '%m'), '월') as date,
       r.content as reviewcontent,
       h.userNo as hostNo,
       case when r.reply is not null
           then concat('호스트의 응답\r\n', r.reply)
           end as hostreply


    FROM house_review r
    left outer join house_rv rv on r.house_rvNo = rv.no
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
//    FROM house_review r
//    left outer join house_rv rv on r.house_rvNo = rv.no
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
//       u.last_name as hostName,
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
//left outer join house_rv hr on h.no = hr.houseNo
//left outer join house_review r on hr.no = r.house_rvNo
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
    $query = "SELECT concat(u.last_name, '님의 숙소는 ', h.gu, ',', h.sido, ',', h.country, '에 있습니다.') as location,
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
       content,
       detail,
       tag
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
    $query = "SELECT s.name as surchargeName,
       case when s.detail is null
           then concat('₩', hs.price)
           else concat('₩', hs.price, ' ', s.detail)
           end as surchargeDetail
FROM house_surcharge hs
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

function experienceImage($experienceNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT no,
       image,
       title
FROM image WHERE experienceNo = ?;";

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
       concat('최대 ', e.group_max, '명') as personnel,
       offer.offeritems as inclusion,
       e.language as offerLanguage,
       e.info as program,
       u.image as hostImage,
       u.last_name as hostName,
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
    FROM experience_review r
    left outer join experience_rv rv on r.experience_rvNo = rv.no
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
       content,
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
       location_info as info,
       location as meetLocation,
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
       u.last_name as guestName,
       concat(DATE_FORMAT(r.createdAt, '%Y'), '년', ' ', DATE_FORMAT(r.createdAt, '%m'), '월') as date,
       r.star as reviewStar,
       r.content as reviewContent,
       case when r.reply is not null
           then concat('호스트의 응답\r\n', r.reply)
           end as hostReply


    FROM experience_review r
    left outer join experience_rv rv on r.experience_rvNo = rv.no
    left outer join experience e on rv.experienceNo = e.no
    left outer join user u on rv.userNo = u.no
    left outer join (
    SELECT DISTINCT u.no, u.image, u.last_name
    FROM house h
    left outer join user u on h.userNo = u.no
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
           else concat('(', total.reviewcnt, ')')
           end as reviewCnt
    FROM experience e
    left outer join (
    SELECT rv.experienceNo, count(*) as reviewcnt, ROUND(avg(star), 2) as staravg
    FROM experience_review r
    left outer join experience_rv rv on r.experience_rvNo = rv.no
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
