<div class="find-showtimes" id="owst-find-showtimes">

    <form class="flex flex-row flex-wrap bg-light-gray" id="find-showtimes" name="showtime-date">

        <div class="flex flex-100 flex-1-ns items-center pa2">
            <label class="oswald f3 ttu" for="select-a-theatre">Find Showtimes</label>
        </div>

        <fieldset class="find-showtimes__field find-showtimes__field--theatre">
            <label for="select-a-theatre">Your Cinema</label>
            <select id="select-a-theatre" name="theatre">
                <option selected disabled>Select a cinema...</option>
                <?php foreach ($theatres as $city => $locations): ?>
                    <optgroup label="<?=$city?>">
                        <?php foreach ($locations as $key => $theatre): ?>
                            <option value="<?=$theatre['slug']?>" data-code="<?=$theatre['code']?>"><?=$theatre['name']?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <fieldset class="find-showtimes__field find-showtimes__field--date">
            <label for="select-a-date">Date</label>
            <select id="select-a-date" name="date">
                <option selected disabled>Select a date...</option>
                <?php foreach ($dates as $date => $value): ?>
                    <option value="<?=$date?>" <?=($date===$today)?'selected':null;?>><?=$value?></option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <button class="find-showtimes__submit">Get Showtimes</button>

    </form>

</div>
