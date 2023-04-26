<h3>Document Role Edit</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}

$pageURL = site_url()."/wp-admin/admin.php?page=doc_orgdoclistedit";
 $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orgdoclistedit";	
  $pageURLD = site_url()."/wp-admin/admin.php?page=doc_orgdoclist";	
  
  $id=$_GET['id'];
  $typ=$_GET['a'];
  
if($_POST)
{
	$docname=''; 
	
	if($_POST['sbt']=='Submit')
	{
		 extract($_POST);
 
		 $wpdb->query("update documentlist set `docname`='".$docname."'   where id='".$idv."'");
		
		  
		?>
<script>
		alert("Document name updated successfully.")
	location.href="<?php echo $pageURLE;?>&id="+<?php echo $idv;?>+"&a=1"
</script>
       <?php
	}
 
}


   if( $typ=='1')
   {
 		 
 		 $drol=$wpdb->get_row("select * from documentlist where id='".$id."'");
 		 
 		 
 		 
 }
  if( $typ=='2')
   {
  	$drol=$wpdb->query("delete from documentlist where id='".$id."'"); 
   		?>
<script>
		alert("Document name delete successfully.")
	location.href="<?php echo $pageURLD;?>&id="+<?php echo $id;?>+"&a=1"
</script>
       <?php
 }
 ?>
 <!-- jQuery library -->
<script src="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/jquery.min.js"></script>

<!-- Tokeninput plugin library -->
<script src="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="<?php echo plugins_url('', dirname(__FILE__) );?>/scion/token-input.css" />
 <div style="width:50%;float:left;">
	

<h4>Edit </h4>
<form name="frm" id="frm" method="POST">
<table>
	<tr>
			<td>Document Name</td>
				<td>
					<input type="text" id="docname"  name="docname" value="<?php echo  $drol->docname;?>"/>
				</td>
				</tr>
			 <input type="hidden" id="idv"  name="idv" value="<?php echo $id;?>"/>
				 
				 
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="sbt" id="sbt" value="Submit">
		 
					</td>
				</tr>
</table>
</form>
	</div>
  <style>
 td{font-size:16px; padding:10px;}
</style>
	
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
 
      
      
