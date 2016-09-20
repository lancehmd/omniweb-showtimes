<?php $days = $schedule['schedule_days']['schedule_day']; ?>

<div class="date-select" id="owst-date-selector">

    <div class="date-select__header">
        <?=_e('View showtimes for what day?', 'omniweb-showtimes')?>
    </div>

    <form class="date-select__form">
        <select class="date-select__select" name="date">
            <?php foreach ($days as $key => $value): ?>
                <?php $schedule_date = date_create($days[$key]['date']); ?>
                <option value="<?=$days[$key]['date']?>" <?=($days[$key]['date'] == $date)?'selected':''?>><?=date_format($schedule_date, 'l')?>, <?=date_format($schedule_date, 'M d')?></option>
            <?php endforeach; ?>
        </select>

        <button>Go</button>
        <button class="button os-print-showtimes">Print</button>
    </form>

</div>
