# AnnotateCms Latte #

AnnotateCms Latte is integration of [Latte](https://github.com/nette/latte "Latte Github page") templating engine into Laravel Framework.

## Installation ##
Install via composer into Laravel Framework's project. Add this into your composer.json file:	

	"annotatecms/latte" : "1.*"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

	'Annotatecms\Debugger\LatteServiceProvider',

Publish configuration via Artisan command:

	php artisan config:publish annotatecms/latte

Now you can use "latte" files as you view files.

## Configuration ##

Configuration file is now in app/config/packages/annotatecms/latte/latte.php file.

- filters - array of Latte filters to register into template ([more info](http://doc.nette.org/en/templating#toc-macros))
- helpers - array of Latte helpers to register into template ([more info](http://doc.nette.org/en/templating#toc-helpers-in-latte)) 
- cacheDirectory - directory where compiled templates are saved