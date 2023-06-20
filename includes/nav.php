<?php
$profileActive = (isset($profileActive)) ? $profileActive : "";
$listActive = (isset($listActive)) ? $listActive : "";
$matchesActive = (isset($matchesActive)) ? $matchesActive : "";
?>
<div id="footernav">
	<a href="me.php" class="<?=$profileActive?>"><i class="far fa-user-circle"></i></a>
	<a href="animallist.php" class="<?=$listActive?>"><i class="fas fa-paw"></i></a>
	<a href="matches.php" class="<?=$matchesActive?>"><i class="fas fa-comment-dots"></i></a>
</div>