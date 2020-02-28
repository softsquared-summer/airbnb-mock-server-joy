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

        /*
         * API No. 0
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */

        /*
         * API No. 3
         * API Name : 회원가입 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "userCreate":
            http_response_code(200);
            $isValidPw = isValidPw($req->pw);
            if (isValidFirstname($req->firstName)) {
                if (isValidLastname($req->lastName)) {
                    if (isValidBirthday($req->birthday)) {
                        if (isValidEmail($req->email)) {
                            if (!userExist($req->email)) {
                                if ($isValidPw[0] != FALSE) {
                                    $res->result = userCreate($req->phone, $req->firstName, $req->lastName, $req->birthday, $req->email, $req->pw);
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

        /*
        * API No. 4
        * API Name : 유저 상세 정보 조회 API
        * 마지막 수정 날짜 : 20.02.16
        */

        case "userSelect":
            //header('Content-Type: text/html; charset=UTF-8');
            http_response_code(200);
            if (userSelect($vars["userNo"]) == null) {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "사용자가 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->result = userSelect($vars["userNo"]);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }


        /*
         * API No. 5
         * API Name : 유저 상세 정보 수정 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "userUpdate":
            http_response_code(200);
            if (isValidFirstname($req->firstName)) {
                if (isValidLastname($req->lastName)) {
                    if (isValidBirthday($req->birthday)) {
                        if (isValidEmail($req->email)) {
                            if (!userExist($req->email)) {
                                if (isValidPhone($req->phone)) {
                                    $res->result = userUpdate($vars["userNo"], $req->phone, $req->firstName, $req->lastName, $req->gender, $req->birthday, $req->email);
                                    $res->isSuccess = TRUE;
                                    $res->code = 100;
                                    $res->message = "수정 성공";
                                    echo json_encode($res, JSON_NUMERIC_CHECK);
                                    break;
                                } else {
                                    $res->isSuccess = FALSE;
                                    $res->code = 205;
                                    $res->message = "다른 전화번호를 사용해주세요. 이 번호는 지원되지 않습니다.";
                                    echo json_encode($res, JSON_NUMERIC_CHECK);
                                    break;
                                }
                            } else {
                                $res->isSuccess = FALSE;
                                $res->code = 204;
                                $res->message = "이메일이 중복되었습니다.";
                                echo json_encode($res, JSON_NUMERIC_CHECK);
                                break;
                            }
                        } else {
                            $res->isSuccess = FALSE;
                            $res->code = 203;
                            $res->message = "올바른 이메일 양식이 아닙니다.";
                            echo json_encode($res, JSON_NUMERIC_CHECK);
                            break;
                        }
                    } else {
                        $res->isSuccess = FALSE;
                        $res->code = 202;
                        $res->message = "올바른 생일 양식이 아닙니다.";
                        echo json_encode($res, JSON_NUMERIC_CHECK);
                        break;
                    }
                } else {
                    $res->isSuccess = FALSE;
                    $res->code = 201;
                    $res->message = "최소 1자이상의 한글, 2자이상의 영어로된 성을 입력해주세요.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                }

            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "최소 1자이상의 한글, 2자이상의 영어로된 이름을 입력해주세요.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

        /*
         * API No. 6
         * API Name : 유저 프로필 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "profile":
            http_response_code(200);
            if (profile($vars["userNo"]) == null) {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "사용자가 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->result = profile($vars["userNo"]);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

        /*
         * API No. 7
         * API Name : 유저 프로필 수정 API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "profileUpdate":
            http_response_code(200);
            if (isValidLocation($req->location)) {
                if (isValidSchool($req->school)) {
                    if (isValidJob($req->job)) {
                        $res->result = profileUpdate($vars["userNo"], $req->image, $req->info, $req->location, $req->school, $req->job, $req->language);
                        $res->isSuccess = TRUE;
                        $res->code = 100;
                        $res->message = "수정 성공";
                        echo json_encode($res, JSON_NUMERIC_CHECK);
                        break;
                    } else {
                        $res->isSuccess = FALSE;
                        $res->code = 202;
                        $res->message = "직업은 한글, 영어만 입력할 수 있습니다.";
                        echo json_encode($res, JSON_NUMERIC_CHECK);
                        break;
                    }
                } else {
                    $res->isSuccess = FALSE;
                    $res->code = 201;
                    $res->message = "학교는 한글, 영어만 입력할 수 있습니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                }

            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "지역정보는 한글, 영어만 입력할 수 있습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

        /*
         * API No. 8
         * API Name : 숙소 정보 조회 / 필터 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "houseSearch":
            http_response_code(200);
            $userNo = $_GET["userNo"];
            $search = $_GET["search"];
            $guest = $_GET["guest"];
            $houseType = $_GET["houseType"];
            $bed = $_GET["bed"];
            $room = $_GET["room"];
            $bathroom = $_GET["bathroom"];
            $facilities = $_GET["facilities"];
            $buildingType = $_GET["buildingType"];
            $rule = $_GET["rule"];
            $location = $_GET["location"];
            $language = $_GET["language"];
            $houseSearch = houseSearch($userNo, $search, $guest, $houseType, $bed, $room, $bathroom, $facilities, $buildingType, $rule, $location, $language);
            if ($houseSearch) {
                $res->result = $houseSearch;
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "검색조건에 맞는 숙소가 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }

        /*
         * API No. 9
         * API Name : 숙소 상세 정보 조회 API
         * 마지막 수정 날짜 : 20.02.18
         */

        case "houseDetail":
            http_response_code(200);
            if (houseExist($vars["houseNo"])) {
                $res->result->image = houseImage($vars["houseNo"]);
                $res->result->info = houseInfo($vars["houseNo"]);
                $res->result->facility = houseFacilities($vars["houseNo"]);
                $res->result->room = houseRoom($vars["houseNo"]);
//            $res->result->host = houseHost($vars["houseNo"]);
                $res->result->location = houseLocation($vars["houseNo"]);
                $res->result->notice = houseNotice($vars["houseNo"]);
                $res->result->surcharge = houseSurcharge($vars["houseNo"]);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "숙소가 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }

        /*
         * API No. 10
         * API Name : 숙소 후기 정보 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "houseReview":
            http_response_code(200);
//            $page = $_GET["page"];
            $res->result->evaluation = houseEvaluation($vars["houseNo"]);
            $res->result->reviews = houseReview($vars["houseNo"]);

//            $res->result->reviews = houseReview($vars["houseNo"], $page);
//            $res->result->totalpage = totalPage($vars["houseNo"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
            break;

        /*
         * API No. 11
         * API Name : 체험 정보 조회 / 필터 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "experienceSearch":
            http_response_code(200);
            $userNo = $_GET["userNo"];
            $search = $_GET["search"];
            $guest = $_GET["guest"];
            $priceMin = $_GET["priceMin"];
            $priceMax = $_GET["priceMax"];
            $time = $_GET["time"];
            $language = $_GET["language"];
            $experienceSearch = experienceSearch($userNo, $search, $guest, $priceMin, $priceMax, $time, $language);
            if ($experienceSearch) {
                $res->result = $experienceSearch;
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "검색조건에 맞는 체험이 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }

        /*
         * API No. 12
         * API Name : 체험 상세 정보 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "experienceDetail":
            http_response_code(200);
            if (experienceExist($vars["experienceNo"])) {
                $res->result->image = experienceImage($vars["experienceNo"]);
                $res->result->info = experienceInfo($vars["experienceNo"]);
                $res->result->item = experienceOffer($vars["experienceNo"]);
                $res->result->location = experienceLocation($vars["experienceNo"]);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "조회 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "체험이 존재하지 않습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }

        /*
         * API No. 13
         * API Name : 체험 후기 정보 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "experienceReview":
            http_response_code(200);
            $res->result->evaluation = experienceEvaluation($vars["experienceNo"]);
            $res->result->reviews = experienceReview($vars["experienceNo"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
            break;
        /*
         * API No. 14
         * API Name : 숙소 예약 캘린더 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "houseCalendar":
            http_response_code(200);
            $rv = houseCalendar($vars["houseNo"]);
            $rv_list = array();
            for ($i = 0; $i < count($rv); $i++) {
                if (date_diff(array_values($rv[$i])[0], array_values($rv[$i])[1]) == 1) {
                    $rv_list += array_values($rv[$i])[0];
                } else {
                    $rv_list += dateGap(array_values($rv[$i])[0], date('Y-m-d', strtotime(array_values($rv[$i])[1] . ' -1 day')));
                }
            }
            $Nreservation = implode(',', $rv_list);
            $res->result = $Nreservation;
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
            break;

        /*
         * API No. 15
         * API Name : 체험 예약 캘린더 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */

        /*
         * API No. 16
         * API Name : 사용자 예약 목록 API
         * 마지막 수정 날짜 : 20.02.16
         */

        /*
         * API No. 17
         * API Name : 숙소 예약 API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "houseReservation":
            http_response_code(200);
            $rv = houseCalendar($vars["houseNo"]);
            $json = json_encode(houseHost($vars["houseNo"]));
            $host = json_decode($json);
            $host->hostNo;
            if($req->userNo != $host->hostNo){
                if(isValidDate($req->checkIn)) {
                    if(isValidDate($req->checkOut)){
                        if(isValidGuest($req->guestCnt)) {
                            $rv_list = array();
                            for ($i = 0; $i < count($rv); $i++) {
                                if (date_diff(array_values($rv[$i])[0], array_values($rv[$i])[1]) == 1) {
                                    $rv_list += array_values($rv[$i])[0];
                                } else {
                                    $rv_list += dateGap(array_values($rv[$i])[0], date('Y-m-d', strtotime(array_values($rv[$i])[1] . ' -1 day')));
                                }
                            }
                            $rv_date = dateGap($req->checkIn, date('Y-m-d', strtotime($req->checkOut . ' -1 day')));
                            if(array_intersect($rv_list, $rv_date)){
                                $res->isSuccess = FALSE;
                                $res->code = 200;
                                $res->message = "예약 불가능한 날짜 입니다.";
                                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                                break;
                            } else {
                                $res->result = houseReservation($req->userNo, $vars["houseNo"], $req->checkIn, $req->checkOut, $req->guestCnt, $req->totalPrice);
                                $res->isSuccess = TRUE;
                                $res->code = 100;
                                $res->message = "예약 성공";
                                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                                break;
                            }

                        } else {
                            $res->isSuccess = FALSE;
                            $res->code = 204;
                            $res->message = "게스트 수는 1명 이상이 필요합니다.";
                            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                            break;
                        }

                    } else {
                        $res->isSuccess = FALSE;
                        $res->code = 203;
                        $res->message = "체크아웃 날짜를 날짜 형식으로 입력해주세요.";
                        echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                        break;
                    }

                } else {
                    $res->isSuccess = FALSE;
                    $res->code = 202;
                    $res->message = "체크인 날짜를 날짜 형식으로 입력해주세요.";
                    echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                    break;
                }

            } else {
                $res->isSuccess = FALSE;
                $res->code = 201;
                $res->message = "호스트는 예약이 불가능합니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }

        /*
         * API No. 18
         * API Name : 체험 예약 API
         * 마지막 수정 날짜 : 20.02.16
         */

        /*
         * API No. 19
         * API Name : 유저 정보 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "user":
            //header('Content-Type: text/html; charset=UTF-8');
            http_response_code(200);
            $phone = $_GET["phone"];
            if (isValidPhone($phone)) {
                if (!phoneExist($phone)) {
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    $res->message = "회원가입 가능";
                    echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                    break;
                } else {
                    $res->isSuccess = TRUE;
                    $res->code = 101;
                    $res->message = "가입된 아이디가 존재합니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                }

            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "전화번호 양식에 맞게 다시 입력해주세요.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

        /*
         * API No. 20
         * API Name : 검색 목록 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "searchList":
            http_response_code(200);
            if ($category = $_GET["category"]) {
                switch ($category) {
                    case "house" :
                        $search = $_GET["search"];
                        $result = houseList($search);;
                        $json = json_encode($result);
                        $object = json_decode($json);
                        $results = explode( ',', $object->existLocation );
                        $res->result = $results;
                        $res->isSuccess = TRUE;
                        $res->code = 100;
                        $res->message = "조회 성공";
                        echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                        break;
                    case "experience" :
                        $search = $_GET["search"];
                        $result = experienceList($search);
                        $json = json_encode($result);
                        $object = json_decode($json);
                        $results = explode( ',', $object->existLocation );
                        $res->result = $results;
                        $res->isSuccess = TRUE;
                        $res->code = 100;
                        $res->message = "조회 성공";
                        echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                        break;
                }
            }
            break;
        /*
         * API No. 21
         * API Name : 저장 목록 추가 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "createSaveList":
            http_response_code(200);
            if($req->houseNo == null && $req->experienceNo == null) {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "숙소 번호나 체험 번호가 필요합니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else if ($req->houseNo != null && $req->experienceNo != null) {
                $res->isSuccess = FALSE;
                $res->code = 201;
                $res->message = "숙소 번호와 체험 번호중 하나만 입력해주세요.";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $res->result = createSaveList($vars["userNo"], $req->houseNo, $req->experienceNo);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "저장 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }


        /*
         * API No. 22
         * API Name : 저장 목록 조회 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "selectSaveList":
            http_response_code(200);
            if ($filter = $_GET["filter"]) {
                switch ($filter) {
                    case "simple" :
                        $res->result = selectSaveList($vars["userNo"]);
                        $res->isSuccess = TRUE;
                        $res->code = 100;
                        $res->message = "조회 성공";
                        echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                        break;

                    case "detail" :
                        $saveLocation = $_GET["saveLocation"];
                        $search = explode( ' ', $saveLocation );
                        if($search[1] == "숙소") {
                            $res->result = houseSaveList($vars["userNo"], $search[0]);
                            $res->isSuccess = TRUE;
                            $res->code = 100;
                            $res->message = "조회 성공";
                            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                            break;

                        } else if ($search[1] == '체험') {
                            $res->result = experienceSaveList($vars["userNo"], $search[0]);
                            $res->isSuccess = TRUE;
                            $res->code = 100;
                            $res->message = "조회 성공";
                            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                            break;
                        } else if ($saveLocation == '') {
                            $res->result = allSaveList($vars["userNo"], $search[0]);
                            $res->isSuccess = TRUE;
                            $res->code = 100;
                            $res->message = "조회 성공";
                            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                            break;
                        } else {
                            $res->isSuccess = FALSE;
                            $res->code = 200;
                            $res->message = "조회 실패";
                            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                            break;
                        }

                }
            } else {
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "조회 실패";
                echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
                break;
            }
            break;

        /*
         * API No. 23
         * API Name : 저장 목록 삭제 API
         * 마지막 수정 날짜 : 20.02.16
         */
        case "deleteSaveList":
            http_response_code(200);
            $houseNo = $_GET["houseNo"];
            $experienceNo = $_GET["experienceNo"];
            $res->result = deleteSaveList($vars["userNo"], $houseNo, $experienceNo);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "삭제 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
            break;

        /*
         * API No. 23
         * API Name : deleteSaveList API
         * 마지막 수정 날짜 : 20.02.16
         */

        case "fcm":
            http_response_code(200);
            $fcmRes=json_decode(json_encode(getFcmToken()));
            $cnt = count(getFcmToken());
            for($i=0;$i<=$cnt;$i++){
                $res->result = fcmSend($fcmRes[$i]->fcmToken);
            }
            //$res->result = fcmSend('cferhGt65vA:APA91bGtgP2D7gI4-Uzt6KYuVbet8vSbINUZl3ozdKrIR9ObFjw9JSV-cRqd44D7WOja--l_ki6Xs6m3mxgZEAMCjYSg4J3CE5Ozpl3Zrr2JSTtADpKA8lA6xy6BtJQAT25I_beUB3fY');
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
            break;

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
