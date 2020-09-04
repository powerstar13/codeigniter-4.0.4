<h2><?php echo esc($title); ?></h2>

<?php echo \Config\Services::validation()->listErrors(); // 양식 검증과 관련된 오류를 보고하는 데 사용 ?>

<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $filed => $error) { ?>
            <p><?php echo($error); ?></p>
        <?php } ?>
    </div>
<?php } ?>

<!-- 데이터베이스에 데이터를 입력하기 위해 저장할 정보를 입력할 양식(form) -->
<!-- <form action="/news/create" method="POST"> -->
<?php echo form_open('news/create', ['method' => 'post', 'class' => 'myClass'], ['id' => '1']) ?>
    <?php echo csrf_field(); // CSRF 토큰으로 숨겨진 입력을 생성하여 일부 일반적인 공격으로부터 보호한다. ?>
    <?php echo form_hidden('hidden_group', ['hidden_id' => '2', 'test_id' => '3']) ?>

    <?php echo form_dropdown('select_go', ['1' => '1선택', '2' => '2선택', '3' => '3선택', '4' => '4선택', '5' => '5선택'], '3', ['id' => 'select_id', 'onChange' => 'alert("선택 바꿈");']) ?>

    <?php echo form_label('Check please', 'news_checkbox_id');; ?>
    <?php echo form_checkbox('news_checkbox', '1', TRUE, ['id' => 'news_checkbox_id']); ?>

    <?php echo form_label('Choice please', 'news_radio_id');; ?>
    <?php echo form_radio('news_radio', '1', TRUE, ['id' => 'news_radio_id']); ?>

    <!-- 제목 입력 필드 : Model에서 title을 이용하여 slug를 만든다. -->
    <label for="title">Title</label>
    <input type="input" name="title" /><br />

    <!-- 텍스트 입력 필드 -->
    <label for="body">Text</label>
    <textarea name="body"></textarea><br />

    <?php echo form_submit('submit', 'Create news item') ?>
    <?php echo form_reset('reset', 'Reset news info') ?>
<?php echo form_close('<p>여기까지 양식 입력입니다.</p>'); ?>