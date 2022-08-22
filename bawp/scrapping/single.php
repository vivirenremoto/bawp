<?php

$class_name = 'h2[id=hp_hotel_name]';
$class_photo = 'meta[name=twitter:image]';
$class_score = 'div.bui-review-score__badge';
$class_rating = 'div.bui-review-score__title';
$class_reviews = 'div.bui-review-score__text';
$class_stars = 'span.bui-rating';
$class_description = 'div[id=property_description_content] p';

$html = str_get_html( $html );

$name = @$html->find($class_name, 0)->innertext;

if( $name ){

	$description = @$html->find($class_description, 0)->plaintext;
	$score = @$html->find($class_score, 0)->plaintext;
	$rating = @$html->find($class_rating, 0)->plaintext;
	$reviews = @$html->find($class_reviews, 0)->plaintext;
	$stars_text = @$html->find($class_stars, 0)->{'aria-label'};
	$photo = @$html->find($class_photo, 0)->content;

	$separator = '</span>';
	$t_name = explode( $separator, $name );
	$name = trim( end( $t_name ) );
	$description = trim($description);
	$reviews = str_replace('.', '', current( explode(' ', trim( $reviews ) ) ) );
	$photo = str_replace('/max300/', '/square200/', $photo);
	$photo = str_replace('/max1024x768/', '/square200/', $photo);
	$stars = preg_match( '/([0-9]+)/', $stars_text, $matches ) ? $matches[1] : 0;


	if( isset($search) ) $url = $search;
	$url = current(explode('?', $url));

	$items[] = array(
		'name' => $name,
		'description' => $description,
		'photo' => $photo,
		'url' => $url,
		'rating' => $rating,
		'reviews' => $reviews,
		'score' => $score,
		'stars' => $stars,
	);

}