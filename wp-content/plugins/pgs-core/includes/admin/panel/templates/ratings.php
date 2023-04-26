<div class="ratings-content">
	<p><?php
	echo sprintf(
		esc_html__( 'Please don\'t forget to rate %1$s and leave a nice review, it means a lot to us and our theme.', 'pgs-core' ),
		'<strong>' . $this->theme_data['Name'] . '</strong>'
	);
	?></p>
	<p>
	<?php
	echo sprintf(
		wp_kses(
			__( 'Simply login into your ThemeForest account, go to the <a rel="noopener" target="_blank" href="%2$s">Downloads</a> section and click 5 stars next to the %1$s WordPress theme as shown in the screenshot below:', 'pgs-core' ),
			array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
					'rel'    => array(),
				),
			)
		),
		'<strong>' . $this->theme_data['Name'] . '</strong>',
		'https://themeforest.net/downloads'
	);
	?>
	</p>
	<img src="<?php echo esc_url( get_parent_theme_file_uri( '/images/admin/cs-admin/rate.png' ) ); ?>" />
</div>
