<?php

namespace Codtail\AdminSuit;

use Codtail\AdminSuit\Console\FilterMakeCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class AdminSuitServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../config/config.php', 'admin-suit');
	}

	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				FilterMakeCommand::class,
			]);

			$this->publishes([
				__DIR__ . '/../resources/assets' => public_path('admin-suit'),
			], 'assets');


			// $this->publishes([
			//   __DIR__.'/../resources/views/publishable' => resource_path('views/admin-suit'),
			// ], 'views');

			$this->publishes([
				__DIR__.'/../config/config.php' => config_path('admin-suit.php'),
			  ], 'config');
	
		}

	
		$this->registerRoutes();

		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin-suit');


		Blade::componentNamespace('Codtail\\AdminSuit\\Resources\\Views\\Components', 'admin-suit');
	}

	protected function registerRoutes()
	{
		Route::group($this->routeConfiguration(), function () {
			$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
		});
	}

	protected function routeConfiguration()
	{
		return [
			'prefix' => config('admin-suit.prefix'),
			'middleware' => config('admin-suit.middleware'),
			'as' => config('admin-suit.route_name'),
		];
	}
}
