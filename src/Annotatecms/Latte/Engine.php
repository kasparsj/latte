<?php
/**
 * @author Michal Vyšinský <vysinsky@live.com>
 */

namespace Annotatecms\Latte;

use Illuminate\View\Engines\EngineInterface;
use Nette\Caching\Storages\PhpFileStorage;
use Nette\Latte\Compiler;

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
        return \Latte::make($path, $data)->render();
    }

}