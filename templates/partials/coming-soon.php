<ul class="coming-soon">
    <?php foreach ($movies as $movie): ?>
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
