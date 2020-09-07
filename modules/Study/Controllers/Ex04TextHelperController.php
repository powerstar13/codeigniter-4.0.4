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
}