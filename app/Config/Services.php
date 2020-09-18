<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

/**
 * 구성 파일을 서비스합니다.
 *
 * 서비스는 단순히 시스템이 그 일을 하기 위해 사용하는 다른 Classs/Library이다.
 * 이것은 CI에서 사용하여 나머지 응용 프로그램 내에서 사용에 영향을 주지 않고 프레임 워크의 핵심을 쉽게 교체할 수 있습니다.
 * 이 파일에는 필요한 응용 프로그램별 서비스 또는 서비스 재지정이 있습니다.
 * 서비스 방법에 사용해야 하는 일반적인 메서드 형식에 예제가 포함되어 있습니다.
 * 자세한 예는 system/Config/Services.php의 핵심 서비스 파일을 참조하십시오.
 */
class Services extends CoreServices
{

	//    public static function example($getShared = true)
	//    {
	//        if ($getShared)
	//        {
	//            return static::getSharedInstance('example');
	//        }
	//
	//        return new \CodeIgniter\Example();
    //    }

    //------------------------------------------------------------------

    public static function helloworld($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('helloworld');
        }

        return new \Modules\Pattern\Libraries\HelloWorld();
    }

    //------------------------------------------------------------------

    public static function emailLib($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('emailLib');
        }

        return new \Modules\Pattern\Libraries\EmailLib();
    }

    //------------------------------------------------------------------

    public static function excelLib($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('excelLib');
        }

        return new \Modules\Pattern\Libraries\ExcelLib();
    }

    //------------------------------------------------------------------

    public static function dbUtilLib($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('dbUtilLib');
        }

        return new \Modules\Pattern\Libraries\DBUtilLib();
    }

    //------------------------------------------------------------------

    public static function paginationLib($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('paginationLib');
        }

        return new \Modules\Pattern\Libraries\PaginationLib();
    }

    //------------------------------------------------------------------
}
