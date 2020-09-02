<?php namespace App\Models;

use CodeIgniter\Model;

class UserEntityModel extends Model
{
    protected $table = 'user_entity';
    // 클래스 외부에서 변경하려는 모든 필드를 포함하도록 설정
    // `id`, `created_at`, `updated_at` 필드는 클래스 또는 데이터베이스에서 자동으로 처리되므로 변경하지 않는다.
    protected $allowedFields = [
        'username', 'email', 'password'
    ];
    // 데이터베이스에서 행을 반환하는 모델의 모든 메소드가 일반 객체나 배열 대신 User Entity 클래스의 인스턴스를 반환한다.
    protected $returnType = 'App\Entities\UserEntity';
    protected $useTimestamps = true;
}