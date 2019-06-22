<?php
$file = $_REQUEST["file"];
$controller = new CodeEditorController();
if (in_array($file, $_SESSION["editable_code_files"])) {
    $absPath = ULICMS_DATA_STORAGE_ROOT . $file;
    // TODO: move this to CodeEditorController
    if (isset($_REQUEST["save"]) and isset($_POST["data"])) {
        file_put_contents($absPath, $_POST["data"]);
        if (Request::isAjaxRequest()) {
            exit();
        }
    }
    $data = file_get_contents($absPath);
    ?>
    <p><a href="<?php echo ModuleHelper::buildAdminUrl("code_editor"); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> <?php translate("back"); ?></a></p>
    <p>
        <strong><?php Template::escape($file); ?></strong>
    </p>
    <?php if ($data) { ?>
        <form
            action="index.php?action=edit_code&file=<?php Template::escape($file); ?>&save"
            method="post" id="code-form">
                <?php csrf_token_html(); ?>
            <p>
                <textarea id="data" name="data" cols="20" rows="80" class="codemirror" data-mimetype="<?php esc($controller->getMimeTypeForFile($file)); ?>"><?php Template::escape($data); ?></textarea>
            </p>
            <p>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php translate("save_changes"); ?></button>
            </p>


            <div class="inPageMessage">
                <div id="msg_code_edit" class="inPageMessage"></div>
                <img class="loading" src="gfx/loading.gif" alt="Wird gespeichert...">
            </div>
        </form>
        <?php
        $translation = new JSTranslation();
        $translation->addKey("changes_was_saved");
        $translation->render();

        BackendHelper::enqueueEditorScripts();
        enqueueScriptFile(ModuleHelper::buildRessourcePath("code_editor", "js/main.js"));
        combinedScriptHtml();
    }
} else {
    noperms();
}