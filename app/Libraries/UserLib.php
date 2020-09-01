<?php namespace App\Libraries;

/**
 * 데이터 작업
 * - find(), insert(), update(), delete() 등을 포함하여 테이블에서 기본 CRUD 작업을 수행하기 위한 여러 함수가 제공된다.
 */
class UserLib
{
    protected $userModel;

    private function __construct()
    {
        $this->userModel = model('App\Models\UserModel', false);
    }

    /**
     * ======================================================
     * 데이터 찾기
     * ======================================================
     */

    /**
     * 첫 번째 매개 변수로 전달된 값과 기본 키가 일치하는 단일 행(row)을 리턴한다.
     *
     * @param int $user_id : 유저 일련번호
     * @return array $user : 유저 정보 단일 행(row)
     */
    public function find($user_id)
    {
        $user = $this->userModel->find($user_id); // 값은 `$returnType`에 지정된 형식으로 반환된다.

        // 하나의 키 대신 primaryKey 배열을 전달하여 둘 이상의 행을 반환하도록 지정할 수 있다.
        $users = $this->userModel->find([1, 2, 3]);

        // 매개 변수를 전달하지 않으면 `findAll()`처럼 작동하여 모델의 테이블에 있는 모든 행을 리턴한다.

        return $user;
    }

    /**
     * 컬럼명에 해당하는 유저 정보 목록
     *
     * @param string $column_name : 컬럼명
     * @return array $user : null 또는 인덱스화된 열(column)의 값 배열을 반환한다.
     * @Exception DataException : `$column_name`이 컬럼명에 일치하지 않을 경우 발생
     */
    public function findColumn($column_name)
    {
        $user = $this->userModel->findColumn($column_name);
        return $user;
    }

    /**
     * 모든 결과를 반환
     *
     * @return array $users : 유저 정보 목록
     */
    public function findAll($limit, $offset, $where = array())
    {
        $users = null;

        if (!empty($limit) && !empty($offset)) {
            if (empty($where['active'])) {
                $users = $this->userModel->findAll();
            } else {
                // 메소드를 호출하기 전에 필요에 따라 쿼리 빌더의 메소드를 추가하여 수정할 수 있다.
                $users = $this->userModel->where('active', $where['active'])->findAll();
            }
        } else {
            // limit 및 offset 값을 각각 첫 번째와 두 번째 매개 변수로 전달할 수 있다.
            if (empty($where['active'])) {
                $users = $this->userModel->findAll($limit, $offset);
            } else {
                // 메소드를 호출하기 전에 필요에 따라 쿼리 빌더의 메소드를 추가하여 수정할 수 있다.
                $users = $this->userModel->where('active', $where['active'])->findAll($limit, $offset);
            }
        }

        return $users;
    }

    /**
     * 결과 집합의 첫 번째 행을 반환한다.
     * - 쿼리 빌더와 함께 사용하느 것이 가장 좋다.
     *
     * @return array $user : 유저 정보
     */
    public function first()
    {
        $user = $this->userModel->where('deleted_at', 0)->first();
        return $user;
    }

    /**
     * 삭제된 데이터 포함 조회
     * - `$useSoftDeletes`가 `true`이면 find 메소드는 'deleted_at IS NOT NULL'인 행을 반환하지 않는다.
     * - 이를 일시적으로 무시하려면 find 메소드를 호출하기 전에 `withDeleted()` 메소드를 사용한다.
     *
     * @return array $users : 유저 목록
     */
    public function withDeleted($withDeleted = true)
    {
        $users = null;

        if (!$withDeleted) {
            // 삭제 안된 데이터만 가져오기 (deleted_at = 0)
            $users = $this->userModel->findAll(); // active users
        } else {
            // 삭제된 데이터도 포함하여 가져오기
            $users = $this->userModel->withDeleted()->findAll(); // all users
        }

        return $users;
    }

    /**
     * withDeleted()는 삭제된 행과 삭제되지 않은 행을 모두 리턴하지만, 이 메소드는 find 메소드를 수정하여 소프트 삭제된 행만 리턴한다.
     *
     * @return array $deletedUsers : 삭제된 유저 목록
     */
    public function onlyDeleted()
    {
        $deletedUsers = $this->userModel->onlyDeleted()->findAll();
        return $deletedUsers;
    }
}