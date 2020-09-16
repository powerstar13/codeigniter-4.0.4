<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * 데이터베이스 유틸리티 라이브러리의 기능을 확인하기 위한 컨트롤러
 */
class Ex11DBUtil extends BaseController
{
    private $dbUtilLib;

    public function __construct()
    {
        parent::__construct();

        $this->dbUtilLib = service('dbUtilLib');
    }

    /**
     * 데이터베이스 목록 조회
     *
     * @return void
     */
    public function list()
    {
        $dbList = $this->dbUtilLib->getList();
        debug($dbList, 'list');

        foreach ($dbList as $index => $item) {
            // 특정 데이터베이스가 존재하는지 확인
            if ($this->dbUtilLib->exists($item)) {
                debug("{$item} 존재함");
            }
        }
    }

    /**
     * 데이터베이스 최적화
     *
     * @return void
     */
    public function optimize()
    {
        // CI가 현재 사용중인 데이터베이스를 최적화 한다.
        $result = $this->dbUtilLib->optimize();

        if ($result !== FALSE) {
            debug('데이터베이스 최적화 성공');
        } else {
            debug('데이터베이스 최적화 실패');
        }
    }

    /**
     * 테이블 수리/최적화
     *
     * @return void
     */
    public function tableUtil()
    {
        $this->dbUtilLib->tableUtil();
    }

    /**
     * 데이터베이스 백업 후 내려받기
     *
     * @return void
     */
    public function backup()
    {
        $this->dbUtilLib->backup();
    }
}