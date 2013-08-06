<?php
/**
 * @author Michal Vyšinský <vysinsky@live.com>
 */

namespace Annotatecms\Latte;

use Illuminate\View\Engines\EngineInterface;
use Nette\Caching\Storages\PhpFileStorage;
use Nette\Latte\Compiler;
use Nette\Templating\FileTemplate;

class Engine implements EngineInterface {

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string $path
     * @param  array  $data
     *
     * @return string
     */
    public function get($path, array $data = array()) {
        $template = new FileTemplate($path);
        $template->setParameters($data);

        $filters = \Config::get("latte::latte.filters", array());
        $helpers = \Config::get("latte::latte.helpers", array());

        $cacheDirectory = \Config::get("latte::latte.cacheDirectory");

        $template->setCacheStorage(new PhpFileStorage($cacheDirectory));

        $latte = new \Nette\Latte\Engine();
        $template->registerFilter($latte);

        if(count($filters)) {
            $compiler = $latte->getCompiler();
            foreach ($filters as $filterClass) {
                $filterClass::install($compiler);
            }
        }

        foreach ($helpers as $helperLoader) {
            $template->registerHelperLoader($helperLoader);
        }

        $template->render();
    }

}