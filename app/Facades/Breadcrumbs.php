<?php

namespace App\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use stdClass;

class Breadcrumbs extends Facade
{
    protected static $callbacks = [];

    protected static function getFacadeAccessor()
    {
        return 'breadcrumbs';
    }

    public static function for($name, $callback)
    {
        static::$callbacks[$name] = $callback;
    }

    public static function render($name = null, ...$params)
    {
        if ($name === null) {
            $route = request()->route();
            $name = $route ? $route->getName() : null;
        }

        $generator = new BreadcrumbsGenerator();

        if ($name && isset(static::$callbacks[$name])) {
            try {
                call_user_func_array(static::$callbacks[$name], array_merge([$generator], $params));
            } catch (\Exception $e) {
                \Log::error("Error generating breadcrumbs: " . $e->getMessage());
            }
        }

        return view('partials.breadcrumbs', [
            'breadcrumbs' => $generator->getBreadcrumbs()
        ])->render();
    }
}

class BreadcrumbsGenerator
{
    protected $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = new Collection();
    }

    public function push($title, $url = null)
    {
        $breadcrumb = new stdClass();
        $breadcrumb->title = $title;
        $breadcrumb->url = $url;

        $this->breadcrumbs->push($breadcrumb);
        return $this;
    }

    public function parent($name, ...$params)
    {
        if (isset(Breadcrumbs::$callbacks[$name])) {
            try {
                call_user_func_array(Breadcrumbs::$callbacks[$name], array_merge([$this], $params));
            } catch (\Exception $e) {
                \Log::error("Error in breadcrumb parent: " . $e->getMessage());
            }
        }
        return $this;
    }

    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }
}
