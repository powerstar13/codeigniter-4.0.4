<?php namespace Modules\Pattern\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * 썸네일 생성에 필요한 설정 정보들을 정의
 */
class Thumbnail extends BaseConfig
{
    // 사용되는 PHP의 내부 모듈 이름 (값 고정)
    public $imageLibrary = 'gd';
    // 썸네일 이미지 생성 여부 (값 고정)
    public $createThumb = TRUE;
    // 이미지 축소 시, 해상도 비율 유지 여부 (값 고정)
    public $maintainRatio = TRUE;
    // 썸네일이 저장될 경로
    public $thumbPath;
    // 축소될 이미지 넓이 (컨트롤러에서 변경 가능)
    public $width = 320;
    // 축소될 이미지 높이 (컨트롤러에서 변경 가능)
    public $height = 320;
    // 원본 파일의 경로 (컨트롤러에서 값을 할당해야 한다.)
    public $sourceImage = '';
    // 썸네일 이미지 파일명 뒤에 붙을 지시자 (컨트롤러에서 변경 가능)
    public $thumbMarker = '_thumb';

    public $viewPath;

    public function __construct()
    {
        $this->viewPath = 'assets/images/thumbs/' . date('Ymd') . '/';
        $this->thumbPath = FCPATH . $this->viewPath;
    }
}