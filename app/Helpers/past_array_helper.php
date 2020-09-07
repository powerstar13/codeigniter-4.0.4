<?php

/**
 * ======================================
 * CI4에서 사라진 이전 array 헬퍼 함수 정의
 * ======================================
 */

// ------------------------------------------------------------------------

if ( ! function_exists('element'))
{
	/**
	 * 배열에서 원소 추출하기
	 *
	 * 배열에서 특정 키에 맵핑되는 값을 리턴한다.
     * - Classic PHP는 배열에서 존재하지 않는 키에 접근하면 에러가 발생하기 때문에, 해당 키가 존재하는지를 먼저 검사해야 하지만, 이 함수는 이에 대한 예외처리를 포함한다.
	 *
	 * @param string $item - 추출하고자 하는 데이터에 대한 배열 키
	 * @param array $array - 데이터를 담고 있는 배열
	 * @param mixed $default - 값이 존재하지 않을 경우 대신 리턴 될 기본값 (생략시 null이 사용된다.)
	 * @return mixed `$array[$item]`에 해당하는 값
	 */
	function element($item, array $array, $default = NULL)
	{
		return array_key_exists($item, $array) ? $array[$item] : $default;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('elements'))
{
	/**
	 * 배열에서 복수의 원소 추출하기
	 *
	 * - 배열에서 특정 키에 맵핑되는 값들을 리턴한다.
	 *
	 * @param	array $items - 추출하고자 하는 데이터에 대한 배열들을 `배열 형태`로 전달한다.
	 * @param	array $array - 데이터를 담고 있는 배열
	 * @param	mixed $default - 값이 존재하지 않을 경우 대신 리턴될 기본값 (생략시 null이 사용된다.)
	 * @return	mixed `$items`에 포함된 인덱스에 대응되는 값들을 새로운 배열 형태로 리턴한다.
	 */
	function elements($items, array $array, $default = NULL)
	{
		$return = array();

		is_array($items) OR $items = array($items);

		foreach ($items as $item)
		{
			$return[$item] = array_key_exists($item, $array) ? $array[$item] : $default;
		}

		return $return;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('random_element'))
{
	/**
	 * 배열에서 임의의 요소 하나를 추출하기
	 *
	 * @param	array $array - 데이터를 담고 있는 배열
	 * @return	mixed $array에 담겨 있는 값들 중 임의의 원소 하나
	 */
	function random_element($array)
	{
		return is_array($array) ? $array[array_rand($array)] : $array;
	}
}

// --------------------------------------------------------------------