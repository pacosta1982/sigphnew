<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Project_tipologiesRequest as StoreRequest;
use App\Http\Requests\Project_tipologiesRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class Project_tipologiesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Project_tipologiesCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Project_tipologies');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/project_tipologies');
        $this->crud->setEntityNameStrings('project_tipologies', 'project_tipologies');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addField(
            [  // Select
                'label' => "Tipo Proyecto",
                'type' => 'select',
                'name' => 'project_type_id', // the db column for the foreign key
                'entity' => 'tipo', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                //'model' => "App\Models\QuestionCategory" // foreign key model
            ]
        );

        $this->crud->addField(
            [  // Select
                'label' => "Tipologia",
                'type' => 'select',
                'name' => 'typology_id', // the db column for the foreign key
                'entity' => 'tipologia', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                //'model' => "App\Models\QuestionCategory" // foreign key model
            ]
        );

        $this->crud->addColumn([
            'label' => "Tipo Proyecto",
            'type' => 'select',
            'name' => 'project_type_id', // the db column for the foreign key
            'entity' => 'tipo', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            //'model' => "App\Models\QuestionCategory" // foreign key model
         ]);

         $this->crud->addColumn([
            'label' => "Tipologia",
            'type' => 'select',
            'name' => 'typology_id', // the db column for the foreign key
            'entity' => 'tipologia', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            //'model' => "App\Models\QuestionCategory" // foreign key model
         ]);

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in Project_tipologiesRequest
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
