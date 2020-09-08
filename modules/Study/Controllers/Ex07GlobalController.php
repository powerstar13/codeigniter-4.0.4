<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

class Ex07GlobalController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();

        // helper 로드
        helper('util');
    }

    /**
     * 전역 상수의 값들을 출력
     * - 주로 디렉토리 관련 작업에 활용할 수 있는 경로 정보들임을 확인할 수 있다.
     *
     * @return void
     */
    public function vars()
    {
        debug(SYSTEMPATH, 'CI system 디렉토리 경로');
        debug(APPPATH, 'CI application 디렉토리 경로');
        debug(ROOTPATH, '프론트 컨트롤러의');
        debug(FCPATH, '프로그램 root경로(프론트 컨트롤러의 index.php 기준)');
        debug(WRITEPATH, 'CI writable 디렉토리 경로');
    }

    /**
     * 전역 함수의 기능 확인
     *
     * @return void
     */
    public function func()
    {
        // 현재 접속 프로토콜이 https인지 검사
        if (is_https()) {
            debug('HTTPS 보안 접속임', '보안접속');
        } else {
            debug('HTTPS 보안 접속 아님', '보안접속');
        }

        // 현재 서버의 PHP 버전이 특정 버전 이상인지 검사
        if (\version_compare(PHP_VERSION, '7.2') >= 0) {
            debug('PHP 7.2 이상 버전임', '버전체크');
        } else {
            debug('PHP 7.2 이상 버전이 아님', '버전체크');
        }

        // CLI(프롬프트환경)에서 실행중인지 검사
        if (is_cli()) {
            debug('CLI환경에서 실행중', '환경검사');
        } else {
            debug('CLI환경에서 실행중 아님', '환경검사');
        }

        // `/Config/App.php`에 설정되어 있는 값 가져오기
        debug(config(App::class)->baseURL, 'config');

        // htmlspecialchars() 함수의 단축 버전
        $input = '<div class="hello" id="world">안녕하세요. 반갑습니다.</div>';
        echo esc($input);
    }
}