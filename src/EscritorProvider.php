<?php

namespace Escritor;

use App;
use Config;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;
use Escritor\Facades\Escritor as EscritorFacade;
use Escritor\Facades\StoreHelper;

use Escritor\Services\CartService;
use Escritor\Services\CustomerProfileService;
use Escritor\Services\LogisticService;
use Escritor\Services\EscritorService;
use Escritor\Services\ProductService;
use Escritor\Services\StoreHelperService;
use Muleta\Traits\Providers\ConsoleTools;
use Route;

class EscritorProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'escritor';
    const pathVendor = 'sierratecnologia/escritor';

    public static $aliasProviders = [
        'Escritor' => \Escritor\Facades\Escritor::class,
        'StoreHelper' => \Escritor\Facades\StoreHelper::class,
    ];

    public static $providers = [

        \Pedreiro\PedreiroServiceProvider::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text' => 'Comercial',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'section' => "admin",
            'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],

        'Comercial' => [
            [
                'text'        => 'Vendas',
                'url'         => 'admin/escritor-analytics',
                'icon'        => 'laptop',
                'icon_color'  => 'red',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 2,
                'feature' => 'escritor',
            ],
            [
                'text'        => 'Products',
                'url'         => 'admin/products',
                'icon'        => 'laptop',
                'icon_color'  => 'red',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 2,
                'feature' => 'escritor',
            ],
            [
                'text'        => 'Plans',
                'url'         => 'admin/plans',
                'icon'        => 'laptop',
                'icon_color'  => 'red',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 2,
                'feature' => 'escritor',
                'config' => 'escritor.have-plans',
            ],
            [
                'text'        => 'Coupons',
                'url'         => 'admin/coupons',
                'icon'        => 'laptop',
                'icon_color'  => 'red',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 2,
                'feature' => 'escritor',
                'config' => 'escritor.have-coupons',
            ],
            [
                'text'        => 'Transactions',
                'url'         => 'admin/transactions',
                'icon'        => 'laptop',
                'icon_color'  => 'red',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 2,
                'feature' => 'escritor',
            ],
            [
                'text'        => 'orders',
                'url'         => 'admin/orders',
                'icon'        => 'laptop',
                'icon_color'  => 'red',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 2,
                'feature' => 'escritor',
            ],
        ],
        // [
        //     'text' => 'Escritor',
        //     'icon' => 'fas fa-fw fa-search',
        //     'icon_color' => "blue",
        //     'label_color' => "success",
        //     'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        // ],
        // 'Escritor' => [
        //     [
        //         'text'        => 'Procurar',
        //         'icon'        => 'fas fa-fw fa-search',
        //         'icon_color'  => 'blue',
        //         'label_color' => 'success',
        //         'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        //         // 'access' => \Porteiro\Models\Role::$ADMIN
        //     ],
        //     'Procurar' => [
        //         [
        //             'text'        => 'Projetos',
        //             'route'       => 'rica.escritor.projetos.index',
        //             'icon'        => 'fas fa-fw fa-ship',
        //             'icon_color'  => 'blue',
        //             'label_color' => 'success',
        //             'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        //             // 'access' => \Porteiro\Models\Role::$ADMIN
        //         ],
        //     ],
        // ],
    ];
    
    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }


        /**
         * Porteiro; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'routes');
    }

    /**
     * Alias the services in the boot.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->routes();
        $loader = AliasLoader::getInstance();
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(
            function () {
                $this->routes();
            }
        );

        $this->loadLogger();

        $loader->alias('StoreHelper', StoreHelper::class);
    }


    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec'.DIRECTORY_SEPARATOR.'escritor.php'), 'sitec.escritor');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations');

        $this->app->singleton(
            'escritor',
            function () {
                return new Escritor();
            }
        );
        $this->app->singleton(
            'storeHelper',
            function () {
                return app()->make(StoreHelperService::class);
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Escritor;
         */
        $this->app->singleton(
            EscritorService::class,
            function ($app) {
                Log::channel('sitec-escritor')->info('Singleton Escritor;');
                return new EscritorService(\Illuminate\Support\Facades\Config::get('sitec.escritor'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/escritor/src/Console/Commands') => '\Escritor\Console\Commands',
            ]
        );

        // /**
        //  * Helpers
        //  */
        // Aqui noa funciona
        // if (!function_exists('escritor_asset')) {
        //     function escritor_asset($path, $secure = null)
        //     {
        //         return route('rica.escritor.assets').'?path='.urlencode($path);
        //     }
        // }

        $this->app->bind(
            'ProductService',
            function ($app) {
                return app()->make(ProductService::class);
            }
        );

        $this->app->bind(
            'CartService',
            function ($app) {
                return app()->make(CartService::class);
            }
        );

        $this->app->bind(
            'LogisticService',
            function ($app) {
                return app()->make(LogisticService::class);
            }
        );

        $this->app->bind(
            'CustomerProfileService',
            function ($app) {
                return app()->make(CustomerProfileService::class);
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'escritor',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes(
            [
            // Paths
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec') => config_path('sitec'),
            ],
            ['config',  'sitec', 'sitec-config']
        );

        // // Publish escritor css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('escritor') => public_path('assets/escritor')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();
    }

    private function loadViews(): void
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'escritor');
        $this->publishes(
            [
            $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'escritor'),
            ],
            ['views',  'sitec', 'sitec-views']
        );
    }
    
    private function loadTranslations(): void
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'escritor')
            ],
            ['lang',  'sitec', 'sitec-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'escritor');
    }


    /**
     * @return void
     */
    private function loadLogger(): void
    {
        Config::set(
            'logging.channels.sitec-escritor',
            [
            'driver' => 'single',
            'path' => storage_path('logs'.DIRECTORY_SEPARATOR.'sitec-escritor.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }
}
