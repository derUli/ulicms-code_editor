<?php

use Rakit\Validation\Validator;

class CodeEditorController extends MainClass
{
    public function _getMimeTypeForFile($file)
    {
        $ext = file_extension($file);
        return $this->_getMimeTypeForExtension($ext);
    }

    public function _getMimeTypeForExtension($ext)
    {
        $mime = null;
        switch ($ext) {
            case "php":
            case "html":
                $mime = "application/x-httpd-php";
                break;
            case "css":
                $mime = "text/css";
                break;
            case "js":
            case "json":
                $mime = "text/javascript";
                break;
        }
        return $mime;
    }

    public function _getAllEditableFiles()
    {
        $contentFolder = Path::resolve("ULICMS_DATA_STORAGE_ROOT/content");
        $files = find_all_files($contentFolder);
        $editableFileTypes = array(
            "php",
            "css",
            "html",
            "js",
            "json"
        );
        $editableFiles = array();
        foreach ($files as $file) {
            $ext = file_extension($file);
            if (in_array($ext, $editableFileTypes) and is_writable($file)) {
                $file = substr($file, strlen(ULICMS_DATA_STORAGE_ROOT));
                $editableFiles [] = $file;
            }
        }

        $editableFiles = array_filter($editableFiles, function ($file) {
            return !startsWith($file, "/content/cache") &&
                    !startsWith($file, "/content/tmp");
        });

        natcasesort($editableFiles);
        return $editableFiles;
    }

    public function _canEditFile($file)
    {
        if (isset($_SESSION ["editable_code_files"]) and is_array($_SESSION ["editable_code_files"])) {
            return in_array($file, $_SESSION ["editable_code_files"]);
        } else {
            return in_array($file, $this->_getAllEditableFiles());
        }
    }

    public function _isWritable($file)
    {
        $file = ULICMS_ROOT . "/" . $file;
        return (is_file($file) and is_writable($file));
    }

    public function settings()
    {
        return Template::executeModuleTemplate(
            "code_editor",
            "admin.php"
        );
    }

    public function getSettingsHeadline()
    {
        return get_translation("code_editor");
    }

    public function savePost()
    {
        $this->validateInput();

        $file = Request::getVar("file");
        $data = Request::getVar("data");

        $absPath = ULICMS_DATA_STORAGE_ROOT . $file;
        if ($this->_canEditFile($file)) {
            file_put_contents($absPath, $data);
            Response::sendHttpStatusCodeResultIfAjax(
                HttpStatusCode::OK,
                ModuleHelper::buildActionURL(
                        "edit_code",
                        "file=" . urlencode($file)
                    )
            );
        }
        ExceptionResult(get_translation("forbidden"), HttpStatusCode::FORBIDDEN);
    }

    protected function validateInput()
    {
        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            'file' => 'required'
        ]);
        $validation->validate();

        $errors = $validation->errors()->all('<li>:message</li>');

        if ($validation->fails()) {
            $html = '<ul>';
            foreach ($errors as $error) {
                $html .= $error;
            }
            $html .= '</ul>';
            ExceptionResult($html, HttpStatusCode::UNPROCESSABLE_ENTITY);
        }
    }
}
