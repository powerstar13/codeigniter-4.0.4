<?php namespace Modules\Pattern\Libraries;

/**
 * 라이브러리 작성 방법을 파악하기 위한 클래스 정의하기
 */
class HelloWorld
{
    /** 한국어 메시지 출력 */
    public function sayKor()
    {
        echo '<p>안녕하세요 코드이그나이터</p>';
    }

    /** 영어 메시지 출력 */
    public function sayEng()
    {
        echo '<p>Hello CodeIginter</p>';
    }

}