<?php
/**
 * The Template for displaying property archives, also referred to as 'Search Results'
 *
 * Override this template by copying it to yourtheme/propertyhive/archive-property.php
 *
 * @author      PropertyHive
 * @package     PropertyHive/Templates
 * @version     1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

get_header('propertyhive');
global $wpdb; ?>

<?php
/**
 * propertyhive_before_main_content hook
 *
 * @hooked propertyhive_output_content_wrapper - 10 (outputs opening divs for the content)
 */
do_action('propertyhive_before_main_content');
?>

<?php /*if ( apply_filters( 'propertyhive_show_page_title', true ) ) : */ ?><!--

            <h1 class="page-title"><?php /*propertyhive_page_title(); */ ?></h1>

        --><?php /*endif; */ ?>

<?php
/**
 * propertyhive_before_search_results_loop hook
 * @hooked propertyhive_search_form - 10
 * @hooked propertyhive_result_count - 20
 * @hooked propertyhive_catalog_ordering - 30
 */
//do_action( 'propertyhive_before_search_results_loop' );
?>
    <div id="archive-search-form" class="light-orange">
        <div class="inner-container">
            <?php
            //do_action('two_roost_search_form');
            propertyhive_search_form();
            ?>
        </div>
    </div>

    <div id="post-count-and-filters">
        <div class="inner-container">
            <div class="fbox-row">

                    <?php $count = $GLOBALS['wp_query']->post_count; ?>
                    <?php if ($count == 1): ?>
                        <div class="post-count fbox-column shrink count">
                            <?php echo $count; ?>&nbsp;
                        </div>
                        <div class="post-count fbox-column ">
                            Property for sale
                        </div>
                    <?php else: ?>
                        <div class="post-count fbox-column shrink count">
                            <?php echo $count; ?>&nbsp;
                        </div>
                        <div class="post-count fbox-column ">
                            Properties for sale
                        </div>
                    <?php endif; ?>

                <div class="filters fbox-column">
                    <?php propertyhive_catalog_ordering(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
// Output results. Filter allows us to not display the results whilst maintaining the main query. True by default
// Used primarily by the Map Search add on - https://wp-property-hive.com/addons/map-search/
if (apply_filters('propertyhive_show_results', true)) :
    ?>
    <div id="property-results">
        <div class="inner-container">
            <?php if (have_posts()) : ?>

                <?php propertyhive_property_loop_start(); ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php ph_get_template_part('content', 'property'); ?>

                <?php endwhile; // end of the loop. ?>

                <?php propertyhive_property_loop_end(); ?>

            <?php else: ?>

                <?php ph_get_template('search/no-properties-found.php'); ?>

            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>

<?php
/**
 * propertyhive_after_search_results_loop hook
 *
 * @hooked propertyhive_pagination - 10
 */
do_action('propertyhive_after_search_results_loop');
?>

<?php
/**
 * propertyhive_after_main_content hook
 *
 * @hooked propertyhive_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('propertyhive_after_main_content');
?>

<?php get_footer('propertyhive'); ?>