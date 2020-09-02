<?php namespace App\Libraries;

/**
 * 데이터 작업
 * - find(), insert(), update(), delete() 등을 포함하여 테이블에서 기본 CRUD 작업을 수행하기 위한 여러 함수가 제공된다.
 */
class UserLib
{
    private $userModel;
    private $userBuilder;

    public function __construct()
    {
        $this->userModel = model('App\Models\UserModel', false);
        $this->userBuilder = $this->userModel->builder(); // 해당 모델의 데이터베이스 연결이 필요할 때 쿼리 빌더 공유 인스턴스에 액세스할 수 있다.
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
    public function find(int $user_id)
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
    public function findColumn(string $column_name)
    {
        $user = $this->userModel->findColumn($column_name);
        return $user;
    }

    /**
     * 모든 결과를 반환
     *
     * @return array $users : 유저 정보 목록
     */
    public function findAll(int $limit, int $offset, array $where)
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
    public function withDeleted(bool $withDeleted = true)
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

    /**
     * ========================================
     * 데이터 저장
     * ========================================
     */

    /**
     * 전달된 데이터의 연관 배열을 이용하여 데이터베이스에 새로운 데이터 행을 작성한다.
     * - 배열의 키는 `$table`의 열(column) 이름과 일치해야 하며, 배열의 값은 해당 키에 저장할 값이다.
     *
     * @param array $resource : 저장할 데이터
     * @return array 결과
     */
    public function insert(array $resource)
    {
        $data = [
            'username' => $resource['username'],
            'email' => $resource['email']
        ];

        $queryResult = $this->userModel->insert($data);

        $result = array();

        if($queryResult === false) {
            $result['rt'] = 400;
            $result['errors'] = $this->userModel->errors();
        } else {
            $result['rt'] = 200;
            $result['rtMsg'] = '유저 정보 저장에 성공했습니다.';
        }

        return $result;
    }

    /**
     * 데이터베이스의 기본 레코드를 업데이트한다.
     * - update()
     *     - 첫 번째 매개 변수는 업데이트할 레코드의 `$primaryKey`이다.
     *     - 두 번째 매개 변수는 이 메소드에 전달될 데이터의 연관 배열이다.
     * - 배열의 키는 `$table`의 열(column) 이름과 일치해야 하며, 배열의 값은 해당 키에 저장할 값이다.
     *
     * @param array $resource
     * @return array 결과
     */
    public function update(array $resource)
    {
        $data = [
            'username' => $resource['username'],
            'email' => $resource['email']
        ];

        $queryResult = $this->userModel->update($resource['id'], $data);

        // 기본키(primary) 배열을 첫 번째 매개 변수로 전달하여, 한 번의 호출로 여러 레코드를 업데이트 할 수 있다.
        $data = [
            'active' => 1
        ];

        $queryResult = $this->userModel->update([1, 2, 3], $data);

        // 유효성 검사, 이벤트 등의 추가 이점을 갖는 쿼리 빌더의 업데이트 명령을 수행하려면, 매개 변수를 비운채 사용
        $queryResult = $this->userModel->whereIn('id', [1, 2, 3])->set($data)->update();

        $result = array();

        if($queryResult === false) {
            $result['rt'] = 400;
            $result['errors'] = $this->userModel->errors();
        } else {
            $result['rt'] = 200;
            $result['rtMsg'] = '유저 정보 수정에 성공했습니다.';
        }

        return $result;
    }

    /**
     * `$primaryKey` 값과 일치하는 배열 키가 존재하는지의 여부에 따라 레코드 INSERT 또는 UPDATE를 자동으로 처리한다.
     *
     * @return array 결과
     */
    public function save(array $resource)
    {
        $result = array();
        $rtMsg = '유저 정보 저장에 성공했습니다.';

        if (empty($resource['id'])) {
            // insert로 작동
            $data = [
                'username' => $resource['username'],
                'email' => $resource['email']
            ];

            $queryResult = $this->userModel->save($data);
        } else {
            $rtMsg = '유저 정보 수정에 성공했습니다.';
            // update로 작동($primaryKey = 'id'에 매칭될 경우)
            $data = [
                'id' => $resource['id'],
                'username' => $resource['username'],
                'email' => $resource['email']
            ];

            $queryResult = $this->userModel->save($data);
        }

        // 실패하면 모델은 `false`를 반환한다.
        if($queryResult === false) {
            $result['rt'] = 400;
            // `errors()` 메소드를 사용하여 유효성 검사 오류를 검색할 수 있다.
            // 필드 이름과 관련 오류가 있는 배열을 반환한다.
            // 양식(form) 맨 위에 모든 오류를 표시하거나 개별적으로 표시하는 데 사용할 수 있다.
            $result['errors'] = $this->userModel->errors();
        } else {
            $result['rt'] = 200;
            $result['rtMsg'] = $rtMsg;
        }

        return $result;

        /**
         * save 메소드는 단순하지 않은 오브젝트를 인식하고 공용 및 보호된 값을 배열로 가져와서 적절한 insert 또는 update 메소드를 전달하여 사용자 정의 클래스 결과 오브젝트에 대한 작업을 훨씬 간단하게 만들 수 있다.
         * 이를 통해 매우 깨끗한 방식으로 Entity 클래스를 사용할 수 있다.
         * 엔티티 클래스는 사용자, 블로그 게시물, 작업 등과 같은 개체 유형의 단일 인스턴스를 나타내는 간단한 클래스이다.
         * 이 클래스는 특정 방식으로 요소를 형식화하는 등 오브젝트 자체를 둘러싼 비즈니스 로직을 유지 보수한다.
         * 데이터베이스에 저장되는 방법에 대해 전혀 알지 못한다.
         */
    }

    /**
     * ========================================================
     * 데이터 삭제
     * ========================================================
     */

    /**
     * 첫 번째 매개 변수로 제공된 기본 키 값을 사용하여 모델 테이블에서 일치하는 레코드를 삭제한다.
     *
     * @param int $id : 유저 일련번호
     * @return void
     */
    public function delete(int $id)
    {
        $this->userModel->delete($id);

        // 모델의 $useSoftDeletes 값이 `true`인 경우, `deleted_at`을 현재 날짜 및 시간으로 설정하여 행을 업데이트한다.
        // 두 번째 매개 변수를 true로 설정하여 영구적으로 삭제할 수 있다.
        $this->userModel->delete($id, true);

        // 첫 번째 매개 변수로 기본 키 배열을 전달하여 한 번에 여러 레코드를 삭제할 수 있다.
        $this->userModel->delete([1, 2, 3]);

        // 매개 변수가 전달되지 않으면 쿼리 빌더의 delete 메소드처럼 작동하며 where 메소드 호출이 필요하다.
        $this->userModel->where('id', $id)->delete();
    }

    /**
     * `deleted_at IS NOT NULL`이 있는 모든 행을 데이터베이스 테이블에서 '영구적으로 제거'한다.
     *
     * @return void
     */
    public function purgeDeleted()
    {
        $this->userModel->purgeDeleted();
    }

    /**
     * ================================================
     * 데이터 검증
     * ================================================
     */

    /**
     * 이 함수는 필드 유효성 검사 규칙을 설정한다.
     *
     * @return void
     */
    public function setValidationRule()
    {
        $fieldName = 'username';
        $fieldRules = 'required|alpha_numeric_space|min_length[3]';

        $this->userModel->setValidationRule($fieldName, $fieldRules);
    }

    /**
     * 이 함수는 유효성 검사 규칙을 설정한다.
     *
     * @return void
     */
    public function setValidationRules()
    {
        $validationRules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|alpha_numeric_space|min_length[3]',
                'errors' => [
                    'required' => 'You must choose a username',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email, id, {id}]',
                'errors' => [
                    'required' => 'We really need your email.',
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
                ]
            ],
        ];

        $this->userModel->setValidationRules($validationRules);
    }

    /**
     * 기능별로 유혀성 검사 메시지를 필드로 설정하는 다른 방법
     * - 이 함수는 오류 메시지를 설정한다.
     *
     * @return void
     */
    public function setValidationMessage()
    {
        $fieldName = 'username';
        $fieldValidationMessage = array(
            'required' => 'Your name is required here',
        );

        $this->userModel->setValidationMessage($fieldName, $fieldValidationMessage);
    }

    /**
     * 이 함수는 필드 메시지를 설정합니다.
     *
     * @return void
     */
    public function setValidationMessages()
    {
        $filedValidationMessage = array(
            'username' => array(
                'required' => 'Your baby name is missing.',
                'min_length' => 'Too short, man!',
            ),
        );

        $this->userModel->setValidationMessages($filedValidationMessage);
    }

    /**
     * =======================================
     * 유효성 검사 규칙 검색
     * =======================================
     */

    /**
     * `validationRules` 속성에 액세스하여 모델의 유효성 검사 규칙을 검색할 수 있다.
     * - 옵션을 사용하여 접근자 메서드를 직접 호출하여 해당 규칙의 하위 집합만 검색 할 수도 있다.
     * @param array $options : 하나의 요소를 가진 연관 배열이며, 키는 "except" 또는 "only"이며, 값은 해당 필드 이름의 배열이다.
     *     - $options = array('except' => ['usename']);
     *         - "사용자 이름" 필드를 제외한 모든 필드에 대한 규칙을 가져옵니다
     *     - $options = array('only' => ['city', 'state']);
     *         - "도시" 및 "국가" 필드에만 규칙을 가져오십시오
     * @return void
     */
    public function getValidationRules(array $options)
    {
        if (empty($options)) {
            $rules = $this->userModel->validationRules;
        } else {
            $rules = $this->userModel->getValidationRules($options);
        }
    }

    /**
     * ========================
     * 쿼리 빌더 사용
     * ========================
     */

    /**
     * 빌더는 모델의 $table로 설정되어 있다.
     * - 동일한 체인 호출에서 쿼리 빌더 메소드와 Model의 CRUD 메소드를 함께 사용할 수 있다.
     *
     * @return array $users : 조회된 유저 목록
     */
    public function useQueryBuilder()
    {
        $users = $this->userModel->where('status', 'active')
            ->orderBy('last_login', 'asc')
            ->findAll();

        return $users;
    }

    /**
     * 모델의 데이터베이스 연결에 완벽하게 액세스할 수도 있다.
     *
     * @param string $name : 이름
     * @return string $userName : 유저 이름
     */
    public function escape(string $name)
    {
        $userName = $this->userModel->escape($name);
        return $userName;
    }

    /**
     * ==========================
     * 런타임 리턴 유형 변경
     *
     * - find() 메소드는 클래스 $returnType 속성으로 사용하여 데이터가 리턴되는 형식을 지정할 수 있다.
     * - 그러나 지정한 형식과 다른 형식으로 데이터를 다시 원할 수도 있다.
     * - 모델은 이를 수행할 수 있는 메소드를 제공한다.
     *
     * Note:
     * - 이 메소드는 다음 find() 메소드 호출에 대한 리턴 유형만 변경한다.
     * - 그 후에는 기본값으로 재설정된다.
     * ==========================
     */

    /**
     * find() 메소드의 데이터를 연관 배열로 리턴한다.
     *
     * @return array $users : 유저 목록
     */
    public function asArray()
    {
        $users = $this->userModel->asArray()->where('status', 'active')->findAll();
        return $users;
    }

    /**
     * find() 메소드의 데이터를 표준 객체 또는 사용자 정의 클래스 인스턴스로 반환한다.
     *
     * @return array $users : 유저 목록
     */
    public function asObject()
    {
        // 표준 객체로 반환
        $users = $this->userModel->asObject()->where('status', 'active')->findAll();

        // 사용자 정의 클래스 인스턴스로 반환
        $users = $this->userModel->asObject('User')->where('status', 'active')->findAll();
    }

    /**
     * ============================
     * 많은 양의 데이터 처리
     *
     * - 많은 양의 데이터를 처리해야 할 때, 메모리가 부족해질 위험이 있다.
     * - 이를 방지하기 위해 chunk() 메소드를 사용하여 작업을 수행하면 작은 크기의 청크를 얻을 수 있다.
     * - 첫 번째 매개 변수는 단일 청크의 크기이다.
     * - 두 번째 매개 변수는 각 청크 데이터 행에 대해 호출될 클로저(Closure)이다.
     *
     * - 이 방법은 크론 작업, 데이터 내보내기(export) 또는 기타 대규모 작업에 적합하다.
     * ============================
     */
    public function chunk()
    {
        $this->userModel->chunk(100, function($data) {
            // do something.
            // $data = 단일 행 데이터
        });
    }
}