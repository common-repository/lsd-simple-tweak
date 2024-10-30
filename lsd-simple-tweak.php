<?php
/*
Plugin Name: LSD Simple Tweak
Plugin URI: http://www.bas-matthee.nl
Description: Tweak the performance and automated settings of your Wordpress wsite by checking or unchecking the numerous options on the settings page.
Author: Bas Matthee
Version: 1.0
Author URI: https://www.twitter.com/BasMatthee
*/

class lsd_simple_tweak {
    
    function __construct() {
        
        if (is_admin()) {
            
            add_action( 'admin_menu', array(&$this,'add_settings_menu') );
            
        }
        
        add_action('init', array(&$this,'apply_tweaks'));
        
    }
    
    function apply_tweaks() {
        
        // Global auto update settings
        $option = get_option('updates_automatic_updater_disabled',0);
        if ($option) {add_filter( 'automatic_updater_disabled', '__return_true' );}
        
        $option = get_option('updates_auto_update_core',0);
        if ($option) {add_filter( 'auto_update_core', '__return_false' );}
        
        // Individual automatic update settings
        $option = get_option('updates_automatic_updates_is_vcs_checkout',0);
        if ($option) {add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1 );}
        
        $option = get_option('updates_allow_dev_auto_core_updates',0);
        if ($option) {add_filter( 'allow_dev_auto_core_updates', '__return_true' );}
        
        $option = get_option('updates_allow_minor_auto_core_updates',0);
        if ($option) {add_filter( 'allow_major_auto_core_updates', '__return_true' );}
        
        $option = get_option('updates_disallow_minor_auto_core_updates',0);
        if ($option) {add_filter( 'allow_minor_auto_core_updates', '__return_false' );}
        
        $option = get_option('auto_updater_disable',0);
        if ($option) {add_filter( 'allow_major_auto_core_updates', '__return_false' );}
        
        $option = get_option('auto_updater_enable',0);
        if ($option) {add_filter( 'allow_major_auto_core_updates', '__return_true' );}
        
        // Extra auto update settings
        $option = get_option('updates_auto_update_plugin',0);
        if ($option) {add_filter( 'auto_update_plugin', '__return_true' );}
        
        $option = get_option('updates_auto_update_theme',0);
        if ($option) {add_filter( 'auto_update_theme', '__return_true' );}
        
        $option = get_option('updates_auto_update_translation',0);
        if ($option) {add_filter( 'auto_update_translation', '__return_false' );}
        
        // Auto update email setting
        $option = get_option('updates_auto_core_update_send_email',0);
        if ($option) {add_filter( 'auto_core_update_send_email', '__return_false' );}
        
        // Cleanup wp_head
        $option = get_option('wp_head_rsd_link',0);
        if ($option) {remove_action('wp_head', 'rsd_link');}
        
        $option = get_option('wp_head_wp_generator',0);
        if ($option) {remove_action('wp_head', 'wp_generator');}
        
        $option = get_option('wp_head_feed_links',0);
        if ($option) {remove_action('wp_head', 'feed_links',2);}
        
        $option = get_option('wp_head_index_rel_link',0);
        if ($option) {remove_action('wp_head', 'index_rel_link');}
        
        $option = get_option('wp_head_wlwmanifest_link',0);
        if ($option) {remove_action('wp_head', 'wlwmanifest_link');}
        
        $option = get_option('wp_head_feed_links_extra',0);
        if ($option) {remove_action('wp_head', 'feed_links_extra',3);}
        
        $option = get_option('wp_head_start_post_rel_link',0);
        if ($option) {remove_action('wp_head', 'start_post_rel_link',10,0);}
        
        $option = get_option('wp_head_parent_post_rel_link',0);
        if ($option) {remove_action('wp_head', 'parent_post_rel_link',10,0);}
        
        $option = get_option('wp_head_adjacent_posts_rel_link',0);
        if ($option) {remove_action('wp_head', 'adjacent_posts_rel_link',10,0);}
        
    }
    
    function add_settings_menu() {
        
    	add_menu_page('Simple Tweak', 'Simple Tweak', 'administrator', __FILE__, array(&$this,'tweak_settings'));
        
    	add_action( 'admin_init', array(&$this,'register_tweak_settings') );
        
    }
    
    function register_tweak_settings() {
        
        // Global auto update settings
        register_setting( 'lsd_tweak_settings', 'updates_automatic_updater_disabled');
        register_setting( 'lsd_tweak_settings', 'updates_auto_update_core');
        
        // Individual automatic update settings
        register_setting( 'lsd_tweak_settings', 'updates_automatic_updates_is_vcs_checkout');
        register_setting( 'lsd_tweak_settings', 'updates_allow_dev_auto_core_updates');
        register_setting( 'lsd_tweak_settings', 'updates_allow_minor_auto_core_updates');
        register_setting( 'lsd_tweak_settings', 'updates_disallow_minor_auto_core_updates');
        register_setting( 'lsd_tweak_settings', 'auto_updater_disable');
        register_setting( 'lsd_tweak_settings', 'auto_updater_ensable');
        
        // Extra auto update settings
        register_setting( 'lsd_tweak_settings', 'updates_auto_update_plugin');
        register_setting( 'lsd_tweak_settings', 'updates_auto_update_theme');
        register_setting( 'lsd_tweak_settings', 'updates_auto_update_translation');
        
        // Auto update email setting
        register_setting( 'lsd_tweak_settings', 'updates_auto_core_update_send_email');
        
        // Cleanup wp_head
        register_setting( 'lsd_tweak_settings', 'wp_head_rsd_link');
        register_setting( 'lsd_tweak_settings', 'wp_head_wp_generator');
        register_setting( 'lsd_tweak_settings', 'wp_head_feed_links');
        register_setting( 'lsd_tweak_settings', 'wp_head_index_rel_link');
        register_setting( 'lsd_tweak_settings', 'wp_head_wlwmanifest_link');
        register_setting( 'lsd_tweak_settings', 'wp_head_feed_links_extra');
        register_setting( 'lsd_tweak_settings', 'wp_head_start_post_rel_link');
        register_setting( 'lsd_tweak_settings', 'wp_head_parent_post_rel_link');
        register_setting( 'lsd_tweak_settings', 'wp_head_adjacent_posts_rel_link');
        
    }
    
    function tweak_settings() {
        
        ?>
        
        <div class="wrap">
        <h2><? echo __('LSD Simple Tweak settings','lsd-simple-tweak')?></h2>
        
        <? if (isset($_GET['settings-updated'])): ?>
            
            <div id="setting-error-settings_updated" class="updated settings-error"> 
            <p><strong><? echo __('Settings saved','lsd-simple-tweak')?></strong></p></div>
            
        <? endif; ?>
        
        <form method="post" action="options.php">
        <?php settings_fields( 'lsd_tweak_settings' ); ?>
        <?php do_settings_sections( 'lsd_tweak_settings' ); ?>
        
        <h3 class="title"><? echo __('Global update settings','lsd-simple-tweak')?></h3>
        <p><? echo __('These settings disable all automatic updates at once. Use the individual settings below to be more precise.','lsd-simple-tweak')?></p>
        <table class="form-table">
        <tr>
            <td>
                <label><input type="checkbox" name="updates_automatic_updater_disabled" value="1" <?php echo (get_option('updates_automatic_updater_disabled',0)==1)?'checked="checked"':''?>/> 
                <? echo __('Disable all automatic updates','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="updates_auto_update_core" value="1" <?php echo (get_option('updates_auto_update_core',0)==1)?'checked="checked"':''?>/> 
                <? echo __('Disable only the automatic core-type updates','lsd-simple-tweak')?></label>
            </td>
        </tr>
        </table>
        
        <h3 class="title"><? echo __('Individual update settings','lsd-simple-tweak')?></h3>
        <p><? echo __('These settings lets you decide per update functionality.','lsd-simple-tweak')?></p>
        <table class="form-table">
        <tr>
            <td>
                <label><input type="checkbox" name="updates_automatic_updates_is_vcs_checkout" value="1" <?php echo (get_option('updates_automatic_updates_is_vcs_checkout',0)==1)?'checked="checked"':''?>/>
                <? echo __('To specifically enable automatic updates even if a VCS folder (.git, .hg, .svn etc) was found in the WordPress directory or any of its parent directories','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="updates_allow_dev_auto_core_updates" value="1" <?php echo (get_option('updates_allow_dev_auto_core_updates',0)==1)?'checked="checked"':''?>/>
                <? echo __('To specifically enable development (nightly) updates','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="updates_allow_minor_auto_core_updates" value="1" <?php echo (get_option('updates_allow_minor_auto_core_updates',0)==1)?'checked="checked"':''?>/>
                <? echo __('To specifically enable minor updates, use the following','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="updates_disallow_minor_auto_core_updates" value="1" <?php echo (get_option('updates_disallow_minor_auto_core_updates',0)==1)?'checked="checked"':''?>/>
                <? echo __('To specifically disable minor updates','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="auto_updater_disable" value="1" <?php echo (get_option('auto_updater_disable',0)==1)?'checked="checked"':''?>/>
                <? echo __('To specifically disable major updates','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="auto_updater_enable" value="1" <?php echo (get_option('auto_updater_enable',0)==1)?'checked="checked"':''?>/>
                <? echo __('To specifically enable major updates','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        </table>
        
        <h3 class="title"><? echo __('Plugin & Theme Updates','lsd-simple-tweak')?></h3>
        <p><? echo __('Automatic plugin and theme updates are disabled by default. To enable them, use the following settings.','lsd-simple-tweak')?></p>
        <table class="form-table">
        <tr>
            <td>
                <label><input type="checkbox" name="updates_auto_update_plugin" value="1" <?php echo (get_option('updates_auto_update_plugin',0)==1)?'checked="checked"':''?>/>
                <? echo __('To enable automatic updates for plugins, use the following','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="updates_auto_update_theme" value="1" <?php echo (get_option('updates_auto_update_theme',0)==1)?'checked="checked"':''?>/>
                <? echo __('To enable automatic updates for themes, use the following','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        </table>
        
        <h3 class="title"><? echo __('Translation Updates','lsd-simple-tweak')?></h3>
        <p><? echo __('Automatic translation file updates are already enabled by default, the same as minor core updates.','lsd-simple-tweak')?></p>
        <table class="form-table">
        <tr>
            <td>
                <label><input type="checkbox" name="updates_auto_update_translation" value="1" <?php echo (get_option('updates_auto_update_translation',0)==1)?'checked="checked"':''?>/>
                <? echo __('To disable translation file updates','lsd-simple-tweak')?></label></th>
            </td>
        </tr>
        </table>
        
        <h3 class="title"><? echo __('Disable Emails','lsd-simple-tweak')?></h3>
        <table class="form-table">
        <tr>
            <td>
                <label><input type="checkbox" name="updates_auto_core_update_send_email" value="1" <?php echo (get_option('updates_auto_core_update_send_email',0)==1)?'checked="checked"':''?>/>
                <? echo __('Disable update emails','lsd-simple-tweak')?></label>
            </td>
        </tr>
        </table>
        
        <h3 class="title"><? echo __('Cleanup the Wordpress head','lsd-simple-tweak')?></h3>
        <table class="form-table">
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_rsd_link" value="1" <?php echo (get_option('wp_head_rsd_link',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide the link to the Really Simple Discovery service endpoint','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_wp_generator" value="1" <?php echo (get_option('wp_head_wp_generator',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide the generator meta tag','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_feed_links" value="1" <?php echo (get_option('wp_head_feed_links',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide the RSS feed links','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_index_rel_link" value="1" <?php echo (get_option('wp_head_index_rel_link',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide the relational link for the site index','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_wlwmanifest_link" value="1" <?php echo (get_option('wp_head_wlwmanifest_link',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide the link to the Windows Live Writer manifest file','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_feed_links_extra" value="1" <?php echo (get_option('wp_head_feed_links_extra',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide the links to the extra feeds such as category feeds','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_start_post_rel_link" value="1" <?php echo (get_option('wp_head_start_post_rel_link',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide relational link for the first post','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_parent_post_rel_link" value="1" <?php echo (get_option('wp_head_parent_post_rel_link',0)==1)?'checked="checked"':''?>/>
                <? echo __('Hide relational link for parent item','lsd-simple-tweak')?></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><input type="checkbox" name="wp_head_adjacent_posts_rel_link" value="1" <?php echo (get_option('wp_head_adjacent_posts_rel_link',0)==1)?'checked="checked"':''?>/> 
                <? echo __('Hide relational links for the posts adjacent to the current post','lsd-simple-tweak')?></label>
            </td>
        </tr>
        </table>
        
        <? submit_button(__('Save settings','lsd-simple-tweak')); ?>
        
        </form>
        </div>
        
        <?
        
    }
    
}

$lsd_simple_tweak = new lsd_simple_tweak();