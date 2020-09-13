<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{

	/*
	|--------------------------------------------------------------------------
	| Base Site URL
	|--------------------------------------------------------------------------
	|
	| URL to your CodeIgniter root. Typically this will be your base URL,
	| WITH a trailing slash:
	|
	|	http://example.com/
	|
	| If this is not set then CodeIgniter will try guess the protocol, domain
	| and path to your installation. However, you should always configure this
	| explicitly and never rely on auto-guessing, especially in production
	| environments.
    |
    */
    public $baseURL = '/';

	/*
	|--------------------------------------------------------------------------
	| Index File
	|--------------------------------------------------------------------------
	|
    | 일반적으로 이것은 다른 것으로 이름을 바꾸지 않는 한 당신의 `index.php` 파일이 될 것이다.
    | mod_rewrite를 사용하여 페이지를 제거하려면 이 변수를 공백으로 설정하십시오.
    |
	| - `.htaccess` 통해서 index.php 경로에 제외되도록 처리함을 참고
	*/
	public $indexPage = ''; // 원본 : index.php

	/*
	|--------------------------------------------------------------------------
	| URI PROTOCOL
	|--------------------------------------------------------------------------
	|
	| This item determines which getServer global should be used to retrieve the
	| URI string.  The default setting of 'REQUEST_URI' works for most servers.
	| If your links do not seem to work, try one of the other delicious flavors:
	|
	| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
	| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
	| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
	|
	| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
	*/
	public $uriProtocol = 'REQUEST_URI';

	/*
	|--------------------------------------------------------------------------
	| Default Locale
	|--------------------------------------------------------------------------
	|
	| The Locale roughly represents the language and location that your visitor
	| is viewing the site from. It affects the language strings and other
	| strings (like currency markers, numbers, etc), that your program
	| should run under for this request.
	|
	*/
	public $defaultLocale = 'ko';

	/*
	|--------------------------------------------------------------------------
	| Negotiate Locale
	|--------------------------------------------------------------------------
	|
	| If true, the current Request object will automatically determine the
	| language to use based on the value of the Accept-Language header.
	|
	| If false, no automatic detection will be performed.
	|
    */
    // 이 기능이 활성화되면 시스템은 `$supportLocales`에 정의한 로케일 배열을 기반으로 올바른 언어를 자동으로 협상한다.
	public $negotiateLocale = true; // Request 클래스에 로케일을 협상하고 싶다면 `true`

	/*
	|--------------------------------------------------------------------------
	| Supported Locales
	|--------------------------------------------------------------------------
	|
	| If $negotiateLocale is true, this array lists the locales supported
	| by the application in descending order of priority. If no match is
	| found, the first locale will be used.
	|
	*/
	public $supportedLocales = ['ko', 'en']; // 지원하는 언어와 요청한 언어가 일치하지 않으면, 첫 번째 항목이 사용된다.

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| The default timezone that will be used in your application to display
	| dates with the date helper, and can be retrieved through app_timezone()
	|
	*/
	public $appTimezone = 'Asia/Seoul';

	/*
	|--------------------------------------------------------------------------
	| Default Character Set
	|--------------------------------------------------------------------------
	|
	| This determines which character set is used by default in various methods
	| that require a character set to be provided.
	|
	| See http://php.net/htmlspecialchars for a list of supported charsets.
	|
	*/
	public $charset = 'UTF-8';

	/*
	|--------------------------------------------------------------------------
	| URI PROTOCOL
	|--------------------------------------------------------------------------
	|
	| If true, this will force every request made to this application to be
	| made via a secure connection (HTTPS). If the incoming request is not
	| secure, the user will be redirected to a secure version of the page
	| and the HTTP Strict Transport Security header will be set.
	*/
	public $forceGlobalSecureRequests = false;

	/*
	|--------------------------------------------------------------------------
	| Session Variables
	|--------------------------------------------------------------------------
	|
	| 'sessionDriver'
	|
	|	The storage driver to use: files, database, redis, memcached
	|       - CodeIgniter\Session\Handlers\FileHandler
	|       - CodeIgniter\Session\Handlers\DatabaseHandler
	|       - CodeIgniter\Session\Handlers\MemcachedHandler
	|       - CodeIgniter\Session\Handlers\RedisHandler
	|
	| 'sessionCookieName'
	|
	|	The session cookie name, must contain only [0-9a-z_-] characters
	|
	| 'sessionExpiration'
	|
	|	The number of SECONDS you want the session to last.
	|	Setting to 0 (zero) means expire when the browser is closed.
	|
	| 'sessionSavePath'
	|
	|	The location to save sessions to, driver dependent.
	|
	|	For the 'files' driver, it's a path to a writable directory.
	|	WARNING: Only absolute paths are supported!
	|
	|	For the 'database' driver, it's a table name.
	|	Please read up the manual for the format with other session drivers.
	|
	|	IMPORTANT: You are REQUIRED to set a valid save path!
	|
	| 'sessionMatchIP'
	|
	|	Whether to match the user's IP address when reading the session data.
	|
	|	WARNING: If you're using the database driver, don't forget to update
	|	         your session table's PRIMARY KEY when changing this setting.
	|
	| 'sessionTimeToUpdate'
	|
	|	How many seconds between CI regenerating the session ID.
	|
	| 'sessionRegenerateDestroy'
	|
	|	Whether to destroy session data associated with the old session ID
	|	when auto-regenerating the session ID. When set to FALSE, the data
	|	will be later deleted by the garbage collector.
	|
	| Other session cookie settings are shared with the rest of the application,
	| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
	|
	*/
	public $sessionDriver            = 'CodeIgniter\Session\Handlers\FileHandler';
	public $sessionCookieName        = 'ci_session';
	public $sessionExpiration        = 7200;
	public $sessionSavePath          = WRITEPATH . 'session';
	public $sessionMatchIP           = false;
	public $sessionTimeToUpdate      = 300;
	public $sessionRegenerateDestroy = false;

	/*
	|--------------------------------------------------------------------------
    | Cookie Related Variables
    | 쿠키 저장에 필요한 정보를 설정한다.
    |
    | - 도메인, 쿠키가 저장될 폴더 위치 등의 정보는 하나의 사이트 안에서 대부분 일괄된 값을 사용하기 때문에, CI는 이러한 정보를 설정파일을 통해 전역적으로 관리할 수 있게 해준다.
	|--------------------------------------------------------------------------
	|
	| 'cookiePrefix'   = Set a cookie name prefix if you need to avoid collisions
	| 'cookieDomain'   = Set to .your-domain.com for site-wide cookies
	| 'cookiePath'     = Typically will be a forward slash
	| 'cookieSecure'   = Cookie will only be set if a secure HTTPS connection exists.
	| 'cookieHTTPOnly' = Cookie will only be accessible via HTTP(S) (no javascript)
	|
	| Note: These settings (with the exception of 'cookie_prefix' and
	|       'cookie_httponly') will also affect sessions.
    |
    */
    // 모든 쿠키변수가 저장될 때, 이름 앞에 자동으로 붙을 단어
    public $cookiePrefix   = '';
    // 쿠키가 인식될 도메인을 명시 (공백인 경우, 현재 URL의 도메인)
    // ex) 도메인이 `project.com` 인 경우, `.project.com`으로 지정 (앞에 점(.) 주의)
    public $cookieDomain   = '';
    // 쿠키가 인식될 URL상의 경로.
    // "/"로 지정할 경우 사이트 전역에서 인식 가능
    public $cookiePath     = '/';
    // 보안설정 --> 기본값 유지
	public $cookieSecure   = false;
	public $cookieHTTPOnly = false;

	/*
	|--------------------------------------------------------------------------
	| Reverse Proxy IPs
	|--------------------------------------------------------------------------
	|
	| If your server is behind a reverse proxy, you must whitelist the proxy
	| IP addresses from which CodeIgniter should trust headers such as
	| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
	| the visitor's IP address.
	|
	| You can use both an array or a comma-separated list of proxy addresses,
	| as well as specifying whole subnets. Here are a few examples:
	|
	| Comma-separated:	'10.0.1.200,192.168.5.0/24'
	| Array:		array('10.0.1.200', '192.168.5.0/24')
	*/
	public $proxyIPs = '';

	/*
	|--------------------------------------------------------------------------
	| Cross Site Request Forgery
	|--------------------------------------------------------------------------
	| Enables a CSRF cookie token to be set. When set to TRUE, token will be
	| checked on a submitted form. If you are accepting user data, it is strongly
	| recommended CSRF protection be enabled.
	|
	| CSRFTokenName   = The token name
	| CSRFHeaderName  = The header name
	| CSRFCookieName  = The cookie name
	| CSRFExpire      = The number in seconds the token should expire.
	| CSRFRegenerate  = Regenerate token on every submission
	| CSRFRedirect    = Redirect to previous page with error on failure
	*/
	public $CSRFTokenName  = 'csrf_test_name';
	public $CSRFHeaderName = 'X-CSRF-TOKEN';
	public $CSRFCookieName = 'csrf_cookie_name';
	public $CSRFExpire     = 7200;
	public $CSRFRegenerate = true;
	public $CSRFRedirect   = true;

	/*
	|--------------------------------------------------------------------------
	| Content Security Policy
	|--------------------------------------------------------------------------
    | 응답의 콘텐츠 보안 정책을 사용하여 이미지, 스크립트, CSS 파일, 오디오, 비디오 등에 사용할 수 있는 소스를 제한합니다.
    | 이 옵션을 사용하면 응답 개체는 ContentSecurityPolicy.php 파일에서 정책의 기본 값을 채웁니다.
    | 컨트롤러는 항상 런타임에 이러한 제한을 추가할 수 있다.
	|
	| For a better understanding of CSP, see these documents:
	|   - http://www.html5rocks.com/en/tutorials/security/content-security-policy/
	|   - http://www.w3.org/TR/CSP/
	*/
    public $CSPEnabled = false;

    /**
     * ========================================
     * 함수를 통해 수정해야할 설정값들은 생성자에서 처리
     * ========================================
     */
    public function __construct()
    {
        /**
         * ================================
         * 사이트 기본 주소 설정
         *
         * - 현재 접속중인 페이지의 프로토콜을 판별하여 '동적'으로 설정한다.
         * ex) http://framework-v404.php.local/  https://framework-v404.php.com/
         * ================================
         */
        $this->baseURL = (is_https() === TRUE ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . '/';

        /**
         * ===========================================
         * 정규표현식을 사용하여 쿠키 설정 개선
         *
         * - 접속된 도메인에서 서브 도메인을 제외한 메인 도메인만을 자동으로 추출하기 위한 정규표현식의 정의
         *     - `project.com`과 `www.project.com`, `blog.project.com`등을 구분하지 않고, `project.com`만 취득할 수 있다.
         * ===========================================
         */
        // 현재 서버 도메인
        $domain = strtolower(trim($_SERVER['SERVER_NAME']));
        // 서브도메인을 제외한 기본도메인만 추출하기 위한 정규표현식
        // ex) `blog.project.com` --> `project.com`
        $urlRegex = '/^(?:(?:[a-z]+):\/\/)?((?:[a-z\d\-]{2,}\.)+[a-z]{2,})(?::\d{1,5})?(?:\/[^\?]*)?(?:\?.+)?$/i';
        $domainRegex = '/([a-z\d\-]+(?:\.(?:asia|info|name|mobi|com|net|org|biz|tel|xxx|kr|co|so|me|eu|cc|or|pe|ne|re|tv|jp|tw|market|local)){1,2})(?::\d{1,5})?(?:\/[^\?]*)?(?:\?.+)?$/i';

        // if (preg_match($urlRegex, $domain)) { // 정규표현식에 부합될 경우
        //     preg_match($domainRegex, $domain, $matches); // 서브 도메인을 제외한다.
        //     $domain = "." . (empty($matches[1]) ? $domain : $matches[1]); // 취득한 값 앞에 점을 붙인다.
        // }

        // 정규표현식을 통해 도메인이 일관되게 설정됟록 구성하면, 사용자가 `www.project.com`, `project.com` 어느쪽으로 접근하더라도, 값이 유실되지 않고 지속될 수 있다.
        $this->cookieDomain = $domain; // 취득한 도메인을 환경설정에 적용
    }
}
