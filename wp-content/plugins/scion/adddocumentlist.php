<h3>Document Role</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}

$pageURL = site_url()."/wp-admin/admin.php?page=doc_orgdoc";
 $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orgdoclistedit";	
  $pageURLd = site_url()."/wp-admin/admin.php?page=doc_orgdoclist";	
  
?><style>
 td{font-size:16px; padding:10px;}
</style>
<!-- jQuery library -->
<script src="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/jquery.min.js"></script>

<!-- Tokeninput plugin library -->
<script src="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/token-input.css" />
<Br>
 
 <style>
 td{font-size:16px; padding:10px;}
</style>
	<div style="width:70%;">
		
<h4>List </h4>
<table style="background:#222;width:600px" cellpadding="1" cellspacing="1"  >
<tr  style="background:#fff;font-weight:bold;color:#222;"><td>Document Name</td><td>Edit</td><td>Delete</td></tr>
<?php $drol=$wpdb->get_results("select * from documentlist order by id desc");
  foreach($drol as $dval)
  {
  ?>
  <tr  style="background:#eaeaea;color:#222; "><td><?php echo $dval->docname;?></td><td><a href="<?php echo $pageURLE ;?>&id=<?php echo $dval->id;?>&a=1">Edit</a> </td><td> <a href="<?php echo $pageURLE ;?>&id=<?php echo $dval->id;?>&a=2">Delete</a></td></tr>
  <?php
  }

?>
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

 
