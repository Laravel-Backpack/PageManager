<?php

namespace Backpack\PageManager\app;

use Illuminate\Support\Collection;

trait TraitReflections
{
    /**
     * Check for equal named templates and unique pages.
     *
     * As the method name of a unique page will also be the template name in the database,
     * we must ensure that there are not any equal names defined.
     * If different Models (and so different tables in the database) are used, this condition must not hold any more.
     *
     * @throws \Exception
     */
    public function checkForTemplatesAndUniquePagesNotDistinct()
    {
        if (config('backpack.pagemanager.page_model_class') !== config('backpack.pagemanager.unique_page_model_class')) {
            return;
        }

        $uniquePages = $this->loadUniquePages();
        $templates = $this->loadTemplates();

        if ($uniquePages->intersect($templates)->isNotEmpty()) {
            throw new \Exception('Templates and unique pages must not have the same function names when same model class is used.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UNIQUE PAGES
    |--------------------------------------------------------------------------
    */

    /**
     * Load all defined unique pages.
     *
     * @return Collection
     */
    private function loadUniquePages()
    {
        $pages_trait = new \ReflectionClass('App\UniquePages');
        $pages = $pages_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        return collect($pages);
    }

    /**
     * Get all defined unique pages.
     *
     * @return Collection
     */
    public function getUniquePages()
    {
        $pages = $this->loadUniquePages();

        if (! count($pages)) {
            abort(503, trans('backpack::pagemanager.template_not_found'));
        }

        return $pages;
    }

    /**
     * Get all defined unique page names.
     *
     * @return Collection
     */
    public function getUniquePageNames()
    {
        return $this->getUniquePages()->pluck('name');
    }

    /**
     * Get the page names keyed with slugs.
     *
     * @return Collection
     */
    public function getUniqueSlugs()
    {
        return $this->getUniquePageNames()->mapWithKeys(function ($name) {
            return [str_slug($name) => $name];
        });
    }


    /*
    |--------------------------------------------------------------------------
    | TEMPLATES
    |--------------------------------------------------------------------------
    */

    /**
     * Load all defined templates.
     *
     * @return Collection
     */
    private function loadTemplates()
    {
        $templates_trait = new \ReflectionClass('App\PageTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        return collect($templates);
    }

    /**
     * Get all defined templates.
     *
     * @return Collection
     */
    public function getTemplates($template_name = false)
    {
        $templates = $this->loadTemplates();

        if (! count($templates)) {
            abort(503, trans('backpack::pagemanager.template_not_found'));
        }

        return collect($templates);
    }

    /**
     * Get all defined template names.
     *
     * @return Collection
     */
    public function getTemplateNames()
    {
        return $this->getTemplates()->pluck('name');
    }
}
