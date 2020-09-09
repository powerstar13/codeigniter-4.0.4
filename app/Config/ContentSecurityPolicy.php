<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Class ContentSecurityPolicyConfig
 *
 * 콘텐츠 보안 정책의 기본 설정을 사용하려면 저장합니다.
 * 여기 값은 사이트에서 읽고 사이트의 기본값으로 설정됩니다.
 * 필요한 경우 페이지별로 재지정할 수 있습니다.
 *
 * Suggested reference for explanations:
 *    https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 *
 * @package Config
 */
class ContentSecurityPolicy extends BaseConfig
{
	// broadbrush CSP management

	public $reportOnly              = false; // 기본 지시문 처리 지정
	public $reportURI               = null; // "report-only" 보고서가 전송될 URL을 지정
	public $upgradeInsecureRequests = false; // HTTP 요청을 HTTPS로 업그레이드하도록 지정

	// sources allowed; string or array of strings
	// Note: once you set a policy to 'none', it cannot be further restricted

	public $defaultSrc     = null; // 지시문에 대해 제공된 것이 없는 경우 사용할 원점을 지정
	public $scriptSrc      = 'self';
	public $styleSrc       = 'self';
	public $imageSrc       = 'self';
	public $baseURI        = null;    // will default to self if not over-ridden
	public $childSrc       = 'self';
	public $connectSrc     = 'self';
	public $fontSrc        = null;
	public $formAction     = 'self';
	public $frameAncestors = null;
	public $mediaSrc       = null;
	public $objectSrc      = 'self';
	public $manifestSrc    = null;

	// mime types allowed; string or array of strings
	public $pluginTypes = null;

	// list of actions allowed; string or array of strings
	public $sandbox = null;

}
