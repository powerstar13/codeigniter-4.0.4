<?php if (!empty($myCookie)) { ?>
    <h1>저장된 쿠키값 : <?php p($myCookie); ?></h1>
<?php } else { ?>
    <h1>저장된 쿠키값 없음</h1>
<?php } ?>

<form action="<?php echo base_url('mvc/cookie/result'); ?>" method="POST">
    <div class="form-group">
        <label for="username">이름</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" />
    </div>

    <button type="submit" class="btn btn-primary">쿠키저장</button>
</form>