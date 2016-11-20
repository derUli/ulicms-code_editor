<?php
$file = $_REQUEST ["file"];
$acl = new ACL ();
if ($acl->hasPermission ( "code_editor" ) and in_array ( $file, $_SESSION ["editable_code_files"] )) {
	$absPath = ULICMS_ROOT . $file;
	if (isset ( $_REQUEST ["save"] ) and isset ( $_POST ["data"] )) {
		file_put_contents ( $absPath, $_POST ["data"] );
	}
	$data = file_get_contents ( $absPath );
	?>
<h1><?php Template::escape($file);?></h1>
<?php if($data){?>
<form
	action="index.php?action=edit_code&file=<?php Template::escape($file);?>&save"
	method="post">
<?php csrf_token_html();?>
<p>
		<textarea name="data" cols=20 rows=80><?php Template::escape($data)?></textarea>
	</p>
	<p>
		<input type="submit" value="<?php translate("save_changes");?>">
	</p>
</form>
<?php }?>
<?php
} else {
	noperms ();
}