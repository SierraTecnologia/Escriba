<?php

if (!function_exists('escritor')) {
    function escritor()
    {
        return app(Escritor\Services\StoreHelperService::class);
    }
}
