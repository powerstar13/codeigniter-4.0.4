<?php namespace Modules\Blog\Controllers;

use App\Controllers\BaseController;

/**
 * 컨틀롤러 클래스는 CodeIgniter\Controller 를 상속받아야 하며,
 * BaseController를 통해 사용자 정의를 하여 필요한 helper 및 공통 메소드를 정의하여 상속 받을 수 있다.
 * - 필요한 경우 BaseController와 같이 그룹별로 다양한 Custom 컨트롤러를 만들어 상속받으면 된다.
 */
class Blog extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();
    }

    /**
     * 다중(Multiple) 뷰 로드
     */
    public function multiple()
    {
        echo view('Modules\Blog\Views\header');
        echo view('Modules\Blog\Views\menu');
        echo view('Modules\Blog\Views\content');
        echo view('Modules\Blog\Views\footer');
    }

    /**
     * 네임스페이스 뷰
     * - 동적 데이터 전달
     *
     * @return void
     */
    public function namespace()
    {
        $data = array(
            'title' => 'My Real Title',
            'heading' => 'My Real Heading',
        );

        echo view('Modules\Blog\Views\Blog', $data);
    }

    /**
     * 뷰 캐싱
     *
     * @return void
     */
    public function cache()
    {
        $data = array(
            'title' => 'My title',
            'heading' => 'My Heading',
            'message' => 'My Message'
        );

        echo view('file_name', $data, ['cache' => 60, 'cache_name' => 'my_cached_view']);
    }

    /**
     * 뷰 데이터 유지
     *
     * @return void
     */
    public function saveData()
    {
        $data = array(
            'title' => 'My title',
            'heading' => 'My Heading',
            'message' => 'My Message'
        );

        /**
         * - 전달한 데이터는 호출된 `view`에 대해 한 번만 사용 가능하다.
         * - 단일 요청에서 `view` 함수를 여러번 호출한다면 각 뷰 호출에 데이터를 전달해야 한다.- 그렇지 않으면, 모든 데이터가 다른 뷰로 `전달`되지 않아 문제가 발생할 수 있다.
         * - `view` 함수의 세 번째 매개 변수 `$option` 배열에 `saveData` 옵션을 사용하여 데이터를 유지할 수 있다.
         */
        echo view('Modules\Blog\Views\Blog', $data, ['saveData' => true]); // 뷰(view) 함수가 데이터를 유지한다.
    }
}