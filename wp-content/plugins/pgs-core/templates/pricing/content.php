<?php
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_pricing'] );
extract( $atts );

if ( empty( $title ) || empty( $features ) ) {
	return;
}

$pricing_classes   = array();
$pricing_classes[] = 'pgscore-pricing';
$pricing_classes[] = 'pgscore-pricing-' . $style;
if ( $bestseller ) {
	$pricing_classes[] = 'active';
}

$plan_features = array( $features );
if ( strpos( $features, "\n" ) !== false ) {
	$plan_features = explode( "\n", $features );
}

// Clean br tags from lines
if ( ! empty( $plan_features ) ) {
	foreach ( $plan_features as $line_k => $line ) {
		$line        = trim( $line );
		$line_length = strlen( $line );
		if ( substr( $line, -6 ) == '<br />' || substr( $line, -4 ) == '<br>' ) {
			if ( substr( $line, -6 ) == '<br />' ) {
				$line = mb_substr( $line, 0, $line_length - 6 );
			} elseif ( substr( $line, -4 ) == '<br>' ) {
				$line = mb_substr( $line, 0, $line_length - 4 );
			}
		}
		$plan_features[ $line_k ] = $line;
	}
}

$url_vars          = '';
$url_vars          = vc_build_link( $btnlink );
$url_vars['class'] = 'button button-border gray';

if ( pgscore_check_plugin_active( 'subscriptio/subscriptio.php' ) && $product_plan_link ) {
	$url             = wc_get_checkout_url() . '?add-to-cart=' . $product_plan_link;
	$url_vars['url'] = $url;
}
$link_attr = '';
if ( ! empty( $url_vars ) && is_array( $url_vars ) ) {
	foreach ( $url_vars as $url_var_k => $url_var_v ) {
		if ( ! empty( $url_var_v ) ) {
			if ( ! empty( $link_attr ) ) {
				$link_attr .= ' ';
			}
			if ( 'url' === $url_var_k ) {
				$link_attr .= 'href="' . esc_url( $url_var_v ) . '"';
			} else {
				$link_attr .= $url_var_k . '="' . $url_var_v . '"';
			}
		}
	}
}
$btn_attr = $link_attr;

$pricing_classes = implode( ' ', array_filter( array_unique( $pricing_classes ) ) );
?>
<div class="<?php echo esc_attr( $pricing_classes ); ?>">
	<?php
	if ( $bestseller ) {
		$label = ! empty( $bestseller_label ) ? $bestseller_label : esc_html__( 'Best Seller', 'pgs-core' );
		?>
		<div class="pricing-ribbon"> 
			<span class="ribbon"><?php echo esc_html( $label ); ?> </span>
		</div>
		<?php
	}
	?>
	<div class="pricing-title">
		<h2>
			<?php echo esc_html( $title ); ?>
		</h2>
		<span><?php echo esc_html( $subtitle ); ?></span>
		<div class="pricing-prize">
			<h2><?php echo esc_html( $price ); ?></h2>
			<span><?php echo esc_html( $frequency ); ?></span>
		</div>
	</div>
	<div class="pricing-list">
		<?php
		if ( ! empty( $plan_features ) ) {
			?>
			<ul>
				<?php
				foreach ( $plan_features as $feature ) {
					if ( ! empty( $feature ) ) {
						?>
						<li><?php echo esc_html( strip_tags( $feature ) ); ?></li>
						<?php
					}
				}
				?>
			</ul>
			<?php
		}
		?>
	</div>
	<div class="pricing-order">
		<a <?php echo $btn_attr; ?>>
			<?php echo esc_html( $btntext ); ?>
		</a>
	</div>
</div>
