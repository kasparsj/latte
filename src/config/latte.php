<?php

return array(
    "filters" => array(
        "Nette\\Latte\\Engine",
    ),
    "helpers" => array(
        "Nette\\Templating\\Helpers::loader",
    ),
    "cacheDirectory" => storage_path() . DIRECTORY_SEPARATOR . "views",
);