<?php
require './pdos/DatabasePdo.php';
require './pdos/IndexPdo.php';
require './vendor/autoload.php';

use \Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

date_default_timezone_set('Asia/Seoul');
ini_set('default_charset', 'utf8mb4');

//에러출력하게 하는 코드
//error_reporting(E_ALL); ini_set("display_errors", 1);

//Main Server API
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    /* ******************   Test   ****************** */
    $r->addRoute('GET', '/', ['IndexController', 'index']);
    $r->addRoute('GET', '/test', ['IndexController', 'test']);
    $r->addRoute('GET', '/test/{testNo}', ['IndexController', 'testDetail']);
    $r->addRoute('POST', '/test', ['IndexController', 'testPost']);
    $r->addRoute('GET', '/jwt', ['MainController', 'validateJwt']);
    $r->addRoute('POST', '/jwt', ['MainController', 'createJwt']); // 로그인

    //------------------------------------------------------------------------------------------
    $r->addRoute('GET', '/users', ['IndexController', 'user']); // 사용자 정보 조회
    $r->addRoute('GET', '/users/{userNo}', ['IndexController', 'userSelect']); // 사용자 정보 상세 조회
    $r->addRoute('GET', '/users/{userNo}/profile', ['IndexController', 'profile']); // 사용자 프로필 조회
    $r->addRoute('POST', '/users', ['IndexController', 'userCreate']); // 사용자 추가
    $r->addRoute('PUT', '/users/{userNo}', ['IndexController', 'userUpdate']); // 사용자 정보 수정
    $r->addRoute('PUT', '/users/{userNo}/profile', ['IndexController', 'profileUpdate']); // 사용자 프로필 수정
    $r->addRoute('GET', '/houses', ['IndexController', 'houseSearch']); // 숙소 정보 조회 / 필터
    $r->addRoute('GET', '/houses/{houseNo}', ['IndexController', 'houseDetail']); // 숙소 상세 정보 조회
    $r->addRoute('GET', '/houses/{houseNo}/review', ['IndexController', 'houseReview']); // 숙소 후기 정보 조회
    $r->addRoute('GET', '/experiences', ['IndexController', 'experienceSearch']); // 체험 정보 조회
    $r->addRoute('GET', '/experiences/{experienceNo}', ['IndexController', 'experienceDetail']); // 체험 상세 정보 조회
    $r->addRoute('GET', '/experiences/{experienceNo}/review', ['IndexController', 'experienceReview']); // 체험 후기 정보 조회
    $r->addRoute('GET', '/houses/{houseNo}/calendar', ['IndexController', 'houseCalendar']); // 숙소 예약 캘린더 조회
    $r->addRoute('GET', '/experiences/{experienceNo}/calendar', ['IndexController', 'experienceCalendar']); // 숙소 예약 캘린더 조회
    $r->addRoute('GET', '/users/{userNo}/reservations', ['IndexController', 'reservationList']); // 사용자 예약 목록 조회
    $r->addRoute('POST', '/houses/{houseNo}/reservations', ['IndexController', 'houseReservation']); // 숙소 예약 추가
    $r->addRoute('POST', '/experiences/{experienceNo}/reservations', ['IndexController', 'experienceReservation']); // 체험 예약 추가
    $r->addRoute('GET', '/search', ['IndexController', 'searchList']); // 검색 가능 목록
    $r->addRoute('POST', '/users/{userNo}/saveList', ['IndexController', 'createSaveList']); // 저장 목록 추가
    $r->addRoute('GET', '/users/{userNo}/saveList', ['IndexController', 'selectSaveList']); // 저장 목록 조회
    $r->addRoute('DELETE', '/users/{userNo}/saveList', ['IndexController', 'deleteSaveList']); // 저장 목록 삭제
    $r->addRoute('POST', '/users/{userNo}/reservations/{reservationNo}/review', ['IndexController', 'createReview']); // 사용자 예약 리뷰 추가
    $r->addRoute('GET', '/fcm', ['IndexController', 'fcm']); // 예약 알람 fcm API


//    $r->addRoute('GET', '/users', 'get_all_users_handler');
//    // {id} must be a number (\d+)
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    // The /{title} suffix is optional
//    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// 로거 채널 생성
$accessLogs = new Logger('ACCESS_LOGS');
$errorLogs = new Logger('ERROR_LOGS');
// log/your.log 파일에 로그 생성. 로그 레벨은 Info
$accessLogs->pushHandler(new StreamHandler('logs/access.log', Logger::INFO));
$errorLogs->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));
// add records to the log
//$log->addInfo('Info log');
// Debug 는 Info 레벨보다 낮으므로 아래 로그는 출력되지 않음
//$log->addDebug('Debug log');
//$log->addError('Error log');

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        switch ($routeInfo[1][0]) {
            case 'IndexController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/IndexController.php';
                break;
            case 'MainController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/MainController.php';
                break;
            /*case 'EventController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/EventController.php';
                break;
            case 'ProductController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ProductController.php';
                break;
            case 'SearchController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/SearchController.php';
                break;
            case 'ReviewController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ReviewController.php';
                break;
            case 'ElementController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ElementController.php';
                break;
            case 'AskFAQController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/AskFAQController.php';
                break;*/
        }

        break;
}