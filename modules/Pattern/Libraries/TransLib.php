<?php namespace Modules\Pattern\Libraries;

/**
 * 트랜잭션을 적용한 SQL 수행
 */
class TransLib
{
    /**
     * 트랜잭션 실행
     *
     * - `transComplete()`가 호출되기 전에 INSERT, UPDATE, SELECT 중 에러가 발생하면 모든 처리를 자동으로 되돌린다.
     *     --> 롤백 (Rollback)
     *
     * @return void
     */
    public function index()
    {
        // 트랜잭션을 시작한다.
        $this->db->transStart();

        $this->db->query('Query1 ...');
        $this->db->query('Query2 ...');
        $this->db->query('Query3 ...');

        // 변경사항을 저장한다. --> 커밋 (Commit)
        $this->db->transComplete();

        // 오류 관리
        if ($this->db->transStatus() === false) {
            log_message('error', 'DB Rollback');
        }
    }

    /**
     * 엄격한 모드 비활성화
     *
     * @return void
     */
    public function off()
    {
        // 방법 1
        $this->db->transStrict(false);

        // 방법 2
        $this->db->transOff();
    }

    /**
     * 테스트 모드
     *
     * - 첫 번째 매개 변수에 `TRUE` 설정
     *
     * @return void
     */
    public function testMode()
    {
        $this->db->transStart(true);
    }

    /**
     * 수동으로 트랜잭션 실행
     */
    public function directTrans()
    {
        $this->db->transBegin();

        $this->db->query('Query1 ...');
        $this->db->query('Query2 ...');
        $this->db->query('Query3 ...');

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
        } else {
            $this->db->transCommit();
        }
    }

    /**
     * 쿼리 캐시
     *
     * @return void
     */
    public function cache()
    {
        $this->db->start_cache();
        $this->db->where('Where ...'); // start_cache() 와 stop_cache() 사이에 있는 구문은 초기화 되지 않고, 별도로 저장되어 있다가 다음번 SQL 구문에서도 재사용된다.
        $this->db->stop_cache();

        $this->db->query('Query1 ...');
        $this->db->query('Query2 ...');

        $this->db->flush_cache(); // 호출되면 저장되어 있던 쿼리 구문들을 삭제하고 새로 시작한다.

        $this->db->query('Query3 ...');
    }
}
