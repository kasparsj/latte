<?php
/**
 * @author Michal Vyšinský <vysinsky@live.com>
 */

namespace Annotatecms\Latte;

use Illuminate\View\Engines\EngineInterface;
use Nette\Caching\Storages\PhpFileStorage;
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

        $filters = \Config::get("nette::latte.filters", array());
        $helpers = \Config::get("nette::latte.helpers", array());
        $cacheDirectory = \Config::get("nette::latte.cacheDirectory");

        $template->setCacheStorage(new PhpFileStorage($cacheDirectory));

        foreach ($filters as $filterClass) {
            $template->registerFilter(new $filterClass);
        }

        foreach ($helpers as $helperLoader) {
            $template->registerHelperLoader($helperLoader);
        }

        $template->render();
    }

}