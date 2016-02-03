<?php
/**
 * Template Name: Concurso de portada
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header();

?>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php get_template_part('page-parts/general-before-wrap-no-title'); ?>

<?php
if ( have_posts() ) :
    // Start the Loop.
    while ( have_posts() ) : the_post();

        /*
         * Include the post format-specific template for the content. If you want to
         * use this in a child theme, then include a file called called content-___.php
         * (where ___ is the post format) and that will be used instead.
         */
        get_template_part( 'content', 'page' );
        ?>

        <?php if ( sq_option( 'page_comments', 0 ) == 1 ): ?>

            <!-- Begin Comments -->
            <?php comments_template( '', true ); ?>
            <!-- End Comments -->

        <?php endif; ?>

    <?php endwhile;

endif;
?>
    <style>
        /* CSS used here will be applied after bootstrap.css */
        body { font-family: 'Open Sans', sans-serif; }

        @media screen and (max-width: 700px){
            #interstitialModal{
                top: 0% !important;
            }
        }
        @media screen and (min-width: 701px){
            #interstitialModal{
                position: fixed;
                top: 7% !important;
            }
        }

        #interstitialModal .modal-dialog
        {
            color: #ffffff;
        }

        #interstitialModal .modal-body
        {
            padding:0px;
        }

        #interstitialModal .modal-dialog a
        {
            color: #ffffff;
            text-decoration:underline;
        }

        #interstitialModal .modal-content
        {
            width: auto;
            border: 0px;
        }
        .modal-backdrop
        {
            opacity:0.8 !important;
        }
        button#close-buton.close{
            opacity: 1 !important;
            font-size: 25px;
            color: white;
        }
        #trackinglink{
            opacity: 0;
        }
        .ad_header, .ad_discount{
            color: black !important;
            text-decoration: none !important;
            font-family: Oswald;
        }
        .ad_header{
            font-size: 20px;
        }
        .ad_link{
            color: white !important;
            width: 90%;
            text-decoration: none !important;
            font-size: 20px;
            font-family: Oswald;

        }
        .old_price{
            color: grey !important;
        }
    </style>

    <!-- Intersitial Modal -->
    <div class="modal fade" id="interstitialModal" tabindex="-1" role="dialog" data-width="640" aria-labelledby="interstitialLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center">
            <a id="trackinglink" href="#">d</a>
            <button id="close-buton" type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">X</span><span class="sr-only text-muted">Close</span>
            </button>
        </p>
        <div class="modal-content">
            <div class="modal-body text-center">
                <?php echo adrotate_group(1); ?>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery('#interstitialModal').modal({show:true, backdrop: 'static',});
        });
    </script>


<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>