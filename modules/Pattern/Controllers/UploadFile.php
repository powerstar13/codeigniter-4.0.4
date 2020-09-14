<?php namespace Modules\Pattern\Controllers;

use App\Controllers\BaseController;
/**
 * 업로드(upload)된 파일 작업 컨트롤러
 */
class UploadFile extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * All files
     *
     * - 파일을 업로드하면 슈퍼 글로벌 `$_FILES`를 통해 PHP에서 업로드된 파일에 액세스 할 수 있다.
     *     - 이 배열은 한 번에 업로드된 여러 파일을 작업할 때 몇 가지 중요한 단점이 있으며, 많은 개발자가 알지 못하는 잠재적인 보안 결함이 있다.
     *     - CI는 공통 인터페이스 뒤에서 파일 사용을 표준화하여 이러한 상황을 모두 지원한다.
     * - 업로드된 파일은 `IncomingRequest` 인스턴스를 통해 액세스된다.
     *     - 이 요청을 통해 업로드된 모든 파일을 검색하려면 `getFiles()`를 사용하십시오.
     *     - `CodeIgniter\HTTP\Files\UploadFile`의 인스턴스로 표시되는 파일 배열을 반환한다
     *
     * @return void
     */
    public function getAllFiles()
    {
        $files = $this->request->getFiles();
    }

    /**
     * 단일 파일 Input
     *
     * - 단일 파일에 액세스해야 하는 경우, `getFile()`을 사용하여 파일 인스턴스를 직접 검색할 수 있다.
     * - `CodeIgniter\HTTP\Files\UploadedFile`의 인스턴스를 반환한다.
     *
     * @return void
     */
    public function getSingleFile()
    {
        // <input type="file" name="userfile" />
        $file = $this->request->getFile('userfile');

        // 배열 표기법
        // <input type="file" name="my-form[details][avatar]" />
        $file = $this->request->getFile('my-form.details.avatar');

        // 다중 파일
        // <input type="file" name="images[]" multiple />
        if ($imagefile = $this->request->getFiles()) {
            // 여기서 `images`는 다중 폼(form) 필드의 이름이다.
            foreach ($imagefile['images'] as $img) {
                // 파일이 제거되면 임시 파일이 삭제된다.
                // 부울을 반환하는 `hasMoved()` 메소드로 파일이 이동했는지 확인할 수 있다.
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(WRITEPATH . 'uploads', $newName);

                    /**
                     * 다음과 같은 경우 업로드된 파일을 `HTTP/Exception`이 발생하며 이동하지 못할 수 있다.
                     *
                     * - 파일이 이미 이동되었습니다.
                     * - 파일이 성공적으로 업로드되지 않았습니다.
                     * - 파일 이동 작업에 실패합니다. (예: 부적절한 권한)
                     */
                }
            }
        }

        // 이름이 같은 파일이 여러 개 있으면 `getFile()`을 사용하여 모든 파일을 개별적으로 검색할 수 있다.
        $file1 = $this->request->getFile('images.0');
        $file2 = $this->request->getFile('images.1');
        // Note : `getFiles()`를 사용하는 것이 더 적절하다.

        // `getFileMultiple()`을 사용하여 같은 이름으로 업로드된 파일의 배열을 얻는 것이 더 쉬울 수 있다.
        $files = $this->request->getFileMultiple('images');
    }

    public function fileTask()
    {
        $file = $this->request->getFile('userfile');

        /**
         * ============================
         * 파일 확인
         *
         * - `isValid()` 메소드를 호출하여 파일이 실제로 HTTP를 통해 오류없이 업로드되었는지 확인할 수 있다.
         * ============================
         */
        if (!$file->isValid()) {
            throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
        }

        /**
         * 이 예제에서 볼 수 있듯이 파일에 업로드 오류가 있는 경우, `getError()`와 `getErrorString()` 메소드를 사용하여 오류 코드(정수)와 오류 메시지를 검색할 수 있다.
         *     - 다음과 같은 오류를 발견할 수 있다.
         *
         * - 파일이 ini 지시문의 `upload_max_filesize`를 초과합니다.
         * - 파일이 폼에 정의된 업로드 한도를 초과합니다.
         * - 파일이 부분적으로 업로드되었습니다.
         * - 파일이 업로드되지 않았습니다.
         * - 파일을 디스크에 쓸 수 없습니다.
         * - 파일을 업로드할 수 없습니다 : 임시 디렉토리가 없습니다.
         * - PHP 확장자가 포함되어 파일 업로드가 중지되었습니다.
         */

        /**
         * ============================
         * 파일 이름
         * ============================
         */
        // `getName()` 메소드를 사용하여 클라이언트가 제공한 원래 파일 이름을 검색할 수 있다.
        // 이것은 일반적으로 클라이언트가 전송한 파일 이름이므로 신뢰할 수 없다.
        // 파일이 이동된 경우, 이동된 파일의 최종 이름을 반환한다.
        $name = $file->getName();

        // 파일이 이동된 경우에도 클라이언트가 전송한대로 업로드된 파일의 원래 이름을 반환한다.
        $originalName = $file->getClientName();

        // 업로드 중에 생성된 임시 파일의 전체 경로를 얻으려면, `getTempName()` 메소드를 사용한다.
        $tempfile = $file->getTempName();

        /**
         * ============================
         * 파일의 다른 정보
         * ============================
         */
        // 업로드된 파일 이름을 기준으로 원본 파일 확장자를 반환한다.
        // 신뢰할 수 없다.
        // 신뢰할 수 있는 확장자를 원한다면 `getExtension()`을 사용하십시오.
        $ext = $file->getClientExtension();

        // 클라이언트가 제공한 파일의 MIME 유형을 리턴한다.
        // 신뢰할 수 없다.
        // 신뢰할 수 있는 MIME 유형을 원한다면 `getMimeType()`을 사용하십시오.
        $type = $file->getClientMimeType();
        debug($type, 'type'); // ex) image/png
    }

    /**
     * ===============================
     * 파일 저장
     *
     * - 각 파일은 `store()` 메소드를 사용하여 새 위치로 이동할 수 있다.
     * - 기본적으로 업로드 파일은 쓰기 가능한 업로드 디렉토리에 저장된다.
     *     - YYYYMMDD 폴더와 같은 임의의 파일 이름이 생성되고 파일 경로를 반환한다.
     *
     * - 첫 번째 매개 변수로 파일이 이동할 디렉토리를 지정할 수 있다.
     *     - 새 파일 이름은 두 번째 매개 변수로 전달한다.
     *
     * 다음과 같은 경우 업로드된 파일을 `HTTP/Exception`이 발생하며 이동하지 못할 수 있다.
     *
     * - 파일이 이미 이동되었습니다.
     * - 파일이 성공적으로 업로드되지 않았습니다.
     * - 파일 이동 작업에 실패합니다. (예: 부적절한 권한)
     * ===============================
     */
    public function fileSave()
    {
        $path = $this->request->getFile('userfile')->store();
        // 새 파일 이름 전달하는 방법
        $path = $this->request->getFile('userfile')->store('head_img/', 'user_name.jpg');
    }
}