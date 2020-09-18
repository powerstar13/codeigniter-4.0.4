<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * 페이지네이션 컨트롤러
 */
class Pagination extends BaseController
{
    private $paginationLib;
    private $pager;

    public function __construct()
    {
        parent::__construct();

        $this->paginationLib = service('paginationLib');
        $this->pager = service('pager');
    }

    public function index()
    {
        $data = $this->paginationLib->pager();

        return default_layout('Modules\Pattern\Views\Pager\index', $data);
    }

    public function multiple()
    {
        $data = $this->paginationLib->multiple();
        return default_layout('Modules\Pattern\Views\Pager\multiple', $data);
    }

    public function myPager()
    {
        $page = $this->request->getGet('page');

        $data = array();
        $data['users'] = $this->paginationLib->myPager($page);

        return default_layout('Modules\Pattern\Views\Pager\myPager', $data);
    }

    public function segment($page)
    {
        $data = array();
        $data['users'] = $this->paginationLib->segment($page);

        return default_layout('Modules\Pattern\Views\Pager\myPager', $data);
    }

    public function makeLinks()
    {
        /**
         * ===========================================================
         * 수동 페이지네이션
         *
         * - 알려진 데이터를 기반으로 페이지네이션을 만들어야 하는 경우가 있다.
         * - 현재 페이지, 페이지당 결과 수, 총 항목 수를 각각 첫 번째, 두 번째, 세 번째 매개 변수로 사용하는 `makeLinks()` 메소드를 사용하여 링크를 수동으로 작성할 수 있다.
         * ===========================================================
         */
        $page = $this->request->getGet('page'); // 현재 페이지
        if (empty($page)) {
            $page = 1;
        }
        $perPage = 10; // 페이지당 결과 수
        $total = 100; // 총 항목 수

        echo $this->pager->makeLinks($page, $perPage, $total);

        // 기본적으로 링크는 일반적인 방식으로 일련의 링크를 표시하지만, 템플릿을 네 번째 매개 변수로 전달하여 페이지네이션에 사용되는 템플릿을 변경할 수 있다.
        echo $this->pager->makeLinks($page, $perPage, $total, 'pagerTemplate');

    }

    /**
     * 페이지 쿼리 매개 변수 대신 페이지 번호에 URI 세그먼트를 사용할 수 있다.
     * `makeLinks()`의 다섯 번째 매개 변수로 사용할 세그먼트 번호를 지정하십시오.
     */
    public function makeLinksSegment($page)
    {
        echo $this->pager->makeLinks($page, 10, 100, 'pagerTemplate', 4);

        // Note: `$segment` 값은 URI 세그먼트 수에 1을 더한 값보다 클 수 없다.

        // 한 페이지에 많은 Pager를 표시해야 하는 경우 그룹을 정의하는 추가 매개 변수가 도움된다.

        $this->pager->setPath('mvc/pager/makeLinks', 'my-group1');
        echo $this->pager->makeLinks($page, 10, 100, 'pagerTemplate', 4, 'my-group1');
        $this->pager->setPath('mvc/pager/makeLinks', 'my-group2');
        echo $this->pager->makeLinks($page, 10, 100, 'pagerTemplate', 4, 'my-group2');

        // 페이지네이션 라이브러리는 그룹 이름이 없거나 default 그룹이 지정되지 않은 경우, HTTP 쿼리의 page 쿼리 매개 변수를 사용한다.
        // 사용자 그룹을 지정할 때는 `page_[groupName]`을 사용한다.
    }

    /**
     * 예상 쿼리만으로 페이지네이션
     *
     * - 기본적으로 모든 GET 쿼리는 페이지네이션 링크에 표시된다.
     * - 예를 들어 URL `http://localhost/pager?a=1&b=2&page=3`에 액세스 할 때, 다음과 같이 다른 링크와 함께 페이지 3의 링크를 생성할 수 있다.
     */
    public function only()
    {
        echo $this->pager->links(); // http://localhost/pager?a=1&b=2&page=3 파라미터가 유지된다.

        // `only()` 메소드는 이미 예상한 쿼리로만 이것을 제한할 수 있다.
        echo $this->pager->only(['a'])->links(); // http://localhost/pager?a=1&page=3 파라미터가 유지된다.

        // `page` 쿼리는 기본적으로 활성화되어 있으며,  `only()`는 모든 페이지네이션 링크에서 작동한다.
    }
}