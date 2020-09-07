<?php

/**
 * =====================
 * 직접 헬퍼 정의해 보기
 * =====================
 */

// `say_eng`라는 함수가 존재하지 않는다면?
if (! function_exists('say_eng'))
{
	function say_eng()
	{
        echo '<h1>Hello CodeIgniter</h1>';
	}
}

if (! function_exists('say_kor'))
{
	function say_kor()
	{
        echo '<h1>안녕하세요. 코드이그나이터</h1>';
	}
}