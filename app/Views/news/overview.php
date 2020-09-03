<!-- XSS 공격을 방지하기 위해 esc()를 사용하고 있다. -->
<h2><?php echo esc($title); ?></h2>

<?php if (!empty($news) && is_array($news)) { ?>
    <?php foreach ($news as $news_item) { ?>
        <h3><?php echo esc($news_item['title']); ?></h3>

        <div class="main">
            <?php echo esc($news_item['body']); ?>
        </div>

        <!-- "url"을 두 번째 매개 변수로 전달했다. 출력이 사용되는 상황에 따라 공격 패턴이 다르기 때문이다. -->
        <p><a href="/news/<?php echo esc($news_item['slug'], 'url') ?>">View article</a></p>
    <?php } ?>
<?php } else { ?>
    <h3>No News</h3>

    <p>Unable to find any news for you.</p>
<?php } ?>