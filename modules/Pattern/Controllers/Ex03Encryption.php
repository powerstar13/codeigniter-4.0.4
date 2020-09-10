<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;

/**
 * 암호화 라이브러리
 */
class Ex03Encryption extends BaseController
{
    private $encrypter;

    public function __construct()
    {
        parent::__construct();
        $this->encrypter = service('encrypter'); // 암호화 라이브러리 로드
    }

    /**
     * 암호화 및 복호화 처리
     *
     * - 같은 문자열을 암호화 할 때마다 매번 다른 결과값을 리턴한다.
     * - 하지만 복호화하면 원래의 값을 훌륭하게 복구해 낸다.
     *
     * @return void
     */
    public function index()
    {
        $plainText = 'This is a plain-text message'; // 암호화 할 문자열
        // string을 암호화 하여 리턴한다.
        $ciphertext = $this->encrypter->encrypt($plainText); // 암호화
        debug(base64_encode($ciphertext), 'encrypt'); // 결과 확인하기
        // 암호화된 문자열을 다시 원래의 문자열로 되돌린 후 리턴한다.
        $decryptText = $this->encrypter->decrypt($ciphertext); // 복호화
        debug($decryptText, 'decrypt'); // 결과 확인하기
    }
}