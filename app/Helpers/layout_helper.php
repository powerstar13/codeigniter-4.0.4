<?php

/**
 * =====================
 * Layout
 * =====================
 */

if (! function_exists('default_layout'))
{
    /**
     * 기본 레이아웃
     *
     * @param string $viewpath : 보여질 content view
     * @param array $resource : 전달될 데이터 원본
     * @return view
     */
	function default_layout(string $viewpath, array $resource = [])
	{
        if (empty($viewpath)) {
            throw new \RuntimeException('전달된 뷰 경로가 없습니다.', 400);
        }
        $data = array(
            'viewpath' => $viewpath, // 보여줄 화면경로
            'data' => $resource // 데이터 원본
        );
        // 화면 출력
        return view('layout/default/index', $data);
	}
}
