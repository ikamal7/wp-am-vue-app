<?php

namespace Kamal\WpAmVueApp\Tests;

/**
 * Assets class test.
 *
 * @since 0.0.1
 */
class AssetTest extends \WP_UnitTestCase {

    /**
     * Asset class instance.
     *
     * @var\Kamal\WpAmVueApp\Asset()
     */
    public $asset;

    /**
     * Setup test environment.
     */
    protected function setUp() : void {
        $this->asset = new\Kamal\WpAmVueApp\Asset();
    }

    public function test_get_router_base_url() {
        $admin_page_url1 = '/wp-admin/admin.php?page=wp-am-vue-app';

        $this->assertEquals(
            $this->asset->get_router_base_url( $admin_page_url1 ),
            'wp-admin/admin.php?page=wp-am-vue-app#',
        );

        $this->assertEquals(
            $this->asset->get_router_base_url( $admin_page_url2 ),
            'wp-admin/admin.php?page=wp-am-vue-app#'
        );
    }
}
