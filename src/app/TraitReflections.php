<?php

namespace Backpack\PageManager\app;


trait TraitReflections
{

    public function checkForTemplatesAndUniquePagesNotDistinct()
    {
        if (config('backpack.pagemanager.page_model_class') != config('backpack.pagemanager.unique_page_model_class')) {
            return;
        }

        $uniquePages = collect($this->getUniquePages())->pluck('name');
        $templates = collect($this->getTemplates())->pluck('name');

        if ($uniquePages->intersect($templates)->isNotEmpty()) {
            throw new \Exception('Templates and unique pages should not have the same function names when same model class is used.');
        }
    }

    /**
     * Get all defined unique pages
     */
    public function getUniquePages()
    {
        $pages_trait = new \ReflectionClass('App\UniquePages');
        $pages = $pages_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        return $pages;
    }

    /**
     * Get all defined templates.
     */
    public function getTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('App\PageTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::pagemanager.template_not_found'));
        }

        return $templates;
    }
}