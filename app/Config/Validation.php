<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
    //--------------------------------------------------------------------

    /**
     * 규칙을 저장하는 방법 v1
     * - 검증 규칙을 저장하려면 `Config\Validation` 클래스에 그룹 이름으로 새로운 공용 속성을 만들면 된다.
     * - 이 요소는 검증 규칙이 있는 배열을 보유한다.
     * - 다음은 검증 배열에 대한 프로토 타입이다.
     */
    public $signup = [
        'username'     => 'required|alpha_numeric_space|min_length[3]',
        'email'        => 'required|valid_email|is_unique[users.email, id, {id}]',
        'password'     => 'required|min_length[8]',
        'pass_confirm' => 'required_with[password]|matches[password]',
    ];

    // run() 메소드를 호출할 때 사용할 그룹을 지정한다.
    // $validation->run($data, 'signup');

    // v1 : 속성을 그룹과 동일하게 지정하고 `_errors`를 추가하여 이 구성 파일에 사용자 정의 오류 메시지를 저장할 수 있다.
    // 이 그룹을 사용할 때 오류는 자동으로 사용된다.
    public $signup_errors = [
        'username' => [
            'required' => 'You must choose a username',
        ],
        'email' => [
            'required' => 'We really need your email.',
            'valid_email' => 'Please check the Email field. It does not appear to be valid.',
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
        ]
    ];

    /**
     * 규칙을 저장하는 방법 v2
     * - 또는 배열에 모든 설정을 전달한다.
     */
    public $signup2 = [
        'username' => [
            'label' => 'Username',
            'rules' => 'required|alpha_numeric_space|min_length[3]',
            'errors' => [
                'required' => 'You must choose a username',
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|is_unique[users.email, id, {id}]',
            'errors' => [
                'required' => 'We really need your email.',
                'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
            ]
        ],
    ];

    /**
     * ==================================
     * News
     * ==================================
     */

    // 뉴스 아이템 추가 규칙
    public $newsCreate = [
        'title' => 'required|min_length[3]|max_length[255]',
        'body' => 'required'
    ];
}
