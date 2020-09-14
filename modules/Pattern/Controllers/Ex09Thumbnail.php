<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * 썸네일 생성을 위한 컨트롤러
 */
class Ex09Thumbnail extends BaseController
{
    private $uploadConfig;
    private $thumbConfig;
    private $image;

    public function __construct()
    {
        parent::__construct();

        // 커스텀 환경설정 파일 읽기 (경로를 포함한 파일명을 파라미터로 설정)
        $this->uploadConfig = (array) config('Modules\Pattern\Config\Upload');
        $this->thumbConfig = (array) config('Modules\Pattern\Config\Thumbnail');
        $this->image = service('image');
        helper(['html', 'filesystem']);
    }

    public function index()
    {
        // 썸네일이 생성될 폴더가 없다면 생성한다.
        if (!is_dir($this->thumbConfig['thumbPath'])) {
            mkdir($this->thumbConfig['thumbPath'], 0777, true);
            chmod($this->thumbConfig['thumbPath'], 0777);
        }

        // 업로드 파일이 저장되어 있는 디렉토리 경로만 추출
        $dir = $this->uploadConfig['uploadPath'];

        // 디렉토리의 파일 이름들을 배열로 추출한다.
        $files = get_filenames($dir); // filesystem 라이브러리의 기능을 활용하여 업로드 폴더 내의 파일이름들을 배열로 받는다.
        debug($files);

        /**
         * 썸네일 이미지 생성을 위한 처리 절차
         *
         * - 업로드 폴더 내의 파일 수 만큼 반복 처리한다.
         */
        foreach ($files as $key => $item) {
            /** (1) 설정정보에 원본파일 경로 추가 */
            $this->thumbConfig['sourceImage'] = "{$dir}/{$item}";

            /** (2) 생성될 경로를 조합 */
            $p = strrpos($item, '.');
            $filename = substr($item, 0, $p);
            $extname = substr($item, $p);
            // 경로조합 --> 저장될 폴더 + 파일이름 + 파일명 뒤에 붙을 지시자 + 확장자
            $thumbFileName = $filename . $this->thumbConfig['thumbMarker'] . $extname;
            $thumb = $this->thumbConfig['thumbPath'] . $thumbFileName;
            $imageSrc = $this->thumbConfig['viewPath'] . $thumbFileName;

            /** (3) 파일의 존재여부를 확인하여 썸네일 생성 */
            // 같은 이름의 썸네일 파일이 존재하지 않을 경우만 생성
            if (!file_exists($thumb)) {
                // 설정 정보를 라이브러리에 로드
                try {
                    $this->image
                        ->withFile($dir . $item)
                        ->resize($this->thumbConfig['width'], $this->thumbConfig['height'], true, 'height')
                        ->save($thumb);
                } catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                    debug($e->getMessage(), 'Image Exception');
                    continue;
                }
            }

            /** (4) 이미지파일 표시하기 */
            echo '<p>' . img(base_url($imageSrc)) . '</p>';
        }
    }
}