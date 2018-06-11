<?php

namespace SuperSimpleTemplates;

class TemplateFactory
{
    private $dir;
    private $helpers;

    public function __construct($dir, array $helpers = [])
    {
        $dirInfo = new \SplFileInfo($dir);
        if (!$dirInfo->isDir()) {
            throw new \InvalidArgumentException("Template directory is not a valid Directory");
        }
        if (!$dirInfo->isReadable()) {
            throw new \InvalidArgumentException("Template directory must be readable");
        }
        $this->dir = $dirInfo->getRealPath() . DIRECTORY_SEPARATOR;
        $this->helpers = $helpers;
    }

    public function build($filename, array $context = [])
    {
        $filename = $this->dir . $filename;
        return new Template($filename, $context, $this->helpers);
    }
}
