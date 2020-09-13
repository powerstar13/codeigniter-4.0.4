<?php if (!empty($mySession)) { ?>
    <h1>저장된 세션값 : <?php p($mySession); ?></h1>
<?php } else { ?>
    <h1>저장된 세션값 없음</h1>
<?php } ?>

<form action="<?php echo base_url('mvc/session/result'); ?>" method="POST">
    <div class="form-group">
        <label for="username">이름</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" />
    </div>

    <select name="sessionType" id="sessionType" class="form-control">
        <option value="">Session Type</option>
        <option value="default">일반</option>
        <option value="flash">Flash data</option>
        <option value="keep">Keep Flash data</option>
        <option value="temp">Temp data</option>
    </select>


    <button type="submit" class="btn btn-primary">세션저장</button>
</form>