<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * 쿠키 컨트롤러
 */
class Ex06Cookie extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        helper('cookie');
    }

    /**
     * 쿠키로 저장할 값을 입력받기 위한 View
     */
    public function index()
    {
        // 읽어온 쿠키를 View에 전달하기
        $data = array();
        $data['myCookie'] = get_cookie('hello_cookie'); // 저장되어 있는 쿠키값 읽어오기

        return default_layout('Modules\Pattern\Views\Ex06\index', $data);
    }

    /**
     * 입력값을 받아 쿠키로 저장한다.
     * - 값을 저장한 후 다시 처음의 index() 함수로 돌아간다.
     *
     * @param POST username
     * @return void
     */
    public function result()
    {
        $username = $this->request->getPost('username'); // 사용자의 입력값 받기

        if (!empty($username)) {
            /**
             * (1) 입력값이 있다면 쿠키 저장하기
             *
             * 쿠키 파라미터 설정 값 --> $name, $value, $expire, $domain, $path, $prefix, $secure, $httpOnly
             * `$domain`, `$path`가 생략될 경우 `App.php`의 설정값을 사용
             * `$expire`이 생략될 경우 브라우저 종료 시 자동 삭제 (여기서는 60초 동안만 유지)
             */
            set_cookie('hello_cookie', $username, 60);
        } else {
            /**
             * (2) 입력값이 없다면 쿠키 삭제하기
             *
             * - `$time`을 음수값으로 설정할 경우 쿠키 즉시 삭제함
             * ex) set_cookie('hello_cookie', false, -1);
             */
            delete_cookie('hello_cookie'); // 쿠키 헬퍼에 내장된 함수를 사용하여 쿠키 삭제
        }

        return redirect('mvc/cookie')->withCookies(); // URL 헬퍼에 내장된 함수를 사용하여 페이지 이동
    }
}