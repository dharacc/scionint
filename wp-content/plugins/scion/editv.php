<h3>Document Role Edit</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}

$pageURL = site_url()."/wp-admin/admin.php?page=doc_org";
 $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orge";	
  $pageURLE = site_url()."/wp-admin/admin.php?page=doc_orge";	
  
 $doclist=$wpdb->get_results("select docname, id from documentlist order by  docname "); 
  $id=$_GET['id'];
  $typ=$_GET['a'];
  $droldet=array(); $brandsarr=array(); $catarr=array(); $docarr=array(); $prodarr=array(); $brandval='';$catval='';$prodval='';$docval='';
  
  
if($_POST)
{
	$doc1='';$doc2='';$doc3='';$doc4='';$doc5='';$doc6='';
 
	if($_POST['sbt']=='Submit')
	{
		 extract($_POST);
 
		 $wpdb->query("update documentrole set `groupname`='".$groupname."' where id='".$idv."'");
		
		  $wpdb->query("delete from documentuser where did='".$idv."'");
		$userids=explode(",",$userid);
		
		 foreach($doc as $dcval)
		 {
		 $doc1.=$dcval.",";
		 }
		 $doc1=substr($doc1,0,-1);
		foreach($userids as $myid)
		{
		  
			$wpdb->query("insert into documentuser(`did`, `userid`, `brandid`, `catid`, `productid`,docid) values('".$idv."','".$myid."','".$brand."','".$cat."','".$product."','".$doc1."')");
		}
		
		?>
<script>
		alert("Role updated successfully.")
	location.href="<?php echo $pageURLE;?>&id="+<?php echo $idv;?>+"&a=1"
</script>
       <?php
	}
 
}


   if( $typ=='1')
   {
 		$results=$wpdb->get_results("select display_name, ID from wp_users order by  display_name ");
 		$products=$wpdb->get_results("SELECT ID,post_title FROM `wp_posts` where post_type='product' and post_status='publish' ");
 		
 		 $drol=$wpdb->get_row("select * from documentrole where id='".$id."'");
 		 $droldet=$wpdb->get_results("select * from documentuser a left join  wp_users b on a.userid=b.ID where a.did='".$drol->id."'");
 		 
 		 if(!empty($droldet[0]->brandid))$brandval=$droldet[0]->brandid;
 		 if(!empty($droldet[0]->catid))$catval=$droldet[0]->catid;
 		 if(!empty($droldet[0]->productid))$prodval=$droldet[0]->productid;
 		 	 if(!empty($droldet[0]->docid))$docval=$droldet[0]->docid;
 		 if(!empty($brandval))
 		 {
 		 	$brandsarr=explode(",",$brandval);
 		 }
 		 
 		 if(!empty($catval))
 		 {
 		 	$catarr=explode(",",$catval);
 		 }
 		 if(!empty($prodval))
 		 {
 		 	$prodarr=explode(",",$prodval);
 		 }
 		  if(!empty($docval))
 		 {
 		 	$docarr=explode(",",$docval);
 		 }
 		 
 		 
 }
 
  if( $typ=='2')
   {
  $drol=$wpdb->query("delete from documentrole where id='".$id."'");
   $drol=$wpdb->query("delete from documentuser where did='".$id."'");
   		?>
<script>
		alert("Role updated successfully.")
	location.href="<?php echo $pageURLE;?>&id="+<?php echo $id;?>+"&a=1"
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
			<td>Group Name</td>
				<td>
					<input type="text" id="groupname"  name="groupname" value="<?php echo  $drol->groupname;?>"/>
				</td>
				</tr>
				<tr>
			<td>Customer User Name</td>
				<td>
					<input type="text" id="userid"  name="userid"/> <input type="hidden" id="idv"  name="idv" value="<?php echo $id;?>"/>
				</td>
				</tr>
				<tr>
					<td>Product Brand</td>
					<td>
						<input type="text" name="brand" id="brand"  >
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
					<input type="checkbox" name="doc[]" id="doc1" <?php if(in_array($dcval->id,$docarr)){echo "checked";}?> value="<?php echo $dcval->id;?>"> 
					
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
  <style>
 td{font-size:16px; padding:10px;}
</style>
	
	<script>
 var usr = [
      <?php foreach($results as $uval){?>
		{id: <?php echo $uval->ID;?>, name: "<?php echo $uval->display_name;?> - <?php echo $uval->ID;?>"},
	  <?php }?>
    ];
	 var prod = [
      <?php foreach($products as $pval){?>
		{id: <?php echo $pval->ID;?>, name: "<?php echo $pval->post_title;?> - <?php echo $pval->ID;?>"},
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
    jQuery("#userid").tokenInput(usr, {
                prePopulate: [
                <?php
	 if(!empty($droldet)) {
	 	 foreach($droldet as $uidval)
 		 {
 		 	?>
 		 	  {id: "<?php echo $uidval->ID;?>",  name: "<?php echo $uidval->display_name;?> - <?php echo $uidval->ID;?>"},
 		 	<?php
 		 } }
 		 
 	?>
                   
                ]});
    jQuery("#product").tokenInput(prod, {
                prePopulate: [
                <?php
	 if(!empty($prodarr)) {
	 	 foreach($prodarr as $prodva)
 		 {
 		 	$productsingle=$wpdb->get_row("SELECT ID,post_title FROM `wp_posts` where post_type='product' and ID='".$prodva."' and post_status='publish' ");
 		 	?>
 		 	  {id: "<?php echo $prodva;?>",  name: "<?php echo $productsingle->post_title;?> - <?php echo $prodva;?>"},
 		 	<?php
 		 } }
 		 
 	?>
                   
                ]});
    jQuery("#cat").tokenInput(prodcat, {
                prePopulate: [
                <?php
	 if(!empty($catarr)) {
	 	 foreach($catarr as $cval)
 		 {
	 		 if(!empty($cval))
	 		 {
	 		     $cname=$wpdb->get_row("SELECT name FROM `wp_terms` where term_id='".$cval."'");
	 		   $v= get_category_parents( $cval, true );print_r($v);
	 		 	?>
	 		 	  {id: "<?php echo $cval;?>",  name: "<?php echo $cname->name;?> - <?php echo $cval;?>"},
	 		 	<?php
	 		 }
 		 }
 		 } 
 	?>
                   
                ]});
    jQuery("#brand").tokenInput(prodbrand, {
                prePopulate: [
                <?php
	 if(!empty($brandsarr)) {
	 	 foreach($brandsarr as $bval)
 		 {
 		 $bname=$wpdb->get_row("SELECT name FROM `wp_terms` where term_id='".$bval."'");
 		 	?>
 		 	  {id: "<?php echo $bval;?>",  name: "<?php echo $bname->name;?> - <?php echo $bval;?>"},
 		 	<?php
 		 } }
 		 
 	?>
                   
                ]});
	
});
</script>
 
      
      
