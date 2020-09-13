<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIgniter</title>
</head>
<body>
    <h1>Hello CodeIgniter</h1>
    <!-- 페이지에서 공통적으로 사용되는 페이지 구성요소는 별도의 View로 구성한 뒤, 개별적으로 load 할 수 있다.-->
    <!-- PHP 페이지 간의 include 처리와 동일한 효과 -->
    <?php echo view('Modules\Pattern\Views\Ex01UseView\inc'); ?>
</body>
</html>