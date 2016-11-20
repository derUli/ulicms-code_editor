<?php
class CodeEditorController {
	public function getMimeTypeForExtension($ext) {
		$mime = null;
		switch ($mime) {
			case "php" :
			case "html" :
				$mime = "application/x-httpd-php";
				break;
				break;
			case "css" :
				$mime = "text/css";
				break;
			case "js" :
			case "json" :
				$mime = "text/javascript";
				break;
				break;
		}
		return $mime;
	}
	public function getAllEditableFiles() {
		$contentFolder = Path::resolve ( "ULICMS_ROOT/content" );
		$files = find_all_files ( $contentFolder );
		$editableFileTypes = array (
				"php",
				"css",
				"html",
				"js",
				"json" 
		);
		$editableFiles = array ();
		foreach ( $files as $file ) {
			$ext = file_extension ( $file );
			if (in_array ( $ext, $editableFileTypes ) and is_writable ( $file )) {
				$file = substr ( $file, strlen ( ULICMS_ROOT ) );
				$editableFiles [] = $file;
			}
		}
		
		natcasesort ( $editableFiles );
		return $editableFiles;
	}
	public function canEditFile($file) {
		if (isset ( $_SESSION ["editable_code_files"] ) and is_array ( $_SESSION ["editable_code_files"] )) {
			
			return in_array ( $file, $_SESSION ["editable_code_files"] );
		} else {
			
			return in_array ( $file, $this->getAllEditableFiles () );
		}
	}
	public function isWritable($file) {
		$file = ULICMS_ROOT . "/" . $file;
		return (is_file ( $file ) and is_writable ( $file ));
	}
}