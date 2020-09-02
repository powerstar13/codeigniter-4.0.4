<?php namespace App\Entities;

use CodeIgniter\Entity;
use CodeIgniter\I18N\Time;

class UserEntity extends Entity
{
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
        $this->attributes['created_at'] = new Time($dateString, 'UTC');

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