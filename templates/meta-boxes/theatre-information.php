<div class="inside">

    <table class="form-table">

        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_street"><?=__('Street', 'omniweb-showtimes')?></label>
            </th>
            <td style="padding-bottom:0;">
                <input class="regular-text" id="theatre_street" name="theatre_street" type="text" value="<?=$data['theatre_street']?>"><br>
                <input class="regular-text" id="theatre_street2" name="theatre_street2" type="text" value="<?=$data['theatre_street2']?>">
            </td>
        </tr>

        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_city">City</label>
            </th>
            <td style="padding-bottom:0;">
                <input id="theatre_city" name="theatre_city" type="text" value="<?=$data['theatre_city']?>">
            </td>
        </tr>

        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_province">Province</label>
            </th>
            <td style="padding-bottom:0;">
                <select id="theatre_province" name="theatre_province">
                    <option value="">Select a province...</option>
                    <?php foreach ($provinces as $key => $value): ?>
                        <option value="<?=$key?>" <?=($data['theatre_province'] == $key)?'selected':null?>><?=$value?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th>
                <label for="theatre_postal_code">Postal Code</label>
            </th>
            <td>
                <input id="theatre_postal_code" name="theatre_postal_code" type="text" value="<?=$data['theatre_postal_code']?>">
            </td>
        </tr>

        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_phone_number"><?=__('Phone Number', 'omniweb-showtimes')?></label>
            </th>
            <td style="padding-bottom:0;">
                <input id="theatre_phone_number" name="theatre_phone_number" type="number" step="1" min="0" value="<?=$data['theatre_phone_number']?>">
            </td>
        </tr>
        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_fax_number"><?=__('Fax Number', 'omniweb-showtimes')?></label>
            </th>
            <td style="padding-bottom:0;">
                <input id="theatre_fax_number" name="theatre_fax_number" type="number" step="1" min="0" value="<?=$data['theatre_fax_number']?>">
            </td>
        </tr>
        <tr>
            <th>
                <label for="theatre_showtimes_number"><?=__('Showtimes Number', 'omniweb-showtimes')?></label>
            </th>
            <td>
                <input id="theatre_showtimes_number" name="theatre_showtimes_number" type="number" step="1" min="0" value="<?=$data['theatre_showtimes_number']?>">
            </td>
        </tr>
        <tr>
            <th>
                <label for="theatre_email_address"><?=__('Email Address', 'omniweb-showtimes')?></label>
            </th>
            <td>
                <input class="regular-text" id="theatre_email_address" name="theatre_email_address" type="email" value="<?=$data['theatre_email_address']?>">
            </td>
        </tr>
        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_facebook_page"><?=__('Facebook Page', 'omniweb-showtimes')?></label>
            </th>
            <td style="padding-bottom:0;">
                <input class="regular-text" id="theatre_facebook_page" name="theatre_facebook_page" type="url" value="<?=$data['theatre_facebook_page']?>">
            </td>
        </tr>
        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_twitter_page"><?=__('Twitter Page', 'omniweb-showtimes')?></label>
            </th>
            <td style="padding-bottom:0;">
                <input class="regular-text" id="theatre_twitter_page" name="theatre_twitter_page" type="url" value="<?=$data['theatre_twitter_page']?>">
            </td>
        </tr>
        <tr>
            <th>
                <label for="theatre_google_page"><?=__( 'Google Page', 'omniweb-showtimes')?></label>
            </th>
            <td>
                <input class="regular-text" id="theatre_google_page" name="theatre_google_page" type="url" value="<?=$data['theatre_google_page']?>">
            </td>
        </tr>

        <tr>
            <th colspan="2" style="padding-bottom:0;">
                <h3>Advanced</h3>
            </th>
        </tr>

        <tr>
            <th style="padding-bottom:0;">
                <label for="theatre_latitude">Latitude</label>
            </th>
            <td style="padding-bottom:0;">
                <input id="theatre_latitude" name="theatre_latitude" type="number" step="0.0000001" value="<?=$data['theatre_latitude']?>"><br>
            </td>
        </tr>

        <tr>
            <th>
                <label for="theatre_longitude">Longitude</label>
            </th>
            <td>
                <input id="theatre_longitude" name="theatre_longitude" type="number" step="0.0000001" value="<?=$data['theatre_longitude']?>">
            </td>
        </tr>

        <tr>
            <th>
                <label for="theatre_code"><?=__('Code', 'omniweb-showtimes')?></label>
            </th>
            <td>
                <input id="theatre_code" name="theatre_code" type="number" value="<?=$data['theatre_code']?>">
            </td>
        </tr>
    </table>

</div>
