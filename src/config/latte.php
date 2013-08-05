<?php

return array(
    "filters" => array(
        "Annotatecms\\Latte\\OverrideMacros"
    ),
    "helpers" => array(
        "Nette\\Templating\\Helpers::loader",
    ),
    "cacheDirectory" => storage_path() . DIRECTORY_SEPARATOR . "views",
);