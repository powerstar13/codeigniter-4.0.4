<h1 class="title"><?php p($bbsInfo['name']); ?></h1>

<!-- /mvc/bbs/notice/write 와 같은  형식으로 게시판의 종류값을 조합하여 이동할 URL 구성 -->
<a href="<?php echo base_url(['mvc', 'bbs', $bbsInfo['key'], 'write']); ?>">글 쓰기</a>