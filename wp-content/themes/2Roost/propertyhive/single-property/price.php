<?php
/**
 * Single Property Price
 *
 * @author 		PropertyHive
 * @package 	PropertyHive/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;
?>

<div class="price">
    <?php if($property->price_qualifier != ''): ?>
        <?php echo $property->price_qualifier; ?>&nbsp;
    <?php endif;?>
    <?php echo $property->get_formatted_price();?>

    <?php
    if ( $fees != '' )
    {
        echo ' <span class="lettings-fees"><a data-fancybox data-src="#propertyhive_lettings_fees_popup" href="javascript:;">' . __( 'Tenancy Info', 'propertyhive' ) . '</a></span>';

        echo '<div id="propertyhive_lettings_fees_popup" style="display:none; max-width:500px;"><h3>' . __( 'Tenancy Info', 'propertyhive' ) . '</h3>' . $fees . '</div>';
    }
    ?>
</div>
