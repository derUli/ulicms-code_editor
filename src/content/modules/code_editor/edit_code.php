<?php
$acl = new ACL ();
if ($acl->hasPermission ( "code_editor" )) {
	?>
Coming Soon!
<?php
} else {
	noperms ();
}