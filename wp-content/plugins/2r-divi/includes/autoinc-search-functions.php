<?php
function twor_ph_form_field( $key, $field )
{
    global $post;

    $output = '';

    switch ($field['type'])
    {
        case "text":
        case "email":
        case "date":
        case "number":
        case "password":
        {
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
            $field['placeholder'] = isset( $field['placeholder'] ) ? $field['placeholder'] : ( ( $field['type'] == 'date' ) ? 'dd/mm/yyyy' : '' );
            $field['required'] = isset( $field['required'] ) ? $field['required'] : false;
            $field['style'] = isset( $field['style'] ) ? $field['style'] : '';

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_text_field( wp_unslash( $_GET[$key] ) );
            }
            else
            {
                if ( !is_post_type_archive('property') && !is_singular('property') && isset($post->ID) )
                {
                    $value = get_post_meta( $post->ID, '_' . $key, true );
                    if ( $value != '' )
                    {
                        $field['value'] = $value;
                    }
                }
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'];
                if ($field['required'])
                {
                    $output .= '<span class="required"> *</span>';
                }
                $output .= '</label>';
            }

            $output .= '<input
                    type="' . esc_attr( $field['type'] ) . '"
                    name="' . esc_attr( $key ) . '"
                    id="' . esc_attr( $key ) . '"
                    value="' . esc_attr( $field['value'] ) . '"
                    placeholder="' . esc_attr( $field['placeholder'] ) . '"
                    class="' . esc_attr( $field['class'] ) . '"
                    style="' . esc_attr( $field['style'] ) . '"
                    ' . ( ($field['required']) ? 'required' : '' ) . '
            >';

            $output .= $field['after'];

            break;
        }
        case "textarea":
        {
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
            $field['placeholder'] = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
            $field['required'] = isset( $field['required'] ) ? $field['required'] : false;

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_textarea_field( wp_unslash( $_GET[$key] ) );
            }
            else
            {
                if ( !is_post_type_archive('property') && !is_singular('property') && isset($post->ID) )
                {
                    $value = get_post_meta( $post->ID, '_' . $key, true );
                    if ( $value != '' )
                    {
                        $field['value'] = $value;
                    }
                }
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'];
                if ($field['required'])
                {
                    $output .= '<span class="required"> *</span>';
                }
                $output .= '</label>';
            }

            $output .= '<textarea
                    name="' . esc_attr( $key ) . '"
                    id="' . esc_attr( $key ) . '"
                    placeholder="' . esc_attr(  $field['placeholder'] ) . '"
                    class="' . esc_attr( $field['class'] ) . '"
                    ' . ( ($field['required']) ? 'required' : '' ) . '
            >' . esc_attr(  $field['value'] ) . '</textarea>';

            $output .= $field['after'];

            break;
        }
        case "checkbox":
        {
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
            $field['label_style'] = isset( $field['label_style'] ) ? $field['label_style'] : '';
            $field['value'] = isset( $field['value'] ) ? $field['value'] : 'yes';
            $field['checked'] = isset( $field['checked'] ) ? $field['checked'] : false;
            if ( isset( $_GET[$key] ) && sanitize_text_field(wp_unslash($_GET[$key])) == $field['value'] )
            {
                $field['checked'] = true;
            }
            else
            {
                if ( !is_post_type_archive('property') && !is_singular('property') && isset($post->ID) )
                {
                    $value = get_post_meta( $post->ID, '_' . $key, true );
                    if ( $value == 'yes' )
                    {
                        $field['checked'] = true;
                    }
                }
            }

            $output .= $field['before'];

            $output .= '<label style="' . esc_attr( $field['label_style'] ) . '"><input
                type="' . esc_attr( $field['type'] ) . '"
                name="' . esc_attr( $key ) . '"
                value="' . esc_attr( $field['value'] ) . '"
                class="' . esc_attr( $field['class'] ) . '"
                ' . checked( $field['checked'], true, false ) . '
            >';
            if ($field['show_label'])
            {
                $output .= ' <span>' . $field['label'] . '</span>';
            }
            $output .= '</label>';

            $output .= $field['after'];

            break;
        }
        case "radio":
        {
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['before_option'] = isset( $field['before_option'] ) ? $field['before_option'] : '<label>';
            $field['after_option'] = isset( $field['after_option'] ) ? $field['after_option'] : '</label>';
            $field['before_input'] = isset( $field['before_input'] ) ? $field['before_input'] : '';
            $field['after_input'] = isset( $field['after_input'] ) ? $field['after_input'] : '';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : false;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_text_field(wp_unslash($_GET[$key]));
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'] . '</label>';
            }

            foreach ( $field['options'] as $option_key => $value )
            {
                $id = esc_attr( $key ) . '_' . esc_attr( $option_key );
                $output .= str_replace("{id}", $id, $field['before_option']);
                $output .= str_replace("{id}", $id, $field['before_input']);
                $output .= '<input
                    type="' . esc_attr( $field['type'] ) . '"
                    name="' . esc_attr( $key ) . '"
                    id="' . $id . '"
                    value="' . esc_attr( $option_key ) . '"
                    class="' . esc_attr( $field['class'] ) . '"
                    ' . checked( esc_attr( $field['value'] ), esc_attr( $option_key ), false ) . '
                >';
                $output .= str_replace("{id}", $id, $field['after_input']);
                $output .= ' ' . esc_html( $value );
                $output .= str_replace("{id}", $id, $field['after_option']);
            }

            $output .= $field['after'];

            break;
        }
        case "select":
        {
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
            $field['required'] = isset( $field['required'] ) ? $field['required'] : false;
            $field['options'] = ( isset( $field['options'] ) && is_array( $field['options'] ) ) ? $field['options'] : array();
            $field['multiselect'] = isset( $field['multiselect'] ) ? $field['multiselect'] : false;

            if ( $field['multiselect'] )
            {
                wp_enqueue_script( 'multiselect' );
            }

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_text_field(wp_unslash($_GET[$key]));
            }
            else
            {
                if ( !is_post_type_archive('property') && !is_singular('property') && isset($post->ID) )
                {
                    $value = get_post_meta( $post->ID, '_' . $key, true );
                    if ( $value != '' )
                    {
                        $field['value'] = $value;
                    }
                }
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                /*$output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'];
                if ($field['required'])
                {
                    $output .= '<span class="required"> *</span>';
                }
                $output .= '</label>';*/
            }

            $blank_option = '';
            foreach ( $field['options'] as $option_key => $value )
            {
                if ( $field['multiselect'] && $option_key == '' )
                {
                    $blank_option = $value;
                    continue;
                }
            }

            $output .= '<select
                name="' . esc_attr( $key ) . ( $field['multiselect'] ? '[]' : '' ) . '"
                id="' . esc_attr( $key ) . '"
                class="' . esc_attr( $field['class'] ) . ( $field['multiselect'] ? ' ph-form-multiselect' : '' ) . '"
                ' . ( $field['multiselect'] ? ' multiple="multiple"' : '' ) . '
                data-blank-option="' . $field['label'] . '"
             >';

            foreach ( $field['options'] as $option_key => $value )
            {
                if ( $field['multiselect'] && $option_key == '' )
                {
                    // Skip because we don't want a blank option in the multiselect. Instead use $value as the placeholder
                    continue;
                }

                $output .= '<option
                    value="' . esc_attr( $option_key ) . '"';
                if ( !$field['multiselect'] )
                {
                    $output .= selected( esc_attr( $field['value'] ), esc_attr( $option_key ), false );
                }
                else
                {
                    if (
                        ( isset($_REQUEST[$key]) && is_array($_REQUEST[$key]) && in_array($option_key, $_REQUEST[$key]) )
                        ||
                        ( !isset($_REQUEST[$key]) && is_array($field['value']) && in_array($option_key, $field['value']) )
                    )
                    {
                        $output .= ' selected';
                    }
                }
                if(strtoupper($value)=='NO PREFERENCE') {
                    $output .= '>' . $field['label'] . '</option>';
                } else {
                    $output .= '>' . esc_html( __( $value, 'propertyhive' ) ) . '</option>';
                }

            }

            $output .= '</select>';

            $output .= $field['after'];

            break;
        }
        case "office":
        {
            $key = 'officeID';

            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
            $field['multiselect'] = isset( $field['multiselect'] ) ? $field['multiselect'] : false;

            if ( $field['multiselect'] )
            {
                wp_enqueue_script( 'multiselect' );
            }

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = (int)$_GET[$key];
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'] . '</label>';
            }

            $output .= 'XXX<select
                name="' . esc_attr( $key ) . ( $field['multiselect'] ? '[]' : '' ) . '"
                id="' . esc_attr( $key ) . '"
                class="' . esc_attr( $field['class'] ) . ( $field['multiselect'] ? ' ph-form-multiselect' : '' ) . '"
                ' . ( $field['multiselect'] ? ' multiple="multiple"' : '' ) . '
                data-blank-option="' . $field['label'] . '"
            >';

            if ( !$field['multiselect'] )
            {
                $output .= '<option
                        value=""
                        ' . selected( esc_attr( $field['value'] ), esc_attr( '' ), false ) . '
                    >' . $field['label'] . '</option>';
            }

            $args = array(
                'post_type' => 'office',
                'nopaging' => true,
                'orderby' => 'title',
                'order' => 'ASC'
            );
            $office_query = new WP_Query($args);

            if ($office_query->have_posts())
            {
                while ($office_query->have_posts())
                {
                    $office_query->the_post();

                    $output .= '<option
                        value="' . esc_attr( $post->ID ) . '" ';
                    if ( !$field['multiselect'] )
                    {
                        $output .= selected( esc_attr( $field['value'] ), esc_attr( $post->ID ), false );
                    }
                    else
                    {
                        if ( isset($_REQUEST[$key]) && is_array($_REQUEST[$key]) && in_array($post->ID, $_REQUEST[$key]) )
                        {
                            $output .= ' selected';
                        }
                    }
                    $output .= '>' . esc_html( get_the_title() ) . '</option>';

                }
            }
            wp_reset_postdata();

            $output .= '</select>';

            $output .= $field['after'];

            break;
        }
        case "country":
        {
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_text_field(wp_unslash($_GET[$key]));
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'] . '</label>';
            }

            $output .= 'YYY<select
                name="' . esc_attr( $key ) . '"
                id="' . esc_attr( $key ) . '"
                class="' . esc_attr( $field['class'] ) . '"
             >';

            $output .= '<option
                        value=""
                        ' . selected( esc_attr( $field['value'] ), esc_attr( '' ), false ) . '
                    >' . $field['label'] . '</option>';

            $countries = get_option( 'propertyhive_countries', array() );
            if ( is_array($countries) && !empty($countries) )
            {
                $ph_countries = new PH_Countries;

                foreach ( $countries as $country )
                {
                    $ph_country = $ph_countries->get_country( $country );

                    if ( $ph_country !== FALSE )
                    {
                        $output .= '<option
                        value="' . esc_attr( $country ) . '"
                        ' . selected( esc_attr( $field['value'] ), esc_attr( $country ), false ) . '
                        >' . esc_html( $ph_country['name'] ) . '</option>';
                    }
                }
            }

            $output .= '</select>';

            $output .= $field['after'];

            break;
        }
        case "slider":
        {
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_style( 'jquery-ui-style', PH()->plugin_url() . '/assets/css/jquery-ui/jquery-ui.css', array(), PH_VERSION );

            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
            $field['min'] = isset( $field['min'] ) ? $field['min'] : '';
            $field['max'] = isset( $field['max'] ) ? $field['max'] : '';
            $field['step'] = isset( $field['step'] ) ? $field['step'] : '1';

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'];
                $output .= ' - <span id="search-form-slider-value-' . $key . '" class="search-form-slider-value"></span>';
                $output .= '</label>';
            }

            $output .= '<div id="search-form-slider-' . $key . '" class="search-form-slider" style="min-width:150px;"></div>';

            $field_name = str_replace("_slider", "", $key);
            $output .= '<input type="hidden" name="minimum_' . $field_name . '" id="min_slider_value-' . $key . '" value="' . ( isset($_GET['minimum_' . $field_name]) ? ph_clean($_GET['minimum_' . $field_name]) : '' ) . '">';
            $output .= '<input type="hidden" name="maximum_' . $field_name . '" id="max_slider_value-' . $key . '" value="' . ( isset($_GET['maximum_' . $field_name]) ? ph_clean($_GET['maximum_' . $field_name]) : '' ) . '">';

            $output .= $field['after'];

            $value = '';
            $prefix = '';
            $suffix = '';

            if ( $key == 'price_slider' || $key == 'rent_slider' )
            {
                $prefix = '£';

                $search_form_currency = get_option( 'propertyhive_search_form_currency', 'GBP' );

                $ph_countries = new PH_Countries();
                $countries = $ph_countries->countries;

                foreach ( $countries as $country_code => $country )
                {
                    if ( isset($country['currency_code']) && $country['currency_code'] == $search_form_currency )
                    {
                        if ( $country['currency_prefix'] === true )
                        {
                            $prefix = $country['currency_symbol'];
                            $suffix = '';
                        }
                        else
                        {
                            $prefix = '';
                            $suffix = $country['currency_symbol'];
                        }
                        break;
                    }
                }
            }

            if ( $field['min'] != '' && $field['max'] != '' )
            {
                $value = 'values: [ ' . ( isset($_GET['minimum_' . $field_name]) && $_GET['minimum_' . $field_name] != '' ? ph_clean($_GET['minimum_' . $field_name]) : $field['min'] ) . ', ' . ( isset($_GET['maximum_' . $field_name]) && $_GET['maximum_' . $field_name] != '' ? ph_clean($_GET['maximum_' . $field_name]) : $field['max'] ) . ' ],';
            }

            $output .= '<script>
                jQuery(document).ready(function()
                {
                    jQuery( "#search-form-slider-' . $key . '" ).slider({
                        range: ' . ( ( $field['min'] != '' && $field['max'] != '' ) ? 'true' : 'false' ) . ',
                        step: ' . $field['step'] . ',
                        ' . ( $field['min'] != '' ? 'min: ' . $field['min'] . ',' : '' ) . '
                        ' . ( $field['max'] != '' ? 'max: ' . $field['max'] . ',' : '' ) . '
                        ' . $value . '
                        slide: function( event, ui ) {
                            jQuery( "#search-form-slider-value-' . $key . '" ).html( "' . $prefix . '" + ui.values[ 0 ].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + "' . $suffix . '" + " - ' . $prefix . '" + ui.values[ 1 ].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + "' . $suffix . '" );
                            jQuery( "#min_slider_value-' . $key . '" ).val( ui.values[0] );
                            jQuery( "#max_slider_value-' . $key . '" ).val( ui.values[1] );
                        }
                    });
                    jQuery( "#search-form-slider-value-' . $key . '" ).html( "' . $prefix . '" + jQuery( "#search-form-slider-' . $key . '" ).slider( "values", 0 ).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + "' . $suffix . '" + " - ' . $prefix . '" + jQuery( "#search-form-slider-' . $key . '" ).slider( "values", 1 ).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + "' . $suffix . '" );
                });
            </script>';

            break;
        }
        case "hidden":
        {
            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            $field['name'] = isset( $field['name'] ) ? $field['name'] : $key;
            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_text_field(wp_unslash($_GET[$key]));
            }

            $output .= '<input type="hidden" name="' . esc_attr( $field['name'] ) . '" value="' . $field['value'] . '">';
            break;
        }
        case "html":
        {
            $field['html'] = isset( $field['html'] ) ? $field['html'] : '';
            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';

            $output .= $field['before'];
            $output .= $field['html'];
            $output .= $field['after'];

            break;
        }
        case "recaptcha":
        {
            $field['site_key'] = isset( $field['site_key'] ) ? $field['site_key'] : '';

            $output .= '<script src="https://www.google.com/recaptcha/api.js"></script>
            <div class="g-recaptcha" data-sitekey="' . $field['site_key'] . '"></div>';
            break;
        }
        case "recaptcha-v3":
        {
            $field['site_key'] = isset( $field['site_key'] ) ? $field['site_key'] : '';

            $output .= '
                <script src="https://www.google.com/recaptcha/api.js?render=' . $field['site_key'] . '"></script>
                <script>
                    grecaptcha.ready(function() {
                        grecaptcha.execute("' . $field['site_key'] . '", {action:\'validate_captcha\'})
                                .then(function(token) {
                            // add token value to form
                            document.querySelectorAll("#g-recaptcha-response").forEach(
                                elem => (elem.value = token)
                            );
                        });
                    });
                </script>
                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                <input type="hidden" name="action" value="validate_captcha">
            ';
            break;
        }
        case "hCaptcha":
        {
            $field['site_key'] = isset( $field['site_key'] ) ? $field['site_key'] : '';

            $output .= '<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
            <div class="h-captcha" data-sitekey="' . $field['site_key'] . '"></div>';
            break;
        }
        case "daterange":
        {
            wp_enqueue_script( 'moment.js', '//cdn.jsdelivr.net/momentjs/latest/moment.min.js' );
            wp_enqueue_script( 'daterangepicker.js', '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js' );
            wp_enqueue_style( 'daterangepicker.css', '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css' );

            $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
            $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';

            $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
            $field['label'] = isset( $field['label'] ) ? $field['label'] : '';

            $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
            $field['style'] = isset( $field['style'] ) ? $field['style'] : '';
            $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
            $field['placeholder'] = isset( $field['placeholder'] ) ? $field['placeholder'] : '';

            if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
            {
                $field['value'] = sanitize_text_field(wp_unslash($_GET[$key]));
            }

            $output .= $field['before'];

            if ($field['show_label'])
            {
                $output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'] . '</label>';
            }

            $output .= '<input type="text" autocomplete="off"
                name="' . esc_attr( $key ) . '"
                id="' . esc_attr( $key ) . '"
                value="' . esc_attr( $field['value'] ) . '"
                style="' . esc_attr( $field['style'] ) . '"
                class="' . esc_attr( $field['class'] ) . '"
                placeholder="' . esc_attr(  $field['placeholder'] ) . '"
            />';
            $output .= $field['after'];

            break;
        }
        default:
        {
            if ( taxonomy_exists($field['type']) )
            {
                $field['class'] = isset( $field['class'] ) ? $field['class'] : '';
                $field['before'] = isset( $field['before'] ) ? $field['before'] : '<div class="control control-' . $key . '">';
                $field['after'] = isset( $field['after'] ) ? $field['after'] : '</div>';
                $field['show_label'] = isset( $field['show_label'] ) ? $field['show_label'] : true;
                $field['label'] = isset( $field['label'] ) ? $field['label'] : '';
                //$field['blank_option'] = isset( $field['blank_option'] ) ? __( $field['blank_option'], 'propertyhive' ) : __( 'No preference', 'propertyhive' );
                $field['blank_option'] = isset( $field['blank_option'] ) ? __( $field['blank_option'], 'propertyhive' ) : __( $field['label'], 'propertyhive' );
                $field['parent_terms_only'] = isset( $field['parent_terms_only'] ) ? $field['parent_terms_only'] : false;
                $field['hide_empty'] = isset( $field['hide_empty'] ) ? $field['hide_empty'] : false;
                $field['multiselect'] = isset( $field['multiselect'] ) ? $field['multiselect'] : false;
                $field['dynamic_population'] = ( isset( $field['dynamic_population'] ) && $field['type'] == 'location' && $field['parent_terms_only'] === false && $field['multiselect'] === false ) ? $field['dynamic_population'] : false; // only applies to location

                if ( $field['multiselect'] )
                {
                    wp_enqueue_script( 'multiselect' );
                }

                $options = array(
                    '' => array(
                        'label' => $field['blank_option'],
                        'parent' => 0
                    )
                );
                $args = array(
                    'hide_empty' => $field['hide_empty'],
                    'parent' => 0
                );
                $terms = get_terms( $field['type'], $args );

                $levels_of_taxonomy = 1;
                if ( !empty( $terms ) && !is_wp_error( $terms ) )
                {
                    foreach ($terms as $term)
                    {
                        if ( isset($field['hide_empty']) && $field['hide_empty'] === true )
                        {
                            $empty_check_args = array(
                                'post_type' => 'property',
                                'meta_query' => array(
                                    array(
                                        'key' => '_on_market',
                                        'value' => 'yes',
                                    ),
                                ),
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $field['type'],
                                        'field' => 'term_id',
                                        'terms' => $term->term_id,
                                    ),
                                ),
                            );
                            $empty_check_query = new WP_Query( $empty_check_args );

                            if ( !$empty_check_query->have_posts() )
                            {
                                continue;
                            }
                        }

                        $options[(int)$term->term_id] = array(
                            'label' => __( $term->name, 'propertyhive' ),
                            'parent' => 0
                        );

                        if ($field['dynamic_population'])
                            $levels_of_taxonomy = max(1, $levels_of_taxonomy);

                        if (
                            !isset($field['parent_terms_only'])
                            ||
                            (
                                isset($field['parent_terms_only']) &&
                                $field['parent_terms_only'] === false
                            )
                        )
                        {
                            $args = array(
                                'hide_empty' => $field['hide_empty'],
                                'parent' => $term->term_id,
                            );
                            $subterms = get_terms( $field['type'], $args );

                            if ( !empty( $subterms ) && !is_wp_error( $subterms ) )
                            {
                                foreach ($subterms as $subterm)
                                {
                                    if ( isset($field['hide_empty']) && $field['hide_empty'] === true )
                                    {
                                        $empty_check_args = array(
                                            'post_type' => 'property',
                                            'meta_query' => array(
                                                array(
                                                    'key' => '_on_market',
                                                    'value' => 'yes',
                                                ),
                                            ),
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => $field['type'],
                                                    'field' => 'term_id',
                                                    'terms' => $subterm->term_id,
                                                ),
                                            ),
                                        );
                                        $empty_check_query = new WP_Query( $empty_check_args );

                                        if ( !$empty_check_query->have_posts() )
                                        {
                                            continue;
                                        }
                                    }

                                    $options[(int)$subterm->term_id] = array(
                                        'label' => ( !$field['dynamic_population'] ? '- ' : '' ) . __( $subterm->name, 'propertyhive' ),
                                        'parent' => (int)$term->term_id,
                                    );

                                    if ($field['dynamic_population'])
                                        $levels_of_taxonomy = max(2, $levels_of_taxonomy);

                                    $args = array(
                                        'hide_empty' => $field['hide_empty'],
                                        'parent' => (int)$subterm->term_id
                                    );
                                    $subsubterms = get_terms( $field['type'], $args );

                                    if ( !empty( $subsubterms ) && !is_wp_error( $subsubterms ) )
                                    {
                                        foreach ($subsubterms as $subsubterm)
                                        {
                                            if ( isset($field['hide_empty']) && $field['hide_empty'] === true )
                                            {
                                                $empty_check_args = array(
                                                    'post_type' => 'property',
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => '_on_market',
                                                            'value' => 'yes',
                                                        ),
                                                    ),
                                                    'tax_query' => array(
                                                        array(
                                                            'taxonomy' => $field['type'],
                                                            'field' => 'term_id',
                                                            'terms' => $subsubterm->term_id,
                                                        ),
                                                    ),
                                                );
                                                $empty_check_query = new WP_Query( $empty_check_args );

                                                if ( !$empty_check_query->have_posts() )
                                                {
                                                    continue;
                                                }
                                            }

                                            $options[(int)$subsubterm->term_id] = array(
                                                'label' => ( !$field['dynamic_population'] ? '- - ' : '' ) . __( $subsubterm->name, 'propertyhive' ),
                                                'parent' => (int)$subterm->term_id,
                                            );

                                            if ($field['dynamic_population'])
                                                $levels_of_taxonomy = max(3, $levels_of_taxonomy);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ( $field['dynamic_population'] )
                {
                    wp_localize_script( 'propertyhive_dynamic_population', 'propertyhive_dynamic_population_params', array(
                        'options' => $options,
                        'levels_of_taxonomy' => $levels_of_taxonomy,
                        'value' => isset($_GET[$field['type']]) ? ph_clean($_GET[$field['type']]) : '',
                        'other_values' => ( isset($_GET['other_' . $field['type']]) && is_array($_GET['other_' . $field['type']]) && !empty($_GET['other_' . $field['type']]) ) ? ph_clean(array_filter($_GET['other_' . $field['type']])) : array(),
                        'taxonomy' => $field['type'],
                    ) );
                    wp_enqueue_script( 'propertyhive_dynamic_population' );
                }

                $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
                if ( isset( $_GET[$key] ) && ! empty( $_GET[$key] ) )
                {
                    $field['value'] = sanitize_text_field(wp_unslash($_GET[$key]));
                }

                for ( $level_i = 1; $level_i <= $levels_of_taxonomy; ++$level_i )
                {
                    $output .= $field['before'];

                    if ($field['show_label'])
                    {
                        //$output .= '<label for="' . esc_attr( $key ) . '">' . $field['label'] . '</label>';
                    }

                    $output .= '<select
                        name="' . esc_attr( $key ) . ( $field['multiselect'] ? '[]' : '' ) . '"
                        id="' . esc_attr( $key ) . '"
                        class="' . esc_attr( $field['class'] ) . ( $field['multiselect'] ? ' ph-form-multiselect' : '' ) . '"
                        ' . ( $field['multiselect'] ? ' multiple="multiple"' : '' ) .
                        ( $field['dynamic_population'] ? ' data-dynamic-population-level="' . $level_i . '"' : '' ) .
                        ( ( $field['dynamic_population'] && $level_i > 1 ) ? ' disabled' : '' ) . '
                        data-blank-option="' . $field['label'] . '"
                    >';

                    if ( $level_i == 1 )
                    {
                        foreach ( $options as $option_key => $value )
                        {
                            if ( $field['multiselect'] && $option_key == '' )
                            {
                                // Skip because we don't want a blank option in the multiselect. Instead use $value as the placeholder
                                continue;
                            }

                            if ( $field['dynamic_population'] && $value['parent'] != '0' )
                            {
                                continue;
                            }

                            $output .= '<option
                                value="' . esc_attr( $option_key ) . '"';
                            if ( !$field['multiselect'] )
                            {
                                $output .= selected( esc_attr( $field['value'] ), esc_attr( $option_key ), false );
                            }
                            else
                            {
                                if ( isset($_REQUEST[$key]) && is_array($_REQUEST[$key]) && in_array($option_key, $_REQUEST[$key]) )
                                {
                                    $output .= ' selected';
                                }
                                elseif ( is_array($field['value']) && in_array($option_key, $field['value']) )
                                {
                                    $output .= ' selected';
                                }
                            }
                            if(strtoupper($value['label'])=='NO PREFERENCE') {
                                $output .= '>' .  $field['label'] . '</option>';
                            } else {
                                $output .= '>' . esc_html( $value['label'] ) . '</option>';
                            }

                        }
                    }

                    $output .= '</select>';

                    $output .= $field['after'];

                    if ( $field['type'] == 'availability' )
                    {
                        $availability_departments = get_option( 'propertyhive_availability_departments', array() );
                        if ( !is_array($availability_departments) ) { $availability_departments = array(); }

                        if ( !empty($availability_departments) )
                        {
                            $JSON_availability_departments = str_replace('No Preference',$field['label'],json_encode($availability_departments));
                            $JSON_options = str_replace('No Preference',$field['label'],json_encode($options));

                            ?>
                            <script>
                                var selected_availability = '<?php echo ( isset($_REQUEST[$key]) && $_REQUEST[$key] != '' ? (int)$_REQUEST[$key] : '' ); ?>';
                                var availability_departments = <?php echo $JSON_availability_departments; ?>;
                                var availabilities = <?php echo $JSON_options; ?>;
                                var availabilities_order = <?php echo json_encode(array_keys($options)); ?>;
                            </script>
                            <?php
                        }
                    }
                }
            }
        }
    }

    echo $output;
}