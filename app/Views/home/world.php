<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>codeigniter</title>

    <style>
        body { color: #0066ff; }
    </style>
</head>
<body>
    <!--
        View를 로드하면서 전달되는 연관배열과 stdClass의 객체 모두 가능하다.
        stdClass의 객체로 전달하는 경우, 멤버변수가 View 페이지 안에서 각각 독립적인 변수로 인식된다.
    -->
    <h1><?=$name?> <small><?=$version?></small></h1>
</body>
</html>