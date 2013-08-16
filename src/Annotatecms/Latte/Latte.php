<?php
/**
 * @author Michal Vyšinský <vysinsky@live.com>
 */

namespace Annotatecms\Latte;

use Nette\Caching\Storages\PhpFileStorage;
use Nette\Latte\Macros\MacroSet;
use Nette\Templating\FileTemplate;

class Latte {

    /**
     * @param       $path
     * @param array $data
     *
     * @return \Nette\Templating\FileTemplate
     */
    public function make($path, $data = array()) {
        $template = new FileTemplate($path);
        $template->setParameters($data);

        $config = \Config::get("annotatecms/latte::latte");

        $filters = $config["filters"];
        $helpers = $config["helpers"];
        $cacheDirectory = $config["cacheDirectory"];

        $template->setCacheStorage(new PhpFileStorage($cacheDirectory));

        $latte = new \Nette\Latte\Engine();
        $template->registerFilter($latte);

        if (count($filters)) {
            $compiler = $latte->getCompiler();
            /** @var MacroSet $filterClass */
            foreach ($filters as $filterClass) {
                $filterClass::install($compiler);
            }
        }

        foreach ($helpers as $helperLoader) {
            $template->registerHelperLoader($helperLoader);
        }

        return $template;
    }

}