<?php

use Spatie\Snapshots\MatchesSnapshots;

class CodeEditorControllerTest extends \PHPUnit\Framework\TestCase
{
    use MatchesSnapshots;

    protected function setUp(): void
    {
        Translation::loadAllModuleLanguageFiles("en");
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
    }

    public function testGetMimeTypeForFileReturnsType()
    {
        $controller = new CodeEditorController();

        $jsFile = ModuleHelper::buildRessourcePath(
            "code_editor",
            "js/main.js"
        );
        $this->assertEquals(
            "text/javascript",
            $controller->_getMimeTypeForFile($jsFile)
        );

        $this->assertEquals(
            "application/x-httpd-php",
            $controller->_getMimeTypeForFile(__FILE__)
        );

        $cssFile = Path::resolve(
            "ULICMS_ROOT/admin/scripts/vallenato/vallenato.css"
        );

        $this->assertEquals(
            "text/css",
            $controller->_getMimeTypeForFile($cssFile)
        );
    }

    public function testGetMimeTypeForFileReturnsNull()
    {
        $controller = new CodeEditorController();
        $this->assertNull(
            $controller->_getMimeTypeForFile("bild.jpg")
        );
    }

    public function testGetAllEditableFiles()
    {
        $controller = new CodeEditorController();
        $files = $controller->_getAllEditableFiles();

        $this->assertGreaterThanOrEqual(80, count($files));

        $files = array_map(function ($file) {
            return Path::resolve("ULICMS_ROOT/${file}");
        }, $files);

        foreach ($files as $file) {
            $this->assertFileExists($file);
        }
    }

    public function testCanEditFileReturnsTrue()
    {
        $controller = new CodeEditorController();
        $this->assertTrue($controller->_canEditFile(
            "/content/modules/code_editor/metadata.json"
        ));
    }

    public function testCanEditFileFromSessionReturnsTrue()
    {
        $_SESSION ["editable_code_files"] = ["foo.php"];
        $controller = new CodeEditorController();
        $this->assertTrue($controller->_canEditFile(
            "foo.php"
        ));
    }

    public function testCanEditFileReturnsFalse()
    {
        $controller = new CodeEditorController();
        $this->assertFalse($controller->_canEditFile(
            "/content/modules/code_editor/gibts_nicht"
        ));
    }

    public function testIsWritableReturnsTrue()
    {
        $controller = new CodeEditorController();
        $this->assertTrue($controller->_isWritable(
            "/content/modules/code_editor/metadata.json"
        ));
    }

    public function testIsWritableReturnsFalse()
    {
        $controller = new CodeEditorController();
        $this->assertFalse($controller->_isWritable(
            "/content/modules/code_editor/gibts_nicht"
        ));
    }

    public function testSettings()
    {
        $controller = new CodeEditorController();
        $html = $controller->settings();

        $this->assertGreaterThanOrEqual(
            90,
            substr_count($html, "<td>")
        );


        $files = $controller->_getAllEditableFiles();

        foreach ($files as $file) {
            $this->assertStringContainsString($file, $html);
        }
    }

    public function testGetSettingsHeadline()
    {
        $controller = new CodeEditorController();
        $this->assertMatchesTextSnapshot($controller->getSettingsHeadline());
    }
}
