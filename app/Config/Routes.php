<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // 자동 라우팅을 비활성화하여 정의한 경로만 액세스 할 수 있다.

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// Modules 컨트롤러 연결 (app/Controllers 디렉토리 외부에 작성된 컨트롤러)
// `group` 라우팅 기능을 사용하면 여기에 필요한 입력양을 줄일 수 있다.
$routes->group('blog', ['namespace' => 'Modules\Blog\Controllers'], function($routes) {
    $routes->get('(:any)', 'Blog::$1');
});

$routes->group('study', ['namespace' => 'Modules\Study\Controllers'], function($routes) {
    $routes->get('/', 'HelloController::index');

    $routes->group('ex01', function($routes) {
        $routes->get('showItem', 'Ex01ConfigController::showItem');
        $routes->get('showAll', 'Ex01ConfigController::showAll');
        $routes->get('customAll', 'Ex01ConfigController::customAll');
        $routes->get('customItem', 'Ex01ConfigController::customItem');
    });

    $routes->group('ex02', function($routes) {
        $routes->get('/', 'Ex02UserHelperController::index');
        $routes->get('debugTest', 'Ex02UserHelperController::debugTest');
    });

    $routes->group('ex03', function($routes) {
        $routes->get('find1', 'Ex03ArrayHelperController::find1');
        $routes->get('find2', 'Ex03ArrayHelperController::find2');
        $routes->get('random', 'Ex03ArrayHelperController::random');
    });

    $routes->group('ex04', function($routes) {
        $routes->get('/', 'Ex04TextHelperController::index');
        $routes->get('limit', 'Ex04TextHelperController::limit');
        $routes->get('highlight', 'Ex04TextHelperController::highlight');
    });

    $routes->group('ex05', function($routes) {
        $routes->get('setRealpath', 'Ex05FilesystemHelperController::setRealpath');
        $routes->get('directoryMap', 'Ex05FilesystemHelperController::directoryMap');
        $routes->get('makeFile', 'Ex05FilesystemHelperController::makeFile');
        $routes->get('filenames', 'Ex05FilesystemHelperController::filenames');
        $routes->get('dirFileInfo', 'Ex05FilesystemHelperController::dirFileInfo');
        $routes->get('delete', 'Ex05FilesystemHelperController::delete');
    });

    $routes->group('ex06', function($routes) {
        $routes->get('getUrl', 'Ex06UrlHelperController::getUrl');
        $routes->get('link', 'Ex06UrlHelperController::link');
        $routes->get('popup', 'Ex06UrlHelperController::popup');
        $routes->get('redirect', 'Ex06UrlHelperController::redirect');
        $routes->get('mail', 'Ex06UrlHelperController::mail');
        $routes->get('autoLink', 'Ex06UrlHelperController::autoLink');
        $routes->get('etc', 'Ex06UrlHelperController::etc');
    });

    $routes->group('ex07', function($routes) {
        $routes->get('vars', 'Ex07GlobalController::vars');
        $routes->get('func', 'Ex07GlobalController::func');
    });

    $routes->group('ex08', function($routes) {
        $routes->get('error', 'Ex08ErrorHandlingController::error');
        $routes->get('notFound', 'Ex08ErrorHandlingController::notFound');
        $routes->get('log', 'Ex08ErrorHandlingController::log');
    });
});

$routes->group('mvc', ['namespace' => 'Modules\Pattern\Controllers'], function($routes) {
    $routes->group('useView', function($routes) {
        $routes->get('/', 'Ex01UseView::index');
        $routes->get('setArray', 'Ex01UseView::setArray');
        $routes->get('library', 'Ex02UserLibrary::library');
    });

    $routes->group('userLib', function($routes) {
        $routes->get('/', 'Ex02UserLibrary::index');
    });

    $routes->group('encrypt', function($routes) {
        $routes->get('/', 'Ex03Encryption::index');
    });

    $routes->group('email', function($routes) {
        $routes->get('joinMail', 'Ex04Email::joinMailSend');
    });

    $routes->group('get', function($routes) {
        $routes->get('sample/(:segment)/(:segment)', 'Ex05Get::sample/$1/$2');
    });

    $routes->group('cookie', function($routes) {
        $routes->get('/', 'Ex06Cookie::index');
        $routes->post('result', 'Ex06Cookie::result');
    });

    $routes->group('session', function($routes) {
        $routes->get('/', 'Ex07Session::index');
        $routes->post('result', 'Ex07Session::result');
    });

    $routes->group('upload', function($routes) {
        $routes->get('/', 'Ex08Upload::index');
        $routes->post('result', 'Ex08Upload::result');
    });

    $routes->group('thumb', function($routes) {
        $routes->get('/', 'Ex09Thumbnail::index');
    });
});

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index'); // 이 지시문은 지정되지 않은 요청에 대해 Home 컨트롤러 내의 index() 메소드로 처리하라는 것
// CodeIgniter는 라우팅 규칙을 위에서 아래로 읽고, 요청과 첫 번째로 일치하는 규칙으로 라우팅합니다.
// 각 규칙은 오른쪽의 슬래시로 구분된 컨트롤러와 메소드 이름에 매핑된 왼족의 정규식입니다.
$routes->get('layout', 'Layout::index');
$routes->get('layout/section', 'Layout::section');
$routes->get('user/save', 'User::save');
$routes->get('user/createUser', 'User::createUser');
$routes->match(['get', 'post'], 'news/create', 'News::create');
$routes->get('news/(:segment)', 'News::view/$1');
$routes->get('news', 'News::index');
$routes->get('(:any)', 'Pages::view/$1');

// 환경 제한
$routes->environment('development', function($routes) { // 개발자만 사용할 수 있는 도구
    // CLI 전용 라우팅
    $routes->cli('tools/message/(:segment)', 'Tools::message/$1');
});


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
