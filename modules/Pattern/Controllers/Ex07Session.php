<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * 세션 컨트롤러
 */
class Ex07Session extends BaseController
{
    private $session;

    public function __construct()
    {
        parent::__construct();

        $this->session = session();
    }

    /**
     * 세션에 저장할 값을 입력받기 위한 View
     */
    public function index()
    {
        // 읽어온 세션을 View에 전달하기
        $data = array();
        $data['mySession'] = session('hello_session'); // 저장되어 있는 세션값 읽어오기

        return default_layout('Modules\Pattern\Views\Ex07\index', $data);
    }

    /**
     * 입력값을 받아 세션으로 저장한다.
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
             * (1) 입력값이 있다면 세션 저장하기
             *
             * 세션 파라미터 설정 값 --> $name, $value
             */
            $this->session->set('hello_session', $username);
        } else {
            /**
             * (2) 입력값이 없다면 현재 사용자에 대한 세션 삭제하기
             */
            $this->session->remove('hello_session');
        }

        return redirect('mvc/session'); // URL 헬퍼에 내장된 함수를 사용하여 페이지 이동
    }
}