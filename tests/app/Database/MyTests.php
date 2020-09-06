<?php namespace App\Database;

use CodeIgniter\Test\CIDatabaseTestCase;

/**
 * CI가 테스트를 위해 제공하는 내장 데이터베이스 도구를 이용하려면 테스트에서 `CIDatabaseTestCase`를 확장해야 한다.
 */
class MyTests extends CIDatabaseTestCase
{
    /**
     * ==========================
     * 마이그레이션과 시드
     *
     * - 테스트를 실행할 때 데이터베이스에 올바른 스키마 설정이 있고 모든 테스트에 대해 알려진 상태인지 확인해야 한다.
     * - 테스트에 몇 가지 클래스 속성을 추가하면 마이그레이션 및 시드를 사용하여 데이터베이스를 설정할 수 있다.
     * ==========================
     */

    /**
     * 이 부울 값은 모든 테스트 전에 데이터베이스가 완전히 새로 고쳐지는지 여부를 결정한다.
     * true인 경우, 모든 마이그레이션이 버전 0으로 롤백된다.
     * 데이터베이스는 항상 `$namespace`에 의해 정의된 사용 가능한 최신 상태로 마이그레이션된다.
     * 사용 가능한 모든 네임스페이스에서 마이그레이션을 실행하려면 이 속성을 `null`로 설정한다.
     *
     * @var boolean $refresh
     */
    protected $refresh = true;
    /**
     * 모든 테스트 실행 전에 데이테베이스를 테스트 데이터로 채우는 데 사용되는 Seed 파일의 이름을 지정한다.
     *
     * @var string $seed
     */
    protected $seed = 'TestSeeder';
    /**
     * 기본적으로 CI는 `tests/_support/Database/Seeds`에서 테스트 중 실행해야 하는 시드를 찾는다.
     * `$basePath` 속성을 지정하여 이 디렉터를 변경할 수 있다.
     * 여기에는 `seeds` 디렉토리가 아니라 하위 디렉토리를 보유한 단일 디렉토리의 경로가 포함되어야 한다.
     *
     * @var string $basePath
     */
    protected $basePath = 'tests/Database/Seeds';
    /**
     * 기본적으로 CI는 `tests/_support/DatabaseTestMigrations/Database/Migrations`에서 테스트 중에 실행해야 할 마이그레이션을 찾는다.
     * `$namespace` 속성에 새 네임스페이스를 지정하여 이 위치를 변경할 수 있다.
     * 이 속성 `Database/Migrations` 경로가 아니라 기본 네임스페이스가 포함되어야 한다.
     *
     * @var string $namespace
     */
    protected $namespace = 'tests/Database/Migrations';

    /**
     * `setUp()` 및 `tearDown()` 단계에서 특수 기능이 실행되므로 해당 메소드를 사용해야 하는 경우, 부모의 메소드를 호출해야 한다.
     * - 그렇지 않으면 여기에 설명된 기능 중 대부분이 동작하지 않는다.
     */

    public function setUp()
    {
        parent::setUp();

        // Do something here...
    }

    public function tearDown()
    {
        parent::tearDown();

        // Do something here...
    }
}