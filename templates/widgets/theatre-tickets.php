<?php if ($tickets): ?>

    <section class="ticket-prices">
        <h4 class="widget-title">Ticket Prices</h4>

        <ul class="ticket-price-list">
            <?php foreach ($tickets as $ticket): ?>
                <li class="ticket-price-listing">
                    <div class="ticket-name">
                        <?=$ticket['_name']?>
                        <span class="ticket-description"><?=$ticket['_description']?></span>
                    </div>
                    <span class="ticket-price">$<?=$ticket['_price']?></span>
                </li>
            <?php endforeach; ?>
        </ul>

    </section>

<?php endif; ?>
