<style>.film-performance:not(:last-child)::after { content: ','; }</style>

<table style="text-align:left;">

    <tr>
        <th colspan="2">
            <?=$film['title']?>

            <?php if ($film['rating']): ?>
                <small>(<?=$film['rating']?>)</small>
            <?php endif; ?>

            <?php if ( $film['runtime'] ): ?>
                <small style="font-weight: normal;">
                    |
                    <?=floor($film['runtime'] / 60)?> hours
                    <?=floor($film['runtime'] % 60)?> minutes
                </small>
            <?php endif; ?>
        </th>
    </tr>

    <tr>
        <td>
            <?php foreach ($film['performances']['performance'] as $performance): ?>
                <?php $showtime = date_create($performance['time']); ?>
                <span class="film-performance"><?=date_format($showtime, 'g:i A')?></span>
            <?php endforeach; ?>
        </td>
    </tr>

    <?php if (isset($film['performances']['performance_3d'])): ?>
        <tr>
            <td>
                <b>3D:</b>
                <?php foreach ($film['performances']['performance_3d'] as $performance): ?>
                    <?php $showtime = date_create($performance['time']); ?>
                    <span class="film-performance"><?=date_format($showtime, 'g:i A')?></span>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endif; ?>

</table>

<hr style="margin: .5em 0;">
