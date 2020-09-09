<?php echo $this->extend('layout/section/index'); // 레이아웃 이름 설정 ?>

<?php echo $this->section('content'); // 컨텐츠 섹션 시작 ?>
    <h1>Hello World!</h1>
    <h2>Layout section!!!</h2>
<?php echo $this->endSection(); // 컨텐츠 섹션 끝 ?>