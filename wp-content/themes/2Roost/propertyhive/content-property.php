<?php
/**
 * The template for displaying a single property within search results loops.
 *
 * Override this template by copying it to yourtheme/propertyhive/content-property.php
 *
 * @author        PropertyHive
 * @package    PropertyHive/Templates
 * @version     1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

global $property, $propertyhive_loop;

// Store loop count we're currently on
if (empty($propertyhive_loop['loop']))
    $propertyhive_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($propertyhive_loop['columns']))
    $propertyhive_loop['columns'] = apply_filters('loop_search_results_columns', 1);

// Ensure visibility
if (!$property)
    return;

// Increase loop count
++$propertyhive_loop['loop'];

// Extra post classes
$classes = array('clear');
if (0 == ($propertyhive_loop['loop'] - 1) % $propertyhive_loop['columns'] || 1 == $propertyhive_loop['columns'])
    $classes[] = 'first';
if (0 == $propertyhive_loop['loop'] % $propertyhive_loop['columns'])
    $classes[] = 'last';
if ($property->featured == 'yes')
    $classes[] = 'featured';
?>
<li <?php post_class($classes); ?>>

    <?php do_action('propertyhive_before_search_results_loop_item'); ?>

    <div class="thumbnail">
        <a href="<?php the_permalink(); ?>" class="thumblink"
           style="background-image: url('<?php echo $property->get_main_photo_src('medium'); ?>');">
            <?php
            /**
             * propertyhive_before_search_results_loop_item_title hook
             *
             * @hooked propertyhive_template_loop_property_thumbnail - 10
             */
            //do_action( 'propertyhive_before_search_results_loop_item_title' );
            ?>
        </a>
    </div>

    <div class="details">
        <div class="the_price">
            <?php propertyhive_template_single_price(); ?>
        </div>
        <div class="the_title">
            <h4><?php the_title(); ?></h4>
        </div>
        <div class="property-items">
                            <span>
                                <span class="room-icon large bedroom"></span>
                                <?php echo $property->bedrooms; ?> Bedrooms
                            </span>
            <span>
                                <span class="room-icon large bathroom"></span>
                                <?php echo $property->bathrooms; ?> Bathroom
                            </span>
            <span>
                                <span class="room-icon large reception"></span>
                                <?php echo $property->reception_rooms; ?> Reception
                            </span>
        </div>
        <div class="excerpt">
            <?php
            $e = get_the_excerpt();
            $p = strpos($e, '.');
            if ($p === false) {
                echo $e;
            } else {
                echo substr($e, 0, $p + 1);;
            }

            ?>
        </div>
        <div class="property-archive-footer">
            <div class="label">Ref: <?php echo $property->reference_number; ?></div>
            <div class="buttons">
                <a href="#" data-fancybox data-src="#sendEnquiryContent" class="btn white">Book
                    a Viewing</a>
                <a href="<?php the_permalink(); ?>" class="btn">View Details</a>
            </div>
        </div>

        <!--<h3><a href="<?php /*the_permalink(); */ ?>"><?php /*the_title(); */ ?></a></h3>-->

        <?php
        /**
         * propertyhive_after_search_results_loop_item_title hook
         *
         * @hooked propertyhive_template_loop_floor_area - 5 (commercial only)
         * @hooked propertyhive_template_loop_price - 10
         * @hooked propertyhive_template_loop_summary - 20
         * @hooked propertyhive_template_loop_actions - 30
         */
        //do_action( 'propertyhive_after_search_results_loop_item_title' );
        ?>

    </div>

    <?php do_action('propertyhive_after_search_results_loop_item'); ?>

</li>