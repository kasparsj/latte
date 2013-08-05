# AnnotateCms Latte #

AnnotateCms Latte is integration of [Latte](https://github.com/nette/latte "Latte Github page") templating engine into Laravel Framework.

## Installation ##
Install via composer into Laravel Framework's project. Add this into your composer.json file:	

	"annotatecms/latte" : "2.*"

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

## Macros ##
Macros are documented on Nette Framework's page ([more info](http://doc.nette.org/en/default-macros)). Bellow are only macros with changed syntax or functionality.

- ifCurrent - checks if argument matches current route
	- {ifCurrent HomeController@getTest} - checks route action
	- {ifCurrent /user/{id}} - cheks route path
	- {ifCurrent /user/{id}, id=>5} - checks route path and "id" argument to be 5

Usage:

	{ifCurrent HomeController@getIndex}
		Homepage is current
	{else}
		Homepage is not current
	{/ifCurrent}

- href, link
	- href is n:macro - usage <a n:href="HomeController@getIndex">Home</a>
	- link usage: <a href="{link HomeController@getIndex}">Home</a>
	- functionally are both variants same
	- could be used with route url: /user/5 (you can ommit leading slash)
	- also could be used with controller action: HomeController@getIndex

- form
	- uses Laravel's Form::open() method to generate form
	- could be used with route url: /user/5 (you can ommit leading slash)
	- also could be used with controller action: HomeController@postIndex

- label
	- syntax: {label NAME, [text], [attributes]} (parameters is [] are optional) 
	- uses Laravel's Form::label() method
	
- input
	- syntax: {input TYPE, NAME, [DEFAULT VALUE], [attributes]} (parameters is [] are optional) 
	- for submit button use only {input submit, "Value"}
	- you can use all inputs provided by Laravel
	- uses Laravel's Form::**{inputType}**() method
	- for select input use syntax: {input select, "gender", ["f" => "Female", "m" => "Male"]}
	 

#### Usage of form macros ####

	{form HomeController@postLogin}
		{label "login", "Login", class=>"form-label", title=>"Some title"} {input text, "login", "Default Value"}
		{label "password", "Password"} {input password}		
		{input submit, "Click me!"}
	{/form}
 
## Macros which not working yet ##
Below are macros, which are not functional or tested yet. I will consider adding support for these macros. There is no sense for some of them to have in Laravel.

- cache
- contentType 
- status
- dump
- debugbreak
- snippet
- Blocks, layouts, template inheritance - not fully tested yet

## Future plans ##
Consider dependency on whole nette/nette package. Maybe it could be posible to depend on latte/latte only.