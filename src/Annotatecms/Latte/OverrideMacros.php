<?php
/**
 * @author Michal Vyšinský <vysinsky@live.com>
 */

namespace Annotatecms\Latte;

use Nette\Latte\Compiler;
use Nette\Latte\MacroNode;
use Nette\Latte\Macros\MacroSet;
use Nette\Latte\PhpWriter;

/**
 * Class OverrideMacros
 *
 * @package Annotatecms\Latte
 * @todo    add these macros: cache, contentType, status
 */
class OverrideMacros extends MacroSet {

    public static function install(\Nette\Latte\Compiler $compiler) {
        $me = parent::install($compiler);

        // routes and links generation
        $me->addMacro("ifCurrent", array($me, "macroIfCurrent"), "endif");
        $me->addMacro('href', NULL, NULL, function (MacroNode $node, PhpWriter $writer) use ($me) {
            return ' ?> href="<?php ' . $me->macroLink($node, $writer) . ' ?>"<?php ';
        });

        // component model
        $me->addMacro("control", array($me, "macroControl"));

        // form macros
        $me->addMacro("link", array($me, "macroLink"));
        $me->addMacro("form", array($me, "macroForm"), "\\Form::close()");
        $me->addMacro("label", array($me, "macroLabel"));
        $me->addMacro("input", array($me, "macroInput"));
    }

    public function macroIfCurrent(MacroNode $node, PhpWriter $writer) {

        $hasArgs = $this->hasArgs($node);

        if (strpos($node->args, "@")) {
            if ($hasArgs) {
                return $writer->write("\$currentRoute = \\Route::getCurrentRoute(); if(\$currentRoute->getAction() == %node.word && \$currentRoute->getParameters() == %node.array): ");
            } else {
                return $writer->write("if(\\Route::getCurrentRoute()->getAction() == %node.word): ");
            }
        }

        if ($hasArgs) {
            return $writer->write("\$currentRoute = \\Route::getCurrentRoute(); if(\$currentRoute->getPath() == %node.word && \$currentRoute->getParameters() == %node.array): ");
        } else {
            return $writer->write("if(\\Route::getCurrentRoute()->getPath() == %node.word): ");
        }
    }

    /**
     * @param MacroNode $node
     *
     * @return int
     */
    private function hasArgs(MacroNode $node) {
        return strpos($node->args, "=>");
    }

    public function macroLink(MacroNode $node, PhpWriter $writer) {
        if (strpos($node->args, "@")) {
            return $writer->write("echo action(%node.word, %node.array?)");
        } else {
            return $writer->write("echo \\URL::to(%node.word, %node.array?)");
        }

    }

    public function macroControl(MacroNode $node, PhpWriter $writer) {
        return $writer->write("\\ComponentManager::make(%node.word)->render();");
    }

    public function macroForm(MacroNode $node, PhpWriter $writer) {

        $hasArgs = $this->hasArgs($node);

        if (strpos($node->args, "@")) {
            $parts = explode(",", $node->args);
            $action = $parts[0];

            return $writer->write("echo \\Form::open(array('action'=>" . $action . "))");
        }

        if ($hasArgs) {
            return $writer->write("echo \\Form::open(%node.array)");
        } else {
            return $writer->write("echo \\Form::open(array('url' => %node.word))");
        }

    }

    public function macroLabel(MacroNode $node, PhpWriter $writer) {
        $args = explode(",", $node->args);

        if (count($args) > 1) {
            list($name, $text) = $args;

            return $writer->write("echo \\Form::label(" . $name . ", " . $text . ", %node.array?)");
        } else {
            return $writer->write("echo \\Form::label(%node.word)");
        }
    }

    public function macroInput(MacroNode $node, PhpWriter $writer) {
        $args = explode(",", $node->args);

        // is submit button
        if ($args[0] == "submit") {
            return $writer->write("echo \\Form::submit(" . $args[1] . ")");
        }

        if ($args[0] == "select") {
            list($type, $name) = $args;

            $items = "array(";

            $array_start = strpos($node->args, "[") + 1;
            $array_end = strpos($node->args, "]");
            $raw_array = explode(",", substr($node->args, $array_start, $array_end - $array_start));

            foreach ($raw_array as $array) {
                $items .= $array . ",";
            }
            $items .= ")";

            return $writer->write("echo \\Form::select(" . $this->t($name) . ", " . $items . ")");
        }

        // has name only
        if (count($args) == 2) {
            list($type, $name) = $args;

            return $writer->write("echo \\Form::" . $type . "(" . $this->t($name) . ")");
        } // has name and default value
        else if (count($args) == 3) {
            list($type, $name, $value) = $args;

            return $writer->write("echo \\Form::" . $type . "(" . $this->t($name) . ", " . $value . ")");
        } // has attributes
        else if ($this->hasArgs($node)) {
            list($type, $name, $value) = $args;

            return $writer->write("echo \\Form::" . $type . "(" . $this->t($name) . ", " . $value . ", %node.array)");
        }
    }

    private function t($string) {
        return trim($string);
    }

}