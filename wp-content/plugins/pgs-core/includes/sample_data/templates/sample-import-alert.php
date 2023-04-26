<script type="text/html" id="tmpl-pgscore-sample-import-alert">
	<h3 class="sample-title"><?php echo esc_html('Sample Data', 'pgs-core');?> : {{data.title}}</h3>
	{{data.message}}
	<# if ( (data.additional_message) != "" ) { #>
		<br>
		<p>
			{{data.additional_message}}
		</p>
	<# } #>
	<# if ( data.import_requirements_list ) { #>
		<h3 class="import-requirements"><?php echo esc_html('Import Requirements', 'pgs-core');?> : </h3>
		<ul class="import-requirements-list">
			<# _.each( data.import_requirements_list, function(res, index) { #>
				<li>- {{res}}</li>
			<# }) #>
		</ul>
	<# } #>
	<# if ( data.required_plugins_list ) { #>
		<h3 class="required-plugins"><?php echo esc_html('Required Plugins', 'pgs-core');?> : </h3>
		<p class="required-plugins-message"><?php echo esc_html('Please install/activate below required plugins before proceed to import.', 'pgs-core');?></p>
		<ul class="required-plugins-list">
			<# _.each( data.required_plugins_list, function(res, index) { #>
				<li>- {{res}}</li>
			<# }) #>
		</ul>
	<# } #>
</script>