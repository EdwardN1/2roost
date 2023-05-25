<?php
/**
 * The template for displaying property content in the single-property.php template
 *
 * Override this template by copying it to yourtheme/propertyhive/content-single-property.php
 *
 * @author      PropertyHive
 * @package     PropertyHive/Templates
 * @version     1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

global $property;
?>

<?php
if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>

<div id="property-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    /**
     * propertyhive_before_single_property_summary hook
     *
     * @hooked propertyhive_template_not_on_market - 5
     * @hooked propertyhive_show_property_images - 10
     */
    do_action('propertyhive_before_single_property_summary');
    ?>

    <div class="inner-container">

        <div class="summary entry-summary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="breadcrumb">
                            <ul class="list-inline">
                                <li><a href="/"><span class="glyphicon glyphicon-home" style="margin-right:5px"></span>
                                        Home</a>
                                </li>
                                <li class="active">Property Details</li>
                                <li class="active"><?php the_title(); ?></li>
                            </ul>
                        </div>
                        <h1 class="uppercase"><?php the_title(); ?></h1>
                        <span class="label">Ref: <?php echo $property->reference_number; ?></span>
                        <h2><?php echo $property->address_three; ?></h2>
                        <?php propertyhive_template_single_price(); ?>
                        <hr>
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
                        <hr>
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
                        <hr>
                        <h2>Description</h2>
                        <div class="description">
                            <?php the_excerpt(); ?>
                            <p>Featuring:</p>

                            <?php
                            $f = $property->get_features();
                            if (($f) && (count($f != 0))):?>
                                <ul class="features">
                                    <?php foreach ($f as $fn): ?>
                                        <li><?php echo $fn; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <p>
                                    Accommodation comprises:
                                </p>
                                <?php
                                $r = $property->get_formatted_description();
                                $p_items = explode('<p class="room">', $r);
                                $rooms = '<ul>';
                                foreach ($p_items as $p_item) {
                                    if ($p_item != '') {
                                        $rooms .= '<li>' . str_replace('p>', 'li>', $p_item);
                                    }
                                }
                                $rooms .= '</ul>';
                                $rooms = str_replace('<strong class="name">', '', $rooms);
                                $rooms = str_replace('</strong>', '', $rooms);
                                $rooms = str_replace('<br>', '', $rooms);
                                echo $rooms;
                                ?>
                            <?php endif; ?>
                        </div>
                        <div class="google-map">
                            <?php echo do_shortcode('[property_map]'); ?>
                        </div>
                        <?php $vts = $property->get_virtual_tour_urls(); ?>
                        <?php if (($vts) && (count($vts !== 0))): ?>
                            <div class="virtual tour">
                                <h2>Virtual Tour</h2>
                                <?php foreach ($vts as $vt): ?>
                                    <div class="video-container">
                                        <iframe width="320" height="240" src="<?php echo $vt; ?>"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen=""></iframe>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        $factions = array();
                        $floorplan_ids = $property->get_floorplan_attachment_ids();
                        if (!empty($floorplan_ids)) {
                            foreach ($floorplan_ids as $floorplan_id) {
                                $label = 'Floorplan';

                                $attachment_data = wp_prepare_attachment_for_js($floorplan_id);
                                if (isset($attachment_data['caption']) && $attachment_data['caption'] != '') {
                                    $label = $attachment_data['caption'];
                                }


                                $factions[] = array(
                                    'href' => wp_get_attachment_url($floorplan_id),
                                    'label' => __($label, 'propertyhive'),
                                    'class' => 'action-floorplans',
                                    'attributes' => array(
                                        'data-fancybox' => 'floorplans'
                                    )
                                );
                            }
                        }
                        ?>
                        <?php if (($factions) && (count($factions !== 0))): ?>
                            <div class="floorplans">
                                <h2>Floor Plans</h2>
                                <?php foreach ($factions as $faction): ?>
                                    <?php
                                    $atts = array();
                                    $atts = $faction['attributes'];
                                    $dataStr = '';
                                    if (($atts) && count($atts !== 0)) {
                                        foreach ($atts as $key => $value) {
                                            $dataStr .= $key . '="' . $value . '" ';
                                        }
                                    }
                                    ?>
                                    <div class="floorplan">
                                        <a href="<?php echo $faction['href']; ?>"
                                           class="<?php echo $faction['class']; ?>" <?php echo $dataStr; ?>>
                                            <img src="<?php echo $faction['href']; ?>" width="100%"
                                                 alt="<?php echo $faction['label']; ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                                <p style="text-align: center">(Click the floor plans to view larger versions)</p>
                                <?php echo $r; ?>
                                <div style="clear: both;"></div>
                            </div>
                        <?php endif; ?>
                        <div class="additional-info">
                            <h2>Additional Information</h2>
                            <?php
                            $tenure = $property->tenure;
                            $saleby = $property->sale_by;
                            $propertytype = $property->property_type;
                            $council_tax = $property->council_tax_band;
                            $outside_space = $property->outside_space;
                            $parking = $property->parking;
                            ?>
                            <?php if ($tenure != ''): ?>
                                <p>This property is sold on a <?php echo $tenure; ?> basis.</p>
                            <?php endif; ?>
                            <?php if ($saleby != ''): ?>
                                <p>This property is for sale by <?php echo $saleby; ?></p>
                            <?php endif; ?>
                            <?php if ($propertytype != ''): ?>
                                <p>Type of property: <?php echo $propertytype; ?></p>
                            <?php endif; ?>
                            <?php if ($council_tax != ''): ?>
                                <p>Council tax band: <?php echo $council_tax; ?></p>
                            <?php endif; ?>
                            <?php if ($outside_space != ''): ?>
                                <p>Outside space: <?php echo $outside_space; ?></p>
                            <?php endif; ?>
                            <?php if ($parking != ''): ?>
                                <p>Parking: <?php echo $parking; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                        $epcs = array();
                        $epc_ids = $property->get_epc_attachment_ids();
                        if (!empty($epc_ids)) {
                            foreach ($epc_ids as $epc_id) {
                                $label = 'epc';

                                $attachment_data = wp_prepare_attachment_for_js($epc_id);
                                if (isset($attachment_data['caption']) && $attachment_data['caption'] != '') {
                                    $label = $attachment_data['caption'];
                                }


                                $eactions[] = array(
                                    'href' => wp_get_attachment_url($epc_id),
                                    'label' => __($label, 'propertyhive'),
                                    'class' => 'action-epc',
                                    'attributes' => array(
                                        'data-fancybox' => 'epcs'
                                    )
                                );
                            }
                        }
                        ?>
                        <?php if (($eactions) && (count($eactions !== 0))): ?>
                            <div class="epcs">
                                <h2>EPC</h2>
                                <?php foreach ($eactions as $eaction): ?>
                                    <?php
                                    $atts = array();
                                    $atts = $eaction['attributes'];
                                    $dataStr = '';
                                    if (($atts) && count($atts !== 0)) {
                                        foreach ($atts as $key => $value) {
                                            $dataStr .= $key . '="' . $value . '" ';
                                        }
                                    }
                                    ?>
                                    <div class="floorplan">
                                        <a href="<?php echo $eaction['href']; ?>"
                                           class="<?php echo $eaction['class']; ?>" <?php echo $dataStr; ?>>
                                            <img src="<?php echo $eaction['href']; ?>" width="100%"
                                                 alt="<?php echo $eaction['label']; ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="remarks">
                            <p class="small"><strong>Important Remarks</strong></p>
                            <p class="small grey">Please note that all the above information has been provided by the
                                vendor in good faith, but will need verification by the purchaser's solicitor. Any
                                areas, measurements or distances referred to are given as a guide only and are not
                                precise. Floor plans are not drawn to scale and are provided as an indicative guide to
                                help illustrate the general layout of the property only. The mention of any appliances
                                and/or services in this description does not imply that they are in full and efficient
                                working order and prospective purchasers should make their own investigations before
                                finalising any agreement to purchase. It should not be assumed that any contents,
                                furnishings or other items shown in photographs (which may have been taken with a wide
                                angle lens) are included in the sale. Any reference to alterations to, or use of, any
                                part of the property is not a statement that the necessary planning, building
                                regulations, listed buildings or other consents have been obtained. We endeavour to make
                                our details accurate and reliable, but they should not be relied on as statements or
                                representations of fact and they do not constitute any part of an offer or contract. The
                                seller does not give any warranty in relation to the property and we have no authority
                                to do so on their behalf.</p>
                        </div>
                        <?php
                        /**
                         * propertyhive_single_property_summary hook
                         *
                         * @hooked propertyhive_template_single_title - 5
                         * @hooked propertyhive_template_single_floor_area - 7
                         * @hooked propertyhive_template_single_price - 10
                         * @hooked propertyhive_template_single_meta - 20
                         * @hooked propertyhive_template_single_sharing - 30
                         */
                        //do_action('propertyhive_single_property_summary');
                        ?>



                        <?php
                        /**
                         * propertyhive_after_single_property_summary hook
                         *
                         * @hooked propertyhive_template_single_actions - 10
                         * @hooked propertyhive_template_single_features - 20
                         * @hooked propertyhive_template_single_summary - 30
                         * @hooked propertyhive_template_single_description - 40
                         */
                        //do_action('propertyhive_after_single_property_summary');
                        ?>
                    </div>
                    <div class="col-sm-4 sidebar sliding-sidebar">
                        <div class="sidebar-content-wrapper">
                            <h2>Highlights</h2>
                            <?php
                            $f = $property->get_features();
                            if (($f) && (count($f != 0))):?>
                                <ul class="features">
                                    <?php foreach ($f as $fn): ?>
                                        <li><?php echo $fn; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <div class="side-bar-box">
                                <div class="title-box"><h4 class="title">Are you interested in this property?</h4></div>
                                <div class="contents-box">
                                    <div class="staff-box clearfix">Call us on Sheffield Branch <a href="tel:01142878696" class="white">0114 2878696</a> Rotherham
                                        Branch <a href="tel:01709437390" class="white">01709 437390</a> or click the button below for further information.<p><small>Ref:
                                                25910</small></p></div>

                                    <a href="#" data-fancybox data-src="#sendEnquiryContent" class="btn white fullwidth">Send Enquiry</a>
                                    <a href="#" data-fancybox data-src="#similarProperties" class="white underline" title="Receive the newest properties straight to your inbox">Send me similar properties </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- .summary -->
    </div>
    <div id="sendEnquiryContent" style="display: none;max-width: 350px;" class="gravity-global">
        <h4>Book a Viewing</h4>
        <?php
        $seFields = array();
        $seFields['view_property'] = $property_view_param = get_the_title().'  Ref: '.$property->reference_number;
        gravity_form(1, false, false, false, $seFields, true, 12);
        ?>
    </div>
    <div id="similarProperties" style="display: none;max-width: 620px;" class="gravity-global">
        <h4>Register for property alerts</h4>
        <?php
        gravity_form(2, false, false, false, '', true, 12);
        ?>
    </div>

</div><!-- #property-<?php the_ID(); ?> -->