<?php namespace Modules\Pattern\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * 게시판에 대한 환경설정 정보
 *
 * - 하나의 프로그램으로 여러 개의 게시판을 사용할 수 있는 멀티 게시판을 구현하기 위해, 각 게시판의 정보를 관리하기 위한 설정 정보가 필요하다.
 * - 이 파일을 통해 게시판의 종류를 명시하고, 각 게시판별로 사용되어질 설정 정보를 관리할 수 있다.
 *     - 여기서는 게시판의 이름과 디자인을 위한 skin 정보만 관리하지만, 필요에 따라 다양한 옵션들을 추가로 정의할 수 있다. (ex. 접근 권한, 등)
 */
class Bbs extends BaseConfig
{
    public $bbs = array(
        // key -> URL 파라미터로 사용
        'notice' => array(
            'name' => '공지사항',
            'skin' => 'default'
        ),
        'news' => array(
            'name' => '최신소식',
            'skin' => 'default'
        ),
        'gallery' => array(
            'name' => '갤러리',
            'skin' => 'photo'
        ),
    );
}