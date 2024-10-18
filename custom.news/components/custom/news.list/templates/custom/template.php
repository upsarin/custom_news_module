<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (!empty($arResult['ITEMS'])) { ?>
	<div class="news-list">
		<?php foreach ($arResult['ITEMS'] as $news) { ?>
			<div class="news-item">
				<h2><?=htmlspecialchars($news['title'])?></h2>
				<div class="news-content"><?=nl2br(htmlspecialchars($news['content']))?></div>
				<div class="news-date"><?=$news['date']?></div>
			</div>
		<? } ?>
	</div>
<? } else {?>
	<p><?=Loc::getMessage('NO_NEWS')?></p>
<? } ?>