<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AppInfo extends BaseCommand
{
    /**
     * `$group` 속성은 단순히 존재하는 다른 모든 명령으로 이 명령을 구성하는 방법을 알려주며, 그 아래에 나열할 제목을 알려준다.
     *
     * @var string $group
     */
    protected $group = 'demo';
    /**
     * `$name` 속성은 이 명령을 호출할 수 있는 이름이다.
     * - 유일한 요구 사항은 공백을 포함하지 않아야하면, 모든 문자는 커맨드 라인 자체에서 유효해야 한다.
     * - 그러나 일반적으로 명령은 소문자이며, 명령 이름 자체와 함께 콘솔을 사용하여 명령 추가로 그룹화한다.
     * - 그룹화는 여러 명령의 이름 충돌을 방지하는데 도움이 된다.
     *
     * @var string $name
     */
    protected $name = 'app:info';
    /**
     * `$description`은 `list` 명령에 표시되는 짧은 문자열이며 명령의 기능을 설명해야 한다.
     *
     * @var string $description
     */
    protected $description = 'Displays basic application information';

    /**
     * `run()` 메소드는 명령이 실행될 때 호출되는 메소드이다.
     * - `$pramas` 배열은 사용할 명령 이름 뒤의 CLI 인수의 목록이다.
     * - CLI 문자열이 아래와 같다면
     *     - php spark foo bar baz
     *     - `foo`는 명령이고 `$params` 배열은
     *         - $params = ['bar', 'baz'];
     * - 이것도 CLI 라이브러리를 통해 액세스할 수 있지만 문자열에서 이미 명령이 제거되었다.
     *     - 이 매개 변수는 스크립트 동작 방식을 사용자 정의할 때 사용할 수 있다.
     * - 데모 명령의 `run` 메소드는 다음과 같다.
     *
     * @param array $params
     * @return void
     */
    public function run(array $params)
    {
        CLI::write('PHP Version: '. CLI::color(phpversion(), 'yellow'));
        CLI::write('CI Version: '. CLI::color(\CodeIgniter\CodeIgniter::CI_VERSION, 'yellow'));
        CLI::write('APPPATH: '. CLI::color(APPPATH, 'yellow'));
        CLI::write('SYSTEMPATH: '. CLI::color(SYSTEMPATH, 'yellow'));
        CLI::write('ROOTPATH: '. CLI::color(ROOTPATH, 'yellow'));
        CLI::write('Included files: '. CLI::color(count(get_included_files()), 'yellow'));
    }
}