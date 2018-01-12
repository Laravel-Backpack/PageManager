<?php

namespace Backpack\PageManager\app\Http\Controllers\Admin;

use App\UniquePages;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\SaveActions;

class UniquePageCrudController extends CrudController
{
    use SaveActions;
    use UniquePages;

    public function setup()
    {
        parent::__construct();

        $modelClass = config('backpack.pagemanager.unique_page_model_class', 'Backpack\PageManager\app\Models\Page');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        // don't set route or entity names here. these depend on the page you are editing

        // unique pages can not be created nor deleted
        $this->crud->denyAccess('create');
        $this->crud->denyAccess('delete');
    }

    /**
     * As we want to edit pages by slug we need a new edit function
     *
     * @param string $slug the page slug
     * @return Response
     */
    public function uniqueEdit($slug)
    {
        $model = $this->crud->model;
        $entry = $model::findBySlug($slug);

        if (! $entry) {
            $entry = $this->createMissingPage($slug);
        }

        $this->data['entry'] = $entry;

        $this->addDefaultPageFields($entry);

        $this->setRoute($slug);
        $this->crud->setEntityNameStrings($this->crud->makeLabel($entry->template), '');

        $this->{$entry->template}();

        return parent::edit($entry->id);
    }

    public function update($slug, $id)
    {
        $this->setRoute($slug);

        return parent::updateCrud();
    }

    public function setRoute($slug)
    {
        $this->crud->setRoute(config('backpack.base.route_prefix').'/unique/'.$slug);
    }

    /**
     * Populate the update form with basic fields, that all pages need.
     *
     * @param Model $page the page entity
     */
    public function addDefaultPageFields($page)
    {
        $this->crud->addField([
            'name' => 'template',
            'type' => 'hidden',
        ]);
        $this->crud->addField([
            'name' => 'name',
            'type' => 'hidden',
        ]);
        $this->crud->addField([
            'name' => 'title',
            'type' => 'hidden',
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'type' => 'hidden',
        ]);

        $this->crud->addField([
            'name' => 'open',
            'type' => 'custom_html',
            'value' => $page->getOpenButton(),
        ]);
    }

    public function getUniquePages()
    {
        $pages_trait = new \ReflectionClass('App\UniquePages');
        $pages = $pages_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        return collect($pages)->pluck('name');
    }

    public function createMissingPage($slug)
    {
        $pages = collect($this->getUniquePages());

        $slugs = $pages->mapWithKeys(function ($page) {
            return [str_slug($page) => $page];
        });

        if (! $page = $slugs->pull($slug)) {
            abort(404);
        }

        $model = $this->crud->model;

        return $model::create([
            'template' => $page,
            'name' => camel_case($page),
            'title' => camel_case($page),
            'slug' => $slug,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BASIC CRUD INFORMATION
    |--------------------------------------------------------------------------
    */

    /**
     * Overrides trait version to remove.
     */
    public function getSaveAction()
    {
        $saveCurrent = [
            'value' => $this->getSaveActionButtonName('save_and_back'),
            'label' => $this->getSaveActionButtonName('save_and_back'),
        ];

        return [
            'active' => $saveCurrent,
            'options' => [],
        ];
    }

    public function setSaveAction($forceSaveAction = null)
    {
        // do nothing to preserve session value for other crud
    }
}
