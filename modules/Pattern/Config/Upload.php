<?php namespace Modules\Study\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * 업로드를 처리하기 위해 CI가 요구하는 설정값들을 정의
 */
class Upload extends BaseConfig
{
    // 업로드 파일 저장 경로
    public $uploadPath;
    // 업로드 허용 확장자
    public $allowedTypes = 'gif|jpg|png';
    // 확장자는 소문자로 저장
    public $fileExtToLower = TRUE;
    // 파일 덮어쓰기 방지
    public $overwrite = FALSE;
    // 암호화된 파일명 사용
    public $encryptName = TRUE;

    // 이 설정값들을 초과하는 파일은 업로드 되지 않는다.
    // --> 사용하지 않는 것을 권장함
    // public $maxSize = 100;
    // public $maxWidth = 1024;
    // public $maxHeight = 768;

    public $viewPath; // `/public/index.php` 파일 경로 기준

    public function __construct()
    {
        $this->viewPath = 'uploads/' . date('Ymd') . '/';
        $this->uploadPath = FCPATH . "/{$this->viewPath}";
    }
}