<?php namespace Modules\Pattern\Libraries;

/**
 * 데이터베이스 유틸리티 라이브러리의 기능을 확인
 */
class DBUtilLib
{
    private $db;
    private $dbUtil;
    private $response;

    public function __construct()
    {
        $model = new Class extends \CodeIgniter\Model {};

        $this->db = \Closure::bind(function ($model) {
            return $model->db;
        }, null, $model)($model);

        // 데이터베이스 관리에 도움으 주는 함수들을 제공한다.
        $this->dbUtil = (new \CodeIgniter\Database\Database())->loadUtils($this->db);

        $this->response = service('response');
    }

    /**
     * 데이터베이스 목록 가져오기
     *
     * - 데이터베이스 목록을 배열로 리턴한다.
     *
     * @return array
     */
    public function getList()
    {
        return $this->dbUtil->listDatabases();
    }

    /**
     * 데이터베이스의 존재 여부 확인
     *
     * - 파라미터로 전달된 이름의 데이터베이스가 존재할 경우 `true`, 그렇지 않을 경우 `false`를 리턴한다.
     *
     * @return boolean
     */
    public function exists(string $dbName)
    {
        return $this->dbUtil->databaseExists($dbName);
    }

    /**
     * 데이터베이스 최적화 하기
     *
     * - 작업 결과에 따라 데이터베이스 상태가 담긴 배열을 리턴하거나, 최적화 실패시 `FALSE`를 리턴한다.
     * - 모든 데이터베이스 플랫폼이 이 기능을 지원하지는 않는다.
     *     - `MySQL`이나 `MariaDB`만 지원한다.
     *
     * @return void
     */
    public function optimize()
    {
        return $this->dbUtil->optimizeDatabase();
    }

    /**
     * ===================================
     * 테이블 최적화 하기
     *
     * - 이 기능을 정기적으로 숳애하면 데이터베이스 성능을 향상시킬 수 있다.
     * ===================================
     */
    public function tableUtil()
    {
        // 테이블 목록 조회
        $list = $this->db->listTables();

        foreach($list as $tableName) {
            $msg = "[{$tableName}]";

            // 테이블의 에러를 수리한다.
            if ($this->dbUtil->repairTable($tableName)) {
                $msg .= ' 수리 성공 /';
            } else {
                $msg .= ' 수리 실패 /';
            }

            // 테이블을 최적화 한다.
            if ($this->dbUtil->optimizeTable($tableName)) {
                $msg .= ' 최적화 완료';
            } else {
                $msg .= ' 최적화 실패';
            }

            debug($msg, $tableName);
        }
    }

    /**
     * ============================================
     * 데이터베이스 백업
     *
     * - 데이터베이스 전체나 각각의 테이블을 `ZIP`이나 `GZIP` 형식으로 압축해서 백업한다.
     * ============================================
     */
    public function backup()
    {
        /**
         * 많은 메모리를 소비하는 작업이므로, `php.ini`에 설정된 최대 메모리 사용량을 일시적으로 해제한다.
         * - ini_set() 함수는 PHP내장함수이지만, 일부 웹 호스팅에서는 보안을 이유로 차단되어 있기도 하다.
         */
        ini_set('memory_limit', '-1'); // 메모리 무제한으로 풀기

        // 다운로드 받을 백업파일의 이름
        $filename = 'myci_backup_' . date('ymd_His', time()) . '.sql.zip';

        // 시스템의 현재 데이터베이스 백업
        $backup = $this->dbUtil->backup([
            // 'tables'             => [], // 백업할 테이블 지정 (생략시 전체 테이블 백업)
			// 'ignore'             => [], // 제외할 테이블 지정 (전체 테이블 백업시에만 사용 가능)
			'filename'           => $filename, // 백업파일 이름
			'format'             => 'gzip', // 백업형식 : gzip, txt
			'add_drop'           => true, // 테이블 드롭 명령어 포함 여부
			'add_insert'         => true, // INSERT 구문 포함 여부
			'newline'            => "\n", // 행 처리 구문 설정
			'foreign_key_checks' => false, // 참조키 검사 수행 여부 (FALSE 권장)
        ]);

        // 다운로드 헬퍼를 사용하여 내려받는다.
        $this->response->download($filename, $backup);
    }
}
