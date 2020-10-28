<?php namespace Ghidev\Fpdf;

use Illuminate\Support\ServiceProvider;

class MC_TableServiceProvider extends ServiceProvider {
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
        $this->app->bind('mc_table', function () {
            return new MC_Table();
        });
	}
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
        return array('mc_table');
	}
}