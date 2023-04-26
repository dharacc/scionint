<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb, $header_layouts;

$header_lists = '';
$table_name   = $wpdb->prefix . 'cs_header_builder';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
	$header_lists = $wpdb->get_results( "SELECT * FROM $table_name" );
	wp_reset_query();
}
?>

<div  class="wrap">
	<h1 class="wp-heading-inline"> <?php _e( 'Header Builder', 'pgs-core' ); ?> </h1>    
	<hr class="wp-header-end" />
	<h2 class="screen-reader-text"><?php _e( 'Header layout List', 'pgs-core' ); ?></h2>

	<div class="poststuff">
		<div class="header-layout-list">
			<div class="header-layout-list-title">
				<h3 class="header-list-title"> <?php _e( 'Header Layout List', 'pgs-core' ); ?> </h3>    
				<p class="description">
				<?php
				printf(
					wp_kses(
						__( 'Here you can manage your header layouts and create new ones. You can set which header to use for all pages using theme settings in <a href="%s" target="_blank">Theme Options</a>', 'pgs-core' ),
						array(
							'a' => array(
								'href'   => true,
								'target' => true,
							),
						)
					),
					admin_url( 'themes.php?page=ciyashop-options&tab=7' )
				)
				?>
				</p>
			</div>
		</div>
		<div class="header-layout-lists-cover">
			<ul class="header-layout-lists">
				<li class="header-layout-list-item header-layout-list-create">
					<div class="header-layout-actions">
							<a href="#" class="button button-primary button-large page-title-action add-header-layout"> <span class="dashicons dashicons-plus-alt"></span> <?php _e( 'Create New', 'pgs-core' ); ?></a>
					</div>
				</li>
				<?php
				if ( ! empty( $header_lists ) ) {
					foreach ( $header_lists as $header_list ) {
						echo '<li class="header-layout-list-item">';
						echo '<div class="header-layout-list-item-inner">';
						echo '<a href="' . esc_url( admin_url() . 'admin.php?page=header-layout' ) . '&header_id=' . $header_list->id . '">' . $header_list->name . '</a>';
						echo '<div class="header-layout-list-actions">';
						echo '<a href="' . esc_url( admin_url() . 'admin.php?page=header-layout' ) . '&header_id=' . $header_list->id . '" class="header-layout-action header-layout-edit"><span class="dashicons dashicons-edit"></span></a>';
						echo '<a href="' . esc_url( admin_url() . 'admin.php?page=header-layout' ) . '&header_id=' . $header_list->id . '" class="header-layout-action header-layout-clone" data-header_id="' . $header_list->id . '"><span class="dashicons dashicons-admin-page"></span></a>';
						echo '<a href="' . esc_url( admin_url() . 'admin.php?page=header-layout' ) . '&header_id=' . $header_list->id . '" class="header-layout-action header-layout-export" data-header_id="' . $header_list->id . '"><span class="dashicons dashicons-upload"></span></a>';
						echo '<a href="" class="header-layout-action header-layout-delete" data-header_id="' . $header_list->id . '"><span class="dashicons dashicons-trash"></span></a>';
						echo '</div>';
						echo '</div>';
						echo '</li>';
					}
				}
				?>
				<li class="header-layout-list-item header-layout-list-create">
					<div class="header-layout-actions">
							<a href="#" class="button button-primary button-large page-title-action import-header-layout"> <span class="dashicons dashicons-download"></span> <?php _e( 'Import', 'pgs-core' ); ?></a>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="chl-preset-header-container">
		<div class="chl-preset-header-inner">
			<div class="chl-preset-header-close">
				<span class="dashicons dashicons-no"></span>
			</div>
			<div class="chl-preset-header-title"><?php esc_html_e( 'Create New Header' ); ?></div>
			<div class="chl-preset-header-content">
				<?php
				foreach ( $header_layouts as $layouts ) {
					?>
					<div class="header-layout" data-layout="<?php echo esc_attr( $layouts['param_name'] ); ?>">
						<a href="<?php echo admin_url( 'admin.php?page=header-layout' ); ?>"><img src="<?php echo esc_url( $layouts['previwe_img'] ); ?>"/></a>
					</div>
					<hr/>
					<?php
				}
				?>
			</div>
		</div>
	</div>

	<div class="chl-container chl-importer-container">
		<div class="chl-importer-inner">		
			<div class="chl-importer-close">
				<span class="dashicons dashicons-no"></span>
			</div>
			<div class="chl-importer-title">
				<?php esc_html_e( 'Import Header', 'pgs-core' ); ?>
			</div>
			<div class="chl-importer-holder">
				<input id="chl-importer-file" type="file" accept=".txt">
				<label for="chl-importer-file" class="chl-importer-file"><i class="fas fa-cloud-download-alt"></i> <?php esc_html_e( 'Choose a file to import', 'pgs-core' ); ?></label>
			</div>
			<div class="chl-importer-actions">
				<a href="javascript:void(0)" class="button button-secondary button-large chl-cancel-button chl-import-cancel"><?php esc_html_e( 'Cancel', 'pgs-core' ); ?></a>
				<a href="javascript:void(0)" class="button button-primary button-large chl-import-button"><?php esc_html_e( 'Import', 'pgs-core' ); ?></a>
			</div>
		</div>
		<div class="chl-importer-loader" style="display:none">
			<img id="loadimg" class="file-upload" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cy_loader.svg' ); ?>" alt="">
		</div>
	</div>
</div>
