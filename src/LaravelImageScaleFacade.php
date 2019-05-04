<?php

namespace Nddcoder\LaravelImageScale;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nddcoder\LaravelImageScale\Skeleton\SkeletonClass
 */
class LaravelImageScaleFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-image-scale';
    }
}
