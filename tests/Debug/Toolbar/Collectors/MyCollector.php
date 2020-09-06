<?php namespace Debug\Toolbar\Collectors;

use CodeIgniter\Debug\Toolbar\Collectors\BaseCollector;

/**
 * 사용자 정의 수집기 생성
 *
 * - 사용자 정의 수집기는 간단하게 작성할 수 있다.
 * - 오토로더가 찾을 수 있도록 완전한(full) 네임스페이스의 `CodeIgniter\Debug\Toolbar\Collectors\BaseController`를 확장하는 새 클래스를 작성한다.
 * - 여기에는 재정의할 수 있는 여러 가지 메소드가 제공되며, 수집기 작동 방식에 따라 올바르게 설정해야하는 4가지 필수 클래스 속성이 있다.
 */
class MyCollector extends BaseCollector
{
    /**
     * 툴바의 타임 라인에 정보를 표시하려는 수집기에 대해 `true`로 설정한다.
     * - 이 값이 true라면, 표시할 데이터를 포맷하고 반환하기 위해 `formatTimelineData()` 메소드를 구현해야 한다.
     *
     * @var boolean $hasTimeline
     */
    protected $hasTimeline = false;
    /**
     * 수집기가 사용자 정의 컨텐츠 자체를 탭에 표시하고자 하는 경우 `true`로 설정한다.
     * - 이것이 true라면 `$title`을 제공하고 탭의 내용을 렌더링하는 `display()` 메소드를 구현해야 하며, 탭 내용의 제목 오른쪽에 추가 정보를 표시하기 위해 `getTitleDetails()` 메소드를 구현해야 할 수도 있다.
     *
     * @var boolean $hasTabContent
     */
    protected $hasTabContent = false;
    /**
     * 수집기가 `Vars` 탭에 추가 데이터를 추가하려면 `true`로 설정한다.
     * - 이것이 true라면, `getVarData()` 메소드를 구현해야 한다.
     *
     * @var boolean $hasVarData
     */
    protected $hasVarData = false;
    /**
     * 열려 있는 탭에 표시된다.
     *
     * @var string $title
     */
    protected $title = '';

    /**
     * =======================
     * 툴바 탭 표시
     *
     * - 툴바 탭을 표시하려면
     *     1. 툴바 제목과 탭 머리글에 모두 표시되는 텍스트를 `$title`에 채운다.
     *     2. `$hasTabContent`를 `true`로 설정한다.
     *     3. `display()` 메소드를 구현한다.
     *     4. 필요에 따라 `getTitleDetails()` 메소드를 구현한다.
     *
     * - `display()`는 탭 자체에 표시되는 HTML을 만든다.
     *     - 탭 제목은 툴바에서 자동으로 처리되므로 걱정하지 않아도 된다.
     *     - HTML 문자열을 반환해야 한다.
     *
     * - `getTitleDetails()` 메소드는 탭 제목의 오른쪽에 표시되는 문자열을 반환해야 한다.
     *     - 추가 개요 정보를 제공하는데 사용할 수 있다.
     *     - 예를 들어 데이터베이스 탭에는 모든 연결에 대한 총 쿼리 수가 표시되고 파일 탭에는 총 파일 수가 표시된다.
     * =======================
     */

    /**
     * ==================================
     * 타임 라인 데이터 제공
     *
     * - 타임 라인에 표시할 정보를 제공하려면
     *     1. `$hasTimeline`을 `true`로 설정한다.
     *     2. `formatTimelineData()` 메소드를 구현한다.
     *
     * - `formatTimelineData()` 메소드는 타임 라인에서 이를 사용하여 올바르게 정렬하고, 올바른 정보를 표시할 수 있는 형식의 배열을 반환해야 한다.
     *     - 내부 배열에는 다음 정보가 포함되어야 한다.
     *         - name, component, start, duration
     * ==================================
     */

    /**
     * ===========================
     * Vars 제공
     *
     * - Vars 탭에 데이터를 추가하려면 다음을 수행한다.
     *     1. `$hasVarData`를 `true`로 설정한다.
     *     2. `getVarData()` 메소드를 구현한다.
     *
     * - `getVarData()` 메소드는 표시할 키/값 쌍의 배열을 포함하는 배열을 반환해야 한다.
     *     - 외부 배열 키의 이름은 Vars 탭의 섹션 이름이다.
     * ===========================
     */
}