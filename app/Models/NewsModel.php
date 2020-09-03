<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * `CodeIgniter/Model`을 확장하여 새 모델을 만들고 데이터베이스 라이브러리를 로드한다.
 *
 * - 이렇게 하면 `$this->db` 객체를 통해 데이터베이스 클래스를 사용할 수 있게 된다.
 *
 * - 데이터베이스 모델이 설정되었으므로 데이터베이스에서 모든 게시물을 가져올 방법이 필요하다.
 *     - 이를 위해 CodeIgniter에 포함된 데이터베이스 추상화 계층인 `Query Builder`를 사용한다.
 *     - 이를 통해 한 번 작성된 쿼리는 지원되는 모든 데이터베이스 시스템에서 작동할 수 있다.
 *     - Model 클래스를 사용하면 Query builder로 쉽게 작업할 수 있으며, 데이터 작업을 보다 간단하게 수행할 수 있는 추가 도구도 제공된다.
 *
 */
class NewsModel extends Model
{
    protected $table = 'news';

    // insert 및 update 메소드는 기본적으로 업데이트할 안전할 필드를 모르기 때문에 업데이트 가능한 필드 목록을 저장한다.
    protected $allowedFields = ['title', 'slug', 'body']; // `id`는 자동증가(auto-increment) 필드이기 때문에 생략된다.

    protected $validationRules = [
        'title' => 'required',
        'slug' => 'required',
        'body' => 'required'
    ];
}