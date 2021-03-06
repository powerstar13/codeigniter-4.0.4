<?php namespace App\Entities;

use CodeIgniter\Entity;
use CodeIgniter\I18N\Time;

class UserEntity extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'email' => null,
        'password' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    /**
     * ==========================
     * 데이터 매핑
     *
     * - 더 이상 사용하지 않을 이름 대신 로그인을 위해 이메일을 사용하도록 바꿔야 하는 경우
     *     - 그러나 어플리케이션을 약간 개인화하기 위해 이름 필드를 현재 사용중인 사용자 이름이 아닌 사용자의 전체 이름을 나타내도록 변경해야 하는 경우
     *     - 데이터베이스에서 문제를 정리하기 위해 마이그레이션을 수행하여 name 필드를 full_name 필드로 변경한다.
     *
     * - 이를 위해 UserEntity 클래스를 수정하는 방법은 두 가지가 있다.
     *     - 첫 번째 방법은 클래스 속성을 `$name`에서 `$full_name`으로 수정하고, 어플리케이션 전체를 변경한다.
     *     - 두 번째 방법은 데이터베이스의 `full_name` 컬럼을 `$name` 속성에 매핑하고 Entity 변경을 수행한다.
     *
     * - 새 데이터베이스 이름을 $datamap 배열에 추가하면 데이터베이스 컬럼에 액세스할 수 있는 클래스 속성을 클래스에 알릴 수 있다.
     *     - 배열의 키는 데이터베이스의 컬럼 이름이며, 배열의 값은 이를 매핑할 클래스 속성이다.
     *
     * - 이 예에서는 모델이 사용자 클래스에서 `full_name` 필드를 설정할 때, 실제로 해당 값을 클래스의 `$name` 속성에 할당하여 `$user->name`을 통해 설정하고 검색할 수 있다.
     *     - 모델이 데이터를 가져와서 데이터베이스에 저장하는데 필요하기 때문에 `$user->full_name`을 통해 값에 계속 액세스 할 수 있다.
     *     - 그러나 `unset`과 `isset`은 원래 이름인 `full_name`이 아닌 매핑된 속성 `$name`에서만 작동한다.
     * ==========================
     */
    protected $datamap = [
        'full_name' => 'name'
    ];

    /**
     * =====================================
     * 뮤테이터(Mutators)
     *
     * - 기본적으로 Entity 클래스는 created_at, updated_at, deleted_at 이라는 필드를 데이터를 설정하거나 검색할 때마다 `Time` 인스턴스로 변환한다.
     *     - Time 클래스는 변하지 않고, 지역화된 방식으로 많은 유용한 메소드를 제공한다.
     *
     * - `options['dates']` 배열에 이름을 추가하여 자동으로 변환할 특성을 정의할 수 있다.
     * =====================================
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * ============================================
     * 1. 속성 캐스팅
     *
     * - `casts` 속성을 사용하여 엔티티의 속성을 공통 데이터 유형으로 변환하도록 지정할 수 있다.
     *     - 이 옵션은 키가 클래스 속성의 이름이고, 값은 캐스트 해야 하는 데이터 유형의 배열이어야 한다.
     *     - 캐스팅은 값을 읽을 때만 영향을 준다.
     *     - 엔티티나 데이터베이스의 영구적인 값에 영향을 주는 변환이 발생하지 않는다.
     *     - 속성은 다음 데이터 형식 중 하나로 캐스팅 할 수 있다.
     *         - integer, float, double, string, boolean, object, array, datetime, timestamp
     *     - 유형의 시작 부분에 물음표를 추가하면 특성을 null 입력 가능으로 표시한다.
     *         - ?string
     *         - ?integer
     *
     * - 다음 예는 UserEntity 의 `is_banned` 속성을 boolean으로 캐스팅한다.
     *
     * --------------------------------------------
     *
     * 2. Array/Json 캐스팅
     *
     * - Array/Json 캐스팅은 직렬화된 배열 또는 JSON을 저장하는 필드에 특히 유용하다.
     *     - array : 자동으로 직렬화 해제
     *     - json : json_decode($value, false)값으로 자동 설정
     *     - json-array : json_decode($value, true)값으로 자동 설정
     *
     * - 속성 값을 읽을 때 속성을 캐스팅할 수 있는 나머지 데이터 형식과 달리
     *     - array : serialize 하여 캐스트
     *     - json, json-array : json_encode 함수를 사용하여 캐스트
     * ============================================
     */
    protected $casts = [
        'is_banned' => 'boolean',
        'is_banned_nullable' => '?boolean',
        'options' => 'array',
        'options_object' => 'json',
        'options_array' => 'json-array',
    ];

    /**
     * ====================================
     * 비즈니스 로직 처리
     *
     * - 가장 먼저 알아야 할 것은 우리가 추가한 메소드의 이름이다.
     * - 각가의 클래스는 snake_case로 작성된 컬럼 이름을 `set` 또는 `get` 접두사가 붙은 PascalCase(첫 단어를 대문자로 시작하는 표기법)로 변환한다.
     * - 이 메소드는 직접 구문을 (ex: $user->email) 사용하여 클래스 속성을 설정하거나 검색할 때마다 자동으로 호출한다.
     * - 다른 클래스에서 액세스하지 않으려면 메소드를 공개(public)하지 않아도 된다.
     *     - 예를 들어, `created_at` 클래스 속성은 `setCreatedAt()`과 `getCreatedAt()` 메소드를 통해 액세스된다.
     *
     * Note:
     * - 이 방법은 클래스 외부에서 속성에 액세스하려고 할 때만 작동한다.
     * - 클래스 내부의 모든 메소드는 `setX()`와 `getX()` 메소드를 직접 호출해야 한다.
     * ====================================
     */

    /**
     * 비밀번호가 항상 해시되도록 한다.
     *
     * @param string $pass
     * @return object $this
     */
    public function setPassword(string $pass)
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * 모델에서 받은 문자열을 DateTime 객체로 변환하여 시간대가 UTC인지 확인하여 뷰어의 현재 시간대를 쉽게 변환한다.
     *
     * @param string $dateString
     * @return object $this
     */
    public function setCreatedAt(string $dateString)
    {
        $this->attributes['created_at'] = new Time($dateString, 'Asia/Seoul');

        return $this;
    }

    /**
     * 시간을 어플리케이션의 사용중인 시간대의 지정된 형식 문자열로 변환한다.
     *
     * @param string $format
     * @return object $this
     */
    public function getCreatedAt(string $format = 'Y-m-d H:i:s')
    {
        // Convert to CodeIgniter\I18n\Time object
        $this->attributes['created_at'] = $this->mutateDate($this->attributes['created_at']);

        $timezone = $this->timezone ?? app_timezone();

        $this->attributes['created_at']->setTimezone($timezone);

        return $this->attributes['created_at']->format($format);
    }
}