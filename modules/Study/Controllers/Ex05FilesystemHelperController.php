<?php namespace Modules\Study\Controllers;

use App\Controllers\BaseController;

/**
 * filesystem_helper 기능 살펴보기
 */
class Ex05FilesystemHelperController extends BaseController
{
    /** 생성자. 클래스가 초기화될 때 자동 실행됨 */
    public function __construct()
    {
        // 상위 클래스의 생성자 호출 --> CI의 기본기능 초기화
        parent::__construct();

        // helper 로드
        helper(['filesystem', 'util']);
    }

    /**
     * ======================
     * Path
     * - 경로 문자열 처리에 관련된 편의 기능을 제공하는 헬퍼
     * ======================
     */

    /**
     * 상대경로를 절대경로로 변환
     * - 상대경로가 실제로 존재하는지 검사하여 경로가 존재할 경우 절대경로를 반환한다.
     *
     * @param   string  $path             : 검사하고자 하는 상대경로 (DOCUMENT_ROOT의 index.php 기준)
     * @param   bool    $check_existence  : 경로가 실재로 존재하는지 확인 (`TRUE`일 경우, 존재하지 않는 경로일 때 InvalidArgumentException 발생)
     * @return  string (1) : 존재하는 경로일 경우, 절대경로로 변환된 값
     * @return  string (2) : 존재하지 않는 경로일 경우, 파라미터를 그대로 리턴한다.
     */
    public function setRealpath()
    {
        /** (1) 존재하지 않는 경로에 대한 검사 */
        $path = './test';
        // 존재하지 않을 경우 파라미터와 리턴값이 동일하다.
        $check = set_realpath($path);
        // 리턴결과 확인
        if ($check === $path) {
            debug($path . '는 존재하지 않습니다.');
        } else {
            debug($check);
        }

        /** (2) 존재하는 경로에 대한 검사 */
        $path = '../modules/Study/Controllers/Ex05FilesystemHelperController.php';
        // 존재하는 경로인 경우 절대경로가 리턴된다.
        $check = set_realpath($path);
        // 리턴결과 확인
        if ($check === $path) {
            debug($path . '는 존재하지 않습니다.');
        } else {
            debug($check);
        }
    }

    /**
     * ================================
     * Directory
     * - 특정 폴더의 하위 정보를 추출할 수 있는 기능을 제공하는 헬퍼
     * ================================
     */

    /**
     * 디렉토리 하위 계층 정보
     * - 주어진 경로 하위의 디렉토리 정보를 리턴한다.
     *
     * @param   string  $source_dir       : 검사하고자 하는 상대경로 (DOCUMENT_ROOT의 index.php 기준)
     * @param   int     $directory_depth  : 검사하고자 하는 depth (기본값 0 = 전체)
     * @param   bool    $hidden           : 숨김파일의 정보를 포함할지 여부 (기본값 false)
     * @return  array 하위 디렉토리 정보를 배열의 계층으로 리턴한다.
     */
    public function directoryMap()
    {
        $map = directory_map('../', 0, true);
        debug($map);
    }

    /**
     * ===========================
     * File
     * - 파일 처리 관련 편의 기능을 제공하는 헬퍼
     * ===========================
     */
    public function makeFile()
    {
        /**
         * (1) 파일 쓰기
         * - 파일 내용을 지정된 경로에 쓴다.
         * - 파일이 없을 경우 파일을 생성한다.
         *
         * @param   string  $path  : 대상파일 상대경로 (DOCUMENT_ROOT의 index.php를 기준)
         * @param   string  $data  : 저장할 내용
         * @param   string  $mode  : PHP의 파일 저장 모드 (기본값 'wb')
         *     - 파일 저장 모드 값 종류
         *         - 'r' : 읽기 전용
         *         - 'r+' : 읽기, 쓰기 겸용
         *         - 'w' : 쓰기 전용. 기존의 내용은 삭제되고, 새롭게 파일을 만든다. 혹은 파일이 존재하지 않을 경우 새로 만든다.
         *         - 'w+' : 읽기, 쓰기 겸용. 기존의 내용은 삭제되고 새롭게 파일을 만든다. 혹은 파일이 존재하지 않을 경우 새로 만든다.
         *         - 'a' : 기존의 파일에 내용을 추가한다. 파일이 존재하지 않는다면 새로 만든다.
         *         - 'a+' : 내용 추가와 읽기 모드로 파일을 열어 기존의 내용 뒤에 추가한다. 파일이 존재하지 않는다면 새로 만든다.
         * @return  bool 파일 저장 성공/실패 여부
         */
        $filename = time() . '_makeFile.txt'; // 저장할 파일의 이름
        $dir = '../writable/temp'; // 파일이 저장될 폴더
        $filepath = "{$dir}/{$filename}"; // 저장할 파일 경로

        // [PHP함수] 폴더가 없다면 생성한다.
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        // 파일에 내용 저장하기
        $str = sprintf('[%s] CI 파일쓰기', date('Y-m-d H:i:s'));
        $result = write_file($filepath, $str);

        if (!$result) {
            // 컨트롤러의 수행을 중단하기 위해서 return 처리
            return debug("{$filepath} 파일 저장 실패", 'write_file');
        }

        /**
         * (2) 파일의 정보 조회하기
         * - 파일 경로가 주어지면 `파일명, 경로, 크기, 수정된 날짜`를 리턴한다.
         *
         * @param   string       $file             대상파일 상대경로 (DOCUMENT_ROOT의 index.php를 기준)
         * @param   mixed        $returned_values  배열 또는 쉼표로 구분된 문자열로 전달하기 위해 반환할 정보 유형
         *     - 유효한 $returned_values 옵션 : name, server_path, size, date, readable, writable, executable, fileperms
         * @return  array 파일정보 배열 (파일명, 경로, 크기, 수정된 날짜 --> name, server_path, size, date)
         *     - 파일이 없을 경우 FALSE 리턴됨
         */
        $info = get_file_info($filepath, 'name,server_path,size,date,readable,writable,executable,fileperms');
        debug($info, 'get_file_info');

        /**
         * (3) 파일의 종류 조회하기
         * - 파일 확장자를 /Config/Mimes.php 에 기록된 mime type으로 변환한다.
         *
         * - CI3 : get_mime_by_extendtion($file)
         * - CI4 : new \CodeIgniter\Files\File($path)->getMimeType();
         */
        $file = new \CodeIgniter\Files\File($filepath);
        $type = $file->getMimeType();
        debug($type, 'getMimeType');

        /**
         * (4) [PHP함수] 저장된 파일의 내용 읽어오기
         * - 파일이 없을 경우 FALSE 리턴됨.
         */
        $contents = file_get_contents($filepath);
        debug($contents, 'file_get_contents');
    }

    /**
     * 특정 디렉토리 내의 파일이름들 가져오기
     * - 주어진 폴더 하위의 파일이름들을 배열로 리턴한다.
     *
     * @param string $source_dir : 조회할 디렉토리 상대경로 (DOCUMENT_ROOT의 index.php를 기준)
     * @param bool $include_path : TRUE = 절대경로 형태로 조회, FALSE = 파일이름만 조회
     * @param bool $hidden : 숨겨진 파일도 가져올 것인지 여부
     * @return array 파일 이름들에 대한 배열
     */
    public function filenames()
    {
        /** "../writable/temp" 디렉토리 내의 파일이름들 조회하기 */
        // 해당 폴더 안의 파일들의 "이름"을 가져오기
        $files = get_filenames('../writable/temp', FALSE);
        debug($files, 'get_filenames_이름');

        // 해당 폴더 안의 파일들의 "절대경로"를 가져오기
        $realFiles = get_filenames('../writable/temp', TRUE);
        debug($realFiles, 'get_filenames_절대경로');
    }

    /**
     * 특정 디렉토리 내의 파일들에 대한 상세 정보 가져오기
     * - 지정된 디렉토리를 읽은 후 파일명, 크기, 날짜, 권한 등을 담은 배열을 리턴한다.
     *
     * @param   string  $source_dir      : 조회할 디렉토리 상대경로 (DOCUMENT_ROOT의 index.php를 기준)
     * @param   bool    $top_level_only  : TRUE = 주어진 폴더만 조회, FALSE = 주어진 경로 하위의 모든 파일들의 정보를 조회
     * @param   bool    $recursion       : 재귀 상태를 결정
     * @return  array 파일 정보(파일 이름, 파일 크기, 날짜 및 권한을 포함)들에 대한 배열
     */
    public function dirFileInfo()
    {
        // 지정된 폴더 안의 모든 파일들의 상세정보 조회하기
        $info = get_dir_file_info('../writable/temp');
        debug($info, 'get_dir_file_info');
    }

    /**
     * 특정 경로 내 모든 파일 삭제
     * - 지정된 경로내의 모든 파일들을 삭제한다.
     *
     * @param   string  $path     : 삭제할 파일들을 보관하고 있는 폴더의 상대경로 (DOCUMENT_ROOT의 index.php를 기준)
     * @param   bool    $del_dir  : TRUE = 폴더들까지 함께 삭제, FALSE = 폴더는 남겨두고 파일들만 삭제
     * @param   bool    $htdocs   : .htaccess 및 인덱스 페이지 파일 삭제를 건너뛸지 여부
     * @param   bool    $hidden   : 숨겨진 파일 포함 여부(기간부터 시작되는 파일)
     *
     * @return  bool 삭제 성공 여부
     */
    public function delete()
    {
        $dir = '../writable/temp';
        /** "../writable/temp" 경로 내의 모든 파일, 폴더 삭제하기 */
        if (!is_dir($dir)) {
            return debug('해당 폴더는 존재하지 않습니다.');
        }
        // 지정된 폴더 내의 모든 항목들 삭제
        $ok = delete_files($dir, TRUE); // --> FIXME: 폴더는 삭제 안되고 있음 확인 필요

        if ($ok) {
            debug("삭제완료", 'delete_files');
        } else {
            debug("삭제실패", 'delete_files');
        }
    }
}