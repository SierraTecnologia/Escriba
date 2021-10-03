<?php

namespace Escritor;

use Config;
use Crypto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ReflectionClass;
use Request;
use Session;

use View;

class Escritor
{
    protected $version;
    protected $filesystem;

    /**
     * The current locale, cached in memory
     *
     * @var string
     */
    private $locale;
    public $backendRoute = 'admin';

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);

        $this->findVersion();
    }

    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return void
     */
    protected function findVersion()
    {
        if (!is_null($this->version)) {
            return;
        }

        if ($this->filesystem->exists(base_path('composer.lock'))) {
            // Get the composer.lock file
            $file = json_decode(
                $this->filesystem->get(base_path('composer.lock'))
            );

            // Loop through all the packages and get the version of escritor
            foreach ($file->packages as $package) {
                if ($package->name == 'sierratecnologia/escritor') {
                    $this->version = $package->version;
                    break;
                }
            }
        }
    }
    /**
     * SierraTecnologia CMS url generator - handles custom siravel url
     *
     * @param string $string
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function url($string)
    {
        $url = str_replace('.', '/', $string);

        return url($this->backendRoute.'/'.$url);
    }


    /**
     * Creates a breadcrumb trail.
     *
     * @param array $locations Locations array
     *
     * @return string
     */
    public function breadcrumbs($locations)
    {
        $trail = '';

        foreach ($locations as $location) {
            if (is_array($location)) {
                foreach ($location as $key => $value) {
                    $trail .= '<li class="breadcrumb-item"><a href="'.$value.'">'.ucfirst($key).'</a></li>';
                }
            } else {
                $trail .= '<li class="breadcrumb-item">'.ucfirst($location).'</li>';
            }
        }

        return $trail;
    }

    /**
     * Module Assets.
     *
     * @param string $module      Module name
     * @param string $path        Asset path
     * @param string $contentType Content type
     *
     * @return string
     */
    public function moduleAsset($path, $contentType = 'null')
    {
        // $assetPath = base_path(Config::get('siravel.module-directory').'/'.ucfirst($module).'/Assets/'.$path);
        $assetPath = __DIR__.'/../publishes/assets/'.$path;

        // if (!is_file($assetPath)) {
        //     $assetPath = '/assets/'.$module.'/'.$path;
        // }

        // @todo
        return $assetPath;

        return url('admin/asset/'.Crypto::url_encode($assetPath).'/'.Crypto::url_encode($contentType).'/?isModule=true');
    }
}
