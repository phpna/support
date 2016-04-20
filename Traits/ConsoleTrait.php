<?php
namespace Phpna\Support\Traits;
class ConsoleTrait
{
    public function block($string, $verbosity = null)
    {
        $style = new OutputFormatterStyle('white','green', array('bold', 'underscore'));
        $this->output->getFormatter()->setStyle('block', $style);
        $this->line($string, 'block', $verbosity);
    }
}
