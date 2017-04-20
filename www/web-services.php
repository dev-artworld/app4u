<?php
/*
Plugin Name: App4u Web Services
Description: A plugin for web services
Version: 0.1
*/

add_action('init','check_web_services');
function check_web_services(){

	if(isset($_REQUEST['source'])&& trim($_REQUEST['source'])=='app'){

		$action = trim($_REQUEST['action']);
		switch ($action) {

			case 'search':
				$seachTerm = $_GET['term'];
				$seachCategory = $_GET['category'];
			if( $seachTerm != '' ){
				global $wpdb;
					$sql = "SELECT ID, post_title, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'app_information' AND post_title LIKE '%$seachTerm%'";
        			$results = $wpdb->get_results( $sql, ARRAY_A );
					echo json_encode($results);

                  }
				if( $seachCategory != '' ){
						
						global $wpdb;
						$sql = "SELECT * FROM {$wpdb->prefix}terms
						LEFT JOIN {$wpdb->prefix}term_relationships ON({$wpdb->prefix}terms.term_id = {$wpdb->prefix}term_relationships.term_taxonomy_id)
						LEFT JOIN {$wpdb->prefix}posts ON({$wpdb->prefix}term_relationships.object_id = {$wpdb->prefix}posts.ID)
						WHERE name LIKE '%$seachCategory%' AND post_type ='app_information' group by name";
						$results = $wpdb->get_results( $sql, ARRAY_A );
					
						$imgarray = array();
						foreach($results as $result){
								$term_id = $result[term_id];
								$img = z_taxonomy_image_url($term_id);
								$imgarray[$term_id] = $img;
							}
							
						foreach($results as $key1=>$value1){
							foreach($results[$key1] as $datakey=>$img_value){
								foreach($imgarray as $key2=>$value2){
									if($img_value == $key2 && $datakey =='term_id'){
										$results[$key1]['image'] = $imgarray[$key2];
									}
							   }
						   }
						}
						
						echo json_encode($results);
					
					}
			
				exit();
			break;

			case 'get_Categories':
				$categories = array();
				$terms = get_terms( array('taxonomy' => 'app_category','hide_empty' => true,'parent' => 0) );

				foreach ($terms as $term) {

                    $img = z_taxonomy_image_url($term->term_id);
					$cat = array( 'id'=> $term->term_id,'slug'=> $term->slug, 'name' => $term->name,
						'img' => $img);
					array_push($categories, $cat);

				}
				 echo json_encode($categories);
				 exit();
			break;
			case 'single_category':
					$subcategories = array();
                    $term_id =  $_REQUEST['term_id'];
					$taxonomy_name = 'app_category';
					$termchildren = get_term_children($term_id,$taxonomy_name);
					if(empty($termchildren))
					{
						$posts_of_category = array();
						$args = array('posts_per_page'   => -1, 'post_type' =>'app_information',
						'post_status' =>'publish','tax_query' => array(
						 array(
								'taxonomy' => 'app_category',
								'field' => 'term_id',
								'terms' => $term_id
							  )
						));
					$app_posts= get_posts($args);
					if(!empty($app_posts)){
					$posts_of_category['data']='apps';
					foreach ($app_posts as $app_post){

					$price 		=  	get_field('price',$app_post->ID);
					$video_url 	=  	get_field('video_url',$app_post->ID);
					$apple_link = 	get_field('apple_link',$app_post->ID);
                    $google_link= 	get_field('google_link',$app_post->ID);
								
					$args = array(
						 'meta_key' => 'wpcr3_review_post',	
	                     'post_type' => 'wpcr3_review',
	                     'posts_per_page'=>'-1',
	                     'post_status'  => 'publish',
	                     'meta_query' => array(
		                       array(
			                          'key' => 'wpcr3_review_post',
						              'value' => $app_post->ID,
									)
							)
						 );
                   $reviewslist = get_posts( $args );
                   $total_of_review = 0;
                   $average_divider = count($reviewslist);
                      
				                      // $rating = get_post_meta($postslist);

				                      // $review = array();
                    foreach($reviewslist as $reviewlist) {
                   	 $rating = get_post_meta($reviewlist->ID);
                     $total_of_review = $rating['wpcr3_review_rating'][0]+$total_of_review;
                   	
                     $average = $total_of_review/$average_divider;
					 //$average = round($average, 2);
					// $average_review_style = 100*$average/5;
                    // print_r($average);
                    // exit();

                     $review = array('review_rating'=>$average);
                     }
                     $reviews = $review;
                 /*print_r($reviews);
                 exit();*/
                     //$img = wp_get_attachment_image_src(get_post_thumbnail_id($app_post->ID),'thumbnail');
                    $img = "";                    
                     if ( has_post_thumbnail($app_post->ID) ) {
					   $img = wp_get_attachment_image_src(get_post_thumbnail_id($app_post->ID),'thumbnail');
					   $img = $img[0];
					}
					else {
					   $img = site_url(). '/app4u/img/featured-app-img.png';
					       
					}
					
                    

					$post = array('id'=>$app_post->ID,
						'post_title'=>$app_post->post_title,
						'post_content'=>$app_post->post_content,
						'image' => $img,
						'price'=>$price,
						'video_url'=> $video_url,
						'apple_link'=>$apple_link,
                        'google_link'=>$google_link,
						'review' => $reviews);

					$posts_of_category['apps'][] = $post;

                        	//array_push($posts_of_category, $post);
						}
					}else{
						$posts_of_category['data']='There is no apps in this category';
					}
					echo json_encode($posts_of_category);
					exit();
					}
					else
					{
						$subcategories['data']='subcategories';
		                file_put_contents(dirname(__FILE__).'/termchildren.log', print_r($termchildren,true),FILE_APPEND);
	                    foreach ( $termchildren as $child )
	                    {

                    	$term = get_term_by( 'id', $child, $taxonomy_name);
                        file_put_contents(dirname(__FILE__).'/ab.log', print_r($term,true),FILE_APPEND);
                    	if( $term->count <= 0 )
                    	 {
                              continue;
                         }

                      $img = z_taxonomy_image_url($term->term_id);

                      $subcategories['subcategories'][] = array('id'=> $term->term_id,'name'=>$term->name,'slug'=>$term->slug,'img'=>$img,'parent'=>$term->parent);

                     // array_push($subcategories, $cat);

					}

                      
					echo json_encode($subcategories);
					exit();
				}


				break;
				 case 'single_app':
					 $single_app_post = array();
	                 $post_id =  $_REQUEST['ID'];
                     
	                 $arg = array(
			                     'post_type' => 'acf',
			                     'posts_per_page'=>'-1',
			                     'post_status'  => 'publish',
			                     );
	                 $cus = get_post($post_id);
	              
	                 $post_modified = $cus->post_modified; /*$customfield = get_post_custom($post_id);
                      $custom =  array('additional_size'=>$customfield->additional_size,
                      	);*/
                     $args = array(
			                     'post_type' => 'wpcr3_review',
			                     'posts_per_page'=>'-1',
			                     'post_status'  => 'publish',
			                     'meta_query' => array(
							                       array(
								                          'key' => 'wpcr3_review_post',
											              'value' => $post_id,
													    )
								                       )
								  );
                   	 $reviewslist = get_posts( $args );
                   
                   //	$author = get_user_by('id', $cus->post_author);
                   /*	$user_info = array('user_login'=> $author->user_login,'user_nicename'=>$author->user_nicename,
                   		'user_email'=>$author->user_email,'user_url'=>$author->user_url,
                   		'display_name'=>$author->display_name);
                   	echo "<pre>";
                   	print_r($user_info);
                   	exit();*/

                   	 $review = array();
                     foreach($reviewslist as $reviewlist)
                     {
                   	 $rating = get_post_meta($reviewlist->ID);
                   	 $review[] = array(
				                        'review_name'=>$rating['wpcr3_review_name'][0],
				                        'review_email'=>$rating['wpcr3_review_email'][0],
				                        'review_rating'=>$rating['wpcr3_review_rating'][0],
				                        'review_title'=>$rating['wpcr3_review_title'][0],
				                        'post_content'=>$reviewlist->post_content

				                       );

                     }
                     $reviews = $review;

                     $content_post = get_post($post_id);  
                     $post = get_post($post_id);
                     $title = $post->post_title;
                     //$app_title 		= get_field('app_title',$post_id);
                     $app_content = $content_post->post_content;
                     $app_category 	= get_field('app_category',$post_id);
                     $add_subcategory = get_field('add_subcategory',$post_id);
                     $apple_link 	= get_field('apple_link',$post_id);
                     $google_link 	= get_field('google_link',$post_id);
                     $image		= get_field('image_ser',$post_id);
	                  $additional_size 		= get_field('additional_size',$post_id);
	                  $additional_installs = get_field('additional_installs',$post_id);
	                  $additional_current_version = get_field('additional_current_version',$post_id);
	                  $additional_requires_android = get_field('additional_requires_android',$post_id);
	                  $additional_content_rating = get_field('additional_content_rating',$post_id);
	                  $additional_interactive_elements = get_field('additional_interactive_elements',$post_id);
	                  $additional_in_app_products = get_field('additional_in_app_products',$post_id);
	                  $additional_permissions = get_field('additional_permissions',$post_id);
	                  $additional_report = get_field('additional_report',$post_id);
	                  $additional_offered_by = get_field('additional_offered_by',$post_id);
                     foreach ($image as $key => $value) {
                     	$images[] = $value;
                     }
                     $section 		= get_field('section',$post_id);
	                 $video_url 		= get_field('video_url',$post_id);
	                 $featured_app 	= get_field('featured_app',$post_id);
	                 $price =  get_field('price',$post_id);
                     $img = "";                    
                     if ( has_post_thumbnail($post_id) ) {
					   $img = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'thumbnail');
					   $img = $img[0];
					}
					else {
					   $img = site_url(). '/app4u/img/featured-app-img.png';
					       
					}
             		 $author = get_user_by('id', $cus->post_author);
                     $cat_id = get_the_terms( $post_id,'app_category');
                     $app_info = array('app_title' => $title,
						                   	'app_category'=>$app_category,
						                   	'add_subcategory'=>$add_subcategory,
						                   	'category_id' => $cat_id[0]->term_id,
						                    'app_content'=>$app_content,
						                   	'apple_link'=>$apple_link,
						                   	'google_link'=>$google_link,
						                   	'Image'=>($images) ? $images : array($img),
						                   	'section'=>$section,
						                   	'video_url'=>$video_url,
						                   	'featured_ap'=>$featured_ap,
						                   	'price'=>$price,
						                   	'Featured_Image'=>$img,
						                   	'Review'=>$reviews,
						                   	'post_modified'=>$post_modified,
						                   	'additional_size'=>$additional_size,
						                   	'additional_installs'=>$additional_installs,
						                   	'additional_current_version'=>$additional_current_version,
						                   	'additional_requires_android'=>$additional_requires_android,
						                   	'additional_content_rating'=>$additional_content_rating,
						                   	'additional_interactive_elements'=>$additional_interactive_elements,
						                   	'additional_in_app_products'=>$additional_in_app_products,
						                   	'additional_permissions'=>$additional_permissions,
						                   	'additional_report'=>$additional_report,
						                   	'additional_offered_by'=>$additional_offered_by,
						                   	'display_name'=>$author->display_name,
						                   	'user_url'=>$author->user_url
						             );
                      array_push($single_app_post, $app_info);
                      echo json_encode($single_app_post);
                      exit();

                  	/*echo "<pre>";
                  	print_r($app_info);
                  		echo "</pre>";*/
                  	break;
                  	case 'app_slider':
	                  	$app_slider = array();
	                  	$args = array(
		                     'post_type' => 'zee_slider',
		                     'posts_per_page'=>'-1',
		                     'post_status'  => 'publish'
						);
                  	
                       $sliders = get_posts( $args );
                       
                        foreach($sliders as $slider) {
                       	$img = wp_get_attachment_image_src(get_post_thumbnail_id($slider->ID),'thumbnail');
                        
						$appslider = array(
	                        'post_title'=>$slider->post_title,
	                        'post_content'=>$slider->post_content,
	                        'image'=>$img[0]
	                    );
                        $app_slider['slides'][] = $appslider;

                       }
                       echo json_encode($app_slider);
                       exit();
 
                  	break;
                  	case 'get_apps' :
                          $term_id =  $_REQUEST['term_id']; 
             			  $args = array(
									 'post_type' => 'app_information',
									 'posts_per_page'=>'-1',
									 'post_status'  => 'publish',
									 'tax_query' => array(
											            array(
															'taxonomy' => 'app_category',
															'field' => 'term_id',
															'terms' => $term_id
													         )
								                          )
										);
							$app = get_posts( $args );
                       		foreach ($app as $apps) 
                       		{
                       		$args = array(	
									 'meta_key' => 'wpcr3_review_post',	
				                     'post_type' => 'wpcr3_review',
				                     'posts_per_page'=>'-1',
				                     'post_status'  => 'publish',
				                     'meta_query' => array(
								                       array(
									                          'key' => 'wpcr3_review_post',
												              'value' => $apps->ID,
															)
														  )
										 );
				                      $reviewslist = get_posts($args);
				                      $total_of_review = 0;
				                      $average_divider = count($reviewslist);
				                      foreach($reviewslist as $reviewlist) 
				                      {
				                      $rating = get_post_meta($reviewlist->ID);
	                                  $total_of_review = $rating['wpcr3_review_rating'][0]+$total_of_review;
				                      $average = $total_of_review/$average_divider;
				                      $review = array('review_rating'=>$average);
				                      }
				                      $reviews = $review;
				                      $price =  get_field('price',$apps->ID);
									  $video_url =  get_field('video_url',$apps->ID);
									  $apple_link = get_field('apple_link',$apps->ID);
				                      $google_link = get_field('google_link',$apps->ID);
				                      //$img = wp_get_attachment_image_src(get_post_thumbnail_id($apps->ID),'thumbnail');
				                       $img = "";                    
					                     if ( has_post_thumbnail($apps->ID) ) {
										   $img = wp_get_attachment_image_src(get_post_thumbnail_id($apps->ID),'thumbnail');
										   $img = $img[0];
										}
										else {
										   $img = site_url(). '/app4u/img/featured-app-img.png';
										  // $img = site_url(). '/wp-content/themes/flat-theme-child/thumb-img.php?width=150&height=150&cropratio=1.80:1.10&image='.site_url().'/app4u/img/featured-app-img.png';
										}
				                      $cat_apps = array(
						                      		'post_id'=>$apps->ID,
						                      		'post_title'=>$apps->post_title,
						                      		'image'=>$img,
													'video_url'=>$video_url,
						                      		'price'=>$price,
						                      		'google_link'=>$google_link,
						                      		'apple_link'=> $apple_link,
						                      		'review' => $reviews
				                      		            );
				                      $cat_app['apps'][] = $cat_apps;

	                       }
				                      echo json_encode($cat_app);
				                      exit();

                  	break;
			default:
				# code...
				break;
		}
		exit;
	}
}


?>
