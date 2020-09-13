<?php namespace Config;

/**
 * Database Configuration
 *
 * @package Config
 */

class Database extends \CodeIgniter\Database\Config
{
	/**
	 * The directory that holds the Migrations
	 * and Seeds directories.
	 *
	 * @var string
	 */
	public $filesPath = APPPATH . 'Database/';

	/**
	 * Lets you choose which connection group to
	 * use if no other is specified.
	 *
	 * @var string
	 */
    public $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array
     */
    public $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => '',
        'password' => '',
        'database' => '',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'cacheOn'  => false,
        'cacheDir' => '',
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

	/**
     * The default database connection.
     *
	 * This database connection is used when
	 * running PHPUnit database tests.
	 *
	 * @var array
	 */
	public $tests = [
		'DSN'      => '', // DSN 연결 문자열 (일체형 구성)
		'hostname' => '127.0.0.1', // 호스트 이름
		'username' => '', // 사용자 이름
		'password' => '', // 비밀번호
		'database' => '', // 데이터베이스 이름
		'DBDriver' => 'MySQLi', // 데이터베이스 유형
		'DBPrefix' => '', // 쿼리 빌더 쿼리를 실행할 때 테이블 이름에 추가될 선택적 테이블 접두사.
		'pConnect' => false, // 지속적 연결 사용 여부
		'DBDebug'  => (ENVIRONMENT !== 'production'), // 데이터베이스 오류를 표시해야 하는지 여부
		'cacheOn'  => false, // 쿼리 캐싱 사용 여부
		'cacheDir' => '', // 쿼리 캐시 디렉토리 서버의 절대 경로
		'charset'  => 'utf8', // 사용되는 문자 세트
		'DBCollat' => 'utf8_general_ci', // 사용되는 문자 조합 (MySQLi 드라이버에서만 사용된다.)
		'swapPre'  => '', // dbprefix 와 교체(swap) 되는 기본 테이블 접두사. 수동으로 작성된 쿼리를 실행할 수 있다.
		'encrypt'  => false, // 암호화된 연결을 사용할지 여부
		'compress' => false, // 클라이언트 압축 사용 여부 (MySQL 전용)
		'strictOn' => true, // "엄격 모드" 연결을 강제 적용할지 여부. 어플리케이션을 개발하는 동안 엄격한 SQL을 보장하는데 좋다.
		'failover' => [], // 메인 연결이 어떤 이유로 연결될 수 없는 상황에 대해 설정하여 장애 조치를 지정할 수 있다.
		'port'     => 3306, // 포트 번호.
    ];
    // $tests['schema] = 'public'; // --> PostgreSQL 및 ODBC 드라이버에서 사용

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		// Ensure that we always set the database group to 'tests' if
		// we are currently running an automated test suite, so that
		// we don't overwrite live data on accident.
		if (ENVIRONMENT === 'development')
		{
			$this->defaultGroup = 'tests';

			// Under Travis-CI, we can set an ENV var named 'DB_GROUP'
			// so that we can test against multiple databases.
			if ($group = getenv('DB'))
			{
				if (is_file(TESTPATH . 'travis/Database.php'))
				{
					require TESTPATH . 'travis/Database.php';

					if (! empty($dbconfig) && array_key_exists($group, $dbconfig))
					{
						$this->tests = $dbconfig[$group];
					}
				}
			}
		}
	}

	//--------------------------------------------------------------------

}
