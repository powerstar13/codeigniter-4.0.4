<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * CI는 기본적으로 PHP의 모든 에러를 표시하지만, 개발이 완료된 후 이러한 에러 표시를 숨기고, 개발자가 정의한 에러 페이지를 표시하고자 할 경우에 사용하는 함수들이 제공된다.
 */
class Ex08ErrorHandlingController extends BaseController
{
    private $exception;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 에러 정보 표시하기
     *
     * @return void
     */
    public function error()
    {
        throw new \RuntimeException('개발자가 임의로 발생시킨 에러입니다.', 500);
    }

    /**
     * 404 에러 페이지를 확인하기 위한 메소드
     *
     * @return void
     */
    public function notFound()
    {
        throw new \CodeIgniter\Exceptions\PageNotFoundException(uri_string());
    }

    /**
     * 종류별 로그 기록하기
     *
     * @return void
     */
    public function log()
    {
        log_message('error', '에러 발생');
        log_message('debug', '디버그 확인');
        log_message('info', '정보 기록');
    }
}