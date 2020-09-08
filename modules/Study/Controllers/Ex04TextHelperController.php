<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * text_helper 기능 살펴보기
 */
class Ex04TextHelperController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();

        // helper 로드
        helper(['text', 'util']);
    }

    /**
     * ==============================
     * 랜덤 문자열 생성하기
     * ==============================
     */

    /**
     * 임시 비밀번호, 인증번호 문자열 생성하기
     *
     * - 지정된 타입과 길이만큼 랜덤하게 문자열을 생성한다. 패스워드나 인증번호 등을 생성할 수 있다.
     *
     * @param string $type : 문자열 타입 (생략할 경우 기본값 alnum)
     *     - 랜덤 문자열 생성시 사용되는 type 값의 종류
     *     - basic : mt_rand() 함수가 생성하는 임의의 숫자값으로 사용한다. 이 옵션을 사용하면 임의의 숫자값에 대해서만 결과를 생성한다.
     *     - alpha : 알파벳 대, 소문자만 사용한다.
     *     - alnum : 알파벳 대, 소문자와 숫자의 조합을 사용한다.
     *     - numeric : 숫자값만을 사용하여 임의의 문자열을 생성한다. 0을 포함한다.
     *     - nozero : 0을 제외한다는 점을 제외하고는 numeric과 동일한다.
     *     - md5 : md5() 알고리즘에 기반한 암호화된 숫자조합을 생성한다. 이 속성은 생성할 글자수를 지정하더라도 항상 32글자 고정값을 생성한다.
     *     - sha1 : sha1() 알고리즘에 기반한 암호화된 임의의 숫자조합을 생성한다. 이 속성은 생성할 글자수를 지정하더라도 항상 40글자 고정값을 생성한다.
     *     - crypto : 암호화
     * @param int $len 생성할 문자열 길이 (생략할 경우 기본값 8)
     * @return string $randomString
     */
    public function index()
    {
        $temp_pwd = random_string('alnum', 8);
        debug($temp_pwd, '임시비밀번호');

        $auth_number = random_string('numeric', 6);
        debug($auth_number, '인증번호');
    }

    /**
     * 문자열 처리 관련 편의 기능을 제공하는 헬퍼 (1) --> 자르기
     *
     * @return void
     */
    public function limit()
    {
        $string = '안녕하세요. 코드이그나이터 예제 입니다. 코드이그나이터는 쉽고 빠른 PHP 프레임워크 입니다.';

        /**
         * 단어 자르기
         * - 문자열을 지정된 숫자만큼 단어 단위로 잘라낸다.
         *
         * @param string $str : 원본 문자열
         * @param integer $limit : 잘라낼 단어 수
         * @param string $end_char : 잘라낸 뒤에 적용할 생략 기호
         * @return string 축약된 문자열 결과
         */
        $result1 = word_limiter($string, 4, '...'); // 4단어만 남기고 자른 후 "..."을 덧붙임
        debug($result1, 'word_limiter');

        /**
         * 글자 자르기
         * - 문자열을 지정된 글자수만큼 잘라낸다.
         * - 이 함수는 단어의 완전성 검사를 하기 때문에, 지정된 숫자보다 조금 더 적거나 많게 잘라질 수 있다.
         *
         * @param string $str : 원본 문자열
         * @param integer $n : 잘라낼 글자수
         * @param string $end_char : 잘라낸 뒤에 적용할 생략 기호
         * @return string 축약된 문자열 결과
         */
        $result2 = character_limiter($string, 30, '...'); // 30글자에서 자른 후 "..."을 덧붙임
        debug($result2, 'character_limiter');

        /**
         * 문자열 자르기
         * - 문자열에서 태그를 제거하고 지정된 최대 길이로 자른 후, 생략 기호가 어디에 붙어야 할지 결정한다.
         *
         * @param string $str : 원본 문자열
         * @param integer $max_length : 최대 글자 수
         * @param integer $position : 생략기호가 적용될 위치 (1 = '오른쪽/문장의 뒤', 0 = '왼쪽/문장의 앞', .5 = 가운데)
         * @param string $ellipsis : 잘라낸 뒤에 적용할 생략 기호
         * @return string 축약된 문자열 결과
         */
        $result3 = ellipsize($string, 20, 1, '...'); // 20글자까지 남기고 자른 후, 뒤에 "..."을 덧붙임
        debug($result3, 'ellipsize(1)');

        $result4 = ellipsize($string, 20, 0, '...'); // 20글자까지 남기고 자른 후, 앞에 "..."을 덧붙임
        debug($result4, 'ellipsize(0)');

        $result5 = ellipsize($string, 20, .5, '...'); // 20글자까지 남기고 자른 후, 가운데에 "..."을 덧붙임
        debug($result5, 'ellipsize(.5)');
    }

    /**
     * 문자열 처리 관련 편의 기능을 제공하는 헬퍼 (2) --> 강조하기
     *
     * @return void
     */
    public function highlight()
    {
        $string = '안녕하세요. 코드이그나이터 예제 입니다. 코드이그나이터는 쉽고 빠른 PHP 프레임워크 입니다.';

        /**
         * 문자열 강조하기
         * - 문자열에서 특정 문구에 강조할 태그를 적용한다.
         *
         * @param   string  $str        : 원본 문자열
         * @param   string  $phrase     : 강조할 내용
         * @param   string  $tag_open   : 강조할 내용 앞에 적용할 시작태그
         * @param   string  $tag_close  : 강조할 내용 앞에 적용할 마침태그
         * @return string 단어가 강조된 결과가 적용된 문자열
         */
        $result1 = highlight_phrase($string, '코드이그나이터'); // '코드이그나이터'라는 단어에 `<mark>` 태그를 적용하여 색상강조 처리

        $result2 = highlight_phrase($result1, 'PHP', '<mark style="background:#f0f">', '</mark>'); // 강조처리를 적용할 시작/끝 태그를 직접 정의할 수 있다.
        echo $result2;
    }
}