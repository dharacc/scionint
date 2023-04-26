<h3>Documents</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}

$pageURL = site_url()."/wp-admin/admin.php?page=doc_orgdoc";
 $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orgdoclist";	
  $pageURLd = site_url()."/wp-admin/admin.php?page=doc_orgdoclist";	
 

if($_POST)
{
	 
	
	if($_POST['sbt']=='Submit')
	{
		 extract($_POST);
	 
		 $wpdb->query("insert into documentlist(`docname`   ) values('".$docname."' )");
		 
		
		?>
<script>
		alert("Document created successfully.")
	location.href="<?php echo $pageURLE;?>"
</script>
       <?php
	}
 
}
?><style>
 td{font-size:16px; padding:10px;}
</style>
<!-- jQuery library -->
<script src="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/jquery.min.js"></script>

<!-- Tokeninput plugin library -->
<script src="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/token-input.css" />
<Br>
 
<div style="width:50%;float:left;">
	

<h4>Add </h4>
<form name="frm" id="frm" method="POST">
<table>
	<tr>
			<td>Document Name</td>
				<td>
					<input type="text" id="docname"  name="docname" onblur="getfunction(this.value)"/>
				</td>
				</tr>
				 
				  
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="sbt" id="sbt" value="Submit">
		 
					</td>
				</tr>
</table>
</form>
	</div>
	 
<script>
 
 
 var url = window.location.protocol + "//" +  window.location.host+"/";
 function getfunction(val)
 {
  if(val.length > 2)
  {
      
        jQuery.post(url+'checkuser.php',{val:val,type:'doclist'},function(data){
        if(data==1)
        {
            alert("Document name already exists");
            jQuery("#docname").val('')
         }
				 
        })
  }
 
 }
 
</script>

 
