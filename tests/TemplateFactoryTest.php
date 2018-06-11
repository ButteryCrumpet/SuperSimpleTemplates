<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleTemplates\TemplateFactory;
use SuperSimpleTemplates\Template;

class TemplateFactoryTest extends TestCase
{
    public function testInitialises()
    {
        $this->assertInstanceOf(
            TemplateFactory::class,
            new TemplateFactory(".")
        );
    }

    public function testThrowsInvalidArgumentExceptionOnInvalidDirectory()
    {
        $this->expectException(InvalidArgumentException::class);
        new TemplateFactory("invalid/directory");
    }

    public function testThrowsInvalidArgumentExceptionOnUnreadableDirectory()
    {
        mkdir("templates", 0333);
        $this->expectException(InvalidArgumentException::class);
        new TemplateFactory("templates");
        rmdir("templates");

    }

    public function testBuildsTemplateClass()
    {
        file_put_contents("test.php", "");
        $factory = new TemplateFactory(".");
        $this->assertInstanceOf(
            Template::class,
            $factory->build("test.php")
        );
        unlink("test.php");
    }
}