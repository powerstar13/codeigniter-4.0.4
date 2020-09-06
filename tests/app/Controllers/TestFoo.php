<?php namespace App\Controllers;

use CodeIgniter\Test\FeatureTestCase;

class TestFoo extends FeatureTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * ================================
     * 페이지 요청
     *
     * - 기본적으로 FeatureTestCase를 사용하면 어플리케이션에서 엔드 포인트를 호출하고 결과를 다시 얻을 수 있다.
     * - 이렇게 하려면 `call()` 메소드를 사용하십시오.
     * - 첫 번째 매개 변수는 사용할 HTTP 메소드이다.
     * - (대부분 GET 또는 POST) 두 번째 매개 변수는 테스트할 사이트의 경로이다.
     * - 세 번째 매개 변수는 사용중인 HTTP 동사에 대한 수퍼 글로벌 변수를 채우는데 사용되는 배열이다.
     * - 따라서 `GET` 메소드는 `$_GET` 변수가 채워지고 `POST` 메소드는 `$_POST` 배열이 채워진다.
     * ================================
     */
    public function pageRequest()
    {
        // Get a simple page
        $result = $this->call('get', site_url());

        // Sumit a form
        $result = $this->call('post', site_url('contact'), [
            'name' => 'MasterHong',
            'email' => 'powerstar13@hanmail.net'
        ]);

        // 타이핑을 쉽고 더 명확하게 하기 위해 각 HTTP 동사에 대한 속기 방법이 있다.
        $path = 'contact';
        $params = array(
            'name' => 'MasterHong',
            'email' => 'powerstar13@hanmail.net'
        );
        $result = $this->get($path, $params);
        $result = $this->post($path, $params);
        $result = $this->put($path, $params);
        $result = $this->patch($path, $params);
        $result = $this->delete($path, $params);
        $result = $this->options($path, $params);

        // Note : $parmas 배열은 모든 HTTP 동사에 대해 의미가 없지만 일관성을 위해 포함된다.
    }

    /**
     * 다른 경로(route) 설정
     *
     * - "routes" 배열을 `withRoutes()` 메소드에 전달하여 사용자 지정 경로 모음을 사용할 수 있다.
     * - 이것은 시스템의 기존 경로를 무시한다.
     *
     * @return void
     */
    public function anotherRoute()
    {
        // 각 "routes"는 HTTP동사 (또는 "all"), 일치할 URI, 라우팅 대상을 포함하는 3요소 배열이다.
        $routes = array(
            array('get', 'users', 'UserController::list')
        );

        $result = $this->withRoutes($routes)
            ->get('users');
    }

    /**
     * 세션 값 설정
     *
     * - `withSession()` 메소드를 사용하여 단일 테스트 중에 사용할 사용자 정의 세션 값을 설정할 수 있다.
     *     - 요청이 이루어질 때, $_SESSION 변수 내에 존재해야 하는 키/값 쌍의 배열이 사용된다.
     *     - 인증 등을 테스트할 때 편리하다.
     * - 단일 테스트 중에 사용할 사용자 정의 세션 값을 `withSession()` 메소드를 사용하여 설정할 수 있습니다. `$_SESSION` 변수에 존재해야 하는 값을 키/값 쌍의 배열을 사용하거나 `null`을 전달하여 현재 `$_SESSION`을 사용할 수 있다.
     *
     * @return void
     */
    public function setSession()
    {
        $values = array('logged_in' => 123);

        $result = $this->withSession($values)
            ->get('admin');

        // 또는...

        $_SESSION['logged_in'] = 123;

        $result = $this->withSession()->get('admin');
    }

    /**
     * 이벤트 우회
     *
     * - 이벤트는 어플리케이션에서 사용하기 편리하지만 테스트중에 문제가 될 수 있다.
     * - 특히 이메일을 보내는데 사용되는 이벤트. `skipEvents()` 메소드로 이벤트 처리를 건너 뛰도록 시스템에 지시할 수 있다.
     *
     * @return void
     */
    public function dontUseEvent()
    {
        $userInfo = array(
            'username' => 'MasterHong',
            'email' => 'powerstar13@hanmail.net'
        );

        $result = $this->skipEvents()
            ->post('users', $userInfo);
    }
}