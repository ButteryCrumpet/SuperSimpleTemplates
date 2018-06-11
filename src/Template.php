<?php

namespace SuperSimpleTemplates;

class Template
{
    private $file;
    private $context;
    private $helpers;

    public function __construct($file, array $context = [], array $helpers = [])
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException(sprintf(
                "File %s does not exist.",
                $file
            ));
        }
        $this->file = $file;
        $this->context = $context;
        $this->helpers = $helpers;
    }

    public function render(array $additional_context = [])
    {
        $context = array_merge($this->context, $additional_context);
        extract($context);
        extract($this->helpers);
        ob_start();
        require $this->file;
        return ob_get_clean();
    }
}
