<?php
    $merged = array_merge($category_id);
	$merged_values = array_values($merged);
	// print_r($merged);
	$cat_id =  $merged_values[0];
	$column =  $merged_values[1];
	
	echo "<h2>".$column."</h2>";
	echo "<h2>".$cat_id."</h2>";

	$query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $column,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy'   => 'product_cat',
				'field'      => 'term_id',
				'terms'      => $cat_id,
			),
			array(
			'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
			'operator' => 'IN',
			),
		),
	) );

	$string .= '<ol>'; 
		while ( $query->have_posts() ) : $query->the_post();
	$string .=  '<li>
		<a href="'. get_permalink() .'">
		<div class="product__preview"><img src="' . get_the_post_thumbnail_url() . '"></div>
		<span>' . get_the_title() . '</span>
		</a>
	</li>';
	endwhile;

	$string .= '</ol>'; 

	wp_reset_postdata();
	
	return $string;
?>