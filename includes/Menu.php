<?php

namespace Kamal\WpAmVueApp;

/**
 * Menu generator class.
 *
 * Ensure admin menu registrations.
 *
 * @since 0.0.1
 */
class Menu {

	/**
	 * Constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'init_menu' ) );
	}

	/**
	 * Init Menu.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function init_menu() {
		global $submenu;

		$slug          = WP_AM_VUE_APP_SLUG;
		$menu_position = 50;
		$capability    = 'manage_options';
		// The icon in the data URI scheme.
		$icon_data_uri = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBVcGxvYWRlZCB0bzogU1ZHIFJlcG8sIHd3dy5zdmdyZXBvLmNvbSwgR2VuZXJhdG9yOiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4NCjxzdmcgaGVpZ2h0PSI4MDBweCIgd2lkdGg9IjgwMHB4IiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIA0KCSB2aWV3Qm94PSIwIDAgMjEuODc0IDIxLjg3NCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPGc+DQoJCQk8cGF0aCBzdHlsZT0iZmlsbDojMDEwMDAyOyIgZD0iTTIwLjYwNywyMS44NzRoLTMuMTE0Yy0wLjI1LDAtMC40NzUtMC4xNTMtMC41NjQtMC4zODZsLTIuMjYyLTUuODczSDYuODY0bC0yLjEyNSw1Ljg2MQ0KCQkJCWMtMC4wODYsMC4yMzktMC4zMTMsMC4zOTgtMC41NjgsMC4zOThIMS4yNjdjLTAuMTk5LDAtMC4zODUtMC4wOTgtMC40OTktMC4yNjJjLTAuMTEyLTAuMTY0LTAuMTM3LTAuMzczLTAuMDY1LTAuNTU5DQoJCQkJTDguNjM5LDAuMzg3QzguNzI4LDAuMTUzLDguOTUzLDAsOS4yMDMsMGgyLjk0N2MwLjI0NSwwLDAuNDY2LDAuMTQ4LDAuNTU5LDAuMzc1bDguNDU4LDIwLjY2NQ0KCQkJCWMwLjA3NywwLjE4NywwLjA1NSwwLjM5OS0wLjA1NywwLjU2NkMyMC45OTcsMjEuNzczLDIwLjgwOSwyMS44NzQsMjAuNjA3LDIxLjg3NHogTTguMTAyLDEyLjE3OWg1LjI2MWwtMS44NDktNC45MDYNCgkJCQljLTAuMzEtMC44MTktMC41ODQtMS41NzQtMC44MjEtMi4yNjJDMTAuNTA5LDUuNjU1LDEwLjMsNi4yOTUsMTAuMDY2LDYuOTNMOC4xMDIsMTIuMTc5eiIvPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+';

		add_menu_page( esc_attr__( 'WP Am Vue', 'wp-am-vue-app' ), esc_attr__( 'WP Am Vue', 'wp-am-vue-app' ), $capability, $slug, array( $this, 'plugin_page' ), $icon_data_uri, $menu_position );

		// Register this only for Administrator user.
		if ( current_user_can( $capability ) ) {
			$submenu[ $slug ][] = array( __( 'Settings', 'wp-am-vue-app' ), $capability, 'admin.php?page=' . $slug . '#' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$submenu[ $slug ][] = array( __( 'Table', 'wp-am-vue-app' ), $capability, 'admin.php?page=' . $slug . '#/table' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$submenu[ $slug ][] = array( __( 'Graph', 'wp-am-vue-app' ), $capability, 'admin.php?page=' . $slug . '#/graph' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}
	}

	/**
	 * Render the plugin page.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function plugin_page() {
		require_once WP_AM_VUE_APP_TEMPLATE_PATH . '/app.php';
	}
}
