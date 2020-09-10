<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

/**
 * 메일 설정 정보와 메일 발송 라이브러리를 로드하는 컨트롤러
 */
class Ex04Email extends BaseController
{
    use ResponseTrait;

    private $emailLib;

    public function __construct()
    {
        parent::__construct();
        $this->emailLib = service('emailLib'); // 이메일 라이브러리 로드
    }

    /**
     * 회원가입 인증메일 발송
     *
     * @param GET email : 수신자 주소
     * @return JSON : 결과값
     */
    public function joinMailSend()
    {
        $receiverAddr = $this->request->getGet('email'); // 수신자 주소

        $emailCheck = $this->emailLib->emailCheck($receiverAddr); // 이메일 유효성 검사
        if ($emailCheck['rt'] !== 200) {
            return $this->respond($emailCheck);
        }

        $subject = '회원가입 인증메일입니다.'; // 메일제목
        $content = $this->emailLib->joinTemplate($receiverAddr); // 메일 내용

        $sendResult = $this->emailLib->sendmail($receiverAddr, $subject, $content); // 이메일 발송 처리
        return $this->respond($sendResult);
    }
}