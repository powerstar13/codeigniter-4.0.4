<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
	/*
	|--------------------------------------------------------------------------
	| Templates
	|--------------------------------------------------------------------------
	|
    | 페이지 링크는 뷰를 사용하여 모양을 구성하여 렌더링됩니다.
    | 이 배열에는 링크를 렌더링할 때 사용할 별칭 및 뷰 이름이 포함되어 있습니다.
    |
    | 각 보기 내에서 Pager 객체는 $pager로, 원하는 그룹은 $pagerGroup으로 사용할 수 있습니다.
	|
	*/
	public $templates = [
		'default_full'   => 'CodeIgniter\Pager\Views\default_full',
		'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
		'default_head'   => 'CodeIgniter\Pager\Views\default_head',
		'pagerTemplate' => 'Modules\Pattern\Views\Pager\pagerTemplate',
	];

	/*
	|--------------------------------------------------------------------------
	| Items Per Page
	|--------------------------------------------------------------------------
	|
	| 한 페이지에 표시된 기본 결과 수입니다.
	|
	*/
	public $perPage = 20;
}
