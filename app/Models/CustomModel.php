<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

/**
 * 사용자 정의 모델 만들기
 *
 * - DB에 연결되어 있다면 어플리케이션에 대한 모델을 작성하기 위해 특수한 클래스를 확장하지 않아도 된다.
 * - DB 연결을 통해 CodeIgniter의 모델이 제공하는 기능을 무시하고 사용자가 원하는 방법으로 모델을 만들 수 있다.
 */
class CustomModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db =& $db;
    }
}