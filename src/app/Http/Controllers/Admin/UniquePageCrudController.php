<?php

namespace Backpack\PageManager\app\Http\Controllers\Admin;

use App\UniquePages;
use Backpack\PageManager\app\TraitReflections;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\SaveActions;

class UniquePageCrudController extends CrudController
{
    use SaveActions;
    use UniquePages;
    use TraitReflections;

    public function setup()
    {
        parent::__construct();

        $modelClass = config('backpack.pagemanager.unique_page_model_class', 'Backpack\PageManager\app\Models\Page');

        $this->checkForTemplatesAndUniquePagesNotDistinct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        // Don't set route or entity names here. These depend on the page you are editing

        // unique pages cannot be created nor deleted
        $this->crud->denyAccess(['list', 'create', 'delete']);

        if (config('backpack.pagemanager.unique_page_revisions')) {
            $this->crud->allowAccess('revisions');
        }
    }

    /**
     * Edit the unique page retrieved by slug.
     *
     * @param string $slug
     * @return Response
     */
    public function uniqueEdit($slug)
    {
        $model = $this->crud->model;
        $entry = $model::findBySlug($slug);

        if (! $entry) {
            $entry = $this->createMissingPage($slug);
        }

        $this->uniqueSetup($entry);

        return parent::edit($entry->id);
    }

    /**
     * Update the unique page.
     *
     * @param string $slug
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($slug, $id)
    {
        $this->setRoute($slug);

        return parent::updateCrud();
    }

    /**
     * Set the crud route.
     *
     * @param $slug
     */
    public function setRoute($slug)
    {
        $this->crud->setRoute(config('backpack.base.route_prefix').'/unique/'.$slug);
    }

    /**
     * Populate the update form with basic fields that all pages need.
     *
     * @param Model $page
     */
    public function addDefaultPageFields($page)
    {
        $fields = [
            [
                'name'  => 'buttons',
                'type'  => 'custom_html',
                'value' => $this->buttons($page),
            ],
            [
                'name' => 'template',
                'type' => 'hidden',
            ],
            [
                'name' => 'name',
            ],
            [
                'name' => 'title',
            ],
            [
                'name' => 'slug',
                'type' => 'hidden',
            ],
        ];

        $this->crud->addFields($fields);
    }

    /**
     * Build the buttons html for the edit form.
     *
     * @param Model $page
     * @return string
     */
    public function buttons($page)
    {
        $openButton = $page->getOpenButton();
        $revisionsButton = view('crud::buttons.revisions', ['crud' => $this->crud, 'entry' => $page]);

        return $openButton.' '.$revisionsButton;
    }

    /**
     * Create the page by slug.
     *
     * @param $slug
     * @return mixed
     */
    public function createMissingPage($slug)
    {
        $slugs = $this->getUniqueSlugs();

        if (! $slugs->has($slug)) {
            abort(404);
        }

        $page = $slugs->pull($slug);
        $model = $this->crud->model;

        return $model::create([
            'template' => $page,
            'name'     => camel_case($page),
            'title'    => camel_case($page),
            'slug'     => $slug,
        ]);
    }

    /**
     * Display the revisions for specified resource.
     *
     * @param $slug
     * @param $id
     * @return Response
     */
    public function uniqueRevisions($slug, $id)
    {
        $model = $this->crud->model;
        $entry = $model::findBySlugOrFail($slug);

        $this->uniqueSetup($entry);

        return parent::listRevisions($entry->id);
    }

    /**
     * Restore a specific revision for the specified resource.
     *
     * Used via AJAX in the revisions view
     *
     * @param string $slug
     * @param int $id
     *
     * @return JSON Response containing the new revision that was created from the update
     * @return HTTP 500 if the request did not contain the revision ID
     */
    public function restoreUniqueRevision($slug, $id)
    {
        $model = $this->crud->model;
        $entry = $model::findBySlugOrFail($slug);

        $this->uniqueSetup($entry);

        return parent::restoreRevision($id);
    }

    /**
     * Setup the controller for the entry.
     *
     * @param $entry
     */
    protected function uniqueSetup($entry)
    {
        $this->setRoute($entry->slug);

        $this->addDefaultPageFields($entry);
        $this->crud->setEntityNameStrings($this->crud->makeLabel($entry->template), $this->crud->makeLabel($entry->template));

        $this->{$entry->template}();
    }

    /*
    |--------------------------------------------------------------------------
    | SaveActions overrides
    |--------------------------------------------------------------------------
    */

    /**
     * Overrides trait version to remove 'save_and_back' and 'save_and_new'.
     *
     * @return [type] [description]
     */
    public function getSaveAction()
    {
        $saveCurrent = [
            'value' => $this->getSaveActionButtonName('save_and_back'),
            'label' => $this->getSaveActionButtonName('save_and_back'),
        ];

        return [
            'active'  => $saveCurrent,
            'options' => [],
        ];
    }

    /**
     * Override trait version to not update the session variable.
     *
     * @param [type] $forceSaveAction [description]
     */
    public function setSaveAction($forceSaveAction = null)
    {
        // do nothing to preserve session value for other crud
    }
}
