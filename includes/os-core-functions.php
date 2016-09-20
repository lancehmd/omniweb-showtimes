<?php

function os_slugify($string)
{
   $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   $slug = strtolower($slug);

   return $slug;
}

function os_get_poster( $film_title, $file_name ) {
    $film_slug = os_slugify($film_title);

    if ( file_exists( WP_CONTENT_DIR."/omniweb/thumbnail/{$file_name}" ) ) {
        return content_url()."/omniweb/thumbnail/{$file_name}";
    } elseif ( file_exists( WP_CONTENT_DIR."/omniweb/poster/{$file_name}" ) ) {
        return content_url()."/omniweb/poster/{$file_name}";
    } elseif ( file_exists( WP_CONTENT_DIR."/omniweb/poster/{$film_slug}.jpg" ) ) {
        return content_url()."/omniweb/poster/{$film_slug}.jpg";
    } else {
            return '';
    }
}

function os_search_poster($film_title)
{
    $curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'http://www.omdbapi.com/?type=movie&t='.$film_title);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($curl);
	curl_close($curl);
    $title_results = json_decode($content);

    if ($title_results->Response === 'True') {
        return $title_results->Poster;
    } else {
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://www.omdbapi.com/?type=movie&s='.$film_title);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($curl);
		curl_close($curl);
        $wide_results = json_decode($content);
        if ($wide_results->Response === 'True') {
            return $wide_results[0]->Poster;
        } else {
            return false;
        }
    }
}
