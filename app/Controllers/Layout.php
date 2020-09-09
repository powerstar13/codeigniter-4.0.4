<?php namespace App\Controllers;

class Layout extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 부분(Partial) 뷰 포함을 통함 레이아웃 방식
     * include() 메소드 사용
     *
     * @return void
     */
    public function index()
    {
        $data = array(); // 전달할 값이 있으면 연관배열로 포함시키면 된다.
        return default_layout('welcome_message', $data);
    }

    /**
     * renderSection() 메소드를 통한 레이아웃 방식
     * - extend() 메소드 사용
     * - section() 메소드 사용
     *
     * @return void
     */
    public function section()
    {
        return view('layout/section/content');
    }
}