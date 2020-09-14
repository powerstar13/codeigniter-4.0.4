<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * User Agent 클래스
 *
 * - User Agent 클래스는 브라우저, 모바일 장치 또는 사이트를 방문하는 로봇에 대한 정보를 식별하는 데 도움이 되는 기능을 제공한다.
 */
class UserAgentController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * User Agent 클래스가 초기화되면 사이트를 탐색하는 User Agent가 웹 브라우저, 모바일 장치 또는 로봇인지 확인하려고 시도한다.
     * - 사용 가능한 경우 플랫폼 정보도 수집한다.
     *
     * @return void
     */
    public function index()
    {
        // - User Agent 클래스는 언제든지 `IncomingRequest` 인스턴스에서 직접 사용할 수 있다.
        // - 기본적으로 컨트롤러는 User Agent 클래스를 검색할 수 있는 요청 인스턴스가 있다.
        $agent = $this->request->getUserAgent();
        debug($agent->getAgentString(), 'Agent String');

        if ($agent->isBrowser()) {
            $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } else if ($agent->isRobot()) {
            $currentAgent = $agent->getRobot();
        } else if ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
        } else if ($agent->isReferral()) {
            $currentAgent = $agent->getReferrer();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }

        debug($currentAgent, 'currentAgent');
        debug($agent->getPlatform(), 'Platform'); // Platform info (Windows, Linux, Mac, etc.)
    }
}