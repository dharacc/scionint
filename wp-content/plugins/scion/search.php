 
<?php 
global $wpdb;
if (!isset($wpdb)) {
    require_once('../../../wp-config.php'); 
}
$pageURL = site_url()."/wp-admin/admin.php?page=aff_org";
$searchTerm = $_GET['q'];
$results=$wpdb->get_results("select display_name, ID from wp_users where display_name like'%".$searchTerm."%' ");

// Generate skills data array
$skillData = array();
if($wpdb->num_rows > 0){
    foreach($results as $row){
        $skillData[] = $row;
    }
}

// Return results as json encoded array
echo json_encode($skillData);
?>

 
