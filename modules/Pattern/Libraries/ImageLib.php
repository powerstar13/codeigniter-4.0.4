<?php namespace Modules\Pattern\Libraries;

/**
 * 이미지 조작 클래스
 */
class ImageLib
{
    private $image;
    private $imagick;

    public function __construct()
    {
        // CI의 다른 클래스와 마찬가지로 이미지 클래스는 Services 클래스를 호출하여 컨트롤러에서 초기화된다.
        $this->image = service('image');
        // 사용하려는 이미지 라이브러리의 별명을 서비스 기능으로 전달할 수 있다.
        $this->imagick = service('image', 'imagick');

        /**
         * ImageMagick 라이브러리를 사용하는 경우 `app/Config/Images.php`에서 서버의 라이브러리 경로를 설정해야 한다.
         * Note : ImageMagick 핸들러는 서버에 imagick 확장을 로드할 필요가 없다.
         * 스크립트가 라이브러리에 액세스하고 서버에서 `exec()`를 실행할 수 있다면 작동한다.
         */
    }

    /**
     * 이미지 처리
     *
     * - 수행하려는 처리 유형(크기 조정, 자르기, 회전 또는 워터 마킹)에 관계없이 일반적인 프로세스는 동일하다.
     * - 수행하려는 작업에 해당하는 일부 환경설정을 설정한 후, 사용 가능한 처리 기능 중 하나를 호출하십시오.
     * - 예를 들어 이미지 썸네일을 만들려면 다음을 수행하십시오.
     *
     * @return void
     */
    public function fitSave()
    {
        $this->image
            ->withFile('/path/to/image/mypic.jpg')
            ->fit(100, 100, 'center')
            ->save('/path/to/image/mypic_thumb.jpg');

        // 위의 코드는 라이브러리의 `source_image` 폴더에 있는 mypic.jpg 라는 이미지를 찾은 다음 `GD2 image_library`를 사용하여 `100x100` 픽세인 새 이미지를 작성하여 새 파일(썸네일)로 저장하도록 지시한다.
        // `fit()` 메소드를 사용하므로 원하는 종횡비를 기준으로 자르기 위해 이미지에서 가장 좋은 부분을 찾은 다음 이미지를 자르고 크기를 조정한다.
    }

    /**
     * - 저장하기 전에 필요한만큼 사용 가능한 메소드를 통해 이미지를 처리할 수 있다.
     * - 원본 이미지는 그대로 유지되며, 새로 작성된 이미지는 각 메소드를 통과하여 이전 결과 위에 새로운 결과가 적용된다.
     *
     * @return void
     */
    public function chainMethod()
    {
        $this->image
            ->withFile('/path/to/image/mypic.jpg')
            ->reorient()
            ->rotate(90)
            ->crop(100, 100, 0, 0)
            ->save('/path/to/image/mypic_thumb.jpg');

        // 이 예에서는 동일한 이미지를 가져와 먼저 휴대폰 방향 문제를 해결하고, 이미지를 90도 회전 한 다음, 결과를 왼쪽 상단에서 `100x100픽셀` 이미지로 자른다.
        // 결과는 썸네일로 저장된다.
    }

    /**
     * ==================================
     * 이미지 품질
     * ==================================
     */

    /**
     * - `save()`는 두 번째 매개 변수 `$quality`를 사용하여 결과 이미지 품질을 변경할 수 있다.
     * - 값의 범위는 `0-100`이며 프레임 워크 기본값은 `90`이다.
     * - 이 매개 변수는 JPEG 이미지에만 적용된다.
     *
     * @return void
     */
    public function quality()
    {
        $this->image
            ->withFile('/path/to/image/mypic.jpg')
            ->save('/path/to/image/my_low_quality_pic.jpg', 10); // processing methods

        // Note : 품질이 높을수록 파일 크기가 커진다.
    }

    /**
     * 이미지 리소스를 포함하지 않고, 이미지 품질을 변경하면 원본과 같은 사본이 생성된다.
     *
     * @return void
     */
    public function withResource()
    {
        $this->image
            ->withFile('/path/to/image/mypic.jpg')
            ->withResource()
            ->save('/path/to/image/my_low_quality_pic.jpg', 10);
    }

    /**
     * ==================================
     * 처리 메소드
     *
     * - crop()
     * - convert()
     * - fit()
     * - flatten()
     * - flip()
     * - resize()
     * - rotate()
     * - text()
     *
     * - 이러한 메소드는 클래스 인스턴스를 리턴하여 위에 표시된대로 서로 체인화 될 수 있다.
     * - 실패하면 오류 메시지가 포함된 `CodeIgniter\Images\Exceptions\ImageException`이 발생한다.
     * ==================================
     */

    // 다음과 같이 실패 시, 오류를 포함하여 예외를 포착하는 것이 좋다.
    public function except()
    {
        try {
            $this->image
                ->withFile('/path/to/image/mypic.jpg')
                ->fit(100, 100, 'center')
                ->save('/path/to/image/mypic_thumb.jpg');
        } catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 이미지 자르기
     *
     * - 원본 이미지의 일부만 남아 있도록 이미지를 자를 수 있다.
     * - 특정 크기/종횡비와 일치하는 축소판 이미지를 만들 때 자주 사용된다.
     * - 이것은 `crop()` 메소드로 처리된다.
     *
     * @param integer $width : 결과 이미지의 원하는 너비(픽셀)
     * @param integer $height : 결과 이미지의 원하는 높이(픽셀)
     * @param integer $x : 이미지의 왼쪽부터 자르기를 시작할 픽셀 수
     * @param integer $y : 이미지 상단부터 자르기 시작 픽셀 수
     * @param boolean $maintainRatio : `TRUE`인 경우, 이미지의 원래 종횡비를 유지하기 위해 필요에 따라 최종 크기를 조정
     * @param string $masterDim : `$maintainRatio`가 `TRUE`일 때, 어떤 치수를 그대로 두어야 하는지 지정한다.
     *     - 사용 가능 값 : 'weight', 'height', 'auto'
     * @return void
     */
    public function crop(int $width = null, int $height = null, int $x = null, int $y = null, bool $maintainRatio = false, string $masterDim = 'auto')
    {
        // 이미지 중심에서 `50x50` 픽셀 정사각형을 가져 오려면, 먼저 적절한 x와 y오프셋 값을 계산해야 한다.
        $info = $this->imagick
            ->withFile('/path/to/image/mypic.jpg')
            ->getFile()
            ->getProperties(true);

            $xOffset = ($info['width'] / 2) - 25;
            $yOffset = ($info['heght'] / 2) - 25;

        $this->imagick
            ->withFile('/path/to/image/mypic.jpg')
            ->crop(50, 50, $xOffset, $yOffset)
            ->save('/path/to/new/image.jpg');
    }

    /**
     * 이미지 변환
     *
     * - `convert()` 메소드는 원하는 파일 형식에 대한 라이브러리의 내부 표시기를 변경한다.
     * - 이것은 실제 이미지 리소스를 건드리지 않지만 사용할 형식을 `save()`로 나타낸다.
     *
     * @param integer $imageType : PHP의 이미지 유형 상수 중 하나
     *     - https://www.php.net/manual/en/function.image-type-to-mime-type.php
     * @return void
     */
    public function convert(int $imageType)
    {
        $this->image
            ->withFile('/path/to/image/mypic.jpg')
            ->convert(IMAGETYPE_PNG)
            ->save('/path/to/new/image.jpg');

        // Note : `ImageMagick`은 `$imageType`을 무시하고 확장자로 표시된 형식의 파일을 저장한다.
    }

    /**
     * 이미지 피팅
     *
     * - `fit()` 메소드는 다음 단계를 수행하여 이미지의 일부를 "똑똑한" 방식으로 자르는 것을 단순화 하는데 도움을 준다.
     *     - 원하는 종횡비를 유지하기 위해 원본 이미지의 잘라낼 부분 결정
     *     - 원본 이미지 자름
     *     - 최종 치수로 크기 조정
     *
     * @param integer $width : 이미지의 원하는 최종 너비
     * @param integer $height : 이미지의 원하는 최종 높이
     * @param string $position : 잘라낼 이미지 부분 결정.
     *     - 사용가능 위치 : 'top-left', 'top', 'top-right', 'left', 'center', 'right', 'bottom-left', 'bottom', 'bottom-right'
     * @return void
     */
    public function fit(int $width, int $height = null, string $position = 'center')
    {
        // 종횡비를 항상 유지하는 간단한 자르기 방법을 제공합니다.
        $this->imagick
            ->withFile('/path/to/image/mypic.jpg')
            ->fit(100, 150, 'left')
            ->save('/path/to/new/image.jpg');
    }

    /**
     * 이미지 병합
     *
     * - `flatten()` 메소드는 투명한 이미지(PNG) 뒤에 배경색을 추가하고, RGBA 픽셀을 RGV 픽셀로 변환하는 것을 목표로 한다.
     *     - 투명 이미지에서 jpg로 변환할 때 배경색을 지정하십시오.
     *
     * @param integer $red : 배경의 빨간색 값
     * @param integer $green : 배경의 녹색 값
     * @param integer $blue : 배경의 파란색 값
     * @return void
     */
    public function flatten(int $red = 255, int $green = 255, int $blue = 255)
    {
        $this->imagick
            ->withFile('/path/to/image/mypic.png')
            ->flatten()
            ->save('/path/to/new/image.jpg');

        $this->imagick
            ->withFile('/path/to/image/mypic.png')
            ->flatten(25,25,112)
            ->save('/path/to/new/image.jpg');
    }

    /**
     * 이미지 뒤집기
     *
     * - 수평 또는 수직 축을 따라 이미지를 뒤집을 수 있다.
     *
     * @param string $dir : 뒤집을 축을 지정
     *     - 사용 가능 값 : 'vertical', 'horizontal'
     * @return void
     */
    public function flip(string $dir)
    {
        $this->imagick
            ->withFile('/path/to/image/mypic.jpg')
            ->flip('horizontal')
            ->save('/path/to/new/image.jpg');
    }

    /**
     * 이미지 크기 조정
     *
     * - `resize()` 메소드는 필요한 모든 크기에 맞게 이미지 크기를 조정할 수 있다.
     *
     * @param integer $width : 새 이미지의 원하는 너비 (픽셀)
     * @param integer $height : 새 이미지의 원하는 높이 (픽셀)
     * @param boolean $maintainRatio : 이미지를 새로운 크기에 맞게 늘릴지, 원래 종횡비를 유지할지 결정
     * @param string $masterDim : 비율을 유지할 때, 어떤 축의 치수를 준수해야 하는지 지정
     *     - 사용 가능 값 : 'width', 'height'
     * @return void
     */
    public function resize(int $width, int $height, bool $maintainRatio = false, string $masterDim = 'auto')
    {
        /**
         * 이미지 크기를 조정할 때, 원본 이미지의 비율을 유지하거나, 원하는 크기에 맞게 새 이미지를 늘리거나 여부를 선택할 수 있다.
         * - `$maintainRatio`가 `true`이면 `$masterDim`에 의해 지정된 치수는 그대로 유지되고, 다른 치수는 원래 이미지의 종횡비와 일치하도록 변경된다.
         */
        $this->imagick
            ->withFile('/path/to/image/mypic.jpg')
            ->resize(200, 100, true, 'height')
            ->save('/path/to/new/image.jpg');
    }

    /**
     * 이미지 회전
     *
     * - `rotate()` 메소드를 사용하면 이미지를 90도씩 회전할 수 있다.
     *
     * @param float $angle : 회전 각도
     *     - 사용 가능 값 : '90', '180', '270'
     * @return void
     */
    public function rotate(float $angle)
    {
        $this->image
            ->withFile('/path/to/image/mypic.jpg')
            ->rotate(90)
            ->save('/path/to/image/mypic_thumb.jpg');

        // Note : `$angle` 매개 변수는 부동 소수점(float)을 허용하지만 프로세스 중 정수로 변환한다.
        // --> 값이 위에 나열된 세 값 이외의 값이면 `CodeIgniter\Images\ImageException`이 발생한다.
    }

    /**
     * 텍스트 워터 마크 추가
     *
     * - `text()` 메소드를 사용하여 텍스트 워터 마크를 이미지에 오버레이할 수 있다.
     * - 이 기능은 저작권, 작가 이름을 표시하여 다른 사람의 제품에 사용되지 않도록 하는데 유용하다.
     *
     * @param string $text : 표시하려는 텍스트 문자열
     * @param array $options : 텍스트 표시 방법을 지정하는 옵션 배열
     *     - 사용 가능한 옵션
     *         - color : 텍스트 색상 (16진수) ex) '#ff0000'
     *         - opacity : 텍스트의 불투명도를 나타내는 `0과 1` 사이의 숫자
     *         - withShadow : 그림자를 표시할지 여부 (bool)
     *         - shadowColor : 그림자의 색 (16진수)
     *         - shadowOffset : 그림자를 오프셋 할 픽셀 수. 수직 및 수평 값 모두에 적용
     *         - hAlign : 수평 정렬 --> 'left', 'center', 'right'
     *         - vAlign : 수직 정렬 --> 'top', 'middle', 'bottom'
     *         - hOffset : x 축에 대한 추가 오프셋 (픽셀)
     *         - vOffset : y 축에 대한 추가 오프셋 (픽셀)
     *         - fontPath : 사용하려는 TTF 글꼴의 전체 서버 경로. 지정된 글꼴이 없으면 시스템 글꼴이 사용된다.
     *         - fontSize: 사용할 글꼴 크기. 시스템 글꼴과 함께 GD 핸들러를 사용할 때 유효한 값은 `1-5`이다.
     * @return void
     */
    public function text(string $text, array $options = [])
    {
        $this->imagick
            ->withFile('/path/to/image/mypic.jpg')
            ->text('Copyright 2017 My Photo Co', [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => true,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 20
            ])
            ->save('/path/to/new/image.jpg');

        // Note : ImageMagick 드라이버는 `fontPath`의 전체 서버 경로를 인식하지 못한다.
        // --> 설치된 시스템 글꼴 중 하나 (예: Calibri)의 이름을 제공하십시오.
    }
}