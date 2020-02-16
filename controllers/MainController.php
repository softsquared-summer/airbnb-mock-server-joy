<?php
require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        /*
         * API No. 0
         * API Name : JWT 유효성 검사 테스트 API
         * 마지막 수정 날짜 : 19.04.25
         */
        case "validateJwt":
            // jwt 유효성 검사

            $jwt = $_SERVER["HTTP_X_ACCESS_TOKEN"];

            if (!isValidHeader($jwt, JWT_SECRET_KEY)) {
                $res->isSuccess = FALSE;
                $res->code = 201;
                $res->message = "유효하지 않은 토큰입니다";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                addErrorLogs($errorLogs, $res, $req);
                return;
            }

            $userInfo = getDataByJWToken($jwt, JWT_SECRET_KEY);
            $userNo = $userInfo->no;

            http_response_code(200);
            $res->result = $userNo;
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";

            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /*
         * API No. 1
         * API Name : JWT 생성 테스트 API (로그인)
         * 마지막 수정 날짜 : 19.04.25
         */
        case "createJwt":
            // jwt 유효성 검사
            http_response_code(200);
            $isValidPw = isValidPw($req->pw);

            if(isValidEmail($req->email)){
                if ($isValidPw[0] != FALSE) {
                    if(!isValidUser($req->email, $req->pw)){
                        $res->isSuccess = FALSE;
                        $res->code = 200;
                        $res->message = "유효하지 않은 아이디 입니다";
                        echo json_encode($res, JSON_NUMERIC_CHECK);
                        return;
                    } else {
                        //페이로드에 맞게 다시 설정 요함
                        $json = json_encode(User($req->email));
                        $no = json_decode($json);
                        $jwt = getJWToken($req->email, $req->pw, $no->no, JWT_SECRET_KEY);
                        $res->result->jwt = $jwt;
                        $res->isSuccess = TRUE;
                        $res->code = 100;
                        $res->message = "로그인 성공";
                        echo json_encode($res, JSON_NUMERIC_CHECK);
                        break;
                    }
                } else {
                    $res->isSuccess = FALSE;
                    $res->code = $isValidPw[1];
                    $res->message = $isValidPw[2];
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                }
            } else {
                $res->isSuccess = FALSE;
                $res->code = 201;
                $res->message = "올바른 이메일 주소를 입력해주세요.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
