<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * 게시판 컨트롤러
 */
class Bbs extends BaseController
{
    private $bbsConfig;

    // URL 파라미터에 포함된 게시판 식별값을 사용하여 설정정보를 로드한 후, 미리 준비한 전역변수에 저장할 목적으로 선언한다.
    private $bbsInfo; // 현재 게시판에 대한 설정내용을 저장할 전역변수

    public function __construct()
    {
        parent::__construct();

        $this->bbsConfig = (array) config('Modules\Pattern\Config\Bbs'); // 게시판의 환경 설정 정보를 로드한다.
    }

    /**
     * 생성자에서 URL 파라미터를 식별할 수 없지만, _remap() 메서드에서는 URL 파라미터를 식별할 수 있기 때문에, URL 파라미터에 의한 초기화 용도로도 사용된다.
     *
     * - `http://localhost/bbs/게시판이름/메서드이름` 형식의 주소를 재구성하기 위한 메서드
     *
     * - 메서드에 접근하는 URL을 재정의할 수 있는 `_remap()` 메서드
     *     - CI의 모든 컨트롤러는 필요에 따라 `_remap()` 메서드를 정의할 수 있다.
     *     - 이 메서드가 정의된 컨트롤러는 어떤 URL로 접근하더라도 이 메서드에 연결된다.
     *     - URL에 포함된 클래스 이름 이외의 다른 정보들은 이 메서드에 대한 파라미터로 전달된다.
     */
    public function _remap($bbs, ...$params)
    {
        /**
         * (1) 게시판 설정 검사
         * - 환경설정 정보에 첫 번째 파라미터로 전달받은 게시판의 종류를 의미하는 `$bbs`와 동일한 문자열을 key로 갖는 원소가 존재하는지 검사하고, 존재할 경우 해당 내용을 미리 준비한 전역변수에 객체 형태로 복사한다.
         */
        // 게시판 이름이 $bbsConfig 배열 안에 존재하는지 검사한다.
        if (empty($this->bbsConfig['bbs'][$bbs])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('존재하지 않는 게시판입니다: ' . $bbs);
        }

        // 설정내용을 전역변수에 배열로 변환하여 저장한다.
        $this->bbsInfo = array();
        $this->bbsInfo['key'] = $bbs;
        $this->bbsInfo['name'] = $this->bbsConfig['bbs'][$bbs]['name'];
        $this->bbsInfo['skin'] = $this->bbsConfig['bbs'][$bbs]['skin'];

        /**
         * (2) 실행할 메서드 이름 판별하기
         * - 게시판 종류값 이후의 파라미터들에 대한 처리 (1)
         *     - 메뉴에 적용되어 있는 링크는 게시판의 종류만 명시되어 있고, 어떤 메서드를 실행할지는 명시되어 있지 않는 경우
         *     - 즉, 값이 존재하지 않을 경우, 글 목록 1페이지로 강제 설정하기 위해 다음의 URL로 접근한 것 처럼 `$params` 정보를 강제로 구성한다.
         *     - ex) http://localhost/bbs/news 와 같이 전달된 경우
         *         - 파라미터로 "list"와 "1"이라는 값이 전달되었다고 간주한다.
         *         - 즉, http://localhost/bbs/news/list/1 로 접근되었다고 설정한다.
         */
        if (empty($params)) {
            $params = array('list', 1);
        }
        // 첫 번째 파라미터를 실행할 메서드 이름으로 저장한다.
        $methodName = $params[0];

        /**
         * (3) 목록, 읽기, 수정, 삭제 처리 시, 필요한 추가 파라미터 판별하기
         * - 게시판 종류값 이후의 파라미터들에 대한 처리 (2)
         *     - `$params`의 0번째 원소는 목록, 쓰기, 수정, 삭제 등을 의미하는 메서드 이름이다.
         *     - `$params`의 1번째 원소는
         *         - 목록의 경우 --> 페이지 번호
         *         - 읽기/수정/삭제의 경우 --> 글 번호를 의미하므로, 실행할 메서드의 종류에 따라 1번째 원소가 있는지 확인한다.
         */
        // 두 번째 파라미터를 받는다.
        $addonParams = isset($params[1]) ? $params[1] : false;

        // 파라미터가 없다면?
        if (!$addonParams) {
            if ($methodName === 'list') {
                // 글 목록인 경우, 이 값은 페이지지 번호로 사용된다.
                $addonParams = 1; // 값이 없다면 1페이지로 지정
            } else if (in_array($methodName, array('view', 'edit', 'delete'))) {
                // 읽기/수정/삭제인 경우, 이 값은 대상 게시글을 의미한다.
                throw new \CodeIgniter\Exceptions\PageNotFoundException('존재하지 않는 게시글입니다.'); // 값이 없다면 접근에러로 간주한다.
            }
        }

        /**
         * (4) 요청된 메서드 이름에 따라 메서드를 호출한다.
         * - URL에 명시된 파라미터에 따라 실행할 메서드 분기하기
         *     - `_remap()` 메서드가 정의된 컨트롤러 클래스는 어떤 URL로 접근하더라도 `_remap()` 메서드 안에서 직접 호춣해야 한다.
         *     - 메서드의 호출 시, 목록/읽기/수정/삭제 등에 페이지번호나 글 번호를 의미하는 요청에 필요한 값들을 파라미터로 전달한다.
         */
        switch ($methodName) {
            case 'list':
            case 'view':
            case 'edit':
            case 'editDo':
            case 'delete':
            case 'deleteDo':
                $this->{$methodName}($addonParams);
                break;
            case 'write':
            case 'writeDo':
                $this->{$methodName}();
                break;
            default:
                throw new \CodeIgniter\Exceptions\PageNotFoundException('올바른 경로로 접근 바랍니다.');
                break;
        }
    }

    /**
     * 글 목록
     *
     * - 사용할 View의 경로를 환경설정 정보의 "skin" 값과 조합하여 명시한다.
     * - 이러한 구성 방식은 하나의 메서드에서 "/Config/Bbs.php"에 명시된 "skin" 값에 따라 다른 View를 참조할 수 있게 하므로, 같은 기능이지만 서로 다른 UI들을 갖는 프로그램을 구현할 수 있게 해준다.
     *
     * @param integer $page : 페이지번호
     * @return view
     */
    public function list($page = 1)
    {
        $data = array();
        $data['bbsInfo'] = $this->bbsInfo;
        $data['page'] = $page;

        echo default_layout(sprintf('Modules\Pattern\Views\Bbs\%s\list', $this->bbsInfo['skin']), $data);
    }
}