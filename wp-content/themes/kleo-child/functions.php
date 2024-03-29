<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

/**
 * Kleo Child Theme Functions
 * Add custom code below
*/ 
if ( ! function_exists( 'kleo_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 * Create your own kleo_entry_meta() to override in a child theme.
	 * @since 1.0
	 */
	function kleo_entry_meta($echo=true, $att=array()) {
	
		$meta_list = array();
		
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'kleo_framework' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'kleo_framework' ) );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="post-time"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$author = sprintf( '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'kleo_framework' ), get_the_author() ) ),
			get_the_author()
		);

		//comentado en child
		//$meta_list[] = '<small class="meta-author">'.$author.'</small>';		
		//$meta_list[] = '<small>'.$date.'</small>';
		
		$cat_tag = array();
		
		if ( $categories_list ) {
			$cat_tag[] = $categories_list;
		}
		
/*comentado en child
		if ($tag_list) {
			$cat_tag[] = $tag_list;
		}
*/
		if (!empty($cat_tag)) {
			$meta_list[] = '<small class="meta-category">'.implode(", ",$cat_tag).'</small>';
		}
		
		//comments
		/*if (!isset($att['comments']) || (isset($att['comments']) && $att['comments'] !== false)) {
		$meta_list[] = '<small class="meta-comment-count"><a href="'. get_permalink().'#comments">'.get_comments_number().' <i class="icon-chat-1 hover-tip" 
			data-original-title="'.sprintf( _n( 'This article has one comment', 'This article has %1$s comments', get_comments_number(), 'kleo_framework' ),number_format_i18n( get_comments_number() ) ).'" 
			data-toggle="tooltip" 
			data-placement="top"></i></a></small>';
		}*/
		
		if ($echo) {
			echo implode(", ", $meta_list);
		}
		else {
			return implode(", ", $meta_list);
		}
		
	}
endif;

//Add me to child theme functions.php
function kleo_title()
{
	$output = "";

	if ( is_category() )
	{
		$output = __('','kleo_framework')." ".single_cat_title('',false);
	}
	elseif (is_day())
	{
		$output = __('','kleo_framework')." ".get_the_time('F jS, Y');
	}
	elseif (is_month())
	{
		$output = __('','kleo_framework')." ".get_the_time('F, Y');
	}
	elseif (is_year())
	{
		$output = __('','kleo_framework')." ".get_the_time('Y');
	}
	elseif (is_search())
	{
		global $wp_query;
		if(!empty($wp_query->found_posts))
		{
			if($wp_query->found_posts > 1)
			{
				$output =  $wp_query->found_posts ." ". __('search results for:','kleo_framework')." ".esc_attr( get_search_query() );
			}
			else
			{
				$output =  $wp_query->found_posts ." ". __('search result for:','kleo_framework')." ".esc_attr( get_search_query() );
			}
		}
		else
		{
			if(!empty($_GET['s']))
			{
				$output = __('Resultados de búsqueda:','kleo_framework')." ".esc_attr( get_search_query() );
			}
			else
			{
				$output = __('To search the site please enter a valid term','kleo_framework');
			}
		}

	}
	elseif (is_author())
	{
		$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$output = __('Artículos de','kleo_framework')." ";

		if(isset($curauth->nickname)) $output .= __(':','kleo_framework')." ".$curauth->nickname;

	}
	elseif (is_tag())
	{
		$output = __('','kleo_framework')." ".single_tag_title('',false);
	}
	elseif(is_tax())
	{
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$output = __('','kleo_framework')." ".$term->name;

	} elseif ( is_front_page() && !is_home() ) {
					$output = get_the_title(get_option('page_on_front'));

	} elseif ( is_home() && !is_front_page() ) {
					$output = get_the_title(get_option('page_for_posts'));

	} elseif ( is_404() ) {
					$output = __('Esta página no existe','kleo_framework');
	}
	else {
		$output = get_the_title();
	}

	if (isset($_GET['paged']) && !empty($_GET['paged']))
	{
		$output .= " (".__('Página','kleo_framework')." ".$_GET['paged'].")";
	}

	return $output;




}

/*
*
* Elminar permalink author
*
*/

// The first part //  - He quitado el page de la paginacion 
add_filter('author_rewrite_rules', 'no_author_base_rewrite_rules');
function no_author_base_rewrite_rules($author_rewrite) {
    global $wpdb;
    $author_rewrite = array();
    $authors = $wpdb->get_results("SELECT user_nicename AS nicename from $wpdb->users");   
    foreach($authors as $author) {
        $author_rewrite["({$author->nicename})/page/?([0-9]+)/?$"] = 'index.php?author_name=$matches[1]&paged=$matches[2]';
		$author_rewrite["({$author->nicename})/?([0-9]+)/?$"] = 'index.php?author_name=$matches[1]&paged=$matches[2]';
        $author_rewrite["({$author->nicename})/?$"] = 'index.php?author_name=$matches[1]';
    }  
    return $author_rewrite;
}
 
// The second part //
add_filter('author_link', 'no_author_base', 1000, 2);
function no_author_base($link, $author_id) {
    $link_base = trailingslashit(get_option('home'));
    $link = preg_replace("|^{$link_base}author/|", '', $link);
    return $link_base . $link;
}


/*
*
* Funcion para colocar un script en el footer para poner el titulo de los articulos de la portada
*
*/

function title_post_magazine_home(){
	//Aquí va el script final que escribe los titulos
	//busca el title de los 4 ultimos articulos con la tag .home (hay que excluirla cuando se pintan en el single)
	$query = query_posts('tag=destacado&showposts=4&post_status=publish&order=DESC’');
	//var_dump($query);
	$txt = cut_title($query[0]->post_title);
	$txt2 = cut_title($query[1]->post_title);
	$txt3 = cut_title($query[2]->post_title);
	$txt4 = cut_title($query[3]->post_title);
	//print script
	echo '
		<script>
		//init FITTEXT
			jQuery("#titulogo").fitText();
		//init SLABTEXT
				var stS = "<span class=\'slabText\'>",
				stE = "</span>",
				txt = ["'.$txt.'"];
				txt2 = ["'.$txt2.'"];
				txt3 = ["'.$txt3.'"];
				txt4 = ["'.$txt4.'"];
				jQuery("#post1").html(stS + txt.join(stE + stS) + stE).slabText();
				jQuery("#post2").html(stS + txt2.join(stE + stS) + stE).slabText();
				jQuery("#post3").html(stS + txt3.join(stE + stS) + stE).slabText();
				jQuery("#post4").html(stS + txt4.join(stE + stS) + stE).slabText();
		</script>
	'; 
	/*
	txt = [
				"ESPECIAL ",
				"STREETSTYLE"];

	*/
	//fin print script
}

function cut_title($text){
	//corta el title en dos	
	$newtext = wordwrap($text, 30, '","');
	return $newtext;
	
}


function buscarSoloPosts($query) {
    if ($query->is_search && !is_admin()) {
        $query->set('post_type', 'post');
    }
    return $query;
}

add_filter('pre_get_posts', 'buscarSoloPosts');

/*
 * CUSTOM PAGINATION BASE - Cambia la url de la paginacion, quita el /page/
 * Para que funcione del todo, se ha modificado el fichero, function-core.php dentro de kleo/kleo-framework/lib/ Funcion kleo_pagination();
 *
*/

function custom_pagination_base() {
	global $wp_rewrite;

  // Change the value of the author permalink base to whatever you want here
	  $wp_rewrite->pagination_base = '';

	  $wp_rewrite->flush_rules();
}
add_action( 'init', 'custom_pagination_base', 1 );

/*------------------- SHORTCODES -----------------------*/

/* 
*
* Shortcode para sacar en home los 6 ultimos post despues de los del slider
*
*/

function posts_home(){
	$id_noticias = get_cat_ID( 'noticias' );
	global $not_post_in;
	// The Query
	$args = array(
		'post_status'  => 'publish',
		'posts_per_page' => 29,
		'orderby' => 'date',
		'order'    => 'DESC',
		'cat'	=> '-566, -'.$id_noticias
	);
	query_posts( $args );
	
	/*echo '<div class="row">';*/
	// The Loop
	$c=1;

	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		if($c>0){ 
			$category = get_the_category();
			foreach ($category as $struct ) {
				if ( $struct->cat_name == 'Streetstyle'){
					$category[0] = $struct;
				}
			}

			if ($c>1 && $c%2 == 0){
				echo '<div class="portada_posts portada_posts_left">';
				$link = get_permalink();
				$title = get_the_title();
			}else if($c>1 && $c%2 !== 0){
				echo '<div class="portada_posts portada_posts_right">';
				$link = get_permalink();
				$title = get_the_title();
			}else{
				echo '<div class="portada_posts">';
				$link = get_permalink();
				$title = get_the_title();				
			}

			if ($c==1) {
				echo '<a href="'.$link.'" class="_self element-wrap"><span class="hover-element"><i>.</i></span>'.get_the_post_thumbnail( $post_id, 'full' ).'</a>';
			}else{	
				echo '<a href="'.$link.'" class="_self element-wrap"><span class="hover-element"><i>.</i></span>'.get_the_post_thumbnail( $post_id, 'medium' ).'</a>';
			}
			//echo '<div class="hr-title hr-long"><abbr><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></div>';			
			echo '<h5 style="margin-top: 10px;"><a href="'.$link.'">'.$title.'</a></h5>';
			echo '<div class="pt-cv-content"><small>'.get_the_excerpt().'</small></div>';
			echo '</div>';
			//Mirar los post que ya han salido y cargararlo en la variable de wordpress que permite obviar los que se han mostrado
			$not_post_in[] = get_the_ID();
		}else{
				//Mirar los post que ya han salido y cargararlo en la variable de wordpress que permite obviar los que se han mostrado
				$not_post_in[] = get_the_ID();
		}
		/*if($c==3){
			echo '
			<!-- Banner Home entre los post (3 y 4) -->
			<ins class="adsbygoogle"
			     style="display:block; margin-right: 10px; clear: both;"
			     data-ad-client="ca-pub-9006336585437783"
			     data-ad-slot="2858578552"
			     data-ad-format="auto"></ins>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
		}*/
		//if($c==7){
		//	echo '<a style="text-align: center; display: block; margin: 10px 10px 10px 0px; clear: both;" href="https://www.bogadia.com/sorteos/concurso-de-disenadoras/"><img src="https://www.bogadia.com/wp-content/uploads/tienda/banner-sorteo-tienda.jpg" alt="Sorteo de bolso - Tienda Bogadia"/></a>';
		//}
	/*
		//Seccion tracdelight
		if($c==6){
			echo '<div class="widgetTracdelight">';
				$tracWidget1 = get_page_by_title('Tracdelight Home Widget1', ARRAY_A, 'post');  
				$contentWid1 = $tracWidget1['post_content'];
				echo $contentWid1;
			echo "</div>";
		}
	*/
		$c++;
	endwhile;
	/*echo '</div>';*/
	echo '<div style="clear:both;"></div>';
	// Reset Query
	wp_reset_query();	
}
add_shortcode( 'PostsRecents', 'posts_home' );


/* 
*
* Shortcode para sacar los más leidos al final de la Home
*/
function losmaspoupulares(){	
	//sacamos los post mas visitadod del un plugin, wp_postviews
		 $args = array(
			'numberposts' => 4,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => 'views',
			'post_type' => 'post',
			'post_status' => 'publish', 
			'date_query' => array('column' => 'post_date_gmt', 'after' => '2 month ago') // Muestra los post más leidos solo del último mes.
		);
		$most_viewed = get_posts($args);
	//aqui hacemos lo de siempre, y pintamos el Html, según los resultados
	foreach( $most_viewed as $most_viewed ) {
						
			$category = get_the_category($most_viewed->ID);
			foreach ($category as $struct ) {
				if ( $struct->cat_name == 'Streetstyle'){
					$category[0] = $struct;
				}
			}
			echo '<div class="portada_posts">';
			$link = get_permalink($most_viewed->ID);
			$title = get_the_title($most_viewed->ID);			
			echo '<a href="'.$link.'" class="_self element-wrap"><span class="hover-element"><i>.</i></span>'.get_the_post_thumbnail( $most_viewed->ID, 'medium' ).'</a>';
			echo '<h5 style="text-transform: uppercase; margin-top: 10px;><a href="'.$link.'">'.$title.'</a></h5>';
			echo '<div class="pt-cv-content"><small>'.$most_viewed->post_excerpt.'</small></div>';
			echo '</div>';
			wp_reset_query();
		}
	

}
add_shortcode( 'MasPopulares', 'losmaspoupulares' );

/* 
*
* Shortcode para sacar en los mas, los post mas vistos en la sidebar
*
*/
function losmaspoupularessidebar(){
	//Sql para la obtencion delos posts:
	global $not_post_in;
	$current_post = get_the_ID();
	$likes_posts_args = array(
			'post__not_in' => array($current_post),
			'numberposts' => 4,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => 'views',
			'post_type' => 'post',
			'post_status' => 'publish', 
			'date_query' => array('column' => 'post_date_gmt', 'after' => '1 month ago') // Muestra los post más leidos solo del último mes.	
		);	
	$likes_posts = get_posts($likes_posts_args);
		echo '<h4 class="widget-title">Lo más visto</h4>';
		foreach( $likes_posts as $likes_post ) {			
			$category = get_the_category($likes_post->ID);
			echo '<div class="portada_posts" style="display: table;">';
			$link = get_permalink($likes_post->ID);
			$title = get_the_title($likes_post->ID);			
			$classTitle = "lessFontSize";
			echo '<a style="vertical-align: middle; display: table-cell; width: 100px;" class="element-wrap" href="'.$link.'">'.get_the_post_thumbnail( $likes_post->ID, 'thumbnail' ).'<span class="hover-element"><i></i></span></a>'.'<h5 style="vertical-align: middle; display: table-cell;"><a href="'.$link.'" class="'.$classTitle.'">'.$title.'</a></h5>';	
			echo '</div>';
			wp_reset_query();
		}

}
add_shortcode( 'MasPopularesSidebar', 'losmaspoupularessidebar' );

/* 
*
* Shortcode para sacar post relacionados por tags
*/
function relatedpostsidebar(){
	global $not_post_in;
    global $post;
	$tags = wp_get_post_tags($post->ID);
	$cats = get_the_category();
	$cat_name = $cats[0]->name;
	if ($tags && $cat_name != "Streetstyle") {
	    $tag_ids = array();
	    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
	    $args=array(
		    'tag__in' => $tag_ids,
		    'post__not_in' => array($post->ID),
		    'numberposts' => 4, // Number of related posts to display.
			'post_type' => 'post',
			'post_status' => 'publish',		
			'date_query' => array('column' => 'post_date_gmt', 'after' => '3 months ago') // Muestra los post más leidos solo del último mes.	
		);
		$related_posts = get_posts( $args );
		if (!empty( $related_posts )){
			echo '<h4 class="widget-title">También te gustará</h4>';
		
			foreach( $related_posts as $related_post ) {			
				$category = get_the_category($related_post->ID);
				echo '<div class="portada_posts" style="display: table-row;">';
				$link = get_permalink($related_post->ID);
				$title = get_the_title($related_post->ID);		
				$classTitle = "lessFontSize";
				echo '<a style="width: 100px;" class="element-wrap" href="'.$link.'">'.get_the_post_thumbnail( $related_post->ID, 'thumbnail' ).'<span class="hover-element"><i></i></span></a>'.'<h5 style="vertical-align: middle; display: table-cell;"><a href="'.$link.'" class="'.$classTitle.'">'.$title.'</a></h5>';
				echo '</div>';
				echo '</br>';
				wp_reset_query();
			}
		}
	}
}
add_shortcode( 'RelatedPostSidebar', 'relatedpostsidebar' );


/* 
*
* Shortcode para sacar en los ultimos post en la sidebar de una categoria en concreto
*
*/
function populares_Categoria_Sidebar( $atts ){
	$id_cat = get_cat_ID( $atts['cat'] );
	//Sql para la obtencion delos posts:
	global $not_post_in;
	$current_post = get_the_ID();
	$lasts_posts_args = array(
			'post__not_in' => array($current_post),
			'numberposts' => 4,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => 'views',
			'post_type' => 'post',
			'post_status' => 'publish', 
			'date_query' => array('column' => 'post_date_gmt', 'after' => '2 month ago'), // Muestra los post más leidos solo del último mes.	
			'cat' => $id_cat			
		);	
	?>
	<h4 class="widget-title lessFontSize">Lo más visto en <?php echo $atts['cat'];?></h4>
	<?php
	$lasts_posts = get_posts($lasts_posts_args);
		foreach( $lasts_posts as $last_post ) {	
			$category = get_the_category($last_post->ID);
			echo '<div class="portada_posts" style="display: table-row;">';
			$link = get_permalink($last_post->ID);
			$title = get_the_title($last_post->ID);		
			$classTitle = "lessFontSize";
			echo '<a style="width: 100px;" class="element-wrap" href="'.$link.'">'.get_the_post_thumbnail( $last_post->ID, 'thumbnail' ).'<span class="hover-element"><i></i></span></a>'.'<h5 style="vertical-align: middle; display: table-cell;"><a href="'.$link.'" class="'.$classTitle.'">'.$title.'</a></h5>';
			echo '</div>';
			echo '</br>';
			wp_reset_query();
		}

}
add_shortcode( 'popularesCategoria', 'populares_Categoria_Sidebar' );

/* 
*
* Shortcode para sacar en los mas, los ultimas noticias en la sidebar
*
*/
function lasUltimasNoticiasSidebar(){
	$id_noticias = get_cat_ID( 'noticias' );
	//Sql para la obtencion delos posts:
	global $not_post_in;
	$current_post = get_the_ID();
	$lasts_posts_args = array(
			'post__not_in' => array($current_post),
			'numberposts' => 4,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish',
			'cat' => $id_noticias				
		);	
	$lasts_posts = get_posts($lasts_posts_args);
	?>
	<h4 class="widget-title">#NotiBogadia</h4>
	<?php
		foreach( $lasts_posts as $last_post ) {		
			$category = get_the_category($last_post->ID);
			echo '<div class="portada_posts" style="display: table-row;">';
			$link = get_permalink($last_post->ID);
			$title = get_the_title($last_post->ID);		
			$classTitle = "lessFontSize";
			echo '<a style="width: 112px;" class="element-wrap" href="'.$link.'">'.get_the_post_thumbnail( $last_post->ID, 'thumbnail' ).'<span class="hover-element"><i></i></span></a>'.'<h5 style="vertical-align: middle; display: table-cell;"><a href="'.$link.'" class="'.$classTitle.'">'.$title.'</a></h5>';			
			echo '</div>';
			echo '</br>';
			wp_reset_query();
		}

}
add_shortcode( 'UltimasNoticias', 'lasUltimasNoticiasSidebar' );

/*
*
* Shortcode para la home de la tienda
*
*/
function slider_shop( $atts ){
	$images = explode( ', ', $atts['images']);
	$links = explode(', ', $atts['links']);
	$image=$images[0];
	?>
	<div class="imageNoSlider">
        <a href="<?php if (isset($links[$i])){ bloginfo('wpurl'); echo $links[$i]; }else{ ?>#<?php } ?>" class="princiaplLinkNoSlide"><img class="principalImageNoSlide" src="<?php bloginfo('wpurl'); ?><?php echo $image; ?>" /></a>
    	<?php
        $i =0;
        foreach ($images as $image){
        ?>
        	<img class="thumbNoSlide <?php if($i==0){echo 'selectedImage';}?>" src="<?php bloginfo('wpurl'); ?><?php echo $image; ?>" linker="<?php if (isset($links[$i])){ bloginfo('wpurl'); echo $links[$i]; }else{ ?>#<?php } ?>" />
        <?php
        $i++;
    	}
        ?>
    </div>
	<script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/jssor.slider.mini.js"></script>
	<script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/sliderShop.js"></script>
    <div id="sliderShop_container" style="position: relative; top: 0px; left: 0px; width: 1110px; height: 433px; background: #fff; overflow: hidden; ">
		
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

		<!-- Slides Container -->
        <div u="slides" style="cursor: pointer; position: absolute; left: 0px; top: 0px; width: 874px; height: 437px;
            overflow: hidden;">

        <?php
        $i =0;
        foreach ($images as $image){
        ?>

            <div>
                <a href="<?php if (isset($links[$i])){ bloginfo('wpurl'); echo $links[$i]; }else{ ?>#<?php } ?>"><img u="image" src="<?php bloginfo('wpurl'); ?><?php echo $image; ?>" /></a>
                <div u="thumb">
                    <img class="i" src="<?php bloginfo('wpurl'); ?><?php echo $image; ?>" />
                </div>
            </div>

        <?php
        $i++;
    	}
        ?>

        </div>
 		<!--#region ThumbnailNavigator Skin Begin -->
 		<link href="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/css/sliderShop.css" rel="stylesheet" type="text/css">
        <div u="thumbnavigator" class="jssort11" style="left: 874px; top:0px;">
            <!-- Thumbnail Item Skin Begin -->
            <div u="slides" style="cursor: default;">
                <div u="prototype" class="p" style="top: 0; left: 0;">
                    <div u="thumbnailtemplate" class="tp"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div> 
        <!--#endregion ThumbnailNavigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
	</div>
	<?php
}
add_shortcode( 'sliderShop', 'slider_shop' );

/*
*
* Shortcode para las paginas individuales de colecciones de la tienda
*
*/
function other_collections(){
?>
    <div class="otherCollecContent">
        <div class="otherCollec">
            <div class="hr-title hr-full hr-center">
                <a href="#"><abbr>La Patiño</abbr></a>
            </div>    
            <div class="hr-title hr-full hr-center">
                <a href="#"><abbr>Late West</abbr></a>
            </div>    
            <a href="#"><img src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/004.jpg" /></a>
        </div>
        <div class="otherCollec">
            <div class="hr-title hr-full hr-center">
                <a href="#"><abbr>Lucrecia</abbr></a>
            </div>
            <div class="hr-title hr-full hr-center">
                <a href="#"><abbr>Azalia</abbr></a>
            </div>
            <a href="#"><img src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/005.jpg" /></a>
        </div>
        <div class="otherCollec">
            <div class="hr-title hr-full hr-center">
                <a href="#"><abbr>La Patiño</abbr></a>
            </div>
            <div class="hr-title hr-full hr-center">
                <a href="#"><abbr>Nejliu</abbr></a>
            </div>
            <a href="#"><img src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/006.jpg" /></a>
        </div>
    </div>
<?php
}
add_shortcode('otherCollections', 'other_collections');

/*
*
* Shortcode para la pagina de colecciones de la tienda
*
*/
function content_designers(){
	$user_query = new WP_User_Query( array( 'role' => 'disenador', 'number' => 3, 'offset' => 0 ) );

	// Get the results
	$designers = $user_query->get_results();

	// Check for results
	if (!empty($designers)) {

	?>
	<script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/boxDesigners.js"></script>
    <h2 id="designersTitle">DISEÑADORES</h2>
    <div class="boxContDesigners">
    <?php

	    // loop trough each author
	    foreach ($designers as $designer)
	    {
	    	$user_info = get_userdata($designer->ID);
	    	?>
		    <div class="boxDesigner">
		        <a href="<?php bloginfo('wpurl'); ?>/disenadores/<?php echo $user_info->nickname ; ?>/">
					<?php echo get_avatar( $designer->ID, 512 ); ?>
		            <p><?php echo $user_info->display_name; ?></p>
		        </a>
		    </div>
		    <?php
	    }
	?>
	<?php
	}
?>

</div>
<?php
}
add_shortcode( 'designersContent', 'content_designers' );

/*
*
* Shortcode para sacar fotografo
*
*/
function photographer_box( $atts ){
	$user_photographer = get_user_by( "email", $atts['email'] );
	?>

	<div class="photographer-box">
		<h2 class="newTitleAuthor">
		<a class="author-link photo newAuthorPhoto" href="<?php bloginfo('wpurl'); ?>/equipo" rel="author"> 
			<?php echo get_avatar( $user_photographer -> id, 100 ); ?>
		</a>
		<span>Fotografías de </span>
		<a class="author-link url" href="<?php bloginfo('wpurl'); ?>/equipo" rel="author">
			<?php echo $user_photographer->display_name ; ?>
		</a>
		</h2>
	</div>

	<?php
}
add_shortcode( 'photoBox', 'photographer_box');

/*
*
* Shortcode para la portada de revista
*
*/
function magazine_home_html(){
	//aqui va el codigo html para la porada de revista
	//busca la url de los 4 ultimos articulos con la tag .home (hay que excluirla cuando se pintan en el single)
	$query = query_posts('tag=destacado&showposts=4&post_status=publish&order=DESC');
	//var_dump($query);get_permalink($query[0]->ID)
	$txt =  get_permalink($query[0]->ID);
	$txt2 = get_permalink($query[1]->ID);
	$txt3 = get_permalink($query[2]->ID);
	$txt4 = get_permalink($query[3]->ID);
	
	//Pinta el codigo header <h1 id="titulogo" style="display:none;" class="fixed-nav-title trigger">
					
				//</h1>PHASIONÂTE<span>Passion for Fashion</span>
	echo '
		<div id="container" class="containerM intro-effect-sliced">
		<div class="codrops-top clearfix">
		</div>
		<header class="header">
			<div class="bg-img"></div>
			<div style="margin-top: 150px;" class="title fixed-nav">
				<h1 id="titulogo" style="display:none;" class="fixed-nav-title trigger">
					<span style="display:none">BOGADIA<span>Mucho más que moda</span></span>
				</h1>
			<div>
				<nav id="navSup" class="codrops-demos">
					<div class="col-1">
					<a href="'.$txt.'" class="fixed-nav" id="post1"></a>
					</div>
					<div class="col-2">
					<a href="'.$txt2.'" class="fixed-nav" id="post2"></a>
					</div>
				</nav>
				</div>
			</div>
			<div class="bg-img img-bottom">
				<nav class="codrops-demos">
					<div class="col-3">
					<a href="'.$txt3.'" class="fixed-nav" id="post3"></a>
					</div>
					<div class="col-4">
					<a href="'.$txt4.'" class="fixed-nav" id="post4"></a>
					</div>						
				</nav>
			</div>
		</header>
		<button class="trigger fixed-nav" data-info=""><span>¡Entra!</span></button>
		
	';
	wp_reset_query();
}
add_shortcode( 'MagazineHome', 'magazine_home' );

function shoppingarea(){	
	//sacamos los post mas visitadod del un plugin, wp_postviews
		 $args = array(
			'numberposts' => 1,
			'cat' => '566',
			'post_type' => 'post',
			'post_status' => 'publish',
		 	'order' => 'DESC',
 			'orderby' => 'meta_value_num'
		);
		$shop_post = get_posts($args);
	//aqui hacemos lo de siempre, y pintamos el Html, según los resultados
	foreach( $shop_post as $shop_post ) {			
			echo '<h2 style="text-align: center;font-family:Playfair Display;font-weight:400;font-style:normal">'.get_the_title($shop_post->ID).'</h2>';
			echo do_shortcode( $shop_post->post_content );
			wp_reset_query();
		}
	

}
add_shortcode( 'ShoppingArea', 'shoppingarea' );


/*------------------- Fin SHORTCODES -----------------------*/

/* add class of woocommerce for submenu and also code for every webbrowser */
function woocommerce_body_class($classes = '') {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	$classes[]= 'woocommerce-page';
	/*if (in_array( 'page-template-lucrecia', $classes)){
		$classes[]= 'woocommerce-page';
	}*/
	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


/*------------------------------Fin Funcionalidades------------------------------------*/

/* Optimizacion y tiempo de carga de la web  */

/* BBDD */

//Reducir El Tiempo de Carga y Optimizar La Base de Datos
 remove_action('wp_head','wp_generator');
 remove_action( 'wp_head', 'feed_links_extra', 3 );
 remove_action( 'wp_head', 'feed_links', 2 );
 remove_action( 'wp_head', 'rsd_link' );
 remove_action( 'wp_head', 'wlwmanifest_link' );
 remove_action( 'wp_head', 'index_rel_link' );
 remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
 remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
 remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );


/* JS */



/* HTACCESS */


/* ESCONDER WORDPRESS */

/**
 * Limpieza de wp_head()
 * Borra todo lo que tenga que ver con wordpress para no delatar que es wordpress:
 *
 * Elimina enlaces innecesarios
 * Elimina el CSS utilizado por el widget de comentarios recientes
 * Elimina el  CSS utilizado en las galerías
 * Elimina el cierre automático de etiquetas y cambia de ''s a "'s en rel_canonical()
 */
function nowp_head_cleanup() {
    // Eliminamos lo que sobra de la cabecera
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

    if (!class_exists('WPSEO_Frontend')) {
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', 'nowp_rel_canonical');
    }
}
function nowp_rel_canonical() {
    global $wp_the_query;

    if (!is_singular()) {
        return;
    }

    if (!$id = $wp_the_query->get_queried_object_id()) {
        return;
    }

    $link = get_permalink($id);
    echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}
add_action('init', 'nowp_head_cleanup');


/**
 * Eliminamos la versión de WordPress
 */
add_filter('the_generator', '__return_false');


/**
 * Limpieza de los language_attributes() usados en la etiqueta <html>
 *
 * Cambia lang="es-ES" a lang="es"
 * Elimina dir="ltr"
 */
function nowp_language_attributes() {
    $attributes = array();
    $output = '';

    if (function_exists('is_rtl')) {
        if (is_rtl() == 'rtl') {
            $attributes[] = 'dir="rtl"';
        }
    }

    $lang = get_bloginfo('language');

    if ($lang && $lang !== 'es-ES') {
        $attributes[] = "lang=\"$lang\"";
    } else {
        $attributes[] = 'lang="es"';
    }

    $output = implode(' ', $attributes);
    $output = apply_filters('nowp_language_attributes', $output);

    return $output;
}
add_filter('language_attributes', 'nowp_language_attributes');

//Aumenta el numero de post pedidos al query
function wpsites_query( $query ) {
if ( $query->is_archive() && $query->is_main_query() && !is_admin() && !is_author() ) {
        $query->set( 'posts_per_page', 20 );
    }
}
add_action( 'pre_get_posts', 'wpsites_query' );

//Elimina el error 404 de woocommerce
function flush_rules(){
  flush_rewrite_rules();
}
add_action('init','flush_rules');

/* Boton galeria */

add_filter('um_profile_tabs', 'add_gallery_tab', 1000 );
function add_gallery_tab( $tabs ) {

	$tabs['gallery'] = array(
		'name' => 'Galeria',
		'icon' => 'um-faicon-photo',
	);
		
	return $tabs;
		
}

/* Then we just have to add content to that tab using this action */

add_action('um_profile_content_gallery_default', 'um_profile_content_gallery_default');
function um_profile_content_gallery_default( $args ) {
		
		extract( $args );

		?><form method="post" action="" class="formGallery"><?php
	
		do_action("um_before_form", $args);
				
		do_action("um_before_{$template}_fields", $args);
				
		do_action("um_main_{$template}_fields", $args);
				
		do_action("um_after_form_fields", $args);
				
		do_action("um_after_{$template}_fields", $args);
				
		do_action("um_after_form", $args);

		?></form><?php

}


function add_my_script() {
	?><script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/scripts.js"></script><?php
}
add_action('wp_footer', 'add_my_script');

function bbg_bp_loggedin_register_page_redirect_to( $redirect_to ) {
	if ( bp_is_component_front_page( 'register' ) )
		$redirect_to = bp_get_root_domain() . '/concurso-portada/';

	return $redirect_to;
}
add_filter( 'bp_loggedin_register_page_redirect_to', 'bbg_bp_loggedin_register_page_redirect_to' );
/*
 *Redirigir a los suscriptores a la web del concurso
 */
/* function subscriber_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( 'subscriber', $user->roles ) ) ? '/concurso-portada' : admin_url();
}
add_filter( 'login_redirect', 'subscriber_login_redirect', 10, 3 );

function bp_redirect($user) {
	$redirect_url = 'https://www.bogadia.com/concurso-portada';
	bp_core_redirect($redirect_url);
}
add_action('bp_core_signup_user', 'bp_redirect', 100, 1);

function __my_registration_redirect()
{
	return home_url( '/concurso-portada' );
}
add_filter( 'registration_redirect', '__my_registration_redirect' ); */
/*

-----BORRA ESTE COMENTARIO UNA VEZ HECHOS ESTOS PASOS
	QUEDA COMENTADA PARA CUANDO SE CAMBIEN LOS DIRECTORIOS 
		HAY QUE AÑADIR DEFINES EN EL WP_CONFIG:
			define('UPLOADS', 'wp-content/archivos'); -> Para cambiar el nombre de la carpeta uploads
			define( 'WP_CONTENT_DIR', 'NUEVA RUTA A WP-CONTENT' ); -> Cambiar el directorio de wp_content
-----BORRA ESTE COMENTARIO UNA VEZ HECHOS ESTOS PASOS

 	* Reescritura de URLs 
 	*
 	* Modifica el rewrite de:
 	*  /wp-content/themes/nombredeltema/include/css/ a /include/css/
 	*  /wp-content/themes/nombredeltema/include/js/ a /include/js/
 	*  /wp-content/themes/nombredeltema/include/img/ a /include/img/
 	*  /wp-content/plugins/ a /plugins/
	 */
/*	function nowp_add_rewrites($content) {
   	 global $wp_rewrite;
   		 $nowp_new_non_wp_rules = array(
    	    'assets/(.*)' => THEME_PATH . '/include/$1',
       	 	'plugins/(.*)'   => RELATIVE_PLUGIN_PATH . '/$1'
   		 );
    	$wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $nowp_new_non_wp_rules);
    	return $content;
	}

	function nowp_clean_urls($content) {
    	if (strpos($content, RELATIVE_PLUGIN_PATH) > 0) {
        	return str_replace('/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content);
    	} else {
        	return str_replace('/' . THEME_PATH, '', $content);
    	}
	}

	// No se hace rewrite en multisitio o temas hijo para no joderlo todo
	if ( !is_multisite() && !is_child_theme() ) {
    	add_action('generate_rewrite_rules', 'nowp_add_rewrites');
    	if ( !is_admin() ) {
       	 $tags = array(
        	    'plugins_url',
            	'bloginfo',
            	'stylesheet_directory_uri',
            	'template_directory_uri',
            	'script_loader_src',
            	'style_loader_src'
        	);
       		 add_filters($tags, 'nowp_clean_urls');
    	}
	}
*/