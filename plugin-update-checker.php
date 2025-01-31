<?php
$plugin_update_checker_path = plugin_dir_path( __FILE__ ) . 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';

if (file_exists($plugin_update_checker_path)) {
    require_once $plugin_update_checker_path;
} 
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

function unbox_copyright_plugin_updater() {
    if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) ) {
        $myUpdateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/bridgetwes/unbox-copyright/',
            plugin_dir_path( __FILE__ ) . 'unbox-copyright.php', // Change to point to main plugin file
            'unbox-copyright'
        );
        
        // Set the branch that contains the stable release.
        $myUpdateChecker->setBranch('main');        
    }
}
add_action('init', 'unbox_copyright_plugin_updater'); 