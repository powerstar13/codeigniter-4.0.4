<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * url_helper 기능 살펴보기
 */
class Ex06UrlHelperController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();

        // helper 로드
        helper('util');
    }

    /**
     * URL 헬퍼를 통한 다양한 형식의 URL 정보 조회하기
     */
    public function getUrl()
    {
        /**
         * (1) 설정파일에 정의된 기반 URL 리턴
         * - CI3 --> `/config/config.php`에 설정된 base_url 값을 리턴
         * - CI4 --> `/Config/App.php`에 설정된 baseURL 값을 리턴
         *
         * @param  mixed  $uri      : URL 뒤에 추가될 URI String. 문자열 형식이나 배열 형식으로 설정 가능
         * @param  string $protocol : http/https를 선택할 수 있다.
         * @return string 생성된 URL
         *     - ex) base_url() --> `http://localhost`
         *     - ex) base_url('blog/post/123') --> `http://localhost/blog/post/123`
         *     - ex) base_url(['blog', 'post', '123']) --> `http://localhost/blog/post/123`
         */
        // `app\Config\App.php`에 설정된 baseURL 값을 리턴한다.
        debug(base_url(), 'base_url');

        // 파라미터를 전달하여 전체 URL을 생성할 수 있다.
        debug(base_url('hello/world/?user_id=helloworld'), 'base_url(uri)');

        // 배열 형태로 설정하는 방식도 가능하다.
        debug(base_url(['hello', 'world', '?user_id=helloworld']), 'base_url(["uri"])');

        /**
         * (2) 현재 URL 가져오기
         * - 현재 보여지고 있는 페이지의 전체 URL을 리턴한다. (GET 파라미터는 제외된다.)
         */
        // 접속중인 페이지의 URL을 보여준다. (GET파라미터는 제외됨)
        debug(current_url());

        /**
         * (3) 현재 URI 가져오기
         * - 현재 접속중인 URL에서 base_url에 해당하는 부분을 제외한 값을 리턴한다.
         *
         * @return string ex) `http://some-site.com/blog/comments/123` --> `blog/comments/123`
         */
        // 접속중인 페이지의 URL에서 base_url에 해당하는 부분을 제외하고 표시한다.
        debug(uri_string());
    }

    /**
	 * 링크 태그 생성하기
	 * - 표준 HTML 앵커 링크 (anchor link)를 사이트 URL에 맞도록 생성한다.
	 *
	 * @param mixed            $uri        : URL에 덧붙이고 싶은 segment. base_url() 함수에 전달하는 정보와 동일하게 문자열이나 배열 형식으로 설정할 수 있다.
	 * @param string           $title      : `<a>`의 시작 태그와 끝 태그 사이에 포함될 텍스트
	 * @param mixed            $attributes : 그 밖의 기타 속성들
	 * @param \Config\App|null $altConfig  : 사용할 환경설정을 변경합니다.
	 *
	 * @return string 생성된 링크 태그 문자열
	 */
    public function link()
    {
        // (1) anchor 함수의 사용 예시
        $ex1 = anchor('news/local/123', 'My News', 'title="News title"');
        debug($ex1, 'anchor ex1');

        $ex2 = anchor('news/local/123', 'My News', array('title' => 'The best news!'));
        debug($ex2, 'anchor ex2');

        $ex3 = anchor('', 'Click here', 'title="URL을 설정하지 않음"');
        debug($ex3, 'anchor ex3');

        /**
         * (2) anchor 함수를 활용한 링크 생성
         * - `util_helper`의 debug() 함수는 `<pre>` 태그를 사용하기 때문에 HTML 태그를 실행하지 않고 문자열 형식 그대로 출력한다.
         * - 생성된 링크의 동작을 확인하기 위해서 `echo`로 출력
         */
        // 링크 태그를 생성한다.
        $link = anchor('https://github.com/powerstar13', 'Go MasterHong github', array('title' => 'ITPAPER', 'target' => '_blank'));

        // 생성된 태그를 출력
        debug($link, 'anchor');

        // 클릭할 수 있는 형태로 출력
        echo $link;
    }

    /**
	 * 팝업창을 위한 링크 태그 생성하기
     * - anchor() 함수와 동일하게 링크 문자열을 생성하지만, 지정된 URI를 팝업으로 띄운다.
	 *
	 * @param mixed            $uri        : URL에 덧붙이고 싶은 segment. base_url() 함수에 전달하는 정보와 동일하게 문자열이나 배열 형식으로 설정할 수 있다.
	 * @param string           $title      : `<a>`의 시작 태그와 끝 태그 사이에 포함될 텍스트
	 * @param mixed            $attributes : 팝업창 생성에 필요한 옵션값. Javacsript의 `window.open()` 함수에 설정하는 옵션값과 동일하다.
	 * @param \Config\App|null $altConfig  : 사용할 환경설정을 변경합니다.
	 *
	 * @return string 생성된 링크 태그 문자열
	 */
    public function popup()
    {
        /** 팝업창을 띄우는 링크를 생성한다. */
        // 옵션값은 배열 형식으로 지정
        $attributes = array(
            'width' => 800,
            'height' => 600,
            'scrollbars' => 'yes',
            'status' => 'yes',
            'resizable' => 'yes',
            'screenx' => 0,
            'screeny' => 0,
            'window_name' => 'mypopup'
        );
        $popup = anchor_popup('https://github.com/powerstar13', 'Click Me!', $attributes);

        debug($popup, 'anchor_popup'); // 생성된 태그를 출력
        echo $popup; // 클릭할 수 있는 형태로 출력
    }

    /**
     * 페이지 강제 이동
     * - PHP의 header() 함수를 사용한 페이지 이동을 수행한다.
     * - 내부적으로 header() 함수를 사용하기 때문에, 이 기능이 호출되기 전 어떠한 출력도 브라우저로 전송되어서는 안된다.
     * - 이 함수는 컨트롤러의 실행을 종료한다.
     * - PHP 코드에서 다음과 같이 처리하는 경우와 동일하다.
     *     `header("Location: blog/post/123");`
     *
     * @param string $uri : 이동할 페이지의 URL
     *     - 상대경로로 지정할 경우, 설정 파일의 base_url 값을 사용하여 이동할 주소가 만들어 진다.
     * @return void
     */
    public function redirect()
    {
        // 지정된 URL로 페이지 강제 이동
        // 이 페이지(/study/ex06/redirect)는 브라우저의 history에 남지 않는다.
        return redirect('/');

        // redirect() 함수 이후에 호출된 로직은 실행되지 않는다.
        debug('Hello World');
    }

    /**
	 * 메일 발송을 위한 링크 생성하기
     * - 클릭했을 때, 운영체제의 기본 메일 발송 프로그램이 동작하도록 하는 링크를 생성한다.
     *     - ex) `<a href="mailto:powerstar13@hanmail.net">Write email</a>`
	 *
	 * @param string $email      : 수신자 메일 주소 (`mailto:`은 함수에서 자동으로 적용한다.)
     *     - 수신자 주소에 제목과 내용을 포함시킬 수 있다.
     *         - `mailto:powerstar13@hanmail.net&subject=Hello&Body=안녕하세요.`
	 * @param string $title      : 시작태그와 끝 태그 사이에 포함될 문자열
	 * @param mixed  $attributes : 태그에 추가적으로 적용할 속성
	 *
	 * @return string `<a>` 태그에 대한 문자열
	 */
    public function mail()
    {
        // 수신자 메일 주소
        $address = 'powerstar13@hanmail.net';
        // 메일 프로그램에 자동으로 설정될 "제목"을 수신자 주소 뒤에 추가함 (선택사항)
        $address .= '?subject=CodeIgniter 메일링크 테스트 입니다.';
        // 메일 프로그램에 자동으로 설정될 "내용"을 수신자 주소 뒤에 추가함 (선택사항)
        $address .= '&body=코드이그나이터에서 생성하는 메일링크 테스트 입니다.';
        // 링크에 포함될 텍스트
        $title = 'CodeIgniter 메일링크 테스트';

        // 링크 생성 및 출력
        $link = mailto($address, $title);
        debug($link);
        echo $link;
    }

    /**
	 * 자동으로 링크 생성하기
	 * - 문자열 안에 포함된 URL이나 메일주소에 자동으로 링크를 적용한다.
	 *
	 * @param string  $str   : 원본 문자열
	 * @param string  $type  적용 형식 (email = 메일주소에만 적용, url = URL에만 적용, both = URL과 메일주소에 모두 적용)
	 * @param boolean $popup : 새 탭 열기 링크 형식으로 생성할지 여부
	 *
	 * @return string 변환된 결과값
	 */
    public function autoLink()
    {
        // 링크로 변환할 URL과 메일주소가 포함된 텍스트
        $content = 'MasterHong의 Github 주소는 https://github.com/powerstar13 이고 문의 메일 주소는 powerstar13@hanmail.net 입니다.';

        $result1 = auto_link($content); // 모두 변환
        $result2 = auto_link($content, 'url', true); // URL만 변환
        $result3 = auto_link($content, 'email');

        // 변환 결과 출력
        echo "<p>{$result1}</p>";
        echo "<p>{$result2}</p>";
        echo "<p>{$result3}</p>";
    }

    /**
     * prep_url() 함수와 url_title() 함수 확인하기
     *
     * @return void
     */
    public function etc()
    {
        /**
         * 문자열을 링크에 포함할 수 있는 형태로 변환
         * - 문자열을 입력받아 사람이 읽기 쉬운 URL 문자열을 생성한다.
         *     - 만약 블로그를 만드는데 글제목을 url로 사용하고자 할 경우 유용하다.
         *
         * @param  string  $str       : 원본 문자열
         * @param  string  $separator : 공백 변환 --> '-' or '_'
         * @param  boolean $lowercase : 소문자형태로 변환
         * @return string 변환된 결과 --> 따옴표와 같이 URL에 포함할 수 없는 글자를 제거하고, 공백은 $separator 값으로 변환한다.
         */
        $title = '코드이그나이터 URL 헬퍼 예제';
        $url = base_url(['blog/post', url_title($title)]);
        debug($url);

        /**
         * URL에서 `http://` 이 빠진경우에 추가한다.
         *
         * @param  string $str : 원본 문자열
         * @return string 변환된 결과
         */
        $site = 'github.com/powerstar13';
        $url = prep_url($site);
        debug($url);
    }
}