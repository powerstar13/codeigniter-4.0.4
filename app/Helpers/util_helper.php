<?php

/**
 * ======================================
 * 유용하게 사용할 헬퍼 함수 정의
 * ======================================
 */

if (! function_exists('debug'))
{
    /**
     * 데이터 출력
     *
     * - 각 변수, 배열, 객체들의 데이터를 확인하기 위해 print_r() 함수를 사용할 일이 빈번하다.
     * - 하지만 print_r() 함수는 HTML의 `<pre>` 태그와 함께 사용해야만 브라우저에서 내용을 확인하는데 있어 용이하기 때문에, 이 과정을 하나의 함수로 묶어 처리하도록 하면, 앞으로의 결과 확인에 도움이 된다.
     *
     * @param mixed $msg
     * @param string $title
     * @return string html
     */
	function debug($msg, string $title = 'debug')
	{
        $content = print_r($msg, true); // 전달된 내용을 출력형식으로 변환

        echo "
            <div class='debug'>
                <fieldset style='padding: 15px; margin: 10px; border: 1px solid #bce8f1; border-radius: 4px; color: #31708f; background-color: #d9edf7; word-break: break-all; font-size: 12px; font-family: D2Coding,NanumGothicCoding,나눔고딕코딩,Helvetica,굴림'>
                    <legend style='padding: 2px 15px; border: 1px solid #bce8f1; background-color: #fff; font-weight: bold'>"
                        . $title .
                    "</legend>
                    <pre style='margin: 0px; padding: 0; border:0; background: none; white-space: pre-wrap;'>"
                        . htmlspecialchars($content) .
                    "</pre>
                </fieldset>
            </div>
        ";
	}
}

// ------------------------------------------------------------------------

if (! function_exists('getPageInfo'))
{
    /**
     * 페이지 구현에 필요한 변수값들을 계산한다.
     * @param integer $totalCount - 페이지 계산의 대상이 되는 전체 데이터 수
     * @param integer $nowPage    - 현재 페이지
     * @param integer $listCount  - 한 페이지에 보여질 목록의 수
     * @param integer $groupCount - 페이지 그룹 수
     * @return array $data : 모든 결과값
     *                  - nowPage    : 현재 페이지
     *                  - totalCount : 전체 데이터 수
     *                  - listCount  : 한 페이지에 보여질 목록의 수
     *                  - totalPage  : 전체 페이지 수
     *                  - groupCount : 한 페이지에 보여질 그룹의 수
     *                  - totalGroup : 전체 그룹 수
     *                  - nowGroup   : 현재 페이지가 속해 있는 그룹 번호
     *                  - group_start : 현재 그룹의 시작 페이지
     *                  - groupEnd   : 현재 그룹의 마지막 페이지
     *                  - prevGroupLastPage  : 이전 그룹의 마지막 페이지
     *                  - nextGroupFirstPage : 다음 그룹의 시작 페이지
     *                  - offset      : SQL의 Limit절에서 사용할 데이터 시작 위치
     *
     * View에서 Row number 계산하기
     * 1. 내림차순 : totalCount - offset - index
     * 2. 오름차순 : offset + 1 + index
     */
	function getPageInfo(int $totalCount, int $nowPage = 1, int $listCount = 15, int $groupCount = 5) : array
	{
        /** ===== 계산 ===== */
        // 전체 페이지 수
        $totalPage = intval(($totalCount - 1) / $listCount) + 1;

        // 전체 그룹 수
        $totalGroup = intval(($totalPage - 1) / $groupCount) + 1;

        // 현재 페이지가 속한 그룹
        $nowGroup = intval(($nowPage - 1) / $groupCount) + 1;

        // 현재 그룹의 시작 페이지 번호
        $groupStart = intval(($nowGroup - 1) * $groupCount) + 1;

        // 현재 그룹의 마지막 페이지 번호
        $groupEnd = min($totalPage, $nowGroup * $groupCount);

        // 이전 그룹의 마지막 페이지 번호
        $prevGroupLastPage = 0;
        if ($groupStart > $groupCount) $prevGroupLastPage = $groupStart - 1;

        // 다음 그룹의 시작 페이지 번호
        $nextGroupFirstPage = 0;
        if ($groupEnd < $totalPage) $nextGroupFirstPage = $groupEnd + 1;

        // Limit 절에서 사용할 데이터 시작 위치
        $offset = ($nowPage - 1) * $listCount;

        // 리턴할 데이터들을 배열로 묶기
        $data = array(
            'nowPage' => $nowPage,
            'totalCount' => $totalCount,
            'listCount' => $listCount,
            'totalPage' => $totalPage,
            'groupCount' => $groupCount,
            'totalGroup' => $totalGroup,
            'nowGroup' => $nowGroup,
            'groupStart' => $groupStart,
            'groupEnd' => $groupEnd,
            'prevGroupLastPage' => $prevGroupLastPage,
            'nextGroupFirstPage' => $nextGroupFirstPage,
            'offset' => $offset
        );

        return $data;
	}
}

// ------------------------------------------------------------------------