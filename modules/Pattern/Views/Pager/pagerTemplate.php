<!--
    ===== setSurroundCount() && =====

    첫 번째 줄의 `setSurroundCount()` 메소드는 현재 페이지 링크의 양쪽에 두 개의 링크를 표시할 것을 지정한다.
    - 허용되는 단일 매개 변수는 표시할 링크 수이다.
 -->
<?php
    /** @var \CodeIgniter\Pager\PagerRenderer $pager */
    $pager->setSurroundCount(2);
?>

<h1>Template Custom</h1>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination">
        <!--
            ===== hasPrevious() && hasNext() =====

            이 두개의 메소드는 `setSurroundCount`에 전달된 값을 기준으로 현재 페이지의 양쪽에 표시할 수 있는 링크가 더 있으면 부울 `TRUE`를 리턴한다.
            - ex) 20페이지의 데이터가 있다고 가정해 봅시다.
                1. 현재 페이지가 3페이지일 경우.
                2. 주변 수가 2이면 다음 링크가 목록에 나타난다.
                    - (1, 2, 3, 4, 5) 표시되는 첫 번째 링크는 1페이지이므로, `hasPrevious()`는 페이지 0이 없기 때문에 `FALSE`가 반환된다.
                    - 그러나 `hasNext()`는 5페이지 이후 15개의 추가 결과 페이지가 있으므로 `TRUE`를 반환한다.
         -->
		<?php if ($pager->hasPrevious()) : ?>
			<li>
                <!--
                    ===== getFirst() && getLast() =====

                    `getPrevious()`, `getNext()`와 마찬가지로 첫 페이지와 마지막 페이지에 대한 링크를 리턴한다.
                 -->
				<a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
					<span aria-hidden="true"><?= lang('Pager.first') ?></span>
				</a>
			</li>
			<li>
                <!--
                    ===== getPrevious() & getNext() =====

                    이 메소드는 번호가 매겨진 링크의 양쪽에 이전 또는 다음 결과 페이지의 URL을 리턴한다.

                    - 표준 페이지 지정 구조에 대해 제시된 코드에서 `getPrevious()`와 `getNext()` 메소드는 각각 이전과 다음 페이지 부여 그룹에 대한 연결을 얻기 위해 사용된다.

                    - 현재 페이지를 기준으로 이전 페이지와 다음 페이지로 연결되는 페이지별 구조를 사용하려면 :

                        ===== getPreviousPage() && getNextPage() =====
                        이 메소드는 번호가 지정된 링크의 양쪽에 있는 결과의 이전 페이지 또는 다음 페이지에 대한 URL을 반환하는 `getPrevious()`, `getNext()`와 달리, 현재 표시된 페이지와 관련하여 이전 페이지와 다음 페이지의 URL을 반환한다.

                            1. `getPrevious()` 메소드는 `getPreviousPage()`로 바꾼다.
                            2. `getNext()` 메소드는 `getNextPage()`로 바꾼다.

                        ===== hasPreviousPage() && hasNextPage() =====
                        이 메소드는 현재 표시되고 있는 현재 페이지 전후에 페이지에 대한 링크가 있는 경우 부울 `TRUE`를 리턴한다.
                        - 차이점은 `hasPreviousPage()`, `hasNextPage()`는 현재 페이지를 기준으로 하고, `hasPrevious()`, `hasNext()`는 `setSurroundCount()`에서 통과된 값을 기준으로 하여 현 페이지 전후로 표시할 링크 세트를 기반으로 한다는 것이다.

                            3. `hasPrevious()` 메소드는 `hasPreviousPage()`로 바꾼다.
                            4. `hasNext()` 메소드는 `hasNextPage()`로 바꾼다.

                 -->
				<a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
					<span aria-hidden="true"><?= lang('Pager.previous') ?></span>
				</a>
			</li>
		<?php endif ?>

        <!--
            ===== links() =====

            번호가 매겨진 모든 링크에 대한 데이터 배열을 반환한다.
            - 각 링크의 배열에는 링크의 URI, 제목, 숫자 및 링크가 `현재/활성` 링크인지 여부를 나타내는 부울(bool)이 포함된다.

            $link = [
                'active' => false,
                'uri' => 'http://localhost/foo?page=2',
                'title' => 1
            ];
         -->
		<?php foreach ($pager->links() as $link) : ?>
			<li <?= $link['active'] ? 'class="active"' : '' ?>>
				<a href="<?= $link['uri'] ?>">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li>
				<a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
					<span aria-hidden="true"><?= lang('Pager.next') ?></span>
				</a>
			</li>
			<li>
				<a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
					<span aria-hidden="true"><?= lang('Pager.last') ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
</nav>
