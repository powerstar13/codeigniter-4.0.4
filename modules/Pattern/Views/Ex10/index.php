<form action="<?php echo base_url('mvc/excel/read'); ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <input type="file" class="form-control" id="excel" name="excel" />
    </div>

    <button type="submit" class="btn btn-primary">엑셀파일업로드</button>
</form>
