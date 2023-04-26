<?php
/**
* Widget Customization
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_config_setup() {
	$sections = array(
		'basic_settings'     => 'pgssl_component_config_setup_basic_settings'    ,
	);

	$sections = apply_filters( 'pgssl_component_config_setup_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_config_setup_sections', $action );
	}
	
	do_action( "pgssl_component_config_setup_start" );
	?>
	<div>
		<?php do_action( 'pgssl_component_config_setup_sections' ); ?>
	</div>
	<?php
	do_action( "pgssl_component_config_setup_end" );
}

function pgssl_component_config_setup_basic_settings() {
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Basic Settings", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php _pgssl_e("<b>Connect with caption :</b> Change the content of the label to display above PGS Social Login widget.", 'pgssl-text-domain') ?>
		</p>

		<p>
			<?php _pgssl_e("<b>Social icon set :</b> PGS Social Login provides two set of icons to display on the widget.", 'pgssl-text-domain') ?>
			<?php _pgssl_e("You can also display the providers names instead of icons. This allow the customization of the widget to a great extent", 'pgssl-text-domain') ?>
		</p>

		<table width="100%" border="0" cellpadding="5" cellspacing="2" style="border-top:1px solid #ccc;">
		  <tr>
			<td align="right"><strong><?php _pgssl_e("Social icon set", 'pgssl-text-domain') ?> :</strong></td>
			<td> 	
				<?php
				$icon_sets = array(
					'wpzoom'   => "WPZOOM social networking icon set",
					'icondock' => "Icondock vector social media icons",
				);

				$icon_sets = apply_filters( 'pgssl_component_condfig_setup_alter_icon_sets', $icon_sets );
				
				$pgssl_settings_social_icon_set = get_option( 'pgssl_settings_social_icon_set' );
				?>
				<select name="pgssl_settings_social_icon_set" style="width:535px">
					<?php
						foreach( $icon_sets as $folder => $label ) {
							?>
								<option <?php if( $pgssl_settings_social_icon_set == $folder ) echo "selected"; ?>   value="<?php echo $folder; ?>"><?php _pgssl_e( $label, 'pgssl-text-domain' ) ?></option>
							<?php
						}
					?>
					<option <?php if( $pgssl_settings_social_icon_set == "none" ) echo "selected"; ?>     value="none"><?php _pgssl_e("None, display providers names instead of icons", 'pgssl-text-domain') ?></option>
				</select>
			</td>
		  </tr>
		</table>
	</div>
</div>
<?php
}