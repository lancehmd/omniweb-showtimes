<div class="theatre-information">
    <?php if (has_post_thumbnail()): ?>
        <div class="theatre-logo">
            <?=get_the_post_thumbnail($theatre_id, 'medium')?>
        </div>
    <?php endif; ?>

    <h4 class="widget-title">Address</h4>
    <address class="theatre-address">
        <strong class="theatre-name"><?=$data['theatre_name']?></strong><br>

        <?php if ($data['theatre_street']): ?>
            <?=$data['theatre_street']?><br>
        <?php endif; ?>

        <?php if ($data['theatre_street2']): ?>
            <?=$data['theatre_street2']?><br>
        <?php endif; ?>

        <?php if ($data['theatre_city']): ?>
            <?=$data['theatre_city']?>,
        <?php endif; ?>

        <?php if ($data['theatre_province']): ?>
            <?=$data['theatre_province']?>
        <?php endif; ?>

        <?php if ($data['theatre_postal_code']): ?>
            <?=$data['theatre_postal_code']?>
        <?php endif; ?>

    </address>

    <h4 class="widget-title">Contact</h4>
    <?php if ($data['theatre_showtimes_number'] || $data['theatre_phone_number'] || $data['theatre_fax_number']): ?>
        <ul class="theatre-phone-list">
            <?php if ($data['theatre_showtimes_number']): ?>
                <li class="theatre-phone">
                    <span class="theatre-phone-name">Showtimes </span>
                    <span class="theatre-phone-number">
                        <?=preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['theatre_showtimes_number'])?>
                    </span>
                </li>
            <?php endif; ?>
            <?php if ($data['theatre_phone_number']): ?>
                <li class="theatre-phone">
                    <span class="theatre-phone-name">Office </span>
                    <span class="theatre-phone-number">
                        <?=preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['theatre_phone_number'])?>
                    </span>
                </li>
            <?php endif; ?>
            <?php if ($data['theatre_fax_number']): ?>
                <li class="theatre-phone">
                    <span class="theatre-phone-name">Fax </span>
                    <span class="theatre-phone-number">
                        <?=preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['theatre_fax_number'])?>
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>

    <div class="theatre-social-links">
        <h4 class="widget-title">Social</h4>
        <?php if ( $data['theatre_facebook_page'] ): ?>
            <a href="<?=$data['theatre_facebook_page']?>" target="_blank" rel="noopen" title="Like us on Facebook">
                <i class="i-facebook"></i>
            </a>
        <?php endif; ?>
        <?php if ( $data['theatre_twitter_page'] ): ?>
            <a href="<?=$data['theatre_twitter_page']?>" target="_blank" rel="noopen" title="Follow us on Twitter">
                <i class="i-twitter"></i>
            </a>
        <?php endif; ?>
        <?php if ( $data['theatre_google_page'] ): ?>
            <a href="<?=$data['theatre_google_page']?>" target="_blank" rel="noopen" title="+1 us on Google Plus">
                <i class="i-google"></i>
            </a>
        <?php endif; ?>
        <?php if ( $data['theatre_email_address'] ): ?>
            <a href="mailto:<?=$data['theatre_email_address']?>" target="_blank" rel="noopen" title="Send us an email">
                <i class="i-mail"></i>
            </a>
        <?php endif; ?>
    </div>
</div>
