<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * Excel 처리 컨트롤러
 */
class Ex10Excel extends BaseController
{
    private $excel;

    public function __construct()
    {
        parent::__construct();

        $this->excel = service('excelLib');
    }

    public function index()
    {
        return default_layout('Modules\Pattern\Views\Ex10\index');
    }

    /**
     * 업로드된 파일에서 데이터를 추출
     *
     * @return void
     */
    public function read()
    {
        $file = $this->request->getFile('excel');

        if (!$file->isValid()) {
            return debug(($file->getErrorString() . '(' . $file->getError() . ')'));
        } else if($file->guessExtension() !== 'xlsx') {
            return debug('업로드 가능한 엑셀 확장자는 xlsx 입니다.');
        }

        $this->excel->readXlsx($file->getTempName());
    }

    /**
     * 데이터를 엑셀 파일로 생성하여 다운로드
     *
     * @return void
     */
    public function download()
    {
        /**
         * (1) 엑셀로 사용할 데이터 (2차 연관배열)
         */
        $data = array(
            'head' => array(
                array('구분', '지역', '학교', '학년', '반', '반호', '이름', '만족도1(5점만점)', '만족도2(5점만점)', '전체 만족도'),
                array('', '서울', '', '', '', '', '00명(참여자수)', '수식: 만족도1의 전체 합계 평균', '수식: 만족도2의 전체 합계 평균', '수식: 만족도 1과 2의 합계 평균'),
            ), // 정해진 주제 나열
            'body' => array(
                array('1', '서울시', '서울초등학교', '5', '2', '1', '홍준성', '3.0', '5.0', '4.00'),
                array('2', '서울시', '강남초등학교', '6', '5', '3', 'MasterHong', '4.5', '5.0', '4.75')
            ) // TODO: DB data 조회하여 처리
        );

        $this->excel->template(sprintf('%s년도 Custom', date('Y')), $data);
    }
}