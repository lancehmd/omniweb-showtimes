<div class="wrap">
    <h2>Omniweb Showtimes Settings</h2>

    <form method="post">
        <input type="hidden" name="updated">
        <?php wp_nonce_field('update_settings', 'os_nonce'); ?>

        <h3>FTP Settings</h3>

        <table class="form-table">
            <tr>
                <th>
                    <label for="ftp_host">Host</label>
                </th>
                <td>
                    <input
                        class="regular-text"
                        id="ftp_host"
                        name="ftp_host"
                        type="text"
                        value="<?=esc_attr($settings['ftp_host'])?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="ftp_username">Username</label>
                </th>
                <td>
                    <input
                        class="regular-text"
                        id="ftp_username"
                        name="ftp_username"
                        type="text"
                        value="<?=esc_attr($settings['ftp_username'])?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="ftp_password">Password</label>
                </th>
                <td>
                    <input
                        class="regular-text"
                        id="ftp_password"
                        name="ftp_password"
                        type="password"
                        value="<?=esc_attr($settings['ftp_password'])?>">
                </td>
            </tr>
        </table>

        <p class="submit">
            <button class="button button-primary">Save Changes</button>
        </p>
    </form>
</div>
