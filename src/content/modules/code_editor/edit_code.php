<?php
$file = $_REQUEST ["file"];
$acl = new ACL ();
if ($acl->hasPermission ( "code_editor" ) and in_array ( $file, $_SESSION ["editable_code_files"] )) {
	?>
<h1><?php Template::escape($file);?></h1>
Coming Soon!
<?php
} else {
	noperms ();
}