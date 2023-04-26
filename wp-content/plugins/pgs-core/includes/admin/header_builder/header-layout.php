<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb, $header_elements;
$header_layout_data   = $layout_data = array();
$page_title           = __( 'Add New Header Layout', 'pgs-core' );
$topbar_configuration = '';
$main_configuration   = '';
$bottom_configuration = '';
$id                   = 0;
$icon                 = '';

if ( isset( $_GET['header_id'] ) ) {
	$page_title = __( 'Edit Header Layout', 'pgs-core' );
	$id         = $_GET['header_id'];
	$table_name = $wpdb->prefix . 'cs_header_builder';

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
		$header_layout_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE id=$id" );
		if ( ! empty( $header_layout_data ) ) {
			$header_layout_data = $header_layout_data[0];
			$layout_data        = unserialize( $header_layout_data->value );
		}
		wp_reset_query();
	}

	$topbar_configuration = isset( $layout_data['topbar']['configuration'] ) ? $layout_data['topbar']['configuration'] : '';
	$main_configuration   = isset( $layout_data['main']['configuration'] ) ? $layout_data['main']['configuration'] : '';
	$bottom_configuration = isset( $layout_data['bottom']['configuration'] ) ? $layout_data['bottom']['configuration'] : '';
}
?>

<div  class="wrap">
	<h1> <?php echo $page_title; ?> </h1>
	<hr class="wp-header-end" />
	<h2 class="screen-reader-text"><?php echo $page_title; ?></h2>

	<div class="poststuff">
		<div class="header-layout-cover">
			<div class="item-cover">
				<span class="dashicons dashicons-edit"></span>
				<input class="layout-title" type="text" name="header_layout['layout_name']" placeholder="<?php _e( 'Enter layout name*', 'pgs-core' ); ?>" value="<?php echo isset( $header_layout_data->name ) ? $header_layout_data->name : ''; ?>"/>
			</div>
			<hr/>
			<div class="chl-header-builder-container">
				<div class="chl-elements-container">
					<div class="chl-device-elements">
						<span class="chl-devices-toolbar-title"><?php _e( 'Element options', 'pgs-core' ); ?></span>
						<ul class="chl-elements-list">
							<?php
							foreach ( $header_elements as $header_element ) {
								$element_class  = '';
								$element_id     = isset( $header_element['id'] ) ? $header_element['id'] : '';
								$element_title  = isset( $header_element['name'] ) ? $header_element['name'] : '';
								$element_icon   = isset( $header_element['element_icon'] ) ? $header_element['element_icon'] : '';
								$element_device = isset( $header_element['device'] ) ? $header_element['device'] : '';

								$element_class = 'chl-element-content chl-element-drag';

								if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {

									$element_class .= ' chl-element-' . $element_id;
									if ( $element_device ) {
										$element_class .= ' chl-element-for-' . $element_device;
									}

									?>
									<li class="chl-sortable-item">
										<div class="<?php echo esc_attr( $element_class ); ?>" data-element_id="<?php echo esc_attr( $element_id ); ?>" data-element_title="<?php echo esc_attr( $element_title ); ?>" data-element_data="">
											<div class="chl-element-content-inner">
												<?php
												if ( $element_icon ) {
													?>
													<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $element_icon ); ?>" class="<?php echo esc_attr( $element_icon ); ?>"></i></span>
													<?php
												}
												?>
												<span class="chl-element-title"><?php echo esc_html( $element_title ); ?></span>
											</div>
											<div class="chl-element-content-action">
												<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
												<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
											</div>
										</div>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
				</div>
				<div class="chl-structure chl-structure-desktop">
					<div class="chl-action-cover">
						<div class="chl-toolbar-devices-container">
							<span class="chl-devices-toolbar-title"><?php _e( 'Devices', 'pgs-core' ); ?></span>					
							<div class="chl-toolbar-devices">
								<span class="dashicons dashicons-laptop active-devices" data-device="desktop"><?php _e( 'Desktop', 'pgs-core' ); ?></span>
								<span class="dashicons dashicons-smartphone" data-device="mobile"><?php _e( 'Mobile', 'pgs-core' ); ?></span>
							</div>
						</div>
						<button class="button button-primary button-large chl-save" data-header_id="<?php echo $id; ?>"><span class="ti-save"></span><?php _e( 'Save Changes', 'pgs-core' ); ?></button>
					</div>
					<div class="chl-row chl-elements-cover chl-top-bar" data-possition="topbar" data-element_title="<?php _e( 'Top Bar', 'pgs-core' ); ?>" data-element_data='<?php echo ( '' != $topbar_configuration ) ? wp_json_encode( $topbar_configuration ) : ''; ?>'>
						<div class="chl-element-inner">
							<span class="chl-element-title"><?php _e( 'Top Bar', 'pgs-core' ); ?>
								<div class="chl-element-action">
									<div class="chl-icon-button chl-add-button chl-row-configure">
										<span class="dashicons dashicons-edit"></span>
									</div>
								</div>
							</span>
							<div class="chl-element-structure">
								<div class="chl-element-column chl-element-contents desktop-topbar-left device-desktop" data-possition="desktop_topbar_left">
									<ul class="chl-element-sortable">									
										<?php
										if ( isset( $layout_data['topbar']['desktop_topbar_left'] ) ) {
											$dtl_datas = $layout_data['topbar']['desktop_topbar_left'];
											foreach ( $dtl_datas as $dtl_data ) {
												foreach ( $dtl_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );

													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
														<li class="chl-sortable-item">
															<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
																<div class="chl-element-content-inner">
																	<?php
																	if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																		$icon = $header_elements[ $element_id ]['element_icon'];
																		?>
																		<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																		<?php
																	}
																	?>
																	<span class="chl-element-title"><?php echo $element_title; ?></span>
																</div>
																<div class="chl-element-content-action">
																	<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																	<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
																</div>
															</div>
														</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents desktop-topbar-center device-desktop" data-possition="desktop_topbar_center">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['topbar']['desktop_topbar_center'] ) ) {
											$dtc_datas = $layout_data['topbar']['desktop_topbar_center'];
											foreach ( $dtc_datas as $dtc_data ) {
												foreach ( $dtc_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents desktop-topbar-right device-desktop" data-possition="desktop_topbar_right">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['topbar']['desktop_topbar_right'] ) ) {
											$dtr_datas = $layout_data['topbar']['desktop_topbar_right'];
											foreach ( $dtr_datas as $dtr_data ) {
												foreach ( $dtr_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>

								<div class="chl-element-column chl-element-contents mobile-topbar device-mobile" data-possition="mobile_topbar">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['topbar']['mobile_topbar'] ) ) {
											$mt_datas = $layout_data['topbar']['mobile_topbar'];
											foreach ( $mt_datas as $mt_data ) {
												foreach ( $mt_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="chl-row chl-elements-cover chl-main-header" data-possition="main" data-element_title="<?php _e( 'Main Header', 'pgs-core' ); ?>" data-element_data='<?php echo ( '' != $main_configuration ) ? wp_json_encode( $main_configuration ) : ''; ?>'>
						<div class="chl-element-inner">
							<span class="chl-element-title"><?php _e( 'Main Header', 'pgs-core' ); ?>
								<div class="chl-element-action">
									<div class="chl-icon-button chl-add-button chl-row-configure">
										<span class="dashicons dashicons-edit"></span>
									</div>
								</div>
							</span>
							<div class="chl-element-structure">
								<div class="chl-element-column chl-element-contents desktop-main-left device-desktop" data-possition="desktop_main_left">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['main']['desktop_main_left'] ) ) {
											$dml_datas = $layout_data['main']['desktop_main_left'];
											foreach ( $dml_datas as $dml_data ) {
												foreach ( $dml_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents desktop-main-center device-desktop" data-possition="desktop_main_center">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['main']['desktop_main_center'] ) ) {
											$dmc_datas = $layout_data['main']['desktop_main_center'];

											foreach ( $dmc_datas as $dmc_data ) {
												foreach ( $dmc_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents desktop-main-right device-desktop" data-possition="desktop_main_right">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['main']['desktop_main_right'] ) ) {
											$dmr_datas = $layout_data['main']['desktop_main_right'];
											foreach ( $dmr_datas as $dmr_data ) {
												foreach ( $dmr_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>

								<div class="chl-element-column chl-element-contents mobile-main-left device-mobile" data-possition="mobile_main_left">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['main']['mobile_main_left'] ) ) {
											$mml_datas = $layout_data['main']['mobile_main_left'];
											foreach ( $mml_datas as $mml_data ) {
												foreach ( $mml_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents mobile-main-center device-mobile" data-possition="mobile_main_center">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['main']['mobile_main_center'] ) ) {
											$mmc_datas = $layout_data['main']['mobile_main_center'];
											foreach ( $mmc_datas as $mmc_data ) {
												foreach ( $mmc_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents mobile-main-right device-mobile" data-possition="mobile_main_right">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['main']['mobile_main_right'] ) ) {
											$mmr_datas = $layout_data['main']['mobile_main_right'];
											foreach ( $mmr_datas as $mmr_data ) {
												foreach ( $mmr_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="chl-row chl-elements-cover chl-header-bottom" data-possition="bottom" data-element_title="<?php _e( 'Header Bottom', 'pgs-core' ); ?>" data-element_data='<?php echo ( '' != $bottom_configuration ) ? wp_json_encode( $bottom_configuration ) : ''; ?>'>
						<div class="chl-element-inner">
							<span class="chl-element-title"><?php _e( 'Header Bottom', 'pgs-core' ); ?>
								<div class="chl-element-action">
									<div class="chl-icon-button chl-add-button chl-row-configure">
										<span class="dashicons dashicons-edit"></span>
									</div>
								</div>
							</span>
							<div class="chl-element-structure">
								<div class="chl-element-column chl-element-contents desktop-bottom-left device-desktop" data-possition="desktop_bottom_left">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['bottom']['desktop_bottom_left'] ) ) {
											$dbl_datas = $layout_data['bottom']['desktop_bottom_left'];
											foreach ( $dbl_datas as $dbl_data ) {
												foreach ( $dbl_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents desktop-bottom-center device-desktop" data-possition="desktop_bottom_center">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['bottom']['desktop_bottom_center'] ) ) {
											$dbc_datas = $layout_data['bottom']['desktop_bottom_center'];
											foreach ( $dbc_datas as $dbc_data ) {
												foreach ( $dbc_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
								<div class="chl-element-column chl-element-contents desktop-bottom-right device-desktop" data-possition="desktop_bottom_right">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['bottom']['desktop_bottom_right'] ) ) {
											$dbr_datas = $layout_data['bottom']['desktop_bottom_right'];
											foreach ( $dbr_datas as $dbr_data ) {
												foreach ( $dbr_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>

								<div class="chl-element-column chl-element-contents mobile-bottom-right device-mobile" data-possition="mobile_bottom">
									<ul class="chl-element-sortable">
										<?php
										if ( isset( $layout_data['bottom']['mobile_bottom'] ) ) {
											$mb_datas = $layout_data['bottom']['mobile_bottom'];
											foreach ( $mb_datas as $mb_data ) {
												foreach ( $mb_data as $key => $value ) {
													$element_id    = $value[0]['element_id'];
													$element_title = $value[0]['element_title'];
													$element_data  = wp_json_encode( $value );
													if ( isset( $header_elements[ $element_id ] ) && $header_elements[ $element_id ] ) {
														?>
													<li class="chl-sortable-item">
														<div class="chl-element-content chl-element-drag chl-element-logo" data-element_id="<?php echo $element_id; ?>" data-element_title="<?php echo $element_title; ?>" data-element_data='<?php echo $element_data; ?>'>
															<div class="chl-element-content-inner">
																<?php
																if ( isset( $header_elements[ $element_id ]['element_icon'] ) && $header_elements[ $element_id ]['element_icon'] ) {
																	$icon = $header_elements[ $element_id ]['element_icon'];
																	?>
																	<span class="chl-element-icon"><i data-fip-value="<?php echo esc_attr( $icon ); ?>" class="<?php echo esc_attr( $icon ); ?>"></i></span>
																	<?php
																}
																?>
																<span class="chl-element-title"><?php echo $element_title; ?></span>
															</div>
															<div class="chl-element-content-action">
																<button class="chl-icon-button chl-clone-btn" data-tip="Clone"><span class="ti-layers"></span></button>
																<button class="chl-icon-button chl-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
															</div>
														</div>
													</li>
														<?php
													}
												}
											}
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="chl-device-elements-settings"></div>
			</div>
			<hr/>
		</div>
	</div>
</div>
