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
