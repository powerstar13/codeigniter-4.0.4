<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * 파일 업로드 수행을 위한 컨트롤러
 */
class Ex08Upload extends BaseController
{
    private $uploadConfig;

    public function __construct()
    {
        parent::__construct();

        // 커스텀 환경설정 파일 읽기 (경로를 포함한 파일명을 파라미터로 설정)
        $this->uploadConfig = (array) config('Modules\Pattern\Config\Upload');
        helper('html');
    }

    public function index()
    {
        return default_layout('Modules\Pattern\Views\Ex08\index');
    }

    public function result()
    {
        $file = $this->request->getFile('photo');

        if (!$file->isValid()) {
            // throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            debug(($file->getErrorString() . '(' . $file->getError() . ')'));
            return false;
        }

        /**
         * (1) 업로드 설정
         */
        $uploadPath = $this->uploadConfig['uploadPath'];
        // 업로드 환경설정 정보에서 필요한 정보만 추출
        if (!is_dir($uploadPath)) {
            // 파일이 업로드 될 폴더가 존재하지 않는다면 생성한다.
            mkdir($uploadPath, 0766, TRUE); // 경로, 퍼미션, 하위폴더 생성 여부 설정
        }

        /**
         * (2) 업로드 수행 및 결과 처리
         */
        $newName = $file->getRandomName();
        $path = $file->move($uploadPath, $newName);

        if ($path) {
            $imageProperties = [
                'src'    => base_url($this->uploadConfig['viewPath'] . $newName),
                'width'  => '300',
                'title'  => '업로드된 이미지',
            ];
            echo img($imageProperties);
        } else {
            debug('업로드 실패...', 'File store');
        }
    }
}