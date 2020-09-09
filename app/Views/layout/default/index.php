<!DOCTYPE html>
<html lang="ko">
<head>
    <?php echo $this->include('layout/common/head'); ?>
</head>
<body>
    <?php echo $this->include('layout/default/inc/header'); ?>

    <?php echo view($viewpath, $data); ?>

    <?php echo $this->include('layout/default/inc/footer'); ?>
</body>
</html>