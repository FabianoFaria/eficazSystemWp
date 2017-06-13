<?php
/**
 * Admin View: Page - Importer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$demo_imported_id = get_option( 'themegrill_demo_imported_id' );

?>
<div class="wrap demo-importer">
	<h1><?php esc_html_e( 'Demo Importer', 'themegrill-demo-importer' ); ?>
		<span class="title-count demo-count"><?php echo count( $this->demo_config ); ?></span>
		<?php if ( apply_filters( 'themegrill_demo_importer_new_demos', false ) ) : ?>
			<a href="<?php echo esc_url( 'https://themegrill.com/upcoming-new-demos' ); ?>" class="page-title-action" target="_blank"><?php esc_html_e( 'New Demos', 'themegrill-demo-importer' ); ?></a>
		<?php endif; ?>
	</h1>
	<?php if ( ! get_option( 'themegrill_demo_imported_notice_dismiss' ) && in_array( $demo_imported_id, array_keys( $this->demo_config ) ) ) : ?>
		<div id="message" class="notice notice-info is-dismissible" data-notice_id="demo-importer">
			<p><?php printf( __( '<strong>Notice</strong> &#8211; If you want to completely remove a demo installation after importing it, you can use a plugin like %1$sWordPress Reset%2$s.', 'themegrill-demo-importer' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/wordpress-reset/' ) . '">', '</a>' ); ?></p>
		</div>
	<?php endif; ?>
	<div class="error hide-if-js">
		<p><?php _e( 'The Demo Importer screen requires JavaScript.', 'themegrill-demo-importer' ); ?></p>
	</div>

	<div class="theme-browser">
		<div class="themes wp-clearfix">
			<?php foreach ( $demos as $demo ) : ?>
				<div class="theme<?php if ( $demo['active'] ) echo ' active'; ?>" tabindex="0" aria-describedby="<?php echo esc_attr( $demo['id'] . '-action ' . $demo['id'] . '-name' ); ?>">
					<?php if ( $demo['screenshot'] ) : ?>
						<div class="theme-screenshot">
							<img src="<?php echo esc_url( $demo['screenshot'] ); ?>" alt="" />
						</div>
					<?php else : ?>
						<div class="theme-screenshot blank"></div>
					<?php endif; ?>

					<span class="more-details" id="<?php echo esc_attr( $demo['id'] . '-action' ); ?>"><?php esc_html_e( 'Demo Details', 'themegrill-demo-importer' ); ?></span>
					<div class="theme-author"><?php
						/* translators: %s: Demo author name */
						printf( __( 'By %s', 'themegrill-demo-importer' ), $demo['author'] );
					?></div>

					<?php if ( $demo['active'] ) { ?>
						<h2 class="theme-name" id="demo-name"><?php
							/* translators: %s: Demo name */
							printf( __( '<span>Imported:</span> %s', 'themegrill-demo-importer' ), esc_html( $demo['name'] ) );
						?></h2>
					<?php } else { ?>
						<h2 class="theme-name" id="<?php echo esc_attr( $demo['id'] . '-name' ); ?>"><?php echo esc_html( $demo['name'] ); ?></h2>
					<?php } ?>

					<div class="theme-actions">
						<?php if ( $demo['active'] ) : ?>
							<a class="button button-primary live-preview" target="_blank" href="<?php echo esc_url( $demo['actions']['preview'] ); ?>"><?php _e( 'Live Preview', 'themegrill-demo-importer' ); ?></a>
						<?php else : ?>
							<?php if ( ! empty( $demo['hasNotice'] ) ) : ?>
								<?php if ( isset( $demo['hasNotice']['required_theme'] ) ) : ?>
									<a class="button button-primary hide-if-no-js tips demo-import disabled" href="#" data-name=<?php echo esc_attr( $demo['name'] );?>" data-slug="<?php echo esc_attr( $demo['id'] ); ?>" data-tip="<?php echo esc_attr( sprintf( __( 'Required %s theme must be activated to import this demo.', 'themegrill-demo-importer' ), $demo['theme'] ) ); ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
								<?php elseif ( isset( $demo['hasNotice']['required_plugins'] ) ) : ?>
									<a class="button button-primary hide-if-no-js tips demo-import disabled" href="#" data-name=<?php echo esc_attr( $demo['name'] );?>" data-slug="<?php echo esc_attr( $demo['id'] ); ?>" data-tip="<?php echo esc_attr( 'Required Plugin must be activated to import this demo.', 'themegrill-demo-importer' ); ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
								<?php endif; ?>
							<?php else : ?>
								<?php
								/* translators: %s: Demo name */
								$aria_label = sprintf( _x( 'Import %s', 'demo', 'themegrill-demo-importer' ), esc_attr( $demo['name'] ) );
								?>
								<a class="button button-primary hide-if-no-js import" href="#" data-name=<?php echo esc_attr( $demo['name'] );?>" data-slug="<?php echo esc_attr( $demo['id'] ); ?>" aria-label="<?php echo $aria_label; ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
							<?php endif; ?>
							<a class="button button-secondary demo-preview" target="_blank" href="<?php echo esc_url( $demo['actions']['demo_url'] ); ?>"><?php _e( 'Preview', 'themegrill-demo-importer' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="theme-overlay"></div>
	<p class="no-themes"><?php _e( 'No demos found. Try a different search.', 'themegrill-demo-importer' ); ?></p>
</div>

<script id="tmpl-demo" type="text/template">
	<# if ( data.screenshot ) { #>
		<div class="theme-screenshot">
			<img src="{{ data.screenshot }}" alt="" />
		</div>
	<# } else { #>
		<div class="theme-screenshot blank"></div>
	<# } #>

	<span class="more-details" id="{{ data.id }}-action"><?php _e( 'Demo Details', 'themegrill-demo-importer' ); ?></span>
	<div class="theme-author"><?php
		/* translators: %s: Demo author name */
		printf( __( 'By %s', 'themegrill-demo-importer' ), '{{{ data.author }}}' );
	?></div>

	<# if ( data.active ) { #>
		<h2 class="theme-name" id="{{ data.id }}-name"><?php
			/* translators: %s: Demo name */
			printf( __( '<span>Imported:</span> %s', 'themegrill-demo-importer' ), '{{{ data.name }}}' );
		?></h2>
	<# } else { #>
		<h2 class="theme-name" id="{{ data.id }}-name">{{{ data.name }}}</h2>
	<# } #>

	<div class="theme-actions">
		<# if ( data.active ) { #>
			<a class="button button-primary live-preview" target="_blank" href="{{{ data.actions.preview }}}"><?php _e( 'Live Preview', 'themegrill-demo-importer' ); ?></a>
		<# } else { #>
			<# if ( ! _.isEmpty( data.hasNotice ) ) { #>
				<# if ( data.hasNotice['required_theme'] ) { #>
					<a class="button button-primary hide-if-no-js tips demo-import disabled" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}" data-tip="<?php echo esc_attr( sprintf( __( 'Required %s theme must be activated to import this demo.', 'themegrill-demo-importer' ), '{{{ data.theme }}}' ) ); ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
				<# } else if ( data.hasNotice['required_plugins'] ) { #>
					<a class="button button-primary hide-if-no-js tips demo-import disabled" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}" data-tip="<?php echo esc_attr( 'Required Plugin must be activated to import this demo.', 'themegrill-demo-importer' ); ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
				<# } #>
			<# } else { #>
				<?php
				/* translators: %s: Demo name */
				$aria_label = sprintf( _x( 'Import %s', 'demo', 'themegrill-demo-importer' ), '{{ data.name }}' );
				?>
				<a class="button button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}" aria-label="<?php echo $aria_label; ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
			<# } #>
			<a class="button button-secondary demo-preview" target="_blank" href="{{{ data.actions.demo_url }}}"><?php _e( 'Preview', 'themegrill-demo-importer' ); ?></a>
		<# } #>
	</div>

	<# if ( data.imported ) { #>
		<div class="notice notice-success notice-alt"><p><?php _ex( 'Imported', 'demo', 'themegrill-demo-importer' ); ?></p></div>
	<# } #>
</script>

<script id="tmpl-demo-single" type="text/template">
	<div class="theme-backdrop"></div>
	<div class="theme-wrap wp-clearfix">
		<div class="theme-header">
			<button class="left dashicons dashicons-no"><span class="screen-reader-text"><?php _e( 'Show previous demo', 'themegrill-demo-importer' ); ?></span></button>
			<button class="right dashicons dashicons-no"><span class="screen-reader-text"><?php _e( 'Show next demo', 'themegrill-demo-importer' ); ?></span></button>
			<button class="close dashicons dashicons-no"><span class="screen-reader-text"><?php _e( 'Close details dialog', 'themegrill-demo-importer' ); ?></span></button>
		</div>
		<div class="theme-about wp-clearfix">
			<div class="theme-screenshots">
			<# if ( data.screenshot ) { #>
				<div class="screenshot"><img src="{{ data.screenshot }}" alt="" /></div>
			<# } else { #>
				<div class="screenshot blank"></div>
			<# } #>
			</div>

			<div class="theme-info">
				<# if ( data.active ) { #>
					<span class="current-label"><?php _e( 'Imported Demo', 'themegrill-demo-importer' ); ?></span>
				<# } #>
				<h2 class="theme-name">{{{ data.name }}}<span class="theme-version"><?php printf( __( 'Version: %s', 'themegrill-demo-importer' ), '{{ data.version }}' ); ?></span></h2>
				<p class="theme-author"><?php printf( __( 'By %s', 'themegrill-demo-importer' ), '{{{ data.authorAndUri }}}' ); ?></p>

				<# if ( ! _.isEmpty( data.hasNotice ) ) { #>
					<div class="notice demo-message notice-warning notice-alt">
						<# if ( data.hasNotice['required_theme'] ) { #>
							<p class="demo-notice"><?php printf( esc_html__( 'Required %s theme must be activated to import this demo.', 'themegrill-demo-importer' ), '<strong>{{{ data.theme }}}</strong>' ); ?></p>
						<# } else if ( data.hasNotice['required_plugins'] ) { #>
							<p class="demo-notice"><?php _e( 'Required Plugin must be activated to import this demo.', 'themegrill-demo-importer' ); ?></p>
						<# } #>
					</div>
				<# } #>
				<p class="theme-description">{{{ data.description }}}</p>

				<h3 class="plugins-info"><?php _e( 'Plugins Information', 'themegrill-demo-importer' ); ?></h3>

				<table class="plugins-list-table widefat">
					<thead>
						<tr>
							<th class="plugin-name"><?php esc_html_e( 'Plugin Name', 'themegrill-demo-importer' ); ?></th>
							<th class="plugin-type"><?php esc_html_e( 'Type', 'themegrill-demo-importer' ); ?></th>
							<th class="plugin-status"><?php esc_html_e( 'Status', 'themegrill-demo-importer' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<# if ( ! _.isEmpty( data.plugins ) ) { #>
							<# _.each( data.plugins, function( plugin, slug ) { #>
								<tr>
									<td class="plugin-name">
										<# if ( plugin.link ) { #>
											<a href="{{{ plugin.link }}}" target="_blank">{{{ plugin.name }}}</a>
										<# } else { #>
											<a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=search&type=term&s=' ) ); ?>{{ slug }}" target="_blank">{{ plugin.name }}</a>
										<# } #>
									</td>
									<td class="plugin-type">
										<# if ( plugin.required ) { #>
											<span class="required"><?php esc_html_e( 'Required', 'themegrill-demo-importer' ); ?></span>
										<# } else { #>
											<span class="recommended"><?php esc_html_e( 'Recommended', 'themegrill-demo-importer' ); ?></span>
										<# } #>
									</td>
									<td class="plugin-status">
										<# if ( plugin.is_active ) { #>
											<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
										<# } else { #>
											<mark class="error"><span class="dashicons dashicons-no-alt"></span></mark>
										<# } #>
									</td>
								</tr>
							<# }); #>
						<# } else { #>
							<tr>
								<td class="plugins-list-table-blank-state" colspan="3"><p><?php _e( 'No plugins are needed to import this demo.', 'themegrill-demo-importer' ); ?></p></td>
							</tr>
						<# } #>
					</tbody>
				</table>

				<# if ( data.tags ) { #>
					<p class="theme-tags"><span><?php _e( 'Tags:', 'themegrill-demo-importer' ); ?></span> {{{ data.tags }}}</p>
				<# } #>
			</div>
		</div>

		<div class="theme-actions">
			<div class="active-theme">
				<a href="{{{ data.actions.preview }}}" class="button button-primary live-preview" target="_blank"><?php _e( 'Live Preview', 'themegrill-demo-importer' ); ?></a>
			</div>
			<div class="inactive-theme">
				<?php
				/* translators: %s: Demo name */
				$aria_label = sprintf( _x( 'Import %s', 'demo', 'themegrill-demo-importer' ), '{{ data.name }}' );
				?>
				<# if ( _.isEmpty( data.hasNotice ) ) { #>
					<# if ( data.imported ) { #>
						<a href="{{{ data.actions.preview }}}" class="button button-primary live-preview" target="_blank"><?php _e( 'Live Preview', 'themegrill-demo-importer' ); ?></a>
					<# } else { #>
						<a class="button button-primary hide-if-no-js demo-import" href="#" data-name="{{ data.name }}" data-slug="{{ data.id }}" aria-label="<?php echo $aria_label; ?>"><?php _e( 'Import', 'themegrill-demo-importer' ); ?></a>
					<# } #>
				<# } #>
				<a class="button button-secondary demo-preview" target="_blank" href="{{{ data.actions.demo_url }}}"><?php _e( 'Preview', 'themegrill-demo-importer' ); ?></a>
			</div>

			<# if ( data.package && data.actions['delete'] ) { #>
				<a href="{{{ data.actions['delete'] }}}" class="button delete-theme delete-demo"><?php _e( 'Delete', 'themegrill-demo-importer' ); ?></a>
			<# } #>
		</div>
	</div>
</script>

<?php
wp_print_request_filesystem_credentials_modal();
wp_print_admin_notice_templates();
