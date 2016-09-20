<div class="movie-showtime">

    <figure class="movie-poster <?=(os_get_poster($film['title'], $film['thumbnail'])?null:'missing')?>">
        <?php if ($poster) : ?>
            <img src="<?=$poster?>" alt="<?=$film['title']?>">
        <?php endif; ?>
        <?php if ($trailer): ?>
            <a class="button button-tiny button--block" href="<?=$trailer?>" data-lity>Watch Trailer</a>
        <?php endif; ?>
    </figure>

    <div class="movie-information">

        <div class="movie-header">
            <h2 class="movie-title">
                <?=$title?>
                <small style="color:#888;"><?=($subtitle)?$subtitle:null?></small>
            </h2>

            <?php if ( $film['rating'] ): ?>
                <div class="movie-rating" title="Rated <?=$film['rating']?>">
                    <span class="rated-<?=strtolower($film['rating'])?>">
                        <?=$film['rating']?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $film['runtime'] ): ?>
            <div class="movie-row">
                <div class="movie-row-title">Runtime</div>
                <div class="movie-row-content">
                    <?=floor($film['runtime'] / 60)?>h
                    <?=floor($film['runtime'] % 60)?>m
                </div>
            </div>
        <?php endif; ?>

        <?php if (strcasecmp($film['genre'], 'not set')): ?>
            <div class="movie-row">
                <div class="movie-row-title">Genre</div>
                <div class="movie-row-content">
                    <?=$film['genre']?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $film['synopsis'] ): ?>
            <div class="movie-row movie-row-synopsis">
                <div class="movie-row-title">Synopsis</div>
                <div class="movie-row-content">
                    <label class="movie-synopsis-toggle button button-small" for="synopsis-<?=$film['code']?>">View</label>
                    <input type="checkbox" class="movie-synopsis-checkbox" id="synopsis-<?=$film['code']?>">
                    <div class="movie-synopsis">
                        <div class="movie-synopsis-wrap">
                            <?=$film['synopsis']?>
                        </div>
                        <label class="movie-synopsis-close" for="synopsis-<?=$film['code']?>">Close</label>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="movie-row-title movie-row-title-performances">Showtimes</div>
        <div class="movie-row">
            <div class="movie-row-content">
                <div class="movie-performances">
                    <div class="movie-performances-title">Regular</div>
                    <div class="movie-performances-content">
                        <?php foreach ($film['performances']['performance'] as $performance): ?>
                            <?php include __DIR__.'/movie-performance.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (isset($film['performances']['performance_3d'])): ?>
                    <div class="movie-performances">
                        <div class="movie-performances-title">3D</div>
                        <div class="movie-performances-content">
                            <?php foreach ($film['performances']['performance_3d'] as $performance): ?>
                                <?php include __DIR__.'/movie-performance.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>
