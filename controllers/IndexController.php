<?php
require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "index":
            echo "airbnb-mock Server";
            break;
        case "ACCESS_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/access.log");
            break;
        case "ERROR_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/errors.log");
            break;
        /*
         * API No. 0
         * API Name : 테스트 API
         * 마지막 수정 날짜 : 19.04.29
         */


        case "userPage":
            //header('Content-Type: text/html; charset=UTF-8');
            http_response_code(200);
            if (mypage($vars["userNo"]) == null) {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "사용자가 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->result = mypage($vars["userNo"]);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

        /*
         * API No. 0
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */

        /*
         * API No. 1
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "userCreate":
            http_response_code(200);
            $isValidPw = isValidPw($req->pw);
            if (isValidLastname($req->last_name)) {
                if (isValidFirstname($req->first_name)) {
                    if (isValidBirthday($req->birthday)) {
                        if (isValidEmail($req->email)) {
                            if (!SearchUser($req->email)) {
                                if ($isValidPw[0] != FALSE) {
                                    $res->result = userCreate($req->phone, $req->last_name, $req->first_name, $req->gender, $req->birthday, $req->email, $req->pw);
                                    $res->isSuccess = TRUE;
                                    $res->code = 100;
                                    $res->message = "회원가입 성공";
                                    echo json_encode($res, JSON_NUMERIC_CHECK);
                                    break;
                                } else {
                                    $res->isSuccess = FALSE;
                                    $res->code = $isValidPw[1];
                                    $res->message = $isValidPw[2];
                                    echo json_encode($res, JSON_NUMERIC_CHECK);
                                    break;
                                }
                            } else {
                                $res->isSuccess = FALSE;
                                $res->code = 205;
                                $res->message = "이메일이 중복되었습니다.";
                                echo json_encode($res, JSON_NUMERIC_CHECK);
                                break;
                            }
                        } else {
                            $res->isSuccess = FALSE;
                            $res->code = 204;
                            $res->message = "올바른 이메일 양식이 아닙니다.";
                            echo json_encode($res, JSON_NUMERIC_CHECK);
                            break;
                        }
                    } else {
                        $res->isSuccess = FALSE;
                        $res->code = 203;
                        $res->message = "올바른 생일 양식이 아닙니다.";
                        echo json_encode($res, JSON_NUMERIC_CHECK);
                        break;
                    }
                } else {
                    $res->isSuccess = FALSE;
                    $res->code = 202;
                    $res->message = "최소 1자이상의 한글, 2자이상의 영어로된 성을 입력해주세요.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                }

            } else {
                $res->isSuccess = FALSE;
                $res->code = 201;
                $res->message = "최소 1자이상의 한글, 2자이상의 영어로된 이름을 입력해주세요.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }


    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
