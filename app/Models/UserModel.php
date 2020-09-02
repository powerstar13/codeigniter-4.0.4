<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    /**
     * =============================================
     * 1. 데이터베이스 연결
     *
     * - 클래스가 처음 인스턴스화될 때 데이터베이스 연결 인스턴스가 생성자에 전달되지 않으면 구성에서 설정한대로 기본 데이터베이스 그룹에 자동으로 연결된다.
     * - `DBGroup` 속석을 클래스에 추가하여 모델별로 사용되는 그룹을 수정할 수 있다.
     * - 이는 모델 내에서 `$this->db`에 대한 참조가 적절한 DB에 연결되도록 한다.
     * =============================================
     */

    // "group_name"을 데이터베이스 구성 파일에 정의된 데이터베이스 그룹 이름으로 바꾸십시오.
    protected $DBGroup = 'development';


    /**
     * =============================================
     * 2. 모델 구성
     *
     * - 모델 클래스에는 클래스의 메소드가 원활하게 작동하도록 설정할 수 있는 몇 가지 구성 옵션이 있다.
     * - 처음 두 개는 모든 CRUD 메소드에서 사용할 테이블과 필요한 레코드를 찾는 방법을 결정하는데 사용된다.
     * =============================================
     */

    // 모델을 통하여 조작하고자 하는 데이터베이스 테이블을 지정한다.
    // 이것은 내장 CRUD 메소드에만 적용되며 모델을 통한 쿼리에서 이 테이블만 사용하도록 제한하지 않는다.
    protected $table = 'users';
    // 테이블에서 레코드를 고유하게 식별하는 열(Column)의 이름이다.
    // 반드시 데이터베이스에 지정된 기본(primary) 키와 일치할 필요는 없으며, find()와 같은 메소드에서 지정된 값과 일치하는 열을 찾을 때 사용한다.
    // Note: 모든 기능이 예상대로 작동하려면 모든 모델에 기본 키가 지정되어 있어야 한다.
    protected $primaryKey = 'id';

    // 테이블이 자동 증가(auto-increment) 기능을 사용할지 여부를 $primaryKey에 지정한다.
    // false로 설정하면 테이블의 모든 레코드에 대해 기본 키 값을 제공해야 한다.
    // 이 기능은 1:1 관계를 구현하거나 모델에 UUID를 상요하려는 경우에 유용하다.
    // Note: 만약 $useAutoIncrement를 `false`로 설정했다면, 반드시 데이터베이스의 기본 키를 `unique`로 설정해야 모델의 모든 기능이 이전과 동일하게 작동한다.
    protected $useAutoIncrement = true;

    // 모델의 CRUD 메소드는 Result 객체 대신 결과 데이터를 자동으로 반환한다.
    // 이 설정을 통해 반환되는 데이터 유형을 정의할 수 있다.
    // 유효한 값은 'array', 'object' 또한 Result 오브젝트의 getCustomResultObject() 메소드와 함께 사용할 수 있는 클래스명이다.
    protected $returnType = 'array';
    // `true`이면 delete 메소드 호출은 실제로 행을 삭제하는 대신 데이터베이스의 deleted_at 필드를 설정한다. 이를 통해 데이터가 다른 곳에서 참조 될 때 데이터를 보존하거나 복원할 수 있는 개체의 "휴지통"을 유지하거나 단순히 보안 추적의 일부로 보존할 수 있다.
    // `true`인 경우, find 메소드를 호출하기 전에 withDeleted() 메소드를 호출하지 않으면 find 메소드는 삭제되지 않은 행만 리턴한다.
    // 모델의 $dateFormat 설정에 따라 데이터베이스에 타입이 DATETIME 또는 INTEGER인 `deleted_at` 필드가 필요하다.
    // 기본 필드 이름은 `deleted_at`이지만 이 이름은 `$deletedFiled` 속성을 사용하여 원하는 이름으로 수정할 수 있다.
    protected $useSoftDeletes = true;

    // 이 배열은 save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름이다.
    // 여기에 명시되지 않은 필드명은 삭제된다.
    // 이렇게 하면 양식(Form)에서 입력된 모든 데이터를 모델에 모두 입력되는 것을 방지하여 대량 할당 취약점이 발생하지 않도록 보호할 수 있다.
    protected $allowedFields = ['username', 'email', 'password'];

    // 이 값은 현재 날짜가 모든 INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정한다.
    // `true`이면 $dateFormat에 지정된 형식으로 현재 시간을 설정한다.
    // 이를 위해서 테이블에 적절한 데이터 유형의 `created_at`과 `updated_at`라는 열(Column)이 있어야 한다.
    protected $useTimestamps = false;
    // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드를 지정한다.
    // 업데이트가 되지않도록 하려면 비워 두십시오. (useTimestamps가 true여도)
    protected $createdField = 'created_at';
    // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드를 지정한다.
    // 업데이트가 되지않도록 하려면 비워 두십시오. (useTimestamps가 true여도)
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // $useTimestamps 및 $useSoftDeletes 와 함께 작동하여 올바른 유형의 날짜 값이 데이터베이스에 INSERT 되도록 한다.
    // 기본적으로 DATETIME 값을 작성하지만 옵션을 통해 수정할 수 있으며, 유효한 옵션은 datetime, date, int(PHP 타임 스탬프)이다.
    // `useSofeDeletes` 또는 `useTimestamps`에 유효하지 않거나 잘못된 dateFormat을 사용하면 예외가 발생한다.
    protected $dateFormat = 'datetime';

    // 규칙을 저장하는 방법과 같이 유효성 검사 규칙 배열을 포함하거나 유효성 검사 그룹(Validation.php에서 사용자 정의함)의 이름을 포함하는 문자열을 포함한다.
    protected $validationRules = [
        'username'     => 'required|alpha_numeric_space|min_length[3]',
        'email'        => 'required|valid_email|is_unique[users.email, id, {id}]',
        'password'     => 'required|min_length[8]',
        'pass_confirm' => 'required_with[password]|matches[password]',
    ];
    // 사용자 정의 오류 메시지 설정과 같이, 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열을 포함한다.
    // 만약 Validation.php 에서 설정한 rule을 사용할 경우 배열 안에 rule에서 선언한 name을 적어주면 된다.
    protected $validationMessages = [
        'username' => [
            'required'    => '이름을 입력해주세요.',
        ],
        'email'    => [
            'required' => '이메일을 입력해주세요.',
            'valid_email' => '이메일 형식에 맞지 않습니다.',
            'is_unique' => '이미 가입된 이메일 입니다.'
        ]
    ];
    // 모든 `inserts`와 `updates`의 유효성 검사를 하지 않을지 여부이다.
    // 기본적으로 `false`이며 데이터의 유혀성 검사를 항상 시도한다.
    // 이 속성은 주로 `skipValidation()` 메소드에 의해 사용되지만, 모델이 유효성을 검사하지 않도록 `true`로 변경할 수 있다.
    protected $skipValidation = false;

    // 그 외 $beforeInsert $afterInsert $beforeUpdate $afterUpdate $afterFind $afterDelete 이 속성들은 콜백 메소드를 지정할 때 사용되며, 콜백은 속성 이름이 뜻하는 시점에 호출된다.
    // 위에서 정의한 콜백을 사용할지 여부를 결정한다.
    // protected $allowCallbacks = false;

    /**
     * =====================
     * 콜백 정의
     *
     * - 사용할 모델에 먼저 새 클래스 메소드를 작성하고 콜백을 지정한다.
     * - 이 클래스는 $data 배열을 매개 변수로 받는다.
     * - $data 배열에 전달되는 내용은 이벤트마다 다르지만, 원래 메소드에 전달된 기본 데이터를 `data`라는 키에 전달한다.
     * - `inset` 또는 `update` 메소드의 경우, 데이터베이스에 삽입되는 키/값 쌍이 된다.
     * - 기본 배열에는 메소드에 전달된 다른 값도 포함된다.
     * - 다른 콜백이 정보를 전달받을 수 있도록 호출된 콜백 메소드는 `$data` 배열을 리턴해야 한다.
     * =====================
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) return $data;

        $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        unset($data['data']['password']);

        return $data;
    }

    /**
     * ======================
     * 콜백 지정
     *
     * - 적절한 클래스 속성(beforeInsert, afterUpdate 등)에 메소드 이름을 추가하여 콜백이 호출되는 시기를 지정한다.
     * - 단일 이벤트에 여러 개의 콜백을 추가할 수 있으며 지정된 순서대로 처리된다.
     * - 여러 이벤트에서 동일한 콜백을 사용할 수도 있다.
     * ======================
     */
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * =================================
     * Modifying Find Data
     *
     * - `beforeFind`와 `afterFind` 메소드는 모델의 정상적인 응답을 대체하기 위해 수정된 데이터 셀을 반환할 수 있다.
     * - `afterFind`의 경우 반환 배열에서 `data`에 대한 변경 내용은 호출 컨텍스트로 자동 전달된다.
     * - `beforeFind`가 검색 워크플로우를 가로 채기 전, 또 다른 boolean 값 `returnData`도 반환한다.
     * =================================
     */
    protected $beforeFind = ['checkCache'];

    protected function checkCache(array $data)
    {
        // 요청한 항목이 캐시에 있는지 확인
        if (isset($data['id']) && $item = $this->getCachedItem($data['id'])) {
            $data['data'] = $item;
            $data['returnData'] = true;

            return $data;
        }
    }
}