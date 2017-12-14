<?php
// if called directly, abort.
if ( !defined('WPINC') ) { die; }

if ( ! function_exists( 'rsgd_summary' ) ){
    function rsgd_summary($max_words){
        global $post;
        $more = '<a class="more-btn btn main-bg btn-sm" href="'. esc_url(get_permalink($post->ID)) . '"><span>'. esc_html__( 'Read More', PLUGIN_SLUG ) .'</span></a>';
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $content = get_the_content();
        $content = strip_shortcodes( $content );
        $content = preg_replace($reg_exUrl, '', $content);
                
        if($max_words != '-1'){
            
            $content = wp_trim_words( $content , $max_words , '' );    
        
        } else if(has_excerpt( $post->ID )){
            
            $content = get_the_excerpt();
                
        } else if( strpos( $post->post_content, '<!--more-->' ) ) {
            
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
        
        }
        
        return $content;
    } 
}

if ( ! function_exists( 'rsgd_post_types' ) ) {
    function rsgd_post_types(){
        $types = array();
        $exclude_cpts = array(
            'attachment',
            'revision',
            'nav_menu_item',
            'custom_css',
            'customize_changeset',
            'vc4_templates',
            'page',
            'wpcf7_contact_form',
            'vc_grid_item',
            'mc4wp-form'
        );
        $builtin = array(
            'post',
        );
        $cpts = get_post_types( array(
            '_builtin' => false
        ) );
        foreach($exclude_cpts as $exclude_cpt)
            unset($cpts[$exclude_cpt]);
        $post_types = array_merge($builtin, $cpts);
        
        foreach( $post_types as $type ) {
            $obj = get_post_type_object( $type );
            $types[$type] = $obj->labels->singular_name;
        }
        
        return $types;
        
    }
}

if ( ! function_exists( 'rsgd_hex2RGB' ) ) {
    function rsgd_hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }
}