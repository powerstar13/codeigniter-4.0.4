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
}