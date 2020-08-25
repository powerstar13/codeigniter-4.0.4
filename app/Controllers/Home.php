<?php namespace App\Controllers;

/**
 * Controller가 View를 호출하는 구조
 */
class Home extends BaseController
{
    /**
     * http://localhost
     * 사이트의 대문 페이지로 인식된다.
     */
	public function index()
	{
        // views 폴더의 welcome_message.php 파일을 호출하여 화면 표시를 요청한다.
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

    /**
     * 컨트롤러와 View의 관계를 이해하기 위한 메서드 추가 작성
     */

    /** hello 페이지 --> http://localhost/home/hello */
    public function hello()
    {
        // View에게 전달할 데이터를 연관배열로 구성하여 전달한다.
        $data = ['name' => '코드이그나이터', 'version' => '4.0.4'];
        return view('home/hello', $data); // /views 디렉토리 내의 경로를 의미 (확장자 생략)
    }

    /** world 페이지 --> http://localhost/home/world */
    public function world()
    {
        // View에게 전달할 데이터를 객체로 구성하여 전달한다.
        $data = new stdClass();
        $data->name = 'Codeigniter';
        $data->version = '4.0.4';
        return view('home/world', $data);
    }
}
