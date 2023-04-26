<h3>Affiliate</h3>
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}
$pageURL = site_url()."/wp-admin/admin.php?page=aff_org";
$results=$wpdb->get_results("select * from affiliate ");
if($_POST)
{
	extract($_POST);
	 
	if(empty($_POST['id']))
	{
	 
			$wpdb->query("insert into affiliate(`country`, `affiliate`, `website`, `logo`, `created`,description) values('".$country."','".$affiliate."','".$website."','".$logo."','".date('Y-m-d H:i:s')."','".$description."')");
		 
			?>
	<script>
	location.href="<?php echo $pageURL;?>&succ=1"
	</script>
	<?php
	}
	if($_POST['id']!='')
	{
		$wpdb->query("update affiliate set `country`='".$country."',description='".$description."', `affiliate`='".$affiliate."', `website`='".$website."', `logo`='".$logo."'  where id='".$id."'");
		?>
	<script>
	location.href="<?php echo $pageURL;?>&succ=2"
	</script>
	<?php
		
	}
	
	
}
$succ='';
$idv='';
$ids='';
$country='';
$description='';
$affiliate='';
$website='';
$logo='';
 
if($_GET)
{
	if(isset($_GET['action']))
	{
		if(($_GET['action'])=='delete')
	{	
		$idv=$_GET['id'];
		$edit=$wpdb->query("delete from affiliate  where id='".$idv."'");
		 ?>
	<script>
	location.href="<?php echo $pageURL;?>&succ=3"
	</script>
	<?php
	}
	}
	if(isset($_GET['succ']))
	{
	if($_GET['succ']==1)
	{
		$succ='Insert successfully done.';
	}
	if($_GET['succ']==2)
	{
		$succ='Edit successfully done.';
	}
	if($_GET['succ']==3)
	{
		$succ='Delete successfully done.';
	}
	}
	if(isset($_GET['action']))
	{
		if(($_GET['action'])=='edit')
	{
		$ids=$_GET['id'];
		$edit=$wpdb->get_row("select * from affiliate  where id='".$ids."'");
		$country=$edit->country;
		$affiliate=$edit->affiliate;
		$website=$edit->website;
		$logo=$edit->logo;
		$description=$edit->description;
	}
	}
	
}
?>

<Br>
<span style="color:green"><b><?php echo $succ;?></b></span>
<style>
 td{font-size:16px; padding:10px;}
</style>
<h4>Add Affiliate</h4>
<form name="frm" id="frm" method="POST">
<table >
				<tr>
			<td>Country</td>
				<td>
					<select name="country" id="country" style="width:200px;">
						<option value="">Select Country</option>
						<?php foreach(COUNTRY as $id=>$val){?>
							<option value="<?php echo $id;?>" <?php if($id==$country){echo "selected";}?>><?php echo $val;?></option>
						<?php }?>
					</select>
				</td>
				</tr>
				<tr>
					<td>Affiliate Name</td>
					<td>
						<input type="text" name="affiliate" id="affiliate" style="width:200px;" value="<?php echo $affiliate;?>">
					</td>
				</tr>
				<tr>
					<td>Affiliate website</td>
					<td>
						<input type="text" name="website" id="website" style="width:200px;" value="<?php echo $website;?>">
					</td>
				</tr>
				<tr>
					<td>Affiliate Description</td>
					<td>
						<input type="text" name="description" id="description" style="width:200px;" value="<?php echo $description;?>">
					</td>
				</tr>
				<tr>
					<td>Affiliate Logo URL</td>
					<td>
						<input type="text" name="logo" id="logo" style="width:200px;" value="<?php echo $logo;?>">
						<?php if($logo!=''){?><img src="<?php echo $logo;?>" width="200"><?php }?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="sbt" id="sbt" value="Submit">
						<input type="hidden" name="id" id="id" value="<?php echo $ids;?>">
					</td>
				</tr>
</table>
</form><br><br>
<table style="background:#222;" cellpadding="2" cellspacing="2" >
<tr style="background:#fff;font-weight:bold;color:#222;">
<td>S No</td>
<td>Country</td>
<td>Name</td>
<td>Website</td>
<td>Logo</td>
<td>Description</td>
<td>Action</td>
</tr>
<?php
$i=1;
$countryval=COUNTRY;
foreach($results as $resval)

{
	?>
	<tr  style="background:#eaeaea;color:#222; ">
<td><?php echo $i++;?></td>
<td><?php echo $countryval[$resval->country];?></td>
<td><?php echo $resval->affiliate;?></td>
<td><?php echo $resval->website;?></td>
<td><img src="<?php echo $resval->logo;?>" height="30"></td>
<td><?php echo $resval->description;?></td>
<td><a href="<?php echo $pageURL;?>&action=edit&id=<?php echo $resval->id;?>">Edit</a> <a href="<?php echo $pageURL;?>&action=delete&id=<?php echo $resval->id;?>">Delete</a></td>
</tr>
	<?php
}?>
</table>
