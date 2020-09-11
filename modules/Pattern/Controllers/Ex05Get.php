<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * URL 파라미터를 전달하기 위한 View를 호출하는 컨트롤러 구성
 */
class Ex05Get extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 파라미터에 기본값이 정의되어 있을 경우, URL에 해당 값이 명시되지 않으면 404 에러가 발생하기 때문에 URL 파라미터를 사용할 때는 기본값을 정의해 주는 것이 좋다.
     * - http://localhost/mvc/get/sample/{param1}/{param2}
     *
     * @param string $param1 : {param1}
     * @param string $param2 : {param2}
     * @return void
     */
    public function sample($param1 = '기본값', $param2 = '기본값')
    {
        debug($param1);
        debug($param2);
    }
}