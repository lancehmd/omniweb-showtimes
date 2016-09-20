<h1 class="widget-title">Coming Soon to <?=get_the_title()?>!</h1>

<ul class="coming-soon">
    <?php foreach ($coming_soon_movies as $movie): ?>
        <?php if (!$movie['movie_theatres'][$theatreId]) continue; ?>

        <li class="movie">
            <a class="trailer-link" href="<?=$movie['movie_trailer_url']?>" rel="noopen" title="Watch the Trailer" data-lity>
                <div class="movie-wrapper">
                    <figure class="poster">
                        <img src="<?=wp_make_link_relative($movie['movie_poster']['url'])?>" alt="<?=$movie['movie_poster']['alt']?>">
                    </figure>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
