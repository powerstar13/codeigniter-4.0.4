<?php namespace Modules\Pattern\Libraries;

class FileLib
{
    /**
     * 파일 작업
     *
     * @param string $path : 파일의 경로
     * @return void
     */
    public function useFile($path)
    {
        /**
         * =================================================
         * (1) 파일 인스턴스 얻기
         *
         * - 생성자의 파일 경로를 전달하여 새 File 인스턴스를 만든다.
         * - 기본적으로 파일은 존재하지 않아도 된다.
         * - 그러나 추가 인수로 `true`를 전달하여 파일이 존재하는지 확인하고, 파일이 없으면 `FileNotFoundException()`을 던질 수 있다.
         * =================================================
         */
        $file = new \CodeIgniter\Files\File($path);

        /**
         * =================================================
         * (2) Spl의 장점 활용
         *
         * - 인스턴스가 있으면 다음을 포함하여 SplFileInfo 클래스의 모든 기능을 사용할 수 있다.
         * =================================================
         */
        // 파일의 basename 가져오기
        debug($file->getBasename(), 'basename');
        // 마지막 수정 시간 가져오기
        debug($file->getMTime(), 'Last modified time');
        // 절대경로 가져오기
        debug($file->getRealPath(), 'Real path');
        // 파일 권한 가져오기
        debug($file->getPerms(), 'permissions');

        // CSV rows 작성
        if ($file->isWritable()) {
            $csv = $file->openFile('w');

            $rows = array();

            foreach ($rows as $row) {
                $csv->fputcsv($row);
            }
        }

        /**
         * =================================================
         * (3) 새로운 기능
         *
         * - SplFileInfo 클래스의 모든 메소드 외에도 몇 가지 새로운 도구가 제공된다.
         * =================================================
         */
        // `getRandomName()` 메소드를 사용하여 현재 타임 스탬프와 미리 지정된 암호로 임의의 안전한 파일 이름을 생성할 수 있다.
        // 파일을 이동할 때 파일 이름을 알아볼 수 없도록 이름을 바꾸는 데 특히 유용하다.
        debug($file->getRandomName(), 'random name'); // ex) 1465965676_385e33f741.jpg

        // 업로드된 파일의 크기를 바이트 단위로 반환한다.
        // 첫 번째 매개 변수로 'kb' 또는 'mb'를 전달하여 킬로바이트 또는 메가바이트로 변환할 수 있다.
        debug($file->getSize(), 'bytes'); // 256901
        debug($file->getSize('kb'), 'kilobytes'); // 250.880
        debug($file->getSize('mb'), 'megabytes'); // 0.245

        // 파일의 미디어 타입 (mime type)을 얻어 온다.
        // 파일 유형을 결정할 때, 가능한 한 안전한 것으로 간주되는 메소드를 사용한다.
        debug($file->getMimeType(), 'Mime type'); // ex) image/png

        // 신뢰할 수 있는 `getMimeType()` 메소드를 기반으로 파일 확장자를 판별한다.
        // MIME 형식을 알 수 없으면 NULL을 반환한다.
        // 이 방법은 파일 이름으로 제공되는 확장자를 사용하는 것보다 더 신뢰할 수 있다.
        // 확장을 결정하기 위해 `app/Confg/Mime.php`의 값을 사용한다.
        debug($file->guessExtension(), 'ext'); // ex) jpg (without the period)

        // 각 파일은 적절하게 이름이 지정된 `move()` 메소드를 사용하여 새 위치로 이동할 수 있다.
        // 이것은 디렉토리를 사용하여 파일을 첫 번째 매개 변수로 이동시킨다.
        // 기본적으로 원래 파일 이름이 사용된다.
        // 두 번째 매개 변수에 새 파일 이름을 지정할 수 있다.
        // `move()` 메소드는 재배치된 파일에 대한 새 File 인스턴스를 리턴하므로 이동된 위치가 필요한 경우, 결과를 캡처해야 한다.
        $newName = $file->getRandomName();
        $file = $file->move(WRITEPATH . 'uploads', $newName);
        debug($file, 'move');
    }
}