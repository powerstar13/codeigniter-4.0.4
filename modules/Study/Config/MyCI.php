<?php namespace Modules\Study\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * 개발자가 필요에 따라 추가하는 설정파일
 */
class MyCI extends BaseConfig
{
    // 개발자가 직접 추가하는 환경설정 데이터
    public $myname = 'CodeIgniter';
    public $version = "4.0.4";
    // 단일값 형태 뿐 아니라 배열 형태도 가능하다.
    public $loadmap = array(
        'step1' => 'HTML/CSS',
        'step2' => 'Javascript + jQuery',
        'step3' => 'Classic PHP + MySQL',
        'step4' => 'JSON RPC Server + Ajax',
        'step5' => 'CodeIgniter',
        'step6' => 'Portfolio Project',
    );
}