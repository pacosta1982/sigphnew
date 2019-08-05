<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Land_projectRequest as StoreRequest;
use App\Http\Requests\Land_projectRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class Land_projectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Land_projectCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Land_project');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/land_project');
        $this->crud->setEntityNameStrings('land_project', 'land_projects');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->addField([  // Select
            'label' => "Terreno",
            'type' => 'select',
            'name' => 'land_id', // the db column for the foreign key
            'entity' => 'tierra', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Land",

            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
         ]);


         $this->crud->addField([  // Select
            'label' => "Tipo Proyecto",
            'type' => 'select',
            'name' => 'project_type_id', // the db column for the foreign key
            'entity' => 'tipo', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Project_type",

            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
         ]);

         $this->crud->addColumn([
            'label' => "Tipo Terreno", // Table column heading
            'type' => "select",
            'name' => 'land_id', // the column that contains the ID of that connected entity;
            'entity' => 'tierra', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            //'model' => "App\Models\Land", // foreign key model
         ]);

         $this->crud->addColumn([
            'label' => "Tipo Terreno", // Table column heading
            'type' => "select",
            'name' => 'project_type_id', // the column that contains the ID of that connected entity;
            'entity' => 'tipo', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            //'model' => "App\Models\Land", // foreign key model
         ]);

        // add asterisk for fields that are required in Land_projectRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
