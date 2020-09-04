<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\NewsLib;

/**
 * CodeIgniter 클래스인 `Controller`를 확장하여 몇 가지 도우미 메소드를 제공하며, 디스크에 정보를 저장하는 `Logger` 클래스와 `Request` 및 `Response` 객체를 사용할 수 있도록 한다.
 */
class News extends Controller
{
    private $newsLib;

    public function __construct()
    {
        $this->newsLib = new NewsLib();
    }

    /**
     * 모든 뉴스 항목을 보는 메소드
     *
     * @return void
     */
    public function index()
    {
        $data['news'] = $this->newsLib->getNews();
        $data['title'] = 'News archive';

        // 데이터를 뷰에 전달
        echo view('templates/header', $data);
        echo view('news/overview', $data);
        echo view('templates/footer', $data);
    }

    /**
     * `$slug` 변수가 모델의 메소드로 전달되는 것을 볼 수 있다.
     *
     * @param string $slug : 뉴스 항목을 식별한다.
     * @return void
     */
    public function view(string $slug = null)
    {
        $data['news'] = $this->newsLib->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $slug);
        }

        $data['title'] = $data['news']['title'];

        echo view('templates/header', $data);
        echo view('news/view', $data);
        echo view('templates/footer', $data);
    }

    /**
     * 뉴스 아이템 저장
     *
     * @return void
     */
    public function create()
    {
        if (
            // 1. POST 요청을 처리하는지 확인
            $this->request->getMethod() === 'post'
            // 2. 제출된 양식을 확인하여 데이터가 검증 규칙을 통과했는지 확인
            && $this->validate('newsCreate')
        ) {
            $post = $this->request->getPost();

            $result = $this->newsLib->save($post);

            if ($result['rt'] === 200) {
                echo view('news/success');
                return false;
            } else {
                $data['errors'] = $result['errors'];
                // return redirect()->back()->withInput();
            }
        }

        helper('form');

        $data['title'] = 'Create a news item';

        echo view('templates/header', $data);
        echo view('news/create', $data);
        echo view('templates/footer');
    }
}