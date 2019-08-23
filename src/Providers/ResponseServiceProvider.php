<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/11/18
	 * Time: 13.19
	 */

	namespace Kosmosx\Response\Laravel\Providers;

	use Illuminate\Support\ServiceProvider;

	class ResponseServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->registerAlias();
			$this->registerServices();
		}

		/**
		 * Load alias
		 */
		protected function registerAlias()
		{
			$this->app->alias(\Kosmosx\Response\Laravel\Facades\FactoryResponse::class, 'FactoryResponse');
			$this->app->alias(\Kosmosx\Response\Laravel\Facades\RestResponse::class, 'RestResponse');
		}

		/**
		 * Register Services
		 */
		protected function registerServices()
		{
			/**
			 * Service Response
			 */
			$this->app->singleton('factory.response', 'Kosmosx\Response\Laravel\FactoryResponse');
			$this->app->bind('service.response', 'Kosmosx\Response\RestResponse');
		}
	}