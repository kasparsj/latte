<?php
/**
 * @author Michal Vyšinský <vysinsky@live.com> 
 */

namespace Annotatecms\Latte\Facades;


use Illuminate\Support\Facades\Facade;

class Latte extends Facade {

    protected static function getFacadeAccessor() {
        return "annotate.latte";
    }

}