<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * array_helper 기능 살펴보기
 */
class Ex03ArrayHelperController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();

        // helper 로드
        helper(['array', 'past_array', 'util']);
    }

    /**
     * 배열에서 key 이름에 의한 원소 찾기
     *
     * @return void
     */
    public function find1()
    {
        // 배열 데이터
        $array = array(
            'year' => 2020,
            'month' => 9,
            'date' => 7
        );

        // $array 배열에서 key가 'day'인 요소를 찾는다.
        // 값을 찾지 못할 경우 false가 리턴된다.
        $result1 = element('date', $array);
        debug($result1);

        // $array 배열에서 key가 'hello'인 요소를 찾는다.
        // 값을 찾지 못할 경우, 세 번째 파라미터가 기본값으로 전달된다.
        $result2 = element('hello', $array, '알 수 없음');
        debug($result2);
    }

    /**
     * elements 함수를 사용하여 복수의 원소 추출하기
     * - 배열에서 key 이름에 의한 원소들을 일괄 찾기
     *
     * @return void
     */
    public function find2()
    {
        // 배열 데이터
        $array = array(
            'year' => 2020,
            'month' => 9,
            'date' => 7
        );
        $find = array('year', 'month', 'hello');

        // `$array`에서 `$find`와 키가 일치하는 항목들을 추출하여 새로운 배열로 리턴한다.
        // 찾지 못한 항목에 대해서는 세 번째 파라미터로 처리된다.
        // 세 번째 파라미터를 찾지 못할 경우 false가 리턴된다.
        $result = elements($find, $array, 'unknown');
        debug($result);

        // `$find` 배열에서 설정한 `year`, `month`의 경우, 원본 배열에서 정의하고 있는 key와 일치하기 때문에 데이터가 검출된다.
        // `hello`의 경우에는 원본 배열에 정의되지 않은 값이기 때문에, 기본적으로 설정된 'unknown'이라는 문자열이 대신 적용된다.
    }

    /**
     * 배열에서 랜덤으로 원소 추출
     *
     * @return void
     */
    public function random()
    {
        // 배열 데이터
        $array = array('일', '월', '화', '수', '목', '금', '토');

        // 주어진 배열에서 랜덤한 요소 하나를 추출한다.
        $rnd = random_element($array);
        debug($rnd);
    }
}