<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * 컨틀롤러 클래스는 CodeIgniter\Controller 를 상속받아야 하며,
 * BaseController를 통해 사용자 정의를 하여 필요한 helper 및 공통 메소드를 정의하여 상속 받을 수 있다.
 * - 필요한 경우 BaseController와 같이 그룹별로 다양한 Custom 컨트롤러를 만들어 상속받으면 된다.
 */
class HelloController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();
    }

    // 이 위치에 각 페이지를 구성하는 메소드가 추가된다.
}