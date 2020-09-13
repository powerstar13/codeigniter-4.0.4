<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * Controller에서 View를 호출하는 모든 패턴을 정리하기 위한 컨트롤러
 */
class Ex01UseView extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // 클래스 네임스페이스를 사용하여 뷰를 로드할 수 있다.
        // 지정된 View 파일이 없을 경우 404 에러가 표시된다.
        return view('Modules\Pattern\Views\Ex01\index');
    }

    /**
     * View에게 데이터를 전달하는 패턴
     *
     * - 연관 배열을 구성하여 View에게 전달한다.
     * - View에서는 연관배열의 Key를 변수로 인식한다.
     */
    public function setArray()
    {
        // 연관배열로 HTML 코드에 전달할 데이터 구성하기
        $data = array(
            'name' => '코드이그나이터',
            'language' => 'PHP',
            'level' => '중급'
        );

        // 로드할 View와 전달할 데이터 설정 (데이터는 생략 가능함)
        return view('Modules\Pattern\Views\Ex01\setArray', $data);
    }

}