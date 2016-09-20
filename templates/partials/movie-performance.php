<?php

$showtime = date_create($performance['time']);
$target   = 'target="_blank"';
$time     = null;

if (strtotime($performance['time']) < strtotime('now')) {
    $time = 'past-showtime';
    $target = '';
    $performance['url'] = '#';
}

if ($theatreId == '51904') {
    $target = '';
    $performance['url'] = '#';
}

?>

<a class="movie-performance <?=$time?>" href="<?=$performance['url']?>" rel="noopen" <?=$target?>>
    <?=date_format($showtime, 'g:i A')?>
</a>
