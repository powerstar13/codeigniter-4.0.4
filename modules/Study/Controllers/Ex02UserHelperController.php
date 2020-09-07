<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

class Ex02UserHelperController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();

        /** hello_helper.php를 로드한다. */
        // 환경설정 데이터, 헬퍼, 라이브러리 등 로드하기
        // --> 초기화가 필요한 기능들의 load는 대부분 생성자에서 수행된다.
        helper(['hello', 'util']);
    }

    /**
     * 정의한 헬퍼 기능 확인하기
     * URL = /study/ex02
     *
     * @return void
     */
    public function index()
    {
        // 정의한 헬퍼 함수 호출
        say_eng();
        say_kor();
    }

    /**
     * 변수, 배열, 객체에 대한 debug() 함수 기능 확인하기
     * URI = /study/ex02/debugTest
     *
     * @return void
     */
    public function debugTest()
    {
        // 단일 값에 대한 테스트
        $msg = "Hello CodeIgniter";
        debug($msg);

        // 배열에 대한 테스트
        $data = array(
            'name' => '코드이그나이터',
            'version' => '4.0.4'
        );
        debug($data);

        // 객체에 대한 테스트
        $obj = (object) null;
        $obj->name = 'CodeIgniter';
        $obj->value = '4.0.4';
        debug($obj);
    }
}