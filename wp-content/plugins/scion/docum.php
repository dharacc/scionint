<h3>Document Role</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}

$pageURL = site_url()."/wp-admin/admin.php?page=aff_org";
 $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orglist";	
  $pageURLd = site_url()."/wp-admin/admin.php?page=doc_orge";	
 $results=$wpdb->get_results("select display_name, ID from wp_users order by  display_name ");
 $products=$wpdb->get_results("SELECT ID,post_title FROM `wp_posts` where post_type='product' and post_status='publish' ");
 $doclist=$wpdb->get_results("select docname, id from documentlist order by  docname ");
if($_POST)
{
	$doc1='';$doc2='';$doc3='';$doc4='';$doc5='';$doc6='';
	
	if($_POST['sbt']=='Submit')
	{
		 extract($_POST);
	 
		 $wpdb->query("insert into documentrole(`groupname`, `doc1`, `doc2`, `doc3`, `doc4`, `doc5`, `doc6`   ) values('".strtolower($groupname)."','".$doc1."','".$doc2."','".$doc3."','".$doc4."','".$doc5."','".$doc6."')");
		
		 $lastid = $wpdb->insert_id;
		$userids=explode(",",$userid);
		foreach($userids as $myid)
		{
			$wpdb->query("insert into documentuser(`did`, `userid`, `brandid`, `catid`, `productid`) values('".$lastid."','".$myid."','".$brand."','".$cat."','".$product."')");
		}
		
		?>
<script>
		alert("Role created successfully.")
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
			<td>Group Name</td>
				<td>
					<input type="text" id="groupname"  name="groupname" onblur="getfunction(this.value)"/>
				</td>
				</tr>
				<tr>
			<td>Customer User Name</td>
				<td>
					<input type="text" id="userid"  name="userid"/>
				</td>
				</tr>
				<tr>
					<td>Product Brand</td>
					<td>
					<input type="text" id="brand"  name="brand"/>
						 
					</td>
				</tr>
				<tr>
					<td>Product Category</td>
					<td>
						<input type="text" name="cat" id="cat"  >
					</td>
				</tr>
				<tr>
					<td>Product Name</td>
					<td>
						<input type="text" name="product" id="product"  >
					</td>
				</tr>
<tr>
					<td><B>Documents List</b></td>
					<td>
						&nbsp;
					</td>
				</tr>
<?php $i=1;foreach( $doclist as $dcval){?>				<tr>
					<td><?php echo $dcval->docname;?></td>
					<td>
					<input type="checkbox" name="doc[]" id="doc1" value="<?php echo $dcval->id;?>"> 
					 
					</td>
				</tr>
				  <?php $i++;}?>
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
 var usr = [
      <?php foreach($results as $uval){?>
		{id: <?php echo $uval->ID;?>, name: "<?php echo $uval->display_name;?> - <?php echo $uval->ID;?>"},
	  <?php }?>
    ];
	 var prod = [
      <?php foreach($products as $pval){?>
		{id: <?php echo $pval->ID;?>, name: "<?php echo $pval->post_title;?> - <?php echo $uval->ID;?>"},
	  <?php }?>
    ];
	<?php
	$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);
 
$product_categories = get_terms( 'product_cat', $cat_args );

	$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);
 
$product_brand = get_terms( 'yith_product_brand', $cat_args );

 
 ?>
  var prodcat = [
 <?php
if( !empty($product_categories) ){
 
    foreach ($product_categories as $key => $category) {
       			$parent_name='';
       			 
              if(!empty($category->parent))
              {
             			 
 			$par=$wpdb->get_row("SELECT name FROM `wp_terms` where term_id='".$category->parent."'");
 			if($par) $parent_name=$par->name." - ";
              }
		?>
		{id: <?php echo $category->term_id;?>, name: "<?php echo $parent_name;?><?php echo $category->name;?> - <?php echo $category->term_id;?>"},
		<?php
	}
}
 
	?>
 ];
 
 var prodbrand = [
 <?php
 
if( !empty($product_brand) ){
 
    foreach ($product_brand as $key => $category) {
           
		?>
		{id: <?php echo $category->term_id;?>, name: "<?php echo $category->name;?> - <?php echo $category->term_id;?>"},
		<?php
	}
}
	?>
 ]
 var url = window.location.protocol + "//" +  window.location.host+"/";
 function getfunction(val)
 {
  if(val.length > 2)
  {
      
        jQuery.post(url+'checkuser.php',{val:val,type:'rolelist'},function(data){
        if(data==1)
        {
            alert("Role name already exists");
            jQuery("#groupname").val('')
         }
				 
        })
  }
 
 }
 
 
jQuery(document).ready(function() {
    jQuery("#userid").tokenInput(usr);
    jQuery("#product").tokenInput(prod);
    jQuery("#cat").tokenInput(prodcat);
    jQuery("#brand").tokenInput(prodbrand);
	
});
</script>

 
