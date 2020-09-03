<?php namespace App\Libraries;

class NewsLib
{
    private $newsModel;
    private $newsBuilder;

    public function __construct()
    {
        $this->newsModel = model('App\Models\NewsModel', false);
        $this->newsBuilder = $this->newsModel->builder();
    }
    /**
     * 이 코드를 사용하면 두 가지 다른 쿼리를 수행 할 수 있다.
     * 모든 뉴스 레코드를 얻거나, `slug`를 통해 뉴스 항목을 얻을 수 있다.
     * `Query Builder`를 실행하기 전 `$slug` 변수에 값이 제거되지 않았다.
     *
     * 여기서 사용되는 두 가지 메소드 `findAll()`과 `first()`는 모델 클래스에 의해 제공된다.
     * 이 두 메소드는 이미 우리가 앞서 `NewsModel` 클래스에 설정한 `$table` 속성을 기준으로 사용할 테이블을 알고 있다.
     * 이 메소드는 Query Builder를 사용하여 현재 테이블에서 명령을 실행하고 원하는 형식으로 결과 배열을 반환하는 도우미(helper) 메소드이다.
     * 이 예에서 `findAll()`은 일련의 객체(Object)를 반환한다.
     */
    public function getNews(string $slug = null)
    {
        if (empty($slug)) {
            return $this->newsModel->findAll();
        }

        return $this->newsModel->asArray()
            ->where(['slug' => $slug])
            ->first();
    }

    /**
     * 뉴스 아이템 저장 처리
     *
     * @param array $data
     * @return array
     */
    public function save(array $resource) : array
    {
        $data = array(
            'title' => $resource['title'],
            'slug' => url_title($resource['title'], '-', TRUE), // 전달받은 문자열에서 모든 공백을 대시(-)로 바꾸고 모든 문자가 소문자인지 확인한다. (URI로 사용 가능한 완벽한 slug를 만든다.)
            'body' => $resource['body'],
        );
        $queryResult = $this->newsModel->save($data);

        $result = array();

        if($queryResult === false) {
            $result['rt'] = 400;
            $result['errors'] = $this->newsModel->errors();
        } else {
            $result['rt'] = 200;
            $result['rtMsg'] = '유저 정보 저장에 성공했습니다.';
        }

        return $result;
    }
}