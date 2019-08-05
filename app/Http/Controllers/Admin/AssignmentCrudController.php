<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AssignmentRequest as StoreRequest;
use App\Http\Requests\AssignmentRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class AssignmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AssignmentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Assignment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/assignment');
        $this->crud->setEntityNameStrings('asignaciones', 'Asignaciones');
        //$this->crud->enableExportButtons();
        //$this->crud->disableResponsiveTable();
        $this->crud->enableResponsiveTable();

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
                'label' => "Documento",
                'type' => 'select',
                'name' => 'document_id', // the db column for the foreign key
                'entity' => 'document', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                //'model' => "App\Models\QuestionCategory" // foreign key model
                ]
        );

        $this->crud->addField(
            [  // Select
                'label' => "Categoria",
                'type' => 'select',
                'name' => 'category_id', // the db column for the foreign key
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                //'model' => "App\Models\QuestionCategory" // foreign key model
                ]
        );

        $this->crud->addField(
            [  // Select
                'label' => "Etapa",
                'type' => 'select',
                'name' => 'stage_id', // the db column for the foreign key
                'entity' => 'stage', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Stage" // foreign key model
                ]
        );

        $this->crud->addColumn([
            'label' => "Tipo Proyecto", // Table column heading
            'type' => "select",
            'name' => 'project_type_id', // the column that contains the ID of that connected entity;
            'entity' => 'tipo', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            //'model' => "App\Models\Land", // foreign key model
         ]);

         $this->crud->addColumn([
            'label' => "Documento", // Table column heading
            'type' => "select",
            'name' => 'document_id', // the column that contains the ID of that connected entity;
            'entity' => 'document', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Document", // foreign key model
            'limit' => 20000,
         ]);

         $this->crud->addColumn([
            'label' => "Categoria", // Table column heading
            'type' => "select",
            'name' => 'category_id', // the column that contains the ID of that connected entity;
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Category", // foreign key model
         ]);

         $this->crud->addColumn([
            'label' => "Fase", // Table column heading
            'type' => "select",
            'name' => 'stage_id', // the column that contains the ID of that connected entity;
            'entity' => 'stage', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Stage", // foreign key model
         ]);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in AssignmentRequest
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
