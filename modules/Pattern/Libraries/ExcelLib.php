<?php namespace Modules\Pattern\Libraries;

// Read
use Box\Spout\Reader\ReaderFactory;
// Write
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\CellHorizontalAlignment;
use Box\Spout\Writer\Style\CellVerticalAlignment;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;

class ExcelLib
{
    /**
     * ==========================
     * Excel Read
     * ==========================
     */
    public function readXlsx(string $filePath)
    {
        $reader = ReaderFactory::create(Type::XLSX);
        // $reader->setShouldPreserveEmptyRows(true); // 비어있는 row도 가져오려면 TRUE
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                debug($row, '[Sheet' . ($sheet->getIndex() + 1) . "] {$sheet->getName()} --> Row{$rowIndex}");
            }
        }

        $reader->close();
    }

    /**
     * ==========================================
     * Excel Write Custom Template
     * ==========================================
     */

    /**
     * 테두리 설정
     *
     * @param string $direction : 적용 영역
     *     - top, right, bottom, left : 한 면만 할 경우
     *     - bothTopRight, bothTopBottom, bothTopLeft, bothRightBottom, bothRightLeft, bothBottomLeft : 두 면만 할 경우
     *     - excludeTop, excludeRight, excludeBottom, excludeLeft : 한 면을 제외한 나머지 면을 할 경우
     *     - all (Another default) : 모든 면을 할 경우
     * @param string $color : 테두리 색
     * @param string $width : 테두리 두께
     * @param string $style : 테두리 유형
     * @return Border
     */
    public function border(
        string $direction = 'all',
        string $color = Color::BLACK,
        string $width = Border::WIDTH_THIN,
        string $style = Border::STYLE_SOLID
    ) {
        $border = new BorderBuilder();

        switch ($direction) {
            case Border::TOP:
                $border->setBorderTop($color, $width, $style);
                break;
            case Border::RIGHT:
                $border->setBorderRight($color, $width, $style);
                break;
            case Border::BOTTOM:
                $border->setBorderBottom($color, $width, $style);
                break;
            case Border::LEFT:
                $border->setBorderLeft($color, $width, $style);
                break;
            case 'both' . ucfirst(Border::TOP) . ucfirst(Border::RIGHT):
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderRight($color, $width, $style);
                break;
            case 'both' . ucfirst(Border::TOP) . ucfirst(Border::BOTTOM):
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderBottom($color, $width, $style);
                break;
            case 'both' . ucfirst(Border::TOP) . ucfirst(Border::LEFT):
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
            case 'both' . ucfirst(Border::RIGHT) . ucfirst(Border::BOTTOM):
                $border
                    ->setBorderRight($color, $width, $style)
                    ->setBorderBottom($color, $width, $style);
                break;
            case 'both' . ucfirst(Border::RIGHT) . ucfirst(Border::LEFT):
                $border
                    ->setBorderRight($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
            case 'both' . ucfirst(Border::BOTTOM) . ucfirst(Border::LEFT):
                $border
                    ->setBorderBottom($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
            case 'exclude' . ucfirst(Border::TOP):
                $border
                    ->setBorderRight($color, $width, $style)
                    ->setBorderBottom($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
            case 'exclude' . ucfirst(Border::RIGHT):
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderBottom($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
            case 'exclude' . ucfirst(Border::BOTTOM):
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderRight($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
            case 'exclude' . ucfirst(Border::LEFT):
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderRight($color, $width, $style)
                    ->setBorderBottom($color, $width, $style);
                break;
            default:
                $border
                    ->setBorderTop($color, $width, $style)
                    ->setBorderRight($color, $width, $style)
                    ->setBorderBottom($color, $width, $style)
                    ->setBorderLeft($color, $width, $style);
                break;
        }

        return $border->build();
    }

    /**
     * 서식 스타일 설정
     *
     * @param boolean $fontBold : 글자 두껍게 사용 여부
     * @param integer $fontSize : 글자 크기
     * @param string $fontColor : 글자 색
     * @param string $fontName : 글꼴
     * @param string $backgroundColor : 배경 색
     * @param string $borderDirection : 테두리 방향
     * @param string $borderColor : 테두리 색
     * @param string $borderWidth : 테두리 두께
     * @param string $borderStyle : 테두리 유형
     * @param string $cellHorizontalAlign : 좌우 정렬
     * @param string $cellVerticalAlign : 상하 정렬
     * @return Style
     */
    public function style(
        bool $fontBold = FALSE,
        int $fontSize = 15,
        string $fontColor = Color::BLACK,
        string $fontName = '맑은 고딕',
        string $backgroundColor = Color::WHITE,
        string $borderDirection = 'all',
        string $borderColor = Color::BLACK,
        string $borderWidth = Border::WIDTH_THIN,
        string $borderStyle = Border::STYLE_SOLID,
        string $cellHorizontalAlign = CellHorizontalAlignment::CENTER,
        string $cellVerticalAlign = CellVerticalAlignment::CENTER
    ) {
        $style = new StyleBuilder();

        $border = $this->border($borderDirection, $borderColor, $borderWidth, $borderStyle);
        $style->setBorder($border);

        if ($fontBold) {
            $style->setFontBold();
        }

        return $style->setFontSize($fontSize)
            ->setFontColor($fontColor)
            ->setFontName($fontName)
            ->setBackgroundColor($backgroundColor)
            ->setCellHorizontalAlignment($cellHorizontalAlign)
            ->setCellVerticalAlignment($cellVerticalAlign)
            ->build();
    }

    /**
     * 템플릿
     *
     * @param string $fileName : 파일명
     * @param array $data : 엑셀 데이터 (2차 연관배열)
     * @return file 엑셀 파일
     */
    public function template($fileName = 'test', $data = array())
    {
        /**
         * (1) 문서 속성 지정
         * --> 불필요한 항목 생략 가능
         */
        $headStyle = $this->style(
            TRUE, 11, Color::BLACK, '맑은 고딕', // font
            Color::YELLOW, // background
            'all', Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID, // border
            CellHorizontalAlignment::CENTER, CellVerticalAlignment::CENTER // align
        );

        $rowStyle = $this->style(
            FALSE, 11, Color::BLACK, '맑은 고딕', // font
            Color::WHITE, // background
            'all', Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID, // border
            CellHorizontalAlignment::CENTER, CellVerticalAlignment::CENTER // align
        );

        // Excel Write
        $saveFileName = sprintf('%s_%s.xlsx', $fileName, date('YmdHi'));
        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToBrowser($saveFileName);

        // sheet1
        $writer->getCurrentSheet()->setName($fileName);
        $writer->addRow(['']);
        $writer->addRowsWithStyle($data['head'], $headStyle);
        $writer->mergeCells($fileName, 'A2', 'A3'); // '구분' VericalMerge(2)
        $writer->mergeCells($fileName, 'B3', 'F3'); // '서울' HorizontalMerge(5)
        $writer->colWidths($fileName, '1', '1', 9); // '구분' 너비
        $writer->colWidths($fileName, '3', '3', 24); // '학교' 너비
        $writer->colWidths($fileName, '7', '7', 15); // '이름' 너비
        $writer->colWidths($fileName, '8', '10', 31); // '만족도1, 만족도2, 합계 평균' 너비
        $writer->addRowsWithStyle($data['body'], $rowStyle);

        // $writer->addNewSheetAndMakeItCurrent(); // sheet2 필요할 경우 추가 (적용은 sheet1 루틴과 동일)

        $writer->close();
        exit;
    }
}