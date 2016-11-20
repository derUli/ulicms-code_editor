<?php
define ( "MODULE_ADMIN_HEADLINE", get_translation ( "code_editor" ) );
define ( "MODULE_ADMIN_REQUIRED_PERMISSION", "code_editor" );
function code_editor_admin() {
	$controller = new CodeEditorController ();
	$files = $controller->getAllEditableFiles ();
	$_SESSION ["editable_code_files"] = $files;
	?>
<table class="tablesorter">
	<thead>
		<tr>
			<th>
<?php translate("file");?>
</th>
			<th><?php translate("type")?></th>
			<th>
<?php translate("last_changed");?>
</th>
			<th>
<?php translate("size");?>
</th>
		</tr>
	</thead>
	<tbody>
<?php
	
	foreach ( $files as $file ) {
		$absPath = ULICMS_ROOT . $file;
		?>
<tr>
			<td style="word-break: break-all;"><a
				href="index.php?action=edit_code&file=<?php Template::escape($file);?>">
				<?php Template::escape($file);?></a></td>
			<td><?php echo file_extension($file);?></td>
			<td><?php
		echo strftime ( "%x %X", filemtime ( $absPath ) );
		?></td>
			<td style="text-align: right;"><?php echo round(filesize($absPath) / 1024, 2);?> KB</td>

		</tr>
<?php }?>
	</tbody>
</table>
<?php
}
?>
