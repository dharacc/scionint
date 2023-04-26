 <?php 
 /*
   Plugin Name: Scion Settings 
   description: Add Country & Affiliate Details
   Version: 1.0
   Author: Durai 
   License: GPL2
*/
 
#######################################

function spotlight() {
    //include('spotlight_admin.php');
} 

function doc_org()
{
	include("docum.php");
}
function doc_orglist()
{
	include("documlist.php");
}

function doc_orgdoclist()
{
include("adddocumentlist.php");
} 
function doc_orgdoc()
{
include("adddocument.php");
}
function aff_org()
{
	include("aff.php");
}
function doc_orgdoclistedit()
{
 	include("doceditv.php");
}


function aff_orgd()
{
	include("del.php");
}
function aff_orge()
{
 
 include("editv.php");
}
function scion_data() {
    add_menu_page("scionaffiliate", "Scion Affiliate", 'edit_pages', "scionaffiliate", "scionaffiliate",  home_url()."/wp-content/plugins/pie-register-premium/assets/images/pr_icon.png", 55);
    add_submenu_page("scionaffiliate", "Manage Affiliate", "Manage Affiliate", 'edit_pages', "aff_org", "aff_org");
        add_submenu_page("scionaffiliate", "Add Documents", "Add Documents", 'edit_pages', "doc_orgdoc", "doc_orgdoc");
            add_submenu_page("scionaffiliate", "Documents List", "Documents List", 'edit_pages', "doc_orgdoclist", "doc_orgdoclist");
    add_submenu_page("scionaffiliate", "Add User Role", "Add User Role", 'edit_pages', "doc_org", "doc_org");
        add_submenu_page("scionaffiliate", "Role Lists", "Role Lists", 'edit_pages', "doc_orglist", "doc_orglist");
    add_submenu_page("scionaffiliate", "Edit User Role ", "Edit User Role", 'edit_pages', "doc_orge", "aff_orge");
     add_submenu_page("scionaffiliate", "Edit Document ", "Edit Document", 'edit_pages', "doc_orgdoclistedit", "doc_orgdoclistedit");
 
    //add_submenu_page("OverDrive_spotlight_2", "Spotlight", "Spotlight", 10, "spotlight_org", "od_spotlight_page");
}

add_action('admin_menu', 'scion_data');
