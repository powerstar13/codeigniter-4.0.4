<?php namespace Modules\Pattern\Libraries;

/**
 * 데이터베이스 결과 페이지네이션
 */
class PaginationLib
{
    private $newsModel;
    private $userModel;

    public function __construct()
    {
        // Model의 새 인스턴스 생성
        $this->newsModel = model('App\Models\NewsModel', false);
        $this->userModel = model('App\Models\UserModel', false);
    }

    public function pager()
    {
        return array(
            'news' => $this->newsModel->paginate(10), // 페이지 당 10개씩 리턴
            'pager' => $this->newsModel->pager // 편의상 Model 인스턴스를 유지하는 Pager 인스턴스를 뷰에 할당
        );
    }

    /**
     * 여러 결과 페이지네이션
     *
     * - 서로 다른 두 개의 결과 집합에서 링크를 제공해야 하는 경우, 그룹 이름 페이지네이션 메소드에 전달하여 데이터를 별도로 유지할 수 있다.
     *
     * @return array
     */
    public function multiple()
    {
        return array(
            'news' => $this->newsModel->paginate(10, 'group1'),
            'pages' => $this->userModel->paginate(15, 'group2'),
            'pager' => $this->newsModel->pager
        );
    }

    /**
     * 페이지 수동 설정
     *
     * - 반환할 결과 페이지를 지정해야 하는 경우 페이지를 세 번째 인수로 지정할 수 있다.
     * - 표시할 페이지를 제어하기 위해 기본 `$_GET` 변수와 다른 방법을 사용할 때 유용하다.
     *
     * @return array users
     */
    public function myPager($page = 1)
    {
        return $this->userModel->paginate(10, 'group1', $page);
    }

    /**
     * 페이지의 URI 세그먼트 지정
     *
     * - 페이지 쿼리 매개 변수 대신, 페이지 번호에 URI 세그먼트를 사용할 수 있다.
     * - 네 번째 인수로 사용할 세그먼트 번호를 지정하십시오. 생성된 URI는
     *     - https://localhost/pager?page={$page} 대신
     *     - https://localhost/pager/{$page} 로 표시됩니다.
     *
     * - Note : `$segment` 값은 URI 세그먼트 수에 1을 더한 값보다 클 수 없다.
     *
     * @return array users
     */
    public function segment($page = 1)
    {
        return $this->userModel->paginate(10, 'group1', $page, 4);
    }
}