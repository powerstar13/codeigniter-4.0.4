<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIgniter</title>
</head>
<body>
    <!-- CI에서 연관배열을 전달할 경우 배열의 Key가 변수명이 된다. -->
    <!-- View에서도 PHP의 문법을 사용하여 독립적인 프로그램 로직을 작성할 수 있지만, 가급적 Controller에서 전달되는 데이터를 출력하는 수준으로만 작성하는 것이 바람직하다. (퍼블리싱 파트와의 협업을 위함) -->
    <h1><?php p($name); ?></h1>
    <h1><?php p($language); ?></h1>
    <h1><?php p($level); ?></h1>
</body>
</html>