<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Entitiy를 통해서 수행하는 모델
 * - jobs 테이블의 데이터로 작동
 * - 모든 결과를 `App\Entities\JobEntity` 인스턴스로 반환한다.
 * - 해당 레코드를 데이터베이스에 유지해야 하는 경우, 사용자 정의 메소드를 작성하거나 모델의 save() 메소드를 사용하여 클래스를 검사하고 public과 private 특성을 가져와서 데이터베이스에 저장해야 한다.
 */
class JobModel extends Model
{
    protected $table = 'jobs';
    protected $returnType = '\App\Entities\JobEntity';
    protected $allowedFields = [
        'name', 'description'
    ];
}