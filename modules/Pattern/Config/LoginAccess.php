<?php namespace Modules\Pattern\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * 로그인 여부에 따른 페이지 접근 제어 위한 환경설정
 */
class LoginAccess extends BaseConfig
{
    // 로그인 상태에서는 접근할 수 없는 페이지들
    public $onlyGuest = array(
        '/',
        'member/login', // 로그인 페이지
        'member/login_confirm', // 로그인 처리
        'member/join', // 회원가입
        'member/join_confirm', // 회원가입 처리
        'member/join_success', // 회원가입 성공
        'member/find_pw', // 비밀번호 찾기
        'member/find_pw_confirm', // 비밀번호 확인 처리
        'member/find_pw_success', // 비밀번호 찾기 성공
    );

    // 로그인하지 않은 상태에서는 접근할 수 없는 페이지들
    public $onlyMember = array(
        'member/logout', // 로그아웃
        'member/out', // 회원탈퇴
        'member/out_confirm', // 회원탈퇴 처리
        'member/buy', // 회원탈퇴 성공
        'member/edit', // 정보수정
        'member/edit_confirm', // 정보수정 처리
        'member/edit_success', // 정보수정 성공
    );
}