<?php namespace App\Controllers;

use CodeIgniter\Controller;

Class Pages extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        // 페이지가 실제로 존재하는지 여부를 확인
        if (!is_file(APPPATH . '/Views/pages/' . $page . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page); // 기본 오류 페이지를 표시하는 예외처리
        }

        // header에서 사용될 title 변수값
        $data['title'] = ucfirst($page); // 첫 글자를 대문자 처리

        echo view('templates/header', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }
}