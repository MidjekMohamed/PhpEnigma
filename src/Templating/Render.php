<?php

namespace src\Templating;

use src\Templating\Functions\RawReplacement;
use src\Templating\Functions\EscapedReplacement;
use src\Templating\Functions\Path;

class Render
{
    private ?RenderFunction $function = null;

    public function  __construct()
    {
        $this->function= new RawReplacement();

        $pathFunction = new Path();

        $escapedReplacement = new EscapedReplacement();
        $escapedReplacement->setNext(new Path());

        $this->function->setNext($escapedReplacement);
    }

    public function render(string $template, array $context =[]){
        $path= __DIR__.'/../../templates/'.$template.'.phtml';
        if(!file_exists($path)){
            throw new \LogicException("templates  '$path' not found");
        }
        $content = file_get_contents($path);

        $function = $this->function;
        while($function instanceof RenderFunction){
            $function = $function->apply(content: $content, context: $context);
        }

        return $content;
    }
}