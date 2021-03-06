<?php
require_once MIRA_SNACKBAR_PATH . 'includes/abstracts/abstract-class-wpms-rest-route.php';

add_action('rest_api_init', function () {
    register_rest_route(
        MIRA_SNACKBAR_REST_URL,
        '/' . Mira_Snackbars_Rest_Route::get_route(),
        Mira_Snackbars_Rest_Route::get_route_option()
    );
});

class Mira_Snackbars_Rest_Route extends WPMS_Abstract_Rest_Route
{

    static function get_route()
    {
        return 'snackbars';
    }

    static function get_route_option()
    {
        return  [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => ['Mira_Snackbars_Rest_Route', 'handler'],
                'permission_callback' => ['Mira_Snackbars_Rest_Route', 'permission_handler']

            ],
            'schema' => ['Mira_Snackbars_Rest_Route', 'get_schema']
        ];
    }

    static function permission_handler(WP_REST_Request $request) {
        return !!$request->get_header('X-WP-Nonce');
    }

    static function handler(WP_REST_Request $request)
    {
        ob_start();
        do_action('mira_snackbar_top', ['fixed']);
        do_action('mira_snackbar_bot', ['fixed']);
        $content = ob_get_clean();

        return [
            'data' => $content
        ];
    }

    static function get_schema()
    {
        return [
            '$schema'              => 'http://json-schema.org/draft-04/schema#',
            'title'                => 'snackbars',
            'description'          => esc_html__('Get all active fixed snackbars for current client.', 'mira-snackbar'),
        ];
    }
}
