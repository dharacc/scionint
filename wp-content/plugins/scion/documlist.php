<h3>Document Role</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}

$pageURL = site_url()."/wp-admin/admin.php?page=aff_org";
 $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orge";	
  $pageURLd = site_url()."/wp-admin/admin.php?page=doc_orge";	
 $results=$wpdb->get_results("select display_name, ID from wp_users order by  display_name ");
 $products=$wpdb->get_results("SELECT ID,post_title FROM `wp_posts` where post_type='product' and post_status='publish' ");

if($_POST)
{
	$doc1='';$doc2='';$doc3='';$doc4='';$doc5='';$doc6='';
	
	if($_POST['sbt']=='Submit')
	{
		 extract($_POST);
	 
		 $wpdb->query("insert into documentrole(`groupname`, `doc1`, `doc2`, `doc3`, `doc4`, `doc5`, `doc6`   ) values('".$groupname."','".$doc1."','".$doc2."','".$doc3."','".$doc4."','".$doc5."','".$doc6."')");
		
		 $lastid = $wpdb->insert_id;
		$userids=explode(",",$userid);
		foreach($userids as $myid)
		{
			$wpdb->query("insert into documentuser(`did`, `userid`, `brandid`, `catid`, `productid`) values('".$lastid."','".$myid."','".$brand."','".$cat."','".$product."')");
		}
		
		?>
<script>
		alert("Role created successfully.")
	location.href="<?php echo $pageURL;?>"
</script>
       <?php
	}
 
}
?>
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
<tr  style="background:#fff;font-weight:bold;color:#222;"><td>Role Name</td><td>Edit</td><td>Delete</td></tr>
<?php $drol=$wpdb->get_results("select * from documentrole order by id desc");
  foreach($drol as $dval)
  {
  ?>
  <tr  style="background:#eaeaea;color:#222; "><td><?php echo $dval->groupname;?></td><td><a href="<?php echo $pageURLE ;?>&id=<?php echo $dval->id;?>&a=1">Edit</a> </td><td> <a href="<?php echo $pageURLE ;?>&id=<?php echo $dval->id;?>&a=2">Delete</a></td></tr>
  <?php
  }

?>
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
jQuery(document).ready(function() {
    jQuery("#userid").tokenInput(usr);
    jQuery("#product").tokenInput(prod);
    jQuery("#cat").tokenInput(prodcat);
    jQuery("#brand").tokenInput(prodbrand);
	
});
</script>

 
