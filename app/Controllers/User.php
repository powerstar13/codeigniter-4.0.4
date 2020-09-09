<?php namespace App\Controllers;

use App\Libraries\UserLib;
use CodeIgniter\API\ResponseTrait;

Class User extends BaseController
{

    private $userLib;

    public function __construct()
    {
        parent::__construct();

        $this->userLib = new UserLib();
    }

    public function save()
    {
        // 페이지가 실제로 존재하는지 여부를 확인
        if (!is_file(APPPATH . '/Views/user/save.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('save'); // 기본 오류 페이지를 표시하는 예외처리
        }

        $resource = array(
            'username' => 'masterHong',
            'email' => 'powerstar13@hanmail.net'
        );
        $result = $this->userLib->save($resource);

        $data = array();
        if ($result['rt'] !== 200) {
            $data['errors'] = $result['errors'];
        }

        return view('user/save', $data);
    }

    /**
     * =============================
     * API Response Trait 사용샘플
     * =============================
     */
    use ResponseTrait;

    public function createUser()
    {
        $resource = array(
            'username' => 'masterHong',
            'email' => 'powerstar13@hanmail.net'
        );
        $result = $this->userLib->save($resource);

        // 이 예에서는 일반 상태 메시지 'Created'와 함께 HTTP 상태 코드 201이 반환된다.
        // 가장 일반적인 사용 사례에 대한 메소드이다.
        return $this->respondCreated($result);

        // 일반 응답 방법
        // $this->respond($data, 200);
        // 일반 고장 반응
        // $this->fail($errors, 400);
        // 항목 생성 반응
        // $this->respondCreated($data);
        // 항목이 성공적으로 삭제되었습니다
        // $this->respondDeleted($data);
        // 응답이 필요 없는 명령
        // $this->respondNoContent($message);
        // 고객은 허가받지 않았습니다
        // $this->failUnauthorized($description);
        // 금지된 행동
        // $this->failForbidden($description);
        // 리소스를 찾을 수 없습니다
        // $this->failNotFound($description);
        // 데이터가 유효하지 않았습니다
        // $this->failValidationError($description);
        // 리소스가 이미 존재합니다
        // $this->failResourceExists($description);
        // 이전에 삭제된 리소스
        // $this->failResourceGone($description);
        // 고객이 너무 많은 요청을 했습니다
        // $this->failTooManyRequests($description);
    }
}