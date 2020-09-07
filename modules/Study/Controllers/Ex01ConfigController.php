<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * 환경설정 관련 기능 확인
 *
 * 1. 컨트롤러 클래스 작성시 첫 글자`만` 반드시 대문자
 * 2. 컨트롤러 클래스 이름과 파일 이름은 반드시 일치
 * 3. 컨트롤러 클래스는 Controller 또는 Controller를 상속받은 BaseController 반드시 상속받아야 함
 */
class Ex01ConfigController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();
    }

    /**
     * 개별 설정정보 하나를 조회/수정하기
     * - 환경설정 데이터를 확인
     *
     * @return void
     */
    public function showItem()
    {
        $config = config(App::class);
        // 환경 설정 데이터에서 하나를 리턴
        $baseUrl = $config->baseURL;
        // 화면에 출력하기
        echo "<h1>수정 전: " . $baseUrl . "</h1>";

        // 환경 설정 데이터에서 하나를 수정하거나 새로 추가
        $config->baseURL = 'http://masterhong.com/';
        // 수정된 결과값 다시 조회하기
        $baseUrl = $config->baseURL;
        // 화면에 출력하기
        echo "<h1>수정 후: " . $baseUrl . "</h1>";
    }

    /**
     * 전체 환경설정 정보를 확인한다.
     *
     * @return void
     */
    public function showAll()
    {
        // 환경설정 데이터 전체 배열 가져오기
        $configData = config(App::class);

        // 배열을 출력하기 좋게 문자열로 변환하여 출력
        // `print_r()` 함수의 두 번째 파라미터가 `true`인 경우 결과를 리턴한다.
        $str = print_r($configData, TRUE);
        echo "<pre>{$str}</pre>";
    }

    /**
     * 개발자가 정의한 설정정볼르 추가로 로드하여 기본 설정 정보에 병합한다.
     *
     * - 개발자가 직접 추가한 환경설정 데이터 파일을 읽어온다.
     *
     * @return void
     */
    public function customAll()
    {
        // 환경설정 데이터 전체 배열 가져오기
        $configData = (array) config(App::class);
        // 커스텀 환경설정 파일 읽기 (경로를 포함한 파일명을 파라미터로 설정)
        $customData = (array) config('Modules\Study\Config\MyCI');
        // config data 병합
        $mergeConfigData = array_merge($configData, $customData);

        // 전체 데이터를 출력하여 결과를 확인한다.
        $str = print_r($mergeConfigData, TRUE);
        echo "<pre>{$str}</pre>";
    }

    /**
     * 추가 설정 정보들을 개별적으로 추출한다.
     *
     * @return void
     */
    public function customItem()
    {
        // 커스텀 환경설정 파일 읽기 (경로를 포함한 파일명을 파라미터로 설정)
        $customData = (array) config('Modules\Study\Config\MyCI');

        $myname = $customData['myname'];
        $version = $customData['version'];
        echo "<h1>{$myname}</h1>";
        echo "<h1>{$version}</h1>";

        $loadmap = $customData['loadmap'];
        $str = print_r($loadmap, TRUE);
        echo "<pre>{$str}</pre>";
    }
}