<?php namespace Ghidev\Fpdf;

use Illuminate\Support\ServiceProvider;

class FpdfServiceProvider extends ServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        	$this->app->bind('fpdf', function () {
        		return new Fpdf();
        	});
	}
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('fpdf');
	}
}
