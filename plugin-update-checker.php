<?php
require_once plugin_dir_path( __FILE__ ) . 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

function unbox_copyright_plugin_updater() {
    if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) ) {
        $myUpdateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/bridgetwes/unbox-copyright/',
            __FILE__, // Full path to the main plugin file or functions.php.
            'unbox-copyright'
        );
        
        // Optional: If you're using a private repository, specify the access token:
        // $myUpdateChecker->setAuthentication('your-token-here');
        
        // Set the branch that contains the stable release.
        $myUpdateChecker->setBranch('main');
    }
}
add_action('init', 'unbox_copyright_plugin_updater'); 