<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>User save page</h1>

    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $filed => $error) { ?>
                <p><?php echo($error); ?></p>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>