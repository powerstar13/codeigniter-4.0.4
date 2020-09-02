<?php namespace App\Libraries;

use \App\Entities\UserEntity;

class UserEntityLib
{
    private $userEntityModel;

    public function __construct()
    {
        $this->userEntityModel = model('App\Models\UserEntityModel', false);
    }

    /**
     * - `UserEntityModel` 클래스는 열에 대한 속성을 설정하지 않았지만 여전히 공용 속성인 것처럼 열에 액세스 할 수 있다.
     * - 기본 클래스 `CodeIgniterEntity`는 데이터베이스에서 개체를 만들거나, 가져온 후 변경된 열을 추적하여 isset() 또는 unset() 으로 속성을 확인하는 기능을 제공한다.
     *
     * - `UserEntityModel`가 모델의 save() 메소드로 전달되면 자동으로 특성을 읽고 모델의 `$allowedFields` 속성에 나열된 열의 변경 사항을 저장한다.
     * - 또한 새 행을 만들거나 기존 행을 업데이트할지 여부도 알고 있다.
     *
     * @param array $resource : 유저 정보
     * @return void
     */
    public function save(array $resource)
    {
        if (isset($resource['id']) && !empty($resource['id'])) {
            // SELECT
            $user = $this->userEntityModel->find($resource['id']);

            // data view test
            echo $user->username;
            echo $user->email;

            // UPDATE
            unset($user->username);
            if (!isset($user->username)) {
                $user->username = $resource['username'];
            }
            $this->userEntityModel->save($user);
        } else {
            // INSERT
            $newUser = new UserEntity();
            $newUser->username = $resource['username'];
            $newUser->email = $resource['email'];
            $this->userEntityModel->save($newUser);
        }
    }

    /**
     * ====================================
     * 빠르게 속성 채우기
     *
     * - Entity 클래스는 키/값 쌍 배열을 클래스에 전달하여 클래스 속성을 채울 수 있는 fill() 메소드도 제공한다.
     * - 배열의 모든 속성은 Entity에 설정된다.
     * - 그러나 모델을 통해 저장할 때 `$allowedFields`에 명시된 필드만 실제 데이터베이스에 저장되므로 필드가 잘못 저장되는 것에 대해 걱정할 필요가 없다.
     * ====================================
     */
    public function fill()
    {
        $data = $this->request->getPost();

        $user = new UserEntity();
        $user->fill($data);
        $this->userEntityModel->save($user);

        // 생성자를 통하여 데이터를 전달할 수도 있으며, 인스턴스화 중에는 fill() 메소드를 통해 데이터를 전달한다.
        $user = new UserEntity($data);
        $this->userEntityModel->save($user);
    }

    /**
     * ===============================
     * 뮤테이터(Mutators)
     *
     * - 속성 중 하나가 설정되면 `app/Config/App.php`에 설정된 대로 어플리케이션의 현재 시간대를 사용하여 Time 인스턴스로 변환된다.
     * ===============================
     */
    public function mutators()
    {
        $user = new UserEntity();

        // Time 인스턴스로 Convert 된다.
        $user->created_at = 'April 15, 2017 10:30:00';

        // Time 에서 제공하는 메소드를 사용
        echo $user->created_at->humanize();
        echo $user->created_at->setTimezone('Europe/London')->toDateString;
    }
}