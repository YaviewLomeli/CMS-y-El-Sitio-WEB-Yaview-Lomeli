<?php

/**
* Plugin Name: Woo Shortcodes Kit
* Plugin URI: https://disespubli.com/
* Description: Easy shortcodes which can be displayed on any page or post to build your own my account page and customize the shop page, order emails, the add to cart button and much more!. Enjoy customizing easilly your WooCommerce's shop with more than 30 shortcodes & functions. This plugin not work alone, you need install WooCommerce before.
* Author: Alberto G.
* Version: 1.6.6
* Tested up to: 4.9.4
* WC requires at least: 2.6
* WC tested up to: 3.3.1
* Author URI: https://disespubli.com/
* Text Domain: woo-shortcodes-kit
* Domain Path: /languages
* License: GPLv3 or later License
* URI: http://www.gnu.org/licenses/gpl-3.0.html

    Woo Shortcodes Kit is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.
 
    Woo Shortcodes Kit is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with Woocommerce Shortcodes Kit. If not, see http://www.gnu.org/licenses/gpl-3.0.html.
  */

    //Let's go!
    
// Make sure WooCommerce is active (TEST)
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;
    
    
/* register admin menu */
    
    add_action('admin_menu', 'register_woo_shortcodes_kit');
    
    	if(!function_exists('register_woo_shortcodes_kit')):

	function register_woo_shortcodes_kit() {
    	add_submenu_page( 'woocommerce', 'Woo Shortcodes Kit', 'WSHK', 'manage_options', 'woo-shortcodes-kit', 'init_woo_shortcodes_kit_admin_page_html' ); 
	}


	endif;
	

	if(!function_exists('wshk_add_settings_link')):

    // Load translations
        
    add_action('plugins_loaded', 'wshk_load_textdomain');
    function wshk_load_textdomain() {
        load_plugin_textdomain( 'woo-shortcodes-kit', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

	// Add settings link to plugin list page in admin
        
        function wshk_add_settings_link( $links ) {
            $mysettingslink = __('Settings','woo-shortcodes-kit');
            $myratelink = __('Please rate the plugin','woo-shortcodes-kit');
            $myvideolink = __('Learn how work all the functions','woo-shortcodes-kit');
            $settings_link = array('<a href="admin.php?page=woo-shortcodes-kit"'.' title="'.$mysettingslink.'">' . __( 'Settings', 'woo-shortcodes-kit' ) . '</a>'.' | '.'<a href="https://wordpress.org/support/plugin/woo-shortcodes-kit/reviews/#new-post" target="_blank" title="'.$myratelink.'">' . __( 'Please rate the plugin', 'woo-shortcodes-kit' ) . '</a>'.' | '.'<a href="https://www.youtube.com/watch?v=20L7LjV0BX8&list=PLAI7D4M9MLQA1gcsDKfvuO4N_RfkywlJl" target="_blank" title="'.$myvideolink.'">' . __( 'Learn how work all the functions', 'woo-shortcodes-kit' ) . '</a>');
            return array_merge( $links, $settings_link );;
        } 
	endif;
	
	$plugin = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_$plugin", 'wshk_add_settings_link' );

/** register settings */

	if(!function_exists('wshk_register_settings')):

	function wshk_register_settings() {
    	register_setting( 'wshk_options', 'wshk_enable');
    	register_setting( 'wshk_options', 'wshk_test');
    	register_setting( 'wshk_options', 'wshk-inlinecss');
    	register_setting( 'wshk_options', 'wshk_text');
    	register_setting( 'wshk_options', 'wshk_min'); 
    	register_setting( 'wshk_options', 'wshk_perpage'); 
    	register_setting( 'wshk_options', 'wshk_nperpage');
    	register_setting( 'wshk_options', 'wshk_enablecat');
    	register_setting( 'wshk_options', 'wshk_firstcat');
    	register_setting( 'wshk_options', 'wshk_secondcat');
    	register_setting( 'wshk_options', 'wshk_thirdcat');
    	register_setting( 'wshk_options', 'wshk_enablebought');
    	register_setting( 'wshk_options', 'wshk_buttontext');
    	register_setting( 'wshk_options', 'wshk_enablectbp');
    	register_setting( 'wshk_options', 'wshk_textprefix'); 
    	register_setting( 'wshk_options', 'wshk_textsuffix');
    	register_setting( 'wshk_options', 'wshk_textpsuffix');
    	register_setting( 'wshk_options', 'wshk_textnobp');
    	register_setting( 'wshk_options', 'wshk_enablectbo');
    	register_setting( 'wshk_options', 'wshk_tordersprefix');
    	register_setting( 'wshk_options', 'wshk_torderssuffix');
    	register_setting( 'wshk_options', 'wshk_torderspsuffix');
    	register_setting( 'wshk_options', 'wshk_textnobo');
    	register_setting( 'wshk_options', 'wshk_enablewmessage');
    	register_setting( 'wshk_options', 'wshk_wmorders');
    	register_setting( 'wshk_options', 'wshk_textwmssg');
    	register_setting( 'wshk_options', 'wshk_textsales');
    	register_setting( 'wshk_options', 'wshk_minsales');
    	register_setting( 'wshk_options', 'wshk_nonotice');
    	register_setting( 'wshk_options', 'wshk_morenotice');
    	register_setting( 'wshk_options', 'wshk_enablereviews');
    	register_setting( 'wshk_options', 'wshk_textavsize');
    	register_setting( 'wshk_options', 'wshk_textavbdsize');
    	register_setting( 'wshk_options', 'wshk_textavbdradius');
    	register_setting( 'wshk_options', 'wshk_textavbdtype');
    	register_setting( 'wshk_options', 'wshk_textavbdcolor');
    	register_setting( 'wshk_options', 'wshk_texttbwsize');
    	register_setting( 'wshk_options', 'wshk_textbxfsize');
    	register_setting( 'wshk_options', 'wshk_textbxbdsize');
    	register_setting( 'wshk_options', 'wshk_textbxbdradius');
    	register_setting( 'wshk_options', 'wshk_textbxbdtype');
    	register_setting( 'wshk_options', 'wshk_textbxbdcolor');
    	register_setting( 'wshk_options', 'wshk_textbxbgcolor');
    	register_setting( 'wshk_options', 'wshk_textbtnbdsize');
    	register_setting( 'wshk_options', 'wshk_textbtnbdradius');
    	register_setting( 'wshk_options', 'wshk_textbtnbdtype');
    	register_setting( 'wshk_options', 'wshk_textbtnbdcolor');
    	register_setting( 'wshk_options', 'wshk_textbtntarget');
    	register_setting( 'wshk_options', 'wshk_textbtntxd');
    	
    	register_setting( 'wshk_options', 'wshk_alignthereviews');
    	register_setting( 'wshk_options', 'wshk_aligntheorders');
    	register_setting( 'wshk_options', 'wshk_aligntheproducts');
    	
    	register_setting( 'wshk_options', 'wshk_enabledisplayreviews');
    	register_setting( 'wshk_options', 'wshk_disretextavsize');
    	register_setting( 'wshk_options', 'wshk_disretextavbdsize');
    	register_setting( 'wshk_options', 'wshk_disretextavbdradius');
    	register_setting( 'wshk_options', 'wshk_disretextavbdtype');
    	register_setting( 'wshk_options', 'wshk_disretextavbdcolor');
    	register_setting( 'wshk_options', 'wshk_disretexttbwsize');
    	register_setting( 'wshk_options', 'wshk_disretextbxfsize');
    	register_setting( 'wshk_options', 'wshk_disretextmargintop');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdsize');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdradius');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdtype');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdcolor');
    	register_setting( 'wshk_options', 'wshk_disretextbxbgcolor');
    	register_setting( 'wshk_options', 'wshk_disretextbxpadding');
    	register_setting( 'wshk_options', 'wshk_disretextbxminheight');
    	
    	
    	register_setting( 'wshk_options', 'wshk_disretextlinktarget');
    	register_setting( 'wshk_options', 'wshk_disretextlinktxd');
    	register_setting( 'wshk_options', 'wshk_disretextlinktxtsize');
    	register_setting( 'wshk_options', 'wshk_disretextlinktxtcolor');
    	
    	register_setting( 'wshk_options', 'wshk_disredisplaynumber');
    	register_setting( 'wshk_options', 'wshk_disrecolumnsnumber');
    	
    	
    	register_setting( 'wshk_options', 'wshk_enablerwcounter');
    	register_setting( 'wshk_options', 'wshk_treviewprefix');
    	register_setting( 'wshk_options', 'wshk_treviewsuffix');
    	register_setting( 'wshk_options', 'wshk_treviewpsuffix');
    	register_setting( 'wshk_options', 'wshk_textnoreview');
    	register_setting( 'wshk_options', 'wshk_enableusername');
    	register_setting( 'wshk_options', 'wshk_usernmtc');
    	register_setting( 'wshk_options', 'wshk_usernmts');
    	register_setting( 'wshk_options', 'wshk_usernmta');
    	register_setting( 'wshk_options', 'wshk_enablelogoutbtn');
    	register_setting( 'wshk_options', 'wshk_logbtnbdsize');
    	register_setting( 'wshk_options', 'wshk_logbtnbdradius');
    	register_setting( 'wshk_options', 'wshk_logbtnbdtype');
    	register_setting( 'wshk_options', 'wshk_logbtnbdcolor');
    	register_setting( 'wshk_options', 'wshk_logbtntd');
    	register_setting( 'wshk_options', 'wshk_logbtnta');
    	register_setting( 'wshk_options', 'wshk_logbtnwd');
    	register_setting( 'wshk_options', 'wshk_logbtntext');
    	register_setting( 'wshk_options', 'wshk_enableloginform');
    	register_setting( 'wshk_options', 'wshk_loginredi');
    	register_setting( 'wshk_options', 'wshk_blockmya');
    	register_setting( 'wshk_options', 'wshk_enableaddtocarttxt');
    	register_setting( 'wshk_options', 'wshk_atctxtexternal');
    	register_setting( 'wshk_options', 'wshk_atctxtgrouped');
    	register_setting( 'wshk_options', 'wshk_atctxtsimple');
    	register_setting( 'wshk_options', 'wshk_atctxtvariable');
    	/*register_setting( 'wshk_options', 'wshk_atctxtntin');    */
    	register_setting( 'wshk_options', 'wshk_textbxpadding');
    	register_setting( 'wshk_options', 'wshk_textbtntxt');
    	register_setting( 'wshk_options', 'wshk_avshadow');
    	register_setting( 'wshk_options', 'wshk_textusernmpf');
    	register_setting( 'wshk_options', 'wshk_textusernmsf');
    	register_setting( 'wshk_options', 'wshk_enablegravatar');
    	register_setting( 'wshk_options', 'wshk_textgravasize');
    	register_setting( 'wshk_options', 'wshk_textgravashd');
    	register_setting( 'wshk_options', 'wshk_textgravabdsz');
    	register_setting( 'wshk_options', 'wshk_textgravabdtp');
    	register_setting( 'wshk_options', 'wshk_textgravabdcl');
    	register_setting( 'wshk_options', 'wshk_textgravabdrd');
    	register_setting( 'wshk_options', 'wshk_emailordersizes');
    	register_setting( 'wshk_options', 'wshk_excludecat');
    	register_setting( 'wshk_options', 'wshk_exfirstcat');
    	register_setting( 'wshk_options', 'wshk_exsecondcat');
    	register_setting( 'wshk_options', 'wshk_exthirdcat');
    	register_setting( 'wshk_options', 'wshk_enablecustomenu');
    	register_setting( 'wshk_options', 'wshk_menulocation');
    	register_setting( 'wshk_options', 'wshk_logmenu');
    	register_setting( 'wshk_options', 'wshk_nonlogmenu');
    	register_setting( 'wshk_options', 'wshk_enableshtmenu');
    	register_setting( 'wshk_options', 'wshk_enableuserinmenu');
    	register_setting( 'wshk_options', 'wshk_enablesloginsec');
    	register_setting( 'wshk_options', 'wshk_enablesadminbar');
    	register_setting( 'wshk_options', 'wshk_enablerestrictctnt');
    	register_setting( 'wshk_options', 'wshk_enableoffctnt');
    	register_setting( 'wshk_options', 'wshk_btnlogoutredi');
    	
    	register_setting( 'wshk_options', 'wshk_enablesemab');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntdash');
    	register_setting( 'wshk_options', 'wshk_editdashb');
    	register_setting( 'wshk_options', 'wshk_editaftdashb');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntord');
    	register_setting( 'wshk_options', 'wshk_editorde');
    	register_setting( 'wshk_options', 'wshk_editaftorde');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntdow');
    	register_setting( 'wshk_options', 'wshk_editdown');
    	register_setting( 'wshk_options', 'wshk_editaftdown');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntadd');
    	register_setting( 'wshk_options', 'wshk_editaddre');
    	register_setting( 'wshk_options', 'wshk_editaftaddre');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntpay');
    	register_setting( 'wshk_options', 'wshk_editpaym');
    	register_setting( 'wshk_options', 'wshk_editaftpaym');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntrev');
    	register_setting( 'wshk_options', 'wshk_editrevi');
    	register_setting( 'wshk_options', 'wshk_editaftrevi');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntedi');
    	register_setting( 'wshk_options', 'wshk_editedit');
    	register_setting( 'wshk_options', 'wshk_editaftedit');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntlog');
    	register_setting( 'wshk_options', 'wshk_editlogo');
    	register_setting( 'wshk_options', 'wshk_editaftlogo');
    	
    	register_setting( 'wshk_options', 'wshk_tabsbdsize');
    	register_setting( 'wshk_options', 'wshk_tabsbdtype');
    	register_setting( 'wshk_options', 'wshk_tabsbdcolor');
    	register_setting( 'wshk_options', 'wshk_tabsbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_tabspdtop');
    	register_setting( 'wshk_options', 'wshk_tabspdright');
    	register_setting( 'wshk_options', 'wshk_tabspdbottom');
    	register_setting( 'wshk_options', 'wshk_tabspdleft');
    	
    	register_setting( 'wshk_options', 'wshk_tabstxtsize');
    	register_setting( 'wshk_options', 'wshk_tabstxtcolor');
    	register_setting( 'wshk_options', 'wshk_tabstxtalign');
    	register_setting( 'wshk_options', 'wshk_tabstxtdeco');
    	
    	register_setting( 'wshk_options', 'wshk_tabsbgcolor');
    	register_setting( 'wshk_options', 'wshk_tabswdsize');
    	register_setting( 'wshk_options', 'wshk_tabshgsize');
    	
    	
    	register_setting( 'wshk_options', 'wshk_actabsbdsize');
    	register_setting( 'wshk_options', 'wshk_actabsbdtype');
    	register_setting( 'wshk_options', 'wshk_actabsbdcolor');
    	register_setting( 'wshk_options', 'wshk_actabsbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_actabstxtcolor');
    	register_setting( 'wshk_options', 'wshk_actabstxtdeco');
    	register_setting( 'wshk_options', 'wshk_actabsbgcolor');
    	
    	
    	register_setting( 'wshk_options', 'wshk_hotabsbdsize');
    	register_setting( 'wshk_options', 'wshk_hotabsbdtype');
    	register_setting( 'wshk_options', 'wshk_hotabsbdcolor');
    	register_setting( 'wshk_options', 'wshk_hotabsbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_hotabstxtcolor');
    	register_setting( 'wshk_options', 'wshk_hotabstxtdeco');
    	register_setting( 'wshk_options', 'wshk_hotabsbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_contbbdsize');
    	register_setting( 'wshk_options', 'wshk_contbbdtype');
    	register_setting( 'wshk_options', 'wshk_contbbdcolor');
    	register_setting( 'wshk_options', 'wshk_contbbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_contbpdtop');
    	register_setting( 'wshk_options', 'wshk_contbpdright');
    	register_setting( 'wshk_options', 'wshk_contbpdbottom');
    	register_setting( 'wshk_options', 'wshk_contbpdleft');
    	
    	register_setting( 'wshk_options', 'wshk_contbctheight');
    	register_setting( 'wshk_options', 'wshk_contbctbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_keeplastab');
    	
    	register_setting( 'wshk_options', 'wshk_icondashb');
    	register_setting( 'wshk_options', 'wshk_iconorder');
    	register_setting( 'wshk_options', 'wshk_icondownl');
    	register_setting( 'wshk_options', 'wshk_iconaddre');
    	register_setting( 'wshk_options', 'wshk_iconpayme');
    	register_setting( 'wshk_options', 'wshk_iconrevie');
    	register_setting( 'wshk_options', 'wshk_iconedita');
    	register_setting( 'wshk_options', 'wshk_iconlogou');
    	
    	
    	
	}
	add_action( 'admin_init', 'wshk_register_settings' );
	endif;

/** Define plugin settings page html */

	if(!function_exists('init_woo_shortcodes_kit_admin_page_html')):

	function init_woo_shortcodes_kit_admin_page_html()
	{
    
    //esto es para la caja de .css
    
    if(get_option('wshk-inlinecss')!='')
	{
    $inlineCss=get_option('wshk-inlinecss');
    	}
    else {
    $inlineCss='.wshk {width: 50%;}
	.wshk .wshk-count{ 
    	color:#a46497;font-weight:bold;font-size:18px;
    	}
	.wshk .wshk-text {font-size: 12px;}';
        }
?>

<!-- HTML START -->
<style>


  .probando {
    background-color: #c6adc2;
    border: 1px solid #c6adc2;
    border-radius: 13px;
    color: white;
    padding: 16px 32px;
    width: 50%;
    height: 55px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 14px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.3s; /* Safari */
    transition-duration: 0.3s;
    cursor: pointer;
    letter-spacing: 1px;
}


.probando:Hover {
    background-color: #a46497; 
    color: white; 
    border: 1px solid #a46497;
    border-radius: 13px;
}

input[type=checkbox]{
	height: 0;
	width: 0;
	visibility: hidden;
}

label {
	cursor: pointer;
	text-indent: -9999px;
	width: 64px;
	height: 32px;
	background: #f2f7f6;
	display: block;
	border-radius: 100px;
	position: relative;
}

label:after {
	content: '';
	position: absolute;
	top: 5px;
	left: 5px;
	width: 22px;
	height: 22px;
	background: #c6adc2;
	border-radius: 90px;
	transition: 0.3s;
}

input:checked + label {
	background: #f2f7f6;
}

input:checked + label:after {
	left: calc(100% - 5px);
	transform: translateX(-100%);
	background: #aadb4a;
}

label:active:after {
	width: 50px;
}

// centering
body {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
}
input[type="number"],
input[type="text"]
{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    display: block;
    width: 100%;
    padding: 7px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: transparent;
    margin-bottom: 10px;
    font: 16px Arial, Helvetica, sans-serif;
    height: 45px;
}
/*input[type="textarea"]*/
.textarea
{


/*box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    display: block;
    width: 100%;
    padding: 7px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: transparent;
    margin-bottom: 10px;
    font: 16px Arial, Helvetica, sans-serif;
    height: 245px;*/


box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    display: block;
    width: 500px;
    padding: 7px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: transparent;
    margin-bottom: 10px;
    font: 16px Arial, Helvetica, sans-serif;
    height: 45px;
    resize:none;
    overflow: hidden;
}

.wp-admin select {
    padding: 2px;
    line-height: 28px;
    height: 48px !important;
    border: 1px solid transparent !important;
}


/* Style the element that is used to open and close the accordion class */
div.accordion {
 background-color: #a46497;
 color: #fff;
 cursor: pointer;
 padding: 18px;
 width: 96%;
 text-align: left;
 border: none;
 border-radius: 13px;
 outline: none;
 transition: 0.4s;
 margin-bottom:10px;
}
/* Add a background color to the accordion if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
div.accordion.active, p.accordion:hover {
 background-color: #c6adc2;
}
/* Unicode character for "plus" sign (+) */
div.accordion:after {
 content: "<?php esc_html_e( 'Show Advanced Options', 'woo-shortcodes-kit' ); ?> \1f441";
 font-size: 15px;
 color: #fff;
 float: right;
 margin-left: 5px;
 margin-top: -20px;
}
/* Unicode character for "minus" sign (-) */
div.accordion.active:after {
 content: "<?php esc_html_e( 'Hide Advanced Options', 'woo-shortcodes-kit' ); ?>  \1f5d9";
 font-size: 15px;
 color: #a46497;
 float: right;
 margin-left: 5px;
 margin-top: -20px;
}
/* Style the element that is used for the panel class */
div.panel {
 padding: 0 18px;
 background-color: transparent;
 max-height: 0;
 overflow: hidden;
 transition: 0.4s ease-in-out;
 opacity: 0;
 margin-bottom:10px;
}
div.panel.show {
 opacity: 1;
 max-height: 100%; /* Whatever you like, as long as its more than the height of the content (on all screen sizes) */
}


</style>












<script>
document.addEventListener("DOMContentLoaded", function(event) {
var acc = document.getElementsByClassName("accordion");
var panel = document.getElementsByClassName('panel');
for (var i = 0; i < acc.length; i++) {
 acc[i].onclick = function() {
 var setClasses = !this.classList.contains('active');
 setClass(acc, 'active', 'remove');
 setClass(panel, 'show', 'remove');
 if (setClasses) {
 this.classList.toggle("active");
 this.nextElementSibling.classList.toggle("show");
 }
 }
}
function setClass(els, className, fnName) {
 for (var i = 0; i < els.length; i++) {
 els[i].classList[fnName](className);
 }
}
});
</script>
<div style="width: 90%; padding: 10px; margin: 10px;"> 
 <div style="width: 100%;background-color: #a46497; border: 1px solid #a46497; border-radius: 13px; padding: 20px;"><h1><span style="color: white;">Woo Shortcodes Kit v 1.6.<small>6</small></span><span style="font-size: 12px; color: #c6adc2; float: right;margin-top: 35px;"><?php  echo get_num_queries(); ?> <?php esc_html_e( 'Queries in', 'woo-shortcodes-kit' ); ?> <?php timer_stop(1); ?>  <?php esc_html_e( 'seconds', 'woo-shortcodes-kit' ); ?>
 </span></h1>
 
 </div>
 <!-- Start Options Form -->
 
 <form action="options.php" method="post" id="wshk-sidebar-admin-form">    
 &nbsp;
 <br />

 
 <div id="wshk-tab-menu">
     
     <a id="wshk-general" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 100px;text-transform: uppercase;letter-spacing: 1px;" class="wshk-tab-links active" ><img src="<?php echo  plugins_url( 'images/newsett.png
' , __FILE__ );?> " style="width: 48px; height: 48px; padding-bottom: 15px;"><span style="text-align: center;"><br /><?php esc_html_e( 'Settings', 'woo-shortcodes-kit' ); ?></span></a> 
     
     <a  id="wshk-support" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 100px;text-transform: uppercase;letter-spacing: 1px;"  class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/thshortcodes.png' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;" ;><br /><span style="margin-left: -5px;"><?php esc_html_e( 'Shortcodes', 'woo-shortcodes-kit' ); ?></span></a> 
     
     <a  id="wshk-contact" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 100px;text-transform: uppercase;letter-spacing: 1px;" class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/newcont.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;"><span style="text-align: center;"><br /><?php esc_html_e( 'Contact', 'woo-shortcodes-kit' ); ?></span></a> 
 </div>
 
 
<div class="wshk-setting">

    <!-- General Setting -->   
    
      
    <br />
     
    <div class="first wshk-tab" id="div-wshk-general">
        
        
    <!-- Inicio caja blanca -->
    
    <div style="background-color: white; width: 100%; padding: 20px 20px 20px 20px;border: 1px solid white; border-radius: 13px;">
        
        <!-- caja info ajustes -->
        
         <div style="padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'General Settings', 'woo-shortcodes-kit' ); ?></span></h2>
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Just need make a click in each section to view the functions.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Enable & configure the functions.', 'woo-shortcodes-kit' ); ?></span></small><small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(Some functions use a shortcode to be displayed in the Frontend)', 'woo-shortcodes-kit' ); ?></span></small></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
  
  <!-- estilos para container accordion principal -->
    <style>

.pcontainer {
  width: 100%;
  /*margin: 0 auto;*/
  
}

.acc {
  margin-top: 50px;
  overflow: hidden;
  /*padding: 0;*/
}

.acc li {
  list-style-type: none;
  /*padding: 0;*/
}

.acc_ctrl {
  background: #FFFFFF;
  border: none;
  border-bottom: solid 1px #F2F2F2;
  cursor: pointer;
  display: block;
  outline: none;
  padding: 2em;
  position: relative;
  text-align: left;
  width: 100%;
}

.acc_ctrl:before {
  /*background: #44596B;*/
  content: '';
  height: 2px;
  margin-right: 37px;
  position: absolute;
  right: 0;
  top: 50%;
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
  -webkit-transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -ms-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
  width: 14px;
}

.acc_ctrl:after {
  /*background: #44596B;*/
  content: '';
  height: 2px;
  margin-right: 37px;
  position: absolute;
  right: 0;
  top: 50%;
  width: 14px;
}

.acc_ctrl.active:before {
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  -ms-transform: rotate(0deg);
  -o-transform: rotate(0deg);
  transform: rotate(0deg);
}

.acc_ctrl.active h2, .acc_ctrl:focus h2 {
  position: relative;
}

.acc_panel {
  /*background: #F2F2F2;*/
  display: none;
  overflow: hidden;
}

</style>
<!-- fin estilos accordion principal -->


<!-- inicio accordion principal -->
<div class="pcontainer">
  <ul class="acc">
      
      <!-- cada li una funcion -->
    <li>
      <!-- titulo primer accordion -->
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 24px;"><span class="dashicons dashicons-email-alt"></span> <?php esc_html_e( 'CUSTOMIZE THE ORDER EMAIL', 'woo-shortcodes-kit' ); ?></h3></div>
      
      <!-- contenido primer accordion -->
      <div class="acc_panel">
          <br /><br />
          <!-- titulo funcion container -->
        <div class="accordion">
    <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
    <th><p><input type="checkbox" id="wshk_test" name="wshk_test" value='2' <?php if(get_option('wshk_test')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_test>Toggle</label></th>
    <th style="padding: 30px 20px 0px 20px;"><big><br /><?php esc_html_e( 'Enable Product thumbnail in email orders', 'woo-shortcodes-kit' ); ?>    </big><br />
        <small>  <?php esc_html_e( 'The thumbnail will appear in the order email when a user buy a product.', 'woo-shortcodes-kit' ); ?></small></p><br /></th>
    
 
</table>
</div>


<!-- contenido funcion container -->
<div class="panel">
<br />
<br />
<table>
<tr>
<td>
<p> <?php esc_html_e( 'Set the size for the product thumbnail:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_emailordersizes" name="wshk_emailordersizes" value="<?php if(get_option('wshk_emailordersizes')!=''){ echo get_option('wshk_emailordersizes'); }?>" placeholder="100px"/ size="20"><br /></p></td>
</tr>
</table>
<br /><br /></div>
      </div>
    </li>
  <!-- fin primer accordion -->  
    
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 24px;"><span class="dashicons dashicons-cart"></span> <?php esc_html_e( 'CUSTOMIZE THE ADD TO CART BUTTON', 'woo-shortcodes-kit' ); ?></h3></div>
      
      <div class="acc_panel">
          <br /><br />
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
  <tr>
  
    <th><p><input type="checkbox" id="wshk_enablebought" name="wshk_enablebought" value='5' <?php if(get_option('wshk_enablebought')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablebought>Toggle</label></th>
    <th style="padding: 50px 20px 0px 20px;"><big>    <?php esc_html_e( 'Enable Change the button text "Add to cart" if user have the product purchase', 'woo-shortcodes-kit' ); ?></big><br />
        <small>  <?php esc_html_e( 'The Shop page´s button and the summary´s button text will change if the user have purchase the product.', 'woo-shortcodes-kit' ); ?></small></p><br /></th>
</table>


        
</div>
<div class="panel">
<br />
<br />

        <table>
    <tr>
    
    <td><p> <?php esc_html_e( 'Write here the text to display in the button:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_buttontext" name="wshk_buttontext" value="<?php if(get_option('wshk_buttontext')!=''){ echo get_option('wshk_buttontext'); }?>" placeholder="<?php esc_html_e( "Downloaded/Bought", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    <br /></td>
    </tr>
    </table> 
    
        <br />      
        <br />
        </div>
<br />

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
  <tr>
  
    <th><p><input type="checkbox" id="wshk_enableaddtocarttxt" name="wshk_enableaddtocarttxt" value='14' <?php if(get_option('wshk_enableaddtocarttxt')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enableaddtocarttxt>Toggle</label></th>
    <th style="padding: 50px 20px 0px 20px;"><big>    <?php esc_html_e( 'Enable Change the Add to cart button text & write a different text in each case', 'woo-shortcodes-kit' ); ?></big><br />
        <small>  <?php esc_html_e( 'You can modify the text for external, grouped, simple, variable products', 'woo-shortcodes-kit' ); ?></small></p><br /></th>
</table>


        
</div>
<div class="panel">
<br />
<br />

        <table>
    <tr>
    
    <td style="padding: 30px;">
    <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'external', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" id="wshk_atctxtexternal" name="wshk_atctxtexternal" value="<?php if(get_option('wshk_atctxtexternal')!=''){ echo get_option('wshk_atctxtexternal'); }?>" placeholder="<?php esc_html_e( "Buy this product", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
    
    <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'grouped', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" id="wshk_atctxtgrouped" name="wshk_atctxtgrouped" value="<?php if(get_option('wshk_atctxtgrouped')!=''){ echo get_option('wshk_atctxtgrouped'); }?>" placeholder="<?php esc_html_e( "View products", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
    
   
    </td>    
    <td style="padding: 30px; border-left: 1px solid;">
        
         <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'simple', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" id="wshk_atctxtsimple" name="wshk_atctxtsimple" value="<?php if(get_option('wshk_atctxtsimple')!=''){ echo get_option('wshk_atctxtsimple'); }?>" placeholder="<?php esc_html_e( "Add to cart", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
        
        <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'variable', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" id="wshk_atctxtvariable" name="wshk_atctxtvariable" value="<?php if(get_option('wshk_atctxtvariable')!=''){ echo get_option('wshk_atctxtvariable'); }?>" placeholder="<?php esc_html_e( "Select options", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    
    <!--<p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'default', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" id="wshk_atctxtntin" name="wshk_atctxtntin" value="<?php if(get_option('wshk_atctxtntin')!=''){ echo get_option('wshk_atctxtntin'); }?>" placeholder="<?php esc_html_e( "Read more", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>-->
    </td>
    </tr>
    </table> 
    
        <br />      
        <br />
        </div>
      </div>
    </li>
    
    
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 24px;"><span class="dashicons dashicons-store"></span> <?php esc_html_e( 'CUSTOMIZE THE SHOP PAGE', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" id="wshk_enablecat" name="wshk_enablecat" value='4' <?php if(get_option('wshk_enablecat')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablecat>Toggle</label></th> <th style="padding: 30px 20px 0px 20px;"><big><br /> <?php esc_html_e( 'Enable Display only products of specifics categories in shop page', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Write the category-slug of each category that you want display in shop page page:', 'woo-shortcodes-kit' ); ?></small></p><br /></th>
         </table>
</div>
<div class="panel">
    <table>
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'First Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /><br />  <input type="text" id="wshk_firstcat" name="wshk_firstcat" value="<?php if(get_option('wshk_firstcat')!=''){ echo get_option('wshk_firstcat'); }?>" placeholder="<?php esc_html_e( "category-slug", "woo-shortcodes-kit" ); ?>"/ size="25"><br /></p></td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Second Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /><br />  <input type="text" id="wshk_secondcat" name="wshk_secondcat" value="<?php if(get_option('wshk_secondcat')!=''){ echo get_option('wshk_secondcat'); }?>" placeholder="<?php esc_html_e( "category-slug", "woo-shortcodes-kit" ); ?>"/ size="25"><br /></p></td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Third Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /><br />  <input type="text" id="wshk_thirdcat" name="wshk_thirdcat" value="<?php if(get_option('wshk_thirdcat')!=''){ echo get_option('wshk_thirdcat'); }?>" placeholder="<?php esc_html_e( "category-slug", "woo-shortcodes-kit" ); ?>"/ size="25"><br /></p></td></tr>
        
        <br />
        <br />
        </table>
        </div>
        
        
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" id="wshk_excludecat" name="wshk_excludecat" value='16' <?php if(get_option('wshk_excludecat')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_excludecat>Toggle</label></th> <th style="padding: 30px 20px 0px 20px;"><big><br /> <?php esc_html_e( 'Enable to exclude products of specifics categories in shop page', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Write the category-slug of each category that you want exclude in shop page page:', 'woo-shortcodes-kit' ); ?></small></p><br /></th>
         </table>
</div>
<div class="panel">
    <table>
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'First Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /><br />  <input type="text" id="wshk_firstcat" name="wshk_exfirstcat" value="<?php if(get_option('wshk_exfirstcat')!=''){ echo get_option('wshk_exfirstcat'); }?>" placeholder="<?php esc_html_e( "category-slug", "woo-shortcodes-kit" ); ?>"/ size="25"><br /></p></td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Second Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /><br />  <input type="text" id="wshk_exsecondcat" name="wshk_exsecondcat" value="<?php if(get_option('wshk_exsecondcat')!=''){ echo get_option('wshk_exsecondcat'); }?>" placeholder="<?php esc_html_e( "category-slug", "woo-shortcodes-kit" ); ?>"/ size="25"><br /></p></td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Third Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /><br />  <input type="text" id="wshk_exthirdcat" name="wshk_exthirdcat" value="<?php if(get_option('wshk_exthirdcat')!=''){ echo get_option('wshk_exthirdcat'); }?>" placeholder="<?php esc_html_e( "category-slug", "woo-shortcodes-kit" ); ?>"/ size="25"><br /></p></td></tr>
        
        <br />
        <br />
        </table>
        </div>
        
        
        
        
        
        
        
        
        
        

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
        <th><p><input type="checkbox" id="wshk_perpage" name="wshk_perpage" value='3' <?php if(get_option('wshk_perpage')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_perpage></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><br /> <?php esc_html_e( 'Enable Products per page Manager', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Write the number of products to display per page', 'woo-shortcodes-kit' ); ?></small></p><br /></th>      
        </table>
</div>
<div class="panel"><br /><br /><table>
        <tr>
        <p><?php esc_html_e( 'Number of products:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_nperpage" name="wshk_nperpage" value="<?php if(get_option('wshk_nperpage')!=''){ echo get_option('wshk_nperpage'); }?>" placeholder="<?php esc_html_e( "-1 to show all products", "woo-shortcodes-kit" ); ?>"/ size="20"><small> <?php esc_html_e( 'Write -1 to display All products', 'woo-shortcodes-kit' ); ?></small><br /></p>
        </tr>
        </table>
        <br />
        <br />
        </div>

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
    <th><p><input type="checkbox" id="wshk_enable" name="wshk_enable" value='1' <?php if(get_option('wshk_enable')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enable></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><br /><?php esc_html_e( 'Enable Product Downloads/Sales Counter', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Write the text to show and set the minimun number of Downloads/Sales that a product must have to display the message', 'woo-shortcodes-kit' ); ?> </small></p><br /></th>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td style="padding: 30px;"><p> <?php esc_html_e( 'Write here the text to display below the product:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_text" name="wshk_text" value="<?php if(get_option('wshk_text')!=''){ echo get_option('wshk_text'); }?>" placeholder="<?php esc_html_e( "Downloads", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can use HTML to add icons and text styles, just remember modify the', 'woo-shortcodes-kit' ); ?></small> " " <small><?php esc_html_e( 'with', 'woo-shortcodes-kit' ); ?></small> ' ' <br /> <small> <?php esc_html_e( "Example: i class='fa fa-download' aria-hidden='true'", 'woo-shortcodes-kit' ); ?>></small><br /></p>
    
    <br /><br /><p> <?php esc_html_e( 'Set the minimun number of downloads to display the message:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_min" name="wshk_min" value="<?php if(get_option('wshk_min')!=''){ echo get_option('wshk_min'); }?>" placeholder="<?php esc_html_e( "All", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'By default, is set to display the message without count the number of downloads.', 'woo-shortcodes-kit' ); ?></small><br /></p></td>
    
    <td style="padding: 30px; border-left: 1px solid;"><p> <?php esc_html_e( 'Write here the text to display below the product:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textsales" name="wshk_textsales" value="<?php if(get_option('wshk_textsales')!=''){ echo get_option('wshk_textsales'); }?>" placeholder="<?php esc_html_e( "Sales", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can use HTML to add icons and text styles, just remember modify the', 'woo-shortcodes-kit' ); ?></small> " " <small><?php esc_html_e( 'with', 'woo-shortcodes-kit' ); ?></small> ' ' <br /> <small> <?php esc_html_e( "Example: i class='fa fa-shopping-cart' aria-hidden='true'", 'woo-shortcodes-kit' ); ?>></small><br /></p><br /><br /><p> <?php esc_html_e( 'Set the minimun number of sales to display the message:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_minsales" name="wshk_minsales" value="<?php if(get_option('wshk_minsales')!=''){ echo get_option('wshk_minsales'); }?>" placeholder="<?php esc_html_e( "All", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'By default, is set to display the message without count the number of sales.', 'woo-shortcodes-kit' ); ?></small><br /></p></td>
    </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    </div>
      </div>
    </li>
    
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 24px;"><span class="dashicons dashicons-admin-settings"></span> <?php esc_html_e( 'CUSTOMIZE THE SHORTCODES', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
        <div class="accordion">
 <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablectbp" name="wshk_enablectbp" value='6' <?php if(get_option('wshk_enablectbp')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablectbp></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display & Change the customer total bought products texts', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td><p> <?php esc_html_e( 'Write here the text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textprefix" name="wshk_textprefix" value="<?php if(get_option('wshk_textprefix')!=''){ echo get_option('wshk_textprefix'); }?>" placeholder="<?php esc_html_e( "You have bought", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textsuffix" name="wshk_textsuffix" value="<?php if(get_option('wshk_textsuffix')!=''){ echo get_option('wshk_textsuffix'); }?>" placeholder="<?php esc_html_e( "product", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text plural suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textpsuffix" name="wshk_textpsuffix" value="<?php if(get_option('wshk_textpsuffix')!=''){ echo get_option('wshk_textpsuffix'); }?>" placeholder="<?php esc_html_e( "products", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Text when dont have bought any product:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textnobp" name="wshk_textnobp" value="<?php if(get_option('wshk_textnobp')!=''){ echo get_option('wshk_textnobp'); }?>" placeholder="<?php esc_html_e( "You dont have any products bought yet", "woo-shortcodes-kit" ); ?>"/ size="36"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br />
    </td>
    </tr>
    </table>
    <br />
<p> <?php esc_html_e( 'Text align:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_aligntheproducts" name="wshk_aligntheproducts" value="<?php if(get_option('wshk_aligntheproducts')!=''){ echo get_option('wshk_aligntheproducts'); }?>" placeholder="<?php esc_html_e( "center", "woo-shortcodes-kit" ); ?>"/ size="36"></p>
    <br />
    <br />
    </div>

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablectbo" name="wshk_enablectbo" value='7' <?php if(get_option('wshk_enablectbo')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablectbo></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display & Change the customer total orders texts', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td><p> <?php esc_html_e( 'Write here the text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_tordersprefix" name="wshk_tordersprefix" value="<?php if(get_option('wshk_tordersprefix')!=''){ echo get_option('wshk_tordersprefix'); }?>" placeholder="<?php esc_html_e( "You have made", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text singular suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_torderssuffix" name="wshk_torderssuffix" value="<?php if(get_option('wshk_torderssuffix')!=''){ echo get_option('wshk_torderssuffix'); }?>" placeholder="<?php esc_html_e( "order", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text plural suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_torderspsuffix" name="wshk_torderspsuffix" value="<?php if(get_option('wshk_torderspsuffix')!=''){ echo get_option('wshk_torderspsuffix'); }?>" placeholder="<?php esc_html_e( "orders", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Text when dont have made any order:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textnobo" name="wshk_textnobo" value="<?php if(get_option('wshk_textnobo')!=''){ echo get_option('wshk_textnobo'); }?>" placeholder="<?php esc_html_e( "You dont have any orders made yet", "woo-shortcodes-kit" ); ?>"/ size="36"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br />
    </td>
    </tr>
    </table>
    <br />
<p> <?php esc_html_e( 'Text align:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_aligntheorders" name="wshk_aligntheorders" value="<?php if(get_option('wshk_aligntheorders')!=''){ echo get_option('wshk_aligntheorders'); }?>" placeholder="<?php esc_html_e( "center", "woo-shortcodes-kit" ); ?>"/ size="36"></p>
    <br />
    <br />
    </div>
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablerwcounter" name="wshk_enablerwcounter" value='10' <?php if(get_option('wshk_enablerwcounter')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablerwcounter></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display & Change the customer total reviews texts', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td><p> <?php esc_html_e( 'Write here the text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_treviewprefix" name="wshk_treviewprefix" value="<?php if(get_option('wshk_treviewprefix')!=''){ echo get_option('wshk_treviewprefix'); }?>" placeholder="<?php esc_html_e( "You have made", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text singular suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_treviewsuffix" name="wshk_treviewsuffix" value="<?php if(get_option('wshk_treviewsuffix')!=''){ echo get_option('wshk_treviewsuffix'); }?>" placeholder="<?php esc_html_e( "review", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text plural suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_treviewpsuffix" name="wshk_treviewpsuffix" value="<?php if(get_option('wshk_treviewpsuffix')!=''){ echo get_option('wshk_treviewpsuffix'); }?>" placeholder="<?php esc_html_e( "reviews", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Text when dont have made any review:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textnoreview" name="wshk_textnoreview" value="<?php if(get_option('wshk_textnoreview')!=''){ echo get_option('wshk_textnoreview'); }?>" placeholder="<?php esc_html_e( "You dont have any review made yet", "woo-shortcodes-kit" ); ?>"/ size="36"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br />
    </td>
    </tr>
    </table>
    <br />
<p> <?php esc_html_e( 'Text align:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_alignthereviews" name="wshk_alignthereviews" value="<?php if(get_option('wshk_alignthereviews')!=''){ echo get_option('wshk_alignthereviews'); }?>" placeholder="<?php esc_html_e( "center", "woo-shortcodes-kit" ); ?>"/ size="36"></p>
    <br />
    <br />
    </div>

<div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablewmessage" name="wshk_enablewmessage" value='8' <?php if(get_option('wshk_enablewmessage')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablewmessage></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display & Change the text of Order´s message', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td style="padding: 30px;"><p> <?php esc_html_e( 'Message text:', 'woo-shortcodes-kit' ); ?><br /><br /> <textarea name="wshk_textwmssg" id="wshk_textwmssg" class="textarea" cols="40" rows="6" id="wshk_textwmssg" placeholder="<?php esc_html_e( 'Hi %1$s!<br />To reward your activity in our shop with %2$s orders, we want give to you a 50%% discount for your next order!! 
<br />Enter this coupon code in your next order: WSHK50TST', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:90px;"><?php if(get_option('wshk_textwmssg')!=''){ echo get_option('wshk_textwmssg'); }?></textarea><br /></p>
    <br /><br /></td>
    
    <td style="padding: 30px; border-left: 1px solid;"><p> <?php esc_html_e( 'Set the number of orders to display the message:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_wmorders" name="wshk_wmorders" value="<?php if(get_option('wshk_wmorders')!=''){ echo get_option('wshk_wmorders'); }?>" placeholder="5"/ size="20"><br /></p>
    
    <p><?php esc_html_e( 'Set the custom text to display if the customer not have orders made yet:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_nonotice" name="wshk_nonotice" value="<?php if(get_option('wshk_nonotice')!=''){ echo get_option('wshk_nonotice'); }?>" placeholder="<?php esc_html_e( "Dont have made orders yet", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Set the custom text to display if the customer have more orders:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_morenotice" name="wshk_morenotice" value="<?php if(get_option('wshk_morenotice')!=''){ echo get_option('wshk_morenotice'); }?>" placeholder="<?php esc_html_e( "Coming soon more gifts", "woo-shortcodes-kit" ); ?>"/ size="36"><br /></p>
    <br /><br />
    </td>        
    </tr>
   
    </table> <br /><br /></div>
    
    
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablereviews" name="wshk_enablereviews" value='9' <?php if(get_option('wshk_enablereviews')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablereviews></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display the customer reviews with link to the product', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Expand for Customize the style', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>

<div class="panel"><br /><br /><table>
    <tr>    
    <td style="padding: 30px; width: 35%;"><h4><span class="dashicons dashicons-admin-users"></span> <?php esc_html_e( 'Customize the avatar', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Avatar size:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" id="wshk_textavsize" name="wshk_textavsize"  value="<?php if(get_option('wshk_textavsize')!=''){ echo get_option('wshk_textavsize'); }?>" placeholder="78px"/ size="20" ></p>     
    <p> <?php esc_html_e( 'Avatar border (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textavbdsize" id="wshk_textavbdsize" value="<?php if(get_option('wshk_textavbdsize')!=''){ echo get_option('wshk_textavbdsize'); }?>" placeholder="2px" size="10" /></p>    
    <p> <?php esc_html_e( 'Avatar border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textavbdradius" id="wshk_avbdradius" value="<?php if(get_option('wshk_textavbdradius')!=''){ echo get_option('wshk_textavbdradius'); }?>" placeholder="100%" size="10" /></p>    
   <p> <?php esc_html_e( 'Avatar border (type):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textavbdtype" id="wshk_textavbdtype" value="<?php if(get_option('wshk_textavbdtype')!=''){ echo get_option('wshk_textavbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Avatar border (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textavbdcolor" id="wshk_textavbdcolor" value="<?php if(get_option('wshk_textavbdcolor')!=''){ echo get_option('wshk_textavbdcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar cell (width):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_texttbwsize" id="wshk_texttbwsize" value="<?php if(get_option('wshk_texttbwsize')!=''){ echo get_option('wshk_texttbwsize'); }?>" placeholder="100px" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar shadow:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_avshadow" id="wshk_avshadow" value="<?php if(get_option('wshk_avshadow')!=''){ echo get_option('wshk_avshadow'); }?>" placeholder="5px 5px 5px #c2c2c2" size="10" /></p>
     
    <br /><br />
    </td> 
    <td style="padding: 30px; border-left: 1px solid; width: 35%;"><h4><span class="dashicons dashicons-id"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Box Font (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textbxfsize" id="wshk_textbxfsize" value="<?php if(get_option('wshk_textbxfsize')!=''){ echo get_option('wshk_textbxfsize'); }?>" placeholder="16px" size="10" /></p>        
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textbxbdsize" id="wshk_textbxbdsize" value="<?php if(get_option('wshk_textbxbdsize')!=''){ echo get_option('wshk_textbxbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textbxbdradius" id="wshk_textbxbdradius" value="<?php if(get_option('wshk_textbxbdradius')!=''){ echo get_option('wshk_textbxbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbxbdtype" id="wshk_textbxbdtype" value="<?php if(get_option('wshk_textbxbdtype')!=''){ echo get_option('wshk_textbxbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbxbdcolor" id="wshk_textbxbdcolor" value="<?php if(get_option('wshk_textbxbdcolor')!=''){ echo get_option('wshk_textbxbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbxbgcolor" id="wshk_textbxbgcolor" value="<?php if(get_option('wshk_textbxbgcolor')!=''){ echo get_option('wshk_textbxbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textbxpadding" id="wshk_textbxpadding" value="<?php if(get_option('wshk_textbxpadding')!=''){ echo get_option('wshk_textbxpadding'); }?>" placeholder="20px" size="10" /></p>  
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid; witdh: 35%;"><h4><span class="dashicons dashicons-slides"></span> <?php esc_html_e( 'Customize the button', 'woo-shortcodes-kit' ); ?></h4>         
    <p> <?php esc_html_e( 'Button border (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textbtnbdsize" id="wshk_textbtnbdsize" value="<?php if(get_option('wshk_textbtnbdsize')!=''){ echo get_option('wshk_textbtnbdsize'); }?>" placeholder="1px" size="10" /></p>
    <p> <?php esc_html_e( 'Button border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_textbtnbdradius" id="wshk_textbtnbdradius" value="<?php if(get_option('wshk_textbtnbdradius')!=''){ echo get_option('wshk_textbtnbdradius'); }?>" placeholder="13%" size="10" /></p>
   <p> <?php esc_html_e( 'Button border (type):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbtnbdtype" id="wshk_textbtnbdtype" value="<?php if(get_option('wshk_textbtnbdtype')!=''){ echo get_option('wshk_textbtnbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>
    <p> <?php esc_html_e( 'Button border (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbtnbdcolor" id="wshk_textbtnbdcolor" value="<?php if(get_option('wshk_textbtnbdcolor')!=''){ echo get_option('wshk_textbtnbdcolor'); }?>" placeholder="#a46497" size="10" /></p>
    <p> <?php esc_html_e( 'Button target:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbtntarget" id="wshk_textbtntarget" value="<?php if(get_option('wshk_textbtntarget')!=''){ echo get_option('wshk_textbtntarget'); }?>" placeholder="_blank" size="10" /></p>
    <p> <?php esc_html_e( 'Button text-decoration:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbtntxd" id="wshk_textbtntxd" value="<?php if(get_option('wshk_textbtntxd')!=''){ echo get_option('wshk_textbtntxd'); }?>" placeholder="none" size="10" /></p>
    <p> <?php esc_html_e( 'Button text:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_textbtntxt" id="wshk_textbtntxt" value="<?php if(get_option('wshk_textbtntxt')!=''){ echo get_option('wshk_textbtntxt'); }?>" placeholder="<?php esc_html_e( "View product", "woo-shortcodes-kit" ); ?>" size="10" /></p>
    <br /><br />
    </td>                    
    </tr>
   
    </table> </div>
    
    
    
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enabledisplayreviews" name="wshk_enabledisplayreviews" value='40' <?php if(get_option('wshk_enabledisplayreviews')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enabledisplayreviews></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display all the users reviews where you want', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Expand for Customize the style', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>

<div class="panel"><br /><br /><table>
    <tr>    
    <td style="padding: 30px; width: 35%;"><h4 style="margin-top: -75px;"><span class="dashicons dashicons-admin-users"></span> <?php esc_html_e( 'Customize the avatar', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Avatar size:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" id="wshk_disretextavsize" name="wshk_disretextavsize"  value="<?php if(get_option('wshk_disretextavsize')!=''){ echo get_option('wshk_disretextavsize'); }?>" placeholder="48px"/ size="20" ></p>     
    <p> <?php esc_html_e( 'Avatar border (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextavbdsize" id="wshk_disretextavbdsize" value="<?php if(get_option('wshk_disretextavbdsize')!=''){ echo get_option('wshk_disretextavbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Avatar border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextavbdradius" id="wshk_disretextavbdradius" value="<?php if(get_option('wshk_disretextavbdradius')!=''){ echo get_option('wshk_disretextavbdradius'); }?>" placeholder="100%" size="10" /></p>    
   <p> <?php esc_html_e( 'Avatar border (type):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextavbdtype" id="wshk_disretextavbdtype" value="<?php if(get_option('wshk_disretextavbdtype')!=''){ echo get_option('wshk_disretextavbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Avatar border (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextavbdcolor" id="wshk_disretextavbdcolor" value="<?php if(get_option('wshk_disretextavbdcolor')!=''){ echo get_option('wshk_disretextavbdcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar cell (width):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretexttbwsize" id="wshk_disretexttbwsize" value="<?php if(get_option('wshk_disretexttbwsize')!=''){ echo get_option('wshk_disretexttbwsize'); }?>" placeholder="100px" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar margin top:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextmargintop" id="wshk_disretextmargintop" value="<?php if(get_option('wshk_disretextmargintop')!=''){ echo get_option('wshk_disretextmargintop'); }?>" placeholder="15px" size="10" /></p>
    <!--<p> <?php esc_html_e( 'Avatar shadow:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_avshadow" id="wshk_avshadow" value="<?php if(get_option('wshk_avshadow')!=''){ echo get_option('wshk_avshadow'); }?>" placeholder="5px 5px 5px #c2c2c2" size="10" /></p>-->
     
    <br /><br />
    </td> 
    <td style="padding: 30px; border-left: 1px solid; width: 35%;"><h4><span class="dashicons dashicons-id"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Box Font (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextbxfsize" id="wshk_disretextbxfsize" value="<?php if(get_option('wshk_disretextbxfsize')!=''){ echo get_option('wshk_disretextbxfsize'); }?>" placeholder="16px" size="10" /></p>        
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextbxbdsize" id="wshk_disretextbxbdsize" value="<?php if(get_option('wshk_disretextbxbdsize')!=''){ echo get_option('wshk_disretextbxbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextbxbdradius" id="wshk_disretextbxbdradius" value="<?php if(get_option('wshk_disretextbxbdradius')!=''){ echo get_option('wshk_disretextbxbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextbxbdtype" id="wshk_disretextbxbdtype" value="<?php if(get_option('wshk_disretextbxbdtype')!=''){ echo get_option('wshk_disretextbxbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextbxbdcolor" id="wshk_disretextbxbdcolor" value="<?php if(get_option('wshk_disretextbxbdcolor')!=''){ echo get_option('wshk_disretextbxbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextbxbgcolor" id="wshk_disretextbxbgcolor" value="<?php if(get_option('wshk_disretextbxbgcolor')!=''){ echo get_option('wshk_disretextbxbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextbxpadding" id="wshk_disretextbxpadding" value="<?php if(get_option('wshk_disretextbxpadding')!=''){ echo get_option('wshk_disretextbxpadding'); }?>" placeholder="20px" size="10" /></p>
    <p> <?php esc_html_e( 'Box height:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextbxminheight" id="wshk_disretextbxminheight" value="<?php if(get_option('wshk_disretextbxminheight')!=''){ echo get_option('wshk_disretextbxminheight'); }?>" placeholder="200px" size="10" /></p>
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid; witdh: 35%;"><h4 style="margin-top: -315px;"><span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Customize the title', 'woo-shortcodes-kit' ); ?></h4>
    
    <p> <?php esc_html_e( 'Title text size:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextlinktxtsize" id="wshk_disretextlinktxtsize" value="<?php if(get_option('wshk_disretextlinktxtsize')!=''){ echo get_option('wshk_disretextlinktxtsize'); }?>" placeholder="24px" size="10" /></p>
    <p> <?php esc_html_e( 'Title text color:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextlinktxtcolor" id="wshk_disretextlinktxtcolor" value="<?php if(get_option('wshk_disretextlinktxtcolor')!=''){ echo get_option('wshk_disretextlinktxtcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Title text-decoration:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextlinktxd" id="wshk_disretextlinktxd" value="<?php if(get_option('wshk_disretextlinktxd')!=''){ echo get_option('wshk_disretextlinktxd'); }?>" placeholder="none" size="10" /></p>
    <p> <?php esc_html_e( 'Title link target:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextlinktarget" id="wshk_disretextlinktarget" value="<?php if(get_option('wshk_disretextlinktarget')!=''){ echo get_option('wshk_disretextlinktarget'); }?>" placeholder="_blank" size="10" /></p>
    <br /><br />
    </td>                    
    </tr>
   
    </table><br /><br />
    <table width="100%">
        <tr>
            <td width="50%"><p> <?php esc_html_e( 'How many reviews want display?', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disredisplaynumber" id="wshk_disredisplaynumber" value="<?php if(get_option('wshk_disredisplaynumber')!=''){ echo get_option('wshk_disredisplaynumber'); }?>" placeholder="all" size="10" /></p><br /><small><?php esc_html_e( 'Write all to show all reviews or a specific number to show this number of reviews.', 'woo-shortcodes-kit' ); ?></small></td>
            
            <td width="50%"><p> <?php esc_html_e( 'How many columns want display?:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disrecolumnsnumber" id="wshk_disrecolumnsnumber" value="<?php if(get_option('wshk_disrecolumnsnumber')!=''){ echo get_option('wshk_disrecolumnsnumber'); }?>" placeholder="2" size="10" /></p><br /><small><?php esc_html_e( 'Write the number of columns that you want display the reviews, normally is used 1, 2,3 or 4.', 'woo-shortcodes-kit' ); ?></small></td>
        </tr>
    </table>
    <br /><br />
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablegravatar" name="wshk_enablegravatar" value='15' <?php if(get_option('wshk_enablegravatar')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablegravatar></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display the user gravatar image', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Expand for Customize the style.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td style="padding: 30px; width: 50%;">
    <p> <?php esc_html_e( 'Gravatar size:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_textgravasize" name="wshk_textgravasize" value="<?php if(get_option('wshk_textgravasize')!=''){ echo get_option('wshk_textgravasize'); }?>" placeholder="128px"/ size="50"><br /></p>
    
    <p> <?php esc_html_e( 'Gravatar shadow:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textgravashd" name="wshk_textgravashd" value="<?php if(get_option('wshk_textgravashd')!=''){ echo get_option('wshk_textgravashd'); }?>" placeholder="5px 5px 5px #c6adc2"/ size="50"><br /></p>    
    <br /><br />
    </td>
    <td style="padding: 30px; border-left: 1px solid; width: 50%;">    
    
    <p> <?php esc_html_e( 'Border size:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_textgravabdsz" name="wshk_textgravabdsz" value="<?php if(get_option('wshk_textgravabdsz')!=''){ echo get_option('wshk_textgravabdsz'); }?>" placeholder="4px"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Border type:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textgravabdtp" name="wshk_textgravabdtp" value="<?php if(get_option('wshk_textgravabdtp')!=''){ echo get_option('wshk_textgravabdtp'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Boder color:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textgravabdcl" name="wshk_textgravabdcl" value="<?php if(get_option('wshk_textgravabdcl')!=''){ echo get_option('wshk_textgravabdcl'); }?>" placeholder="#ffffff"/ size="20"><br /></p>    
    
    <p> <?php esc_html_e( 'Border radius:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_textgravabdrd" name="wshk_textgravabdrd" value="<?php if(get_option('wshk_textgravabdrd')!=''){ echo get_option('wshk_textgravabdrd'); }?>" placeholder="100%"/ size="20"><br /></p>
    <br /><br /></td>
    
    
    </tr>
    </table>
    <br />
    <br />
    </div>





    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enableusername" name="wshk_enableusername" value='11' <?php if(get_option('wshk_enableusername')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enableusername></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display the username', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Expand for Customize the style.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td style="padding: 30px; width: 50%;">
    <p> <?php esc_html_e( 'Text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textusernmpf" name="wshk_textusernmpf" value="<?php if(get_option('wshk_textusernmpf')!=''){ echo get_option('wshk_textusernmpf'); }?>" placeholder="<?php esc_html_e( "Hello", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
    
    <p> <?php esc_html_e( 'Text suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_textusernmsf" name="wshk_textusernmsf" value="<?php if(get_option('wshk_textusernmsf')!=''){ echo get_option('wshk_textusernmsf'); }?>" placeholder="!"/ size="50"><br /></p>    
    <br /><br />
    </td>
    <td style="padding: 30px; border-left: 1px solid; width: 50%;">    
    
    <p> <?php esc_html_e( 'Text color:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_usernmtc" name="wshk_usernmtc" value="<?php if(get_option('wshk_usernmtc')!=''){ echo get_option('wshk_usernmtc'); }?>" placeholder="#ffffff"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Text size:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" id="wshk_usernmts" name="wshk_usernmts" value="<?php if(get_option('wshk_usernmts')!=''){ echo get_option('wshk_usernmts'); }?>" placeholder="16"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Text align:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" id="wshk_usernmta" name="wshk_usernmta" value="<?php if(get_option('wshk_usernmta')!=''){ echo get_option('wshk_usernmta'); }?>" placeholder="center"/ size="20"><br /></p>
    <br /><br /></td>
    
    
    </tr>
    </table>
    <br />
    <br />
    </div>
    
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablelogoutbtn" name="wshk_enablelogoutbtn" value='12' <?php if(get_option('wshk_enablelogoutbtn')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablelogoutbtn></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display the Logout button', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Expand for Customize the style.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td style="padding: 30px;">
           
    <p> <?php esc_html_e( 'Button border (size):', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" name="wshk_logbtnbdsize" id="wshk_logbtnbdsize" value="<?php if(get_option('wshk_logbtnbdsize')!=''){ echo get_option('wshk_logbtnbdsize'); }?>" placeholder="1px" size="50" /></p>    
    <p> <?php esc_html_e( 'Button border (radius):', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" name="wshk_logbtnbdradius" id="wshk_logbtnbdradius" value="<?php if(get_option('wshk_logbtnbdradius')!=''){ echo get_option('wshk_logbtnbdradius'); }?>" placeholder="13%" size="50" /></p>    
    <p> <?php esc_html_e( 'Button border (type):', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_logbtnbdtype" id="wshk_logbtnbdtype" value="<?php if(get_option('wshk_logbtnbdtype')!=''){ echo get_option('wshk_logbtnbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="50" /></p>   
    <p> <?php esc_html_e( 'Button border (color):', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_logbtnbdcolor" id="wshk_logbtnbdcolor" value="<?php if(get_option('wshk_logbtnbdcolor')!=''){ echo get_option('wshk_logbtnbdcolor'); }?>" placeholder="#a46497" size="50" /></p>
    
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid;">         
    <p> <?php esc_html_e( 'Button text:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_logbtntext" id="wshk_logbtntext" value="<?php if(get_option('wshk_logbtntext')!=''){ echo get_option('wshk_logbtntext'); }?>" placeholder="<?php esc_html_e( "Logout", "woo-shortcodes-kit" ); ?>" size="50" /></p>
    <p> <?php esc_html_e( 'Button text-decoration:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_logbtntd" id="wshk_logbtntd" value="<?php if(get_option('wshk_logbtntd')!=''){ echo get_option('wshk_logbtntd'); }?>" placeholder="<?php esc_html_e( "none", "woo-shortcodes-kit" ); ?>" size="50" /></p>
    <p> <?php esc_html_e( 'Button text-align:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_logbtnta" id="wshk_logbtnta" value="<?php if(get_option('wshk_logbtnta')!=''){ echo get_option('wshk_logbtnta'); }?>" placeholder="<?php esc_html_e( "center", "woo-shortcodes-kit" ); ?>" size="50" /></p>
    <p> <?php esc_html_e( 'Button width:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" name="wshk_logbtnwd" id="wshk_logbtnwd" value="<?php if(get_option('wshk_logbtnwd')!=''){ echo get_option('wshk_logbtnwd'); }?>" placeholder="100px" size="50" /></p>
    
    <br /><br />
    </td>                    
    
    </tr>
    </table>
    <br />
    <br />
    
    <div style="padding: 30px;">
        
            <p><?php esc_html_e( 'By default the logout button will redirect the users to the WooCommerce my account page, but you can change it for your custom page.', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'Just need write the custom page slug to redirect the users after the logout:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_btnlogoutredi" id="wshk_btnlogoutredi" value="<?php if(get_option('wshk_btnlogoutredi')!=''){ echo get_option('wshk_btnlogoutredi'); }?>" placeholder="<?php esc_html_e( "custom-page-slug", "woo-shortcodes-kit" ); ?>" size="70" /><small><?php esc_html_e( 'Use it if you are building your own myaccount page and want redirect the user to a specific page after the logout.', 'woo-shortcodes-kit' ); ?></small></p>    
    
    
    <br /><br />
        
    </div>
    
    </div>
    
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enableloginform" name="wshk_enableloginform" value='13' <?php if(get_option('wshk_enableloginform')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enableloginform></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for Display the Login form', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Expand for Customize the after login redirection.', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br /><table>
    <tr>
    <td style="padding: 30px;">
           
    <p><?php esc_html_e( 'Write the custom page slug to redirect the users after the login:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_loginredi" id="wshk_loginredi" value="<?php if(get_option('wshk_loginredi')!=''){ echo get_option('wshk_loginredi'); }?>" placeholder="<?php esc_html_e( "custom-account-page", "woo-shortcodes-kit" ); ?>" size="70" /><small><?php esc_html_e( 'Use it if you are building your own myaccount page or want redirect the user to a specific page after the login.', 'woo-shortcodes-kit' ); ?></small></p>    
    
    
    <br /><br />
    </td> 
     <!--<td style="padding: 30px; border-left: 1px solid;">         
    <p><?php esc_html_e( 'Write the custom page slug to Redirect the not logged in users, if try to access to myaccount page:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_blockmya" id="wshk_blockmya" value="<?php if(get_option('wshk_blockmya')!=''){ echo get_option('wshk_blockmya'); }?>" placeholder="<?php esc_html_e( "my-login", "woo-shortcodes-kit" ); ?>" size="50" /><small><?php esc_html_e( 'Use it if you are building your own myaccount page and want to Block the access to myaccount page to not logged in users', 'woo-shortcodes-kit' ); ?></small></p>
    
    
    <br /><br />
    </td>-->               
    
    </tr>
    </table>
    <br />
    <br />
    </div>
      </div>
    </li>
    
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 24px;margin-top: 25px;"><span class="dashicons dashicons-menu"></span> <?php esc_html_e( 'CUSTOMIZE THE MENU', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablecustomenu" name="wshk_enablecustomenu" value='17' <?php if(get_option('wshk_enablecustomenu')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablecustomenu></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for display a custom menu for logged in users and other for non logged in users', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Expand to write the menu name for each case', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><?php esc_html_e( 'Write the menu location where you want apply the changes:', 'woo-shortcodes-kit' ); ?><br /><br /> 


<input type="text" name="wshk_menulocation" id="wshk_menulocation" value="<?php if(get_option('wshk_menulocation')!=''){ echo get_option('wshk_menulocation'); }?>" placeholder="<?php esc_html_e( "Write the menu location here", "woo-shortcodes-kit" ); ?>" size="60" /><small><?php esc_html_e( 'Locations examples:', 'woo-shortcodes-kit' ); ?> <strong>primary</strong> | <strong>secondary</strong> | <strong>top</strong></small></p>
<br /><br />
<table>
    <tr>
    <td style="padding: 30px;">
           
    <p><?php esc_html_e( 'Write the name of the menu for logged in users:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_logmenu" id="wshk_logmenu" value="<?php if(get_option('wshk_logmenu')!=''){ echo get_option('wshk_logmenu'); }?>" placeholder="<?php esc_html_e( "Write the menu name", "woo-shortcodes-kit" ); ?>" size="60" /><small><?php esc_html_e( 'You need make first your custom menu in Appearance > Menus.', 'woo-shortcodes-kit' ); ?></small></p>    
    
    
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid;">         
    <p><?php esc_html_e( 'Write the name of the menu for non logged in users:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="text" name="wshk_nonlogmenu" id="wshk_nonlogmenu" value="<?php if(get_option('wshk_nonlogmenu')!=''){ echo get_option('wshk_nonlogmenu'); }?>" placeholder="<?php esc_html_e( "Write the menu name", "woo-shortcodes-kit" ); ?>" size="60" /><small><?php esc_html_e( 'You need make first your custom menu in Appearance > Menus.', 'woo-shortcodes-kit' ); ?></small></p>
    
    
    <br /><br />
    </td>                    
    
    </tr>
    </table>
    <br />
    <br />
    </div>
    
    
    
    
    
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enableshtmenu" name="wshk_enableshtmenu" value='18' <?php if(get_option('wshk_enableshtmenu')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enableshtmenu></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for let add shortcodes in the menu items titles', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'You can combine this function with the others of the same category.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <br />
    </div>
    
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enableuserinmenu" name="wshk_enableuserinmenu" value='19' <?php if(get_option('wshk_enableuserinmenu')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enableuserinmenu></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for display the username in the menu', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate and paste the shortcode in your menu item title!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"> <table>
    <tr>
        <table>
    <tr>
    <td style="padding: 30px; width: 50%; text-align: center;">
        <p><?php esc_html_e( 'The special shortcode for this function is:', 'woo-shortcodes-kit' ); ?>
        <center><span style="font-size: 18px;"><strong>[wshk_user_in_menu]</strong></span></center>
        
        </td>
        
         <td style="padding: 30px; border-left: 1px solid;">   <br /><br /><br />  <small><span style="color: red;"><?php esc_html_e( 'Copy the Shortcode and Paste in your menu item title', 'woo-shortcodes-kit' ); ?></small></span> <br /><br /> <small><?php esc_html_e( 'For display the username in other sites, check the Shortcodes section and look for display user name.', 'woo-shortcodes-kit' ); ?></small></p>
    <br />
    <br />
    
    
    </td> 
</tr>
</table>
    </div>
      </div>
    </li>
    
    
    <li>
     
       <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 24px;"><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'ADD LOGIN SECURITY & RESTRICT CONTENT', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablesloginsec" name="wshk_enablesloginsec" value='20' <?php if(get_option('wshk_enablesloginsec')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablesloginsec></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for block the access to the wp-admin and wp-login.php', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'After active this function nobody will can access to the wp-admin or wp-login.php, and will be redirected to the login form page.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <br />
    </div>
    
    
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablesadminbar" name="wshk_enablesadminbar" value='21' <?php if(get_option('wshk_enablesadminbar')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablesadminbar></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for block the access to the backend from top admin bar for non admin users', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'After active this function nobody will can access to the backend from top admin bar, because will be hide.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <br />
    </div>
    
    
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enablerestrictctnt" name="wshk_enablerestrictctnt" value='22' <?php if(get_option('wshk_enablerestrictctnt')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enablerestrictctnt></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for restrict custom content for non logged in users', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and use the restrict content shortcode!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'If you are building your custom my account page or want hide any content for non logged in users, use this Shortcode:
', 'woo-shortcodes-kit' ); ?> <br /><br /><strong>[wshk]</strong><?php esc_html_e( 'Put here the content that you want restrict, can be shortcodes too
', 'woo-shortcodes-kit' ); ?> <strong>[/wshk]</strong></p>
    <br />
    <br />
    </div>
    
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" id="wshk_enableoffctnt" name="wshk_enableoffctnt" value='23' <?php if(get_option('wshk_enableoffctnt')!=''){ echo ' checked="checked"'; }?>/><label for=wshk_enableoffctnt></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Enable for restrict custom content for logged in users', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and use the off content shortcode!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'If you want hide any content for logged in users and show only for non logged in users, use this Shortcode:
', 'woo-shortcodes-kit' ); ?> <br /><br /><strong>[off]</strong><?php esc_html_e( 'Put here the content that you want hide for logged in users, can be shortcodes too
', 'woo-shortcodes-kit' ); ?> <strong>[/off]</strong></p>
    <br />
    <br />
    </div>
    
    
      </div>
    </li>
    
    
    <?php
    // Since 1.6.6
    //CHECK IF EASY MY ACCOUNT BUILDER EXIST
    
    if ( in_array( 'easy-myaccount-builder/easy-myaccount-builder-for-wshk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
       include( ABSPATH . '/wp-content/plugins/easy-myaccount-builder/emab-settings.php' );


        }
    ?>
    
    <!--<li>
      <button class="acc_ctrl"><h2>Toyota</h2></button>
      <div class="acc_panel">
        <p>Toyota Motor Corporation is a Japanese automotive manufacturer which was founded by Kiichiro Toyoda in 1937 as a spinoff from his father's company Toyota Industries, which is currently headquartered in Toyota, Aichi Prefecture, Japan.</p>
      </div>
    </li>-->
    
    
  </ul>
</div>

<!--TOGGLE PRINCIPAL-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>$(function() {
  $('.acc_ctrl').on('click', function(e) {
    e.preventDefault();
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).next()
      .stop()
      .slideUp(300);
    } else {
      $(this).addClass('active');
      $(this).next()
      .stop()
      .slideDown(300);
    }
  });
});</script>
    
<!--FIN DE LA CAJA BLANCA-->
    </div>
    
    
    
   
    <br />
    <br />
    <br />
    <br />
        
        <center><button class="probando" type="submit" id="toggle" onclick="click()"><?php esc_html_e( 'SAVE SETTINGS', 'woo-shortcodes-kit' ); ?></button></center>
    <?php settings_fields('wshk_options');?>
    
    
    </form>

<!-- End Options Form -->

   
   </div>
   <!-- Support -->
    
    <div class="last author wshk-tab" id="div-wshk-support">
    &nbsp;
   
    
     <!-- caja info ajustes -->
        
         <div style="background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Shortcodes Panel', 'woo-shortcodes-kit' ); ?></span></h2>
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Hover the elements to see the shortcodes.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Copy the shortcode and paste where you want.', 'woo-shortcodes-kit' ); ?></span></small><small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(Some shortcodes need enable his function to work)', 'woo-shortcodes-kit' ); ?></span></small></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
    
     <!--NUEVO PANEL -->
 
    &nbsp;
    <style>
    .featured .featured-columns .item {
  height: 230px;
  background-size: cover;
  position: relative;
  cursor: pointer;
  margin: 10px;
  width: 30%;
  float:left;
  border: 1px solid #a46497;
  border-radius: 13px;
}
.featured .featured-columns .item .widget-title {
  text-align: center;
  color: white;
  position: relative;
  top: 50px;
  font-weight: 700;
}
.featured .featured-columns .item .textwidget {
  background-color: white;
  position: absolute;
  top: 0;
  width: 100%;
  height: 170px;
  padding: 30px 0px;
  opacity: 0;
  -webkit-transition: opacity 0.3s ease-in-out;
  -moz-transition: opacity 0.3s ease-in-out;
  -ms-transition: opacity 0.3s ease-in-out;
  -o-transition: opacity 0.3s ease-in-out;
  transition: opacity 0.3s ease-in-out;
  box-shadow: 1px 1px 12px #ccc;
  border: 1px solid white;
  border-radius: 13px;
}
.featured .featured-columns .item:hover .textwidget,
.featured .featured-columns .item:focus .textwidget {
  opacity: 1;
}


	.featured .featured-columns .item[data-badge]:after {
		content:attr(data-badge);
		position:absolute;
		top:-10px;
		right:-10px;
		font-size:.7em;
		background:#aadb4a;
		color:white;
		width:40px;height:18px;
		text-align:center;
		line-height:18px;
		border-radius:13px;
		box-shadow:0 0 1px #333;
		letter-spacing: 1px;
		padding: 5px;
	}
	



    </style>
    
    
    <div class='featured'>
        
       <style>
           
           .wshkrow {
    /*margin: 10px -16px;*/
}

/* Add padding BETWEEN each column */
.wshkrow,
.wshkrow > .wshkcolumn {
    /*padding: 8px;*/
}

/* Create three equal columns that floats next to each other */
.wshkcolumn {
    /*float: left;
    width: 33.33%;*/
    display: none; /* Hide all elements by default */
}

/* Clear floats after rows */ 
.wshkrow:after {
    content: "";
    display: table;
    clear: both;
}

/* Content */
.wshkcontent {
    /*background-color: white;
    padding: 10px;*/
}

/* The "show" class is added to the filtered elements */
.wshkshow {
  display: block;
}

/* Style the buttons */
.wshkbtn {
  border: 1px solid #c6adc2;
  border-radius: 13px;
  outline: none;
  padding: 12px 16px;
  background-color: #c6adc2;
  color: white;
  cursor: pointer;
  margin-right: 10px;
  text-transform: uppercase;
}

.wshkbtn:hover {
  background-color: #a46497;
  color: white;
}

.wshkbtn.wshkactive {
  background-color: #a46497;
  color: white;
  border:1px solid #a46497;
  border-radius: 13px;
}
           
       </style>
<div id="myBtnContainer">
  <!--<button class="wshkbtn wshkactive" onclick="filterSelection('all')"> Show all</button>
  <button class="wshkbtn" onclick="filterSelection('myaccount')"> Build myaccount</button>
  <button class="wshkbtn" onclick="filterSelection('counters')"> counters</button>
  <button class="wshkbtn" onclick="filterSelection('addons')"> addons</button>-->
  <br />
  
  <a href="#" class="wshkbtn wshkactive" onclick="filterSelection('all')"><?php esc_html_e( 'Show all', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" onclick="filterSelection('myaccount')"><?php esc_html_e( 'Build my account', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" onclick="filterSelection('counters')"><?php esc_html_e( 'Counters', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" style="margin-left: 4px;" onclick="filterSelection('addons')"><?php esc_html_e( 'Addons', 'woo-shortcodes-kit' ); ?></a>
  <br />
  
</div>
            
<div class="featured-columns panel-widget-style">
    <div id="pl-w57502fd8c7513">
        <div class="panel-grid" id="pg-w57502fd8c7513-0">
            
            <div class="wshkrow">
            <br />
            <br />
             <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/orderslist.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Orders list', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show user the purchase my-orders table, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_myorders]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/globalsales.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Global sales', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the global sales/downloads counter use this shortcode:', 'woo-shortcodes-kit' ); ?> <br /><br /><small>[woo_global_sales]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
           
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/totalproducts.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total Products counter', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total products on any page or post, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_product_count]</small><br /><p><small><span style="color: #666666"><?php esc_html_e( 'if you want exclude any category use:', 'woo-shortcodes-kit' ); ?></span><span style="color: #808080">[woo_total_product_count cat_id="<?php esc_html_e( 'here the category ID number', 'woo-shortcodes-kit' ); ?>"]</span></small></p></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
                    
              <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/olddownloadslist.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Downloads list', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show user the downloads table, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_mydownloads]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/bought.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Bought products', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                 <h3><center><?php esc_html_e( 'If you want show user the products that have bought, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_bought_products]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/gravatarthumb.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Gravatar image', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the user Gravatar image, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_gravatar_image]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/woototalproductsbyuser.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total products by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total bought products by user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_bought_products]</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/woototalordersbyuser.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total orders by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total orders made by user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_customer_total_orders]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/rwcounter.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total reviews by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total reviews made by a user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_count_reviews]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/cstmreviews.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Reviews by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the products reviews made by a user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_review_products]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                    
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/display-the-reviews.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Display Reviews', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the products reviews made by all the users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_display_reviews]</small></center></h3>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/newusernm.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Username', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the username in any page or post, use this shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_user_name]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/woomessage.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Message by Orders', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show a message if the user made a number of orders, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_message]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/newmyadd.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Addresses', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the customer billing & shipping address in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_myaddress]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/mypaym.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Payments methods', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the customer payment methods saved in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_mypayment]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/edit-account-form.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Edit account form', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the customer edit account form in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_myedit_account]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/newmydash.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Dashboard', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the my-account dashboard in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_mydashboard]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/logout-nutton.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Logout button', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the Logout button in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_logout_button]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
                        <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/login-form.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Login form', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you are building your custom my account page and want display the Login form for non logged in users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_login_form]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/hidecontent.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Restrict content', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you are building your custom my account page or want hide any content for non logged in users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[wshk] [/wshk]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/hideye.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Hide content', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want hide any content for logged in users and display only for non logged in users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[off] [/off]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/comingsoon.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Coming soon...', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'New functions will be added in the nexts updates', 'woo-shortcodes-kit' ); ?></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- div del row -->
            </div>
            
            </div>


        </div>
    </div>
</div>

<script>
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("wshkcolumn");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "wshkshow");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "wshkshow");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var wbtnContainer = document.getElementById("myBtnContainer");
var wbtns = wbtnContainer.getElementsByClassName("wshkbtn");
for (var i = 0; i < wbtns.length; i++) {
  wbtns[i].addEventListener("click", function(){
    var wcurrent = document.getElementsByClassName("wshkactive");
    wcurrent[0].className = wcurrent[0].className.replace(" wshkactive", "");
    this.className += " wshkactive";
  });
}
</script>


 
 <!-- FIN NUEVO PANEL -->
   


   
    </div>
    
    
    </div>

    <!-- Contact -->
    
    

</div>
<div class="last wshk-tab" id="div-wshk-contact">
    
    <div style="width: 90%; padding: 10px; margin: 10px;">
   
    
    
         <!-- caja info ajustes -->
        
         <div style="background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Help & Support!', 'woo-shortcodes-kit' ); ?></span></h2>
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Just need hover the items and do 1 click in the white text.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><!--<span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Just need hover the items and do 1 click in the white text.', 'woo-shortcodes-kit' ); ?></span>--></small><!--<small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(Some shortcodes need enable his function to work)', 'woo-shortcodes-kit' ); ?></span></small>--></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
    <style>
    @import url(https://fonts.googleapis.com/css?family=Graduate|Oleo+Script);

mbody {
  margin-top: 5em;
  text-align: center;
  color: #414142;
  background: rgb(246,241,232);
  background: -moz-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%, rgba(212,204,186,1) 100%);
  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(39%,rgba(246,241,232,1)), color-stop(100%,rgba(212,204,186,1)));
  background: -webkit-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  background: -o-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  background: -ms-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  background: radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f1e8', endColorstr='#d4ccba',GradientType=1 );
}

a {
  color: #414142;
  font-style: normal;
  text-decoration: none;
  
}

a:hover {
  text-decoration: none;
}

.container {
  display: block;
  margin: 0 auto;
  width: 100%;
}
  
  #information {
    color: red;
    font-size: 14px;
  }
  
  .wrapper {
    display: inline-block;
    width: 310px;
    height: 100px;
    vertical-align: top;
    margin: 1em 1.5em 2em 0;
    cursor: pointer;
    position: relative;
    font-family: Tahoma, Arial;
    -webkit-perspective: 4000px;
       -moz-perspective: 4000px;
        -ms-perspective: 4000px;
         -o-perspective: 4000px;
            perspective: 4000px;
  }
  
  .mitem {
    height: 40px;
      -webkit-transform-style: preserve-3d;
         -moz-transform-style: preserve-3d;
          -ms-transform-style: preserve-3d;
           -o-transform-style: preserve-3d;
              transform-style: preserve-3d;
      -webkit-transition: -webkit-transform .6s;
         -moz-transition: -moz-transform .6s;
          -ms-transition: -ms-transform .6s;
           -o-transition: -o-transform .6s;
              transition: transform .6s;
  }
  
    .mitem:hover {
      -webkit-transform: translateZ(-50px) rotateX(95deg);
         -moz-transform: translateZ(-50px) rotateX(95deg);
          -ms-transform: translateZ(-50px) rotateX(95deg);
           -o-transform: translateZ(-50px) rotateX(95deg);
              transform: translateZ(-50px) rotateX(95deg);
    }
    
      .mitem:hover img {
        box-shadow: none;
        border-radius: 15px;
      }
      
      .mitem:hover .information {
        #box-shadow: 0px 3px 8px rgba(0,0,0,0.3);
        border-radius: 3px;
      }

    .mitem img {
      display: block;
      #position: absolute;
      top: 0;
      border-radius: 3px;
      
      -webkit-transform: translateZ(50px);
         -moz-transform: translateZ(50px);
          -ms-transform: translateZ(50px);
           -o-transform: translateZ(50px);
              transform: translateZ(50px);
      -webkit-transition: all .6s;
         -moz-transition: all .6s;
          -ms-transition: all .6s;
           -o-transition: all .6s;
              transition: all .6s;
      
    }
    
    
    
    .mitem .information {
      display: block;
      position: absolute;
      top: 0;
      height: 70px;
      width: 290px;
      text-align: left;
      border-radius: 15px;
      padding: 0px;          
      font-size: 12px;
      #text-shadow: 1px 1px 1px rgba(255,255,255,0.5);
      box-shadow: none;
      background: #a46497;
      
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ecf1f4', endColorstr='#becad9',GradientType=0 );
      -webkit-transform: rotateX(-90deg) translateZ(50px);
         -moz-transform: rotateX(-90deg) translateZ(50px);
          -ms-transform: rotateX(-90deg) translateZ(50px);
           -o-transform: rotateX(-90deg) translateZ(50px);
              transform: rotateX(-90deg) translateZ(50px);
      -webkit-transition: all .6s;
         -moz-transition: all .6s;
          -ms-transition: all .6s;
           -o-transition: all .6s;
              transition: all .6s;
      
    }
    
      .information strong {
        display: block;
        margin: .4em 0 .5em 0;
        font-size: 20px;
        color: #ffffff;
        background: #a46497;
        
        
      }
      

    </style>
     <div id="container" class="container" style="width: 100%;">
   <table>
   <tr>
   <td>
    <h1 style="display: none;">CAN ADD A TITLE HERE</h1>
    
    <div class="wrapper">
      <div class="mitem">
      <p style="font-size: 26px; color: #a46497;"><span class="dashicons dashicons-email-alt" style="font-size: 48px; color: #a46497; padding-right: 50px; margin-top: -2px;" ></span><?php esc_html_e( 'CONTACT', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Need help or have ideas to add?', 'woo-shortcodes-kit' ); ?></strong></span></p>
        
        <span class="information">
        
          <center><a href="https://disespubli.com/contact/" style="padding: 20px;" target="_blank"><strong><?php esc_html_e( 'SEND A MESSAGE!', 'woo-shortcodes-kit' ); ?></strong></a></center>
        </span>
      </div>
    </div>
    
    <div class="wrapper">
      <div class="mitem">
         <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-update" style="font-size: 48px; color: #a46497; padding-right: 50px; margin-top: -2px;" ></span><?php esc_html_e( 'CHANGELOG', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Want check the new changes?', 'woo-shortcodes-kit' ); ?></strong></span></p>
         
        <span class="information">
        
          <center><a href="https://disespubli.com/changelog-wshk/" style="padding: 20px;" target="_blank"><strong><?php esc_html_e( 'CHECK NOW!', 'woo-shortcodes-kit' ); ?></strong></a></center>
        </span>
      </div>
    </div>
    
    <div class="wrapper">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-media-document" style="font-size: 48px; color: #a46497; padding-right: 50px; margin-top: -2px;" ></span><?php esc_html_e( 'DOCUMENTATION', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Know all about how work WSHK!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><a href="https://disespubli.com/documentation/" style="padding: 20px;" target="_blank"><strong><?php esc_html_e( 'VIEW DOC!', 'woo-shortcodes-kit' ); ?></strong></a></center>
        </span>
      </div>
    </div>
    
    <div class="wrapper">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-admin-site" style="font-size: 48px; color: #a46497; padding-right: 50px; margin-top: -2px;" ></span><?php esc_html_e( 'THE WEB', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Want know more about WSHK?', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><a href="https://disespubli.com/" style="padding: 20px;" target="_blank"><strong><?php esc_html_e( 'VISIT NOW!', 'woo-shortcodes-kit' ); ?></strong></a></center>
        </span>
      </div>
    </div>
    <div class="wrapper">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-facebook" style="font-size: 48px; color: #a46497; padding-right: 50px; margin-top: -2px;" ></span><?php esc_html_e( 'THE FANPAGE', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Follow all the next news!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><a href="https://www.facebook.com/disespubli/" style="padding: 20px;" target="_blank"><strong><?php esc_html_e( 'FOLLOW THE NEWS!', 'woo-shortcodes-kit' ); ?></strong></a></center>
        </span>
      </div>
    </div>
    <div class="wrapper">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-star-half" style="font-size: 48px; color: #a46497; padding-right: 50px; margin-top: -2px;" ></span><?php esc_html_e( 'RATE IT!', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Help to follow growing!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><a href="https://wordpress.org/support/plugin/woo-shortcodes-kit/reviews/#new-post" style="padding: 20px;" target="_blank"><strong><?php esc_html_e( 'ADD YOUR REVIEW!', 'woo-shortcodes-kit' ); ?></strong></a></center>
        </span>
      </div>
    </div>
    </td>
    <td style="width: 25%">
    <br />
    <br />
    <br />
    
    <center><h3 style="color: grey;"><small><?php esc_html_e( 'DISCOVER THE POWER OF WSHK!', 'woo-shortcodes-kit' ); ?></small></h3></center>
    <br />
    <div style="background: #a46497; border: 1px solid #a46497; border-radius: 3px; height: auto; padding: 15px;">
<center><img src="<?php echo  plugins_url( 'images/play-button.png', __FILE__ );?>" width="64" height="64" /></center>
<center><a  href="https://youtu.be/3vFby7eMe3E" target="_blank" style="text-align: center;"><span style="color: white; font-size: 16px; "><strong><?php esc_html_e( 'Build your own', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'myaccount page!', 'woo-shortcodes-kit' ); ?></strong></span></a></center>
</div>
    <br />
    <div style="background: #a46497; border: 1px solid #a46497; border-radius: 3px; height: auto; padding: 15px;">
<center><img src="<?php echo  plugins_url( 'images/play-button.png', __FILE__ );?>" width="64" height="64" /></center>
<center><a  href="https://disespubli.com/#!/functions" target="_blank" style="text-align: center;"><span style="color: white; font-size: 16px; "><strong><?php esc_html_e( 'Learn how work', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'all the functions!', 'woo-shortcodes-kit' ); ?></strong></span></a></center>
</div>
    
    <br />          
    

    </td>
    </tr>
    </table>
   </div> 
   
  </div>      
    

</div>

<?php
}
endif;

/** add js into admin footer */
// better use get_current_screen(); or the global $current_screen

if (isset($_GET['page']) && $_GET['page'] == 'woo-shortcodes-kit') {
   add_action('admin_footer','init_wshk_admin_scripts');
}

if(!function_exists('init_wshk_admin_scripts')):
function init_wshk_admin_scripts()
{
wp_register_style( 'wshk_admin_style', plugins_url( 'css/wshk-admin-min.css',__FILE__ ) );
wp_enqueue_style( 'wshk_admin_style' );

echo $script='<script type="text/javascript">
    /* Protect WP-Admin js for admin */
    jQuery(document).ready(function(){
        jQuery(".wshk-tab").hide();
        jQuery("#div-wshk-general").show();
        jQuery(".wshk-tab-links").click(function(){
        var divid=jQuery(this).attr("id");
        jQuery(".wshk-tab-links").removeClass("active");
        jQuery(".wshk-tab").hide();
        jQuery("#"+divid).addClass("active");
        jQuery("#div-"+divid).fadeIn();
        });
        })
    </script>';
}
endif;

/** register_deactivation_hook */
/** Delete exits options during deactivation the plugins */

if( function_exists('register_deactivation_hook') ){
   register_deactivation_hook(__FILE__,'init_deactivation_wshk_plugins');   
}

//Delete all options after uninstall the plugin

if(!function_exists('init_deactivation_wshk_plugins')):
function init_deactivation_wshk_plugins(){
    delete_option('wshk_enable');
    delete_option('wshk_text');
    delete_option('wshk-inlinecss');
    delete_option('wshk_test');
    delete_option('wshk_min');
    delete_option('wshk_perpage');
    delete_option('wshk_nperpage');
    delete_option('wshk_enablecat');
    delete_option('wshk_firstcat');
    delete_option('wshk_secondcat');
    delete_option('wshk_thirdcat');
    delete_option('wshk_enablebought');
    delete_option('wshk_buttontext');
    delete_option('wshk_enablectbp');
    delete_option('wshk_textprefix');
    delete_option('wshk_textsuffix');
    delete_option('wshk_textpsuffix');
    delete_option('wshk_textnobp');
    delete_option('wshk_enablectbo');
    delete_option('wshk_tordersprefix');
    delete_option('wshk_torderssuffix');
    delete_option('wshk_torderspsuffix');
    delete_option('wshk_textnobo');
    delete_option('wshk_alignthereviews');
    delete_option('wshk_aligntheorders');
    delete_option('wshk_aligntheproducts');
    delete_option('wshk_enablewmessage');
    delete_option('wshk_wmorders');
    delete_option('wshk_textwmssg');
    delete_option('wshk_textsales');
    delete_option('wshk_minsales');
    delete_option('wshk_nonotice');
    delete_option('wshk_morenotice');
    delete_option('wshk_enablereviews');
    delete_option('wshk_textavsize');
    delete_option('wshk_textavbdsize');
    delete_option('wshk_textavbdradius');
    delete_option('wshk_textavbdtype');
    delete_option('wshk_textavbdcolor');
    delete_option('wshk_texttbwsize');
    delete_option('wshk_textbxfsize');
    delete_option('wshk_textbxbdsize');
    delete_option('wshk_textbxbdradius');
    delete_option('wshk_textbxbdtype');
    delete_option('wshk_textbxbdcolor');
    delete_option('wshk_textbxfsize');
    delete_option('wshk_textbxbdsize');
    delete_option('wshk_textbxbdradius');
    delete_option('wshk_textbxbdtype');
    delete_option('wshk_textbxbdcolor');
    delete_option('wshk_textbxbgcolor');
    delete_option('wshk_textbtnbdsize');
    delete_option('wshk_textbtnbdradius');
    delete_option('wshk_textbtnbdtype');
    delete_option('wshk_textbtnbdcolor');
    delete_option('wshk_textbtntarget');
    delete_option('wshk_textbtntxd');
    
    
    delete_option('wshk_enabledisplayreviews');
    delete_option('wshk_disretextavsize');
    delete_option('wshk_disretextavbdsize');
    delete_option('wshk_disretextavbdradius');
    delete_option('wshk_disretextavbdtype');
    delete_option('wshk_disretextavbdcolor');
    delete_option('wshk_disretexttbwsize');
    delete_option('wshk_disretextbxfsize');
    delete_option('wshk_disretextmargintop');
    delete_option('wshk_disretextbxbdsize');
    delete_option('wshk_disretextbxbdradius');
    delete_option('wshk_disretextbxbdtype');
    delete_option('wshk_disretextbxbdcolor');
    delete_option('wshk_disretextbxbgcolor');
    delete_option('wshk_disretextbxpadding');
    delete_option('wshk_disretextbxminheight');
    
    delete_option('wshk_disretextlinktarget');
    delete_option('wshk_disretextlinktxd');
    delete_option('wshk_disretextlinktxtsize');
    delete_option('wshk_disretextlinktxtcolor');
    
    delete_option('wshk_disredisplaynumber');
    delete_option('wshk_disrecolumnsnumber');
    
    
    
    
    
    delete_option('wshk_enablerwcounter');
    delete_option('wshk_treviewprefix');
    delete_option('wshk_treviewsuffix');
    delete_option('wshk_treviewpsuffix');
    delete_option('wshk_textnoreview');
    delete_option('wshk_enableusername');
    delete_option('wshk_usernmtc');
    delete_option('wshk_usernmts');
    delete_option('wshk_usernmta');
    delete_option('wshk_enablelogoutbtn');
    delete_option('wshk_logbtnbdsize');
    delete_option('wshk_logbtnbdradius');
    delete_option('wshk_logbtnbdtype');
    delete_option('wshk_logbtnbdcolor');
    delete_option('wshk_logbtntd');
    delete_option('wshk_logbtnta');
    delete_option('wshk_logbtnwd');
    delete_option('wshk_logbtntext');
    delete_option('wshk_enableloginform');
    delete_option('wshk_loginredi');
    delete_option('wshk_blockmya');
    delete_option('wshk_enableaddtocarttxt');
    delete_option('wshk_atctxtexternal');
    delete_option('wshk_atctxtgrouped');
    delete_option('wshk_atctxtsimple');
    delete_option('wshk_atctxtvariable');
    /*delete_option('wshk_atctxtntin');*/
    delete_option('wshk_textbxpadding');
    delete_option('wshk_textbtntxt');
    delete_option('wshk_avshadow');
    delete_option('wshk_textusernmpf');
    delete_option('wshk_textusernmsf');
    delete_option('wshk_enablegravatar');
    delete_option('wshk_textgravasize');
    delete_option('wshk_textgravashd');
    delete_option('wshk_textgravabdsz');
    delete_option('wshk_textgravabdtp');
    delete_option('wshk_textgravabdcl');
    delete_option('wshk_textgravabdrd');
    delete_option('wshk_emailordersizes');  
    delete_option('wshk_enablesloginsec'); 
    delete_option('wshk_enablesadminbar');
    delete_option('wshk_enablerestrictctnt');
    delete_option('wshk_enableoffctnt');
    delete_option('wshk_btnlogoutredi');
    
    delete_option('wshk_enablesemab');
    
    delete_option('wshk_enablescontntdash');
    delete_option('wshk_editdashb');
    delete_option('wshk_editaftdashb');
    
    delete_option('wshk_enablescontntord');
    delete_option('wshk_editorde');
    delete_option('wshk_editaftorde');
    
    delete_option('wshk_enablescontntdow');
    delete_option('wshk_editdown');
    delete_option('wshk_editaftdown');
    
    delete_option('wshk_enablescontntadd');
    delete_option('wshk_editaddre');
    delete_option('wshk_editaftaddre');
    
    delete_option('wshk_enablescontntpay');
    delete_option('wshk_editpaym');
    delete_option('wshk_editaftpaym');
    
    delete_option('wshk_enablescontntrev');
    delete_option('wshk_editrevi');
    delete_option('wshk_editaftrevi');
    
    delete_option('wshk_enablescontntedi');
    delete_option('wshk_editedit');
    delete_option('wshk_editaftedit');
    
    delete_option('wshk_enablescontntlog');
    delete_option('wshk_editlogo');
    delete_option('wshk_editaftlogo');
    
    delete_option('wshk_tabsbdsize');
    delete_option('wshk_tabsbdtype');
    delete_option('wshk_tabsbdcolor');
    delete_option('wshk_tabsbdradius');
    
    delete_option('wshk_tabspdtop');
    delete_option('wshk_tabspdright');
    delete_option('wshk_tabspdbottom');
    delete_option('wshk_tabspdleft');
    
    delete_option('wshk_tabstxtsize');
    delete_option('wshk_tabstxtcolor');
    delete_option('wshk_tabstxtalign');
    delete_option('wshk_tabstxtdeco');
    
    delete_option('wshk_tabsbgcolor');
    delete_option('wshk_tabswdsize');
    delete_option('wshk_tabshgsize');
    
    
    delete_option('wshk_actabsbdsize');
    delete_option('wshk_actabsbdtype');
    delete_option('wshk_actabsbdcolor');
    delete_option('wshk_actabsbdradius');
    
    delete_option('wshk_actabstxtcolor');
    delete_option('wshk_actabstxtdeco');
    
    delete_option('wshk_actabsbgcolor');
    
    delete_option('wshk_hotabsbdsize');
    delete_option('wshk_hotabsbdtype');
    delete_option('wshk_hotabsbdcolor');
    delete_option('wshk_hotabsbdradius');
    
    delete_option('wshk_hotabstxtcolor');
    delete_option('wshk_hotabstxtdeco');
    
    delete_option('wshk_hotabsbgcolor');
    
    delete_option('wshk_contbbdsize');
    delete_option('wshk_contbbdtype');
    delete_option('wshk_contbbdcolor');
    delete_option('wshk_contbbdradius');
    
    delete_option('wshk_contbpdtop');
    delete_option('wshk_contbpdright');
    delete_option('wshk_contbpdbottom');
    delete_option('wshk_contbpdleft');
    
    delete_option('wshk_contbctheight');
    delete_option('wshk_contbctbgcolor');
    
    delete_option('wshk_keeplastab');
    
    delete_option('wshk_menulocation');
    
    delete_option('wshk_icondashb');
    delete_option('wshk_iconorder');
    delete_option('wshk_icondownl');
    delete_option('wshk_iconaddre');
    delete_option('wshk_iconpayme');
    delete_option('wshk_iconrevie');
    delete_option('wshk_iconedita');
    delete_option('wshk_iconlogou');
    
    
    
    
    
    
    
}
endif;

/** register_activation_hook */
/** Delete exits options during activation the plugins */

if( function_exists('register_activation_hook') ){
   register_activation_hook(__FILE__,'init_activation_wshk_plugins');   
}

//Disable free version after activate the plugin

if(!function_exists('init_activation_wshk_plugins')):
function init_activation_wshk_plugins(){
    delete_option('wshk_enable');
    delete_option('wshk_text');
    delete_option('wshk-inlinecss');
    delete_option('wshk_test');
    delete_option('wshk_min');
    delete_option('wshk_perpage');
    delete_option('wshk_nperpage');
    delete_option('wshk_enablecat');
    delete_option('wshk_firstcat');
    delete_option('wshk_secondcat');
    delete_option('wshk_thirdcat');
    delete_option('wshk_enablebought');
    delete_option('wshk_buttontext');
    delete_option('wshk_enablectbp');
    delete_option('wshk_textprefix');
    delete_option('wshk_textsuffix');
    delete_option('wshk_textpsuffix');
    delete_option('wshk_textnobp');
    delete_option('wshk_enablectbo');
    delete_option('wshk_tordersprefix');
    delete_option('wshk_torderssuffix');
    delete_option('wshk_torderspsuffix');
    delete_option('wshk_textnobo');
    delete_option('wshk_alignthereviews');
    delete_option('wshk_aligntheorders');
    delete_option('wshk_aligntheproducts');
    delete_option('wshk_enablewmessage');
    delete_option('wshk_wmorders');
    delete_option('wshk_textwmssg');
    delete_option('wshk_textsales');
    delete_option('wshk_minsales');
    delete_option('wshk_nonotice');
    delete_option('wshk_morenotice');
    delete_option('wshk_enablereviews');
    delete_option('wshk_textavsize');
    delete_option('wshk_textavbdsize');
    delete_option('wshk_textavbdradius');
    delete_option('wshk_textavbdtype');
    delete_option('wshk_textavbdcolor');
    delete_option('wshk_texttbwsize');
    delete_option('wshk_textbxfsize');
    delete_option('wshk_textbxbdsize');
    delete_option('wshk_textbxbdradius');
    delete_option('wshk_textbxbdtype');
    delete_option('wshk_textbxbdcolor');
    delete_option('wshk_textbxfsize');
    delete_option('wshk_textbxbdsize');
    delete_option('wshk_textbxbdradius');
    delete_option('wshk_textbxbdtype');
    delete_option('wshk_textbxbdcolor');
    delete_option('wshk_textbxbgcolor');
    delete_option('wshk_textbtnbdsize');
    delete_option('wshk_textbtnbdradius');
    delete_option('wshk_textbtnbdtype');
    delete_option('wshk_textbtnbdcolor');
    delete_option('wshk_textbtntarget');
    delete_option('wshk_textbtntxd');
    
    
    delete_option('wshk_enabledisplayreviews');
    delete_option('wshk_disretextavsize');
    delete_option('wshk_disretextavbdsize');
    delete_option('wshk_disretextavbdradius');
    delete_option('wshk_disretextavbdtype');
    delete_option('wshk_disretextavbdcolor');
    delete_option('wshk_disretexttbwsize');
    delete_option('wshk_disretextmargintop');
    
    delete_option('wshk_disretextbxfsize');
    delete_option('wshk_disretextbxbdsize');
    delete_option('wshk_disretextbxbdradius');
    delete_option('wshk_disretextbxbdtype');
    delete_option('wshk_disretextbxbdcolor');
    delete_option('wshk_disretextbxbgcolor');
    delete_option('wshk_disretextbxpadding');
    delete_option('wshk_disretextbxminheight');
    	
    delete_option('wshk_disretextlinktarget');
    delete_option('wshk_disretextlinktxd');
    delete_option('wshk_disretextlinktxtsize');
    delete_option('wshk_disretextlinktxtcolor');
    
    delete_option('wshk_disredisplaynumber');
    delete_option('wshk_disrecolumnsnumber');
    
    
    
    delete_option('wshk_enablerwcounter');
    delete_option('wshk_treviewprefix');
    delete_option('wshk_treviewsuffix');
    delete_option('wshk_treviewpsuffix');
    delete_option('wshk_textnoreview');
    delete_option('wshk_enableusername');
    delete_option('wshk_usernmtc');
    delete_option('wshk_usernmts');
    delete_option('wshk_usernmta');
    delete_option('wshk_enablelogoutbtn');
    delete_option('wshk_logbtnbdsize');
    delete_option('wshk_logbtnbdradius');
    delete_option('wshk_logbtnbdtype');
    delete_option('wshk_logbtnbdcolor');
    delete_option('wshk_logbtntd');
    delete_option('wshk_logbtnta');
    delete_option('wshk_logbtnwd');
    delete_option('wshk_logbtntext');
    delete_option('wshk_enableloginform');
    delete_option('wshk_loginredi');
    delete_option('wshk_blockmya');
    delete_option('wshk_enableaddtocarttxt');
    delete_option('wshk_atctxtexternal');
    delete_option('wshk_atctxtgrouped');
    delete_option('wshk_atctxtsimple');
    delete_option('wshk_atctxtvariable');
    /*delete_option('wshk_atctxtntin');*/
    delete_option('wshk_textbxpadding');
    delete_option('wshk_textbtntxt');
    delete_option('wshk_avshadow');
    delete_option('wshk_textusernmpf');
    delete_option('wshk_textusernmsf');
    delete_option('wshk_enablegravatar');
    delete_option('wshk_textgravasize');
    delete_option('wshk_textgravashd');
    delete_option('wshk_textgravabdsz');
    delete_option('wshk_textgravabdtp');
    delete_option('wshk_textgravabdcl');
    delete_option('wshk_textgravabdrd');
    delete_option('wshk_emailordersizes');
    delete_option('wshk_enablesloginsec'); 
    delete_option('wshk_enablesadminbar');
    delete_option('wshk_enablerestrictctnt');
    delete_option('wshk_enableoffctnt');
    delete_option('wshk_btnlogoutredi');
    
    delete_option('wshk_enablesemab');
    
    delete_option('wshk_enablescontntdash');
    delete_option('wshk_editdashb');
    delete_option('wshk_editaftdashb');
    
    delete_option('wshk_enablescontntord');
    delete_option('wshk_editorde');
    delete_option('wshk_editaftorde');
    
    delete_option('wshk_enablescontntdow');
    delete_option('wshk_editdown');
    delete_option('wshk_editaftdown');
    
    delete_option('wshk_enablescontntadd');
    delete_option('wshk_editaddre');
    delete_option('wshk_editaftaddre');
    
    delete_option('wshk_enablescontntpay');
    delete_option('wshk_editpaym');
    delete_option('wshk_editaftpaym');
    
    delete_option('wshk_enablescontntrev');
    delete_option('wshk_editrevi');
    delete_option('wshk_editaftrevi');
    
    delete_option('wshk_enablescontntedi');
    delete_option('wshk_editedit');
    delete_option('wshk_editaftedit');
    
    delete_option('wshk_enablescontntlog');
    delete_option('wshk_editlogo');
    delete_option('wshk_editaftlogo');
    
    
    delete_option('wshk_tabsbdsize');
    delete_option('wshk_tabsbdtype');
    delete_option('wshk_tabsbdcolor');
    delete_option('wshk_tabsbdradius');
    
    delete_option('wshk_tabspdtop');
    delete_option('wshk_tabspdright');
    delete_option('wshk_tabspdbottom');
    delete_option('wshk_tabspdleft');
    
    delete_option('wshk_tabstxtsize');
    delete_option('wshk_tabstxtcolor');
    delete_option('wshk_tabstxtalign');
    delete_option('wshk_tabstxtdeco');
    
    delete_option('wshk_tabsbgcolor');
    delete_option('wshk_tabswdsize');
    delete_option('wshk_tabshgsize');
    
    delete_option('wshk_actabsbdsize');
    delete_option('wshk_actabsbdtype');
    delete_option('wshk_actabsbdcolor');
    delete_option('wshk_actabsbdradius');
    
    delete_option('wshk_actabstxtcolor');
    delete_option('wshk_actabstxtdeco');
    
    delete_option('wshk_actabsbgcolor');
    
    delete_option('wshk_hotabsbdsize');
    delete_option('wshk_hotabsbdtype');
    delete_option('wshk_hotabsbdcolor');
    delete_option('wshk_hotabsbdradius');
    
    delete_option('wshk_hotabstxtcolor');
    delete_option('wshk_hotabstxtdeco');
    
    delete_option('wshk_hotabsbgcolor');
    
    delete_option('wshk_contbbdsize');
    delete_option('wshk_contbbdtype');
    delete_option('wshk_contbbdcolor');
    delete_option('wshk_contbbdradius');
    
    delete_option('wshk_contbpdtop');
    delete_option('wshk_contbpdright');
    delete_option('wshk_contbpdbottom');
    delete_option('wshk_contbpdleft');
    
    delete_option('wshk_contbctheight');
    delete_option('wshk_contbctbgcolor');
    
    delete_option('wshk_keeplastab');
    
    delete_option('wshk_menulocation');
    
    delete_option('wshk_icondashb');
    delete_option('wshk_iconorder');
    delete_option('wshk_icondownl');
    delete_option('wshk_iconaddre');
    delete_option('wshk_iconpayme');
    delete_option('wshk_iconrevie');
    delete_option('wshk_iconedita');
    delete_option('wshk_iconlogou');
    }
endif;

/** Include class file **/

require dirname(__FILE__).'/wshk-class.php';



?>