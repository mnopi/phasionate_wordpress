<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>


<?php
//Specific class for post listing */
$blog_type = sq_option('blog_type','masonry');
$template_classes = $blog_type . '-listing';
if ($blog_type == 'standard' && sq_option('blog_meta_status', 1) == 1) { $template_classes .= ' with-meta'; }
add_filter('kleo_main_template_classes', create_function('$cls','$cls .=" posts-listing '.$template_classes.'"; return $cls;'));
?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

	<?php if ( have_posts() ) : ?>

	<?php 
	if ($blog_type == 'masonry') {
		echo '<div class="row">'
			.'<div class="grid-posts kleo-isotope masonry">';
	}
	?>

	<?php if(is_author()){ ?>
		<div id="authorarea" class="vcard author">
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 150 ); ?></a>
			<a class="author-link fn" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<h2><?php echo (get_the_author( )) ; ?></h2></a>
			<div class="authorinfo">
				<?php the_author_meta( 'description' ); ?><br/>
			</div>
		</div>
	<?php }?>

	<?php
			$c = 1;
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
			
				if ($blog_type == 'masonry') {
					get_template_part( 'page-parts/post-content-masonry');
				}
				else {
					//siempre salta por aqui en lo referente a nuestro diseño	
					?>

					<!-- Begin Article -->
					<?php								
						if( $c==1 ){
							//echo '<div class="content_posts content-col-2">';
							$col = "content-col-1";
							//if($c==2)$col .= ' clear';
						}
						if($c > 1 ){
							$col = "content-col-2";
						}
						?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(array($postclass.$col)); ?>>	
							
					<?php		
					get_template_part( 'content', get_post_format() );
					$c++; //Aumentamos 1 el contador $c 
				}
			endwhile;
			?>

			<?php
			if ($blog_type == 'masonry') { 
				echo '</div>'
					.'</div>';
			}
			?>

			<?php
			// page navigation.
			kleo_pagination();

		else :
			// If no content, include the "No posts found" template.
			get_template_part( 'content', 'none' );

		endif;
	?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>