<?php

$base_url = 'https://www.booking.com';
$class_score_item = '.bui-review-score__title';
$class_score = '.bui-review-score__badge';
$class_reviews = '.bui-review-score__text';
$class_item = '.sr__card';
$class_link = 'header a';
$class_photo = 'img';
$class_description = '.bui-card__text';
$class_stars = 'class';

$html = str_replace('bk-icon -sprite-ratings_stars_', '', $html);

$html = str_get_html($html);

$items_aux = @$html->find($class_item);



if ($items_aux) {
    foreach ($items_aux as $item) {
        $link = @$item->find($class_link, 0);

        if ($link) {

            $score_aux = @$item->find($class_score_item);

            //if ($score_aux) {

            $url = @trim($link->href);
            if (!stristr($url, $base_url)) {
                $url = $base_url . $url;
            }

            $url = current(explode('?', $url));

            $photo_obj = @$item->find($class_photo, 0);
            $score = @$item->find($class_score, 0)->innertext;
            $reviews = @$item->find($class_reviews, 0)->innertext;
            $description = @$item->find($class_description, 0)->innertext;

            $stars = 0;
            $stars_obj = @$item->find('svg',0);
            if( $stars_obj ){
                $stars = $stars_obj->getAttribute('class');
            }

            if( strstr($stars, 'bk-icon') ){
                $stars = 0;
            }

            $photo = @$photo_obj->src;
            $name = @$photo_obj->alt;
            $rating = trim(@$score_aux[0]->innertext);
            $description = current(explode('<', trim($description)));
            $reviews = str_replace('.', '', current(explode(' ', trim($reviews))));


            $name = current(explode(', ', $name));

            $items[] = (object) array(
                'name' => $name,
                'description' => $description,
                'photo' => $photo,
                'url' => $url,
                'rating' => $rating,
                'score' => $score,
                'reviews' => $reviews,
                'stars' => $stars,
            );

            //}

        }
    }
}


//echo '<pre>';print_r($items);die();