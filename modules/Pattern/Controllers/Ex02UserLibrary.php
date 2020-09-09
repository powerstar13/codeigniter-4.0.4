<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * 컨트롤러에서 라이브러리 로드하기
 */
class Ex02UserLibrary extends BaseController
{
    private $helloworld;

    public function __construct()
    {
        parent::__construct();
        $this->helloworld = service('helloworld');
    }

    // 라이브러리의 기능 호출하기
    public function index()
    {
        $this->helloworld->sayKor();
        $this->helloworld->sayEng();
    }
}