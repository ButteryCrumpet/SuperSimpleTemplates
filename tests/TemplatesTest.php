<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleTemplates\Template;

class TemplatesTest extends TestCase
{
    public function testInitializes()
    {
        file_put_contents("test.php", "");

        $this->assertInstanceOf(
            Template::class,
            new Template("test.php")
        );

        unlink("test.php");
    }

    public function testThrowsErrorOnInvalidFileName()
    {
        $this->expectException(InvalidArgumentException::class);
        new Template("notAFile.php");
    }

    public function testRendersContext()
    {
        $php = '<h3><?php echo $hi ?></h3>';
        file_put_contents("test.php", $php);

        $template = new Template("test.php", ["hi" => "hello"]);
        $this->assertEquals(
            "<h3>hello</h3>",
            $template->render()
        );

        unlink("test.php");
    }

    public function testHelpers()
    {
        $formHelper = function ($name) {
            return "<input name='" . $name . "'/>";
        };

        $php = '<h3><?php echo $hi ?></h3><?php echo $formHelper($name); ?>';
        file_put_contents("test.php", $php);

        $template = new Template(
            "test.php",
            ["hi" => "hello"],
            ["formHelper" => $formHelper]
        );

        $this->assertEquals(
            "<h3>hello</h3><input name='ho'/>",
            $template->render(["name" => "ho"])
        );

        unlink("test.php");
    }
}

