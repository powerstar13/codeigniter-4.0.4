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
        $sessionType = $this->request->getGet('type'); // 세션의 종류를 가져온다.

        // 읽어온 세션을 View에 전달하기
        $data = array();
        if (empty($sessionType) || $sessionType === 'default') {
            $data['mySession'] = session('hello_session'); // 저장되어 있는 세션값 읽어오기
        } else if (in_array($sessionType, array('flash', 'keep'))) {
            $data['mySession'] = $this->session->getFlashdata('hello_session'); // 페이지에 들어온 직후에는 세션데이터가 유효하지만, 페이지를 새로고침하게 되면 데이터가 자동으로 삭제된다.
            if ($sessionType === 'keep') {
                $this->session->keepFlashdata('hello_session'); // Flash 데이터의 파괴를 1회 유보하고 다음 페이지에서 삭제한다.
            }
        } else if ($sessionType === 'temp') {
            $data['mySession'] = $this->session->getTempdata('hello_session'); // 지정된 시간 동안에는 페이지를 여러 번 새로고침해도 데이터가 유효하지만, 지정된 시간 초과 후에는 데이터가 삭제된다.
        }

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
        $sessionType = $this->request->getPost('sessionType'); // 세션 종류 받기

        if (!empty($username)) {
            /**
             * (1) 입력값이 있다면 세션 저장하기
             *
             * 세션 파라미터 설정 값 --> $name, $value
             */
            if (empty($sessionType) || $sessionType === 'default') {
                $this->session->set('hello_session', $username);
            } else if (in_array($sessionType, array('flash', 'keep'))) {
                $this->session->setFlashdata('hello_session', $username); // 1회성 세션
            } else if ($sessionType === 'temp') {
                $this->session->setTempdata('hello_session', $username, 30); // 30초간 유지되는 시간제한 세션
            }
        } else {
            /**
             * (2) 입력값이 없다면 현재 사용자에 대한 세션 삭제하기
             */
            if (empty($sessionType) || $sessionType === 'default') {
                $this->session->remove('hello_session');
            } else if ($sessionType === 'temp') {
                $this->session->removeTempdata('hello_session'); // tempdata로 만드는 마커를 제거
            }
        }

        // Query String 방식으로 redirect 처리
        return redirect()->to(base_url('mvc/session?type=' . $sessionType)); // URL 헬퍼에 내장된 함수를 사용하여 페이지 이동
    }
}