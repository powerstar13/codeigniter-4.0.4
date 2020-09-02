<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\UserLib;

Class User extends Controller
{
    private $userLib;

    public function __construct()
    {
        $this->userLib = new UserLib();
    }

    public function save()
    {
        // 페이지가 실제로 존재하는지 여부를 확인
        if (!is_file(APPPATH . '/Views/user/save.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('save'); // 기본 오류 페이지를 표시하는 예외처리
        }

        $resource = array(
            'username' => 'masterHong',
            'email' => 'powerstar13@hanmail.net'
        );

        $data = array();
        $data = $this->userLib->save($resource);

        return view('user/save', $data);
    }
}