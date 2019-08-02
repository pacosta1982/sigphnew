<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/usuarios');
        $this->crud->setEntityNameStrings('user', 'users');
        $this->crud->enableResponsiveTable();

        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => "Nombre", // Table column heading
            'limit' => 1000, // character limit; default is 50;
        ]);

        $this->crud->addColumn([
            'name' => 'email', // The db column name
            'label' => "Mail", // Table column heading
            //'limit' => 1000, // character limit; default is 50;
        ]);

        $this->crud->addColumn([
            'name' => 'username', // The db column name
            'label' => "Usuario", // Table column heading
            //'limit' => 1000, // character limit; default is 50;
        ]);

        $this->crud->addColumn([
            'label' => "Sat",
            'type' => 'select',
            'name' => 'sat_ruc', // the db column for the foreign key
            'entity' => 'ItemDynamic', // the method that defines the relationship in your Model
            'attribute' => 'NucNomSat', // foreign key attribute that is shown to user
            //'model' => "App\Models\Sat", // foreign key model
        'limit' => 1000,
        ]);

        //$this->crud->setFromDb();
 /*       $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => "Nombre", // Table column heading
            //'limit' => 1000, // character limit; default is 50;
        ]);

        $this->crud->addColumn([
        'name' => 'email', // The db column name
        'label' => "Mail", // Table column heading
        //'limit' => 1000, // character limit; default is 50;
        ]);

        $this->crud->addColumn([
        'name' => 'username', // The db column name
        'label' => "Usuario", // Table column heading
        //'limit' => 1000, // character limit; default is 50;
        ]);


        $this->crud->addColumn([
            'label' => "Sat",
            'type' => 'select',
            'name' => 'sat_ruc', // the db column for the foreign key
            'entity' => 'getsat', // the method that defines the relationship in your Model
            'attribute' => 'NucNomSat', // foreign key attribute that is shown to user
            'model' => "App\Models\Sat", // foreign key model
        //'limit' => 1000,
        ]);
*/

        /* Create and Edit */
        $this->crud->addField(
        [  // Select
            'label' => "Seleccionar Sat",
            'type' => 'select',
            'name' => 'sat_ruc', // the db column for the foreign key
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => 'NucNomSat', // foreign key attribute that is shown to user
            'model' => "App\Models\Sat", // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('NucNomSat', 'ASC')->where('NucRuc','!=', null)->get();
                }),
            ]
        );

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Nombre',
        ]);

        $this->crud->addField([
            'name' => 'username',
            'type' => 'text',
            'label' => 'Usuario',
        ]);

        $this->crud->addField([   // Email
            'name' => 'email',
            'label' => 'Correo Electronico',
            'type' => 'email'
        ]);

        $this->crud->addField([   // Password
            'name' => 'password',
            'label' => 'Password',
            'type' => 'password'
        ]);


         //$this->crud->setColumns();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();
        //$this->crud->removeColumns(['password', 'remember_token']);
        // add asterisk for fields that are required in UserRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here

        //$input['file_path'] = $request->;
        //return $request;
        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        //'remember_token' => $request['_token'],
        'sat_ruc' => $request->sat_ruc
        ]);
        //return $data;
        //$redirect_location = parent::storeCrud($data);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        //$request->http_referrer;
        //return redirect->Back()$data['http_referrer'];
        //return redirect()->route('usuarios');
        return redirect('admin/usuarios');
    }

    public function update(UpdateRequest $request)
    {
        //return $request;
        // your additional operations before save here
        //$redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $user = User::find($request->id);
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        if($request['password']){
          $user->password = $request['password'];
        }
        $user->remember_token = $request['_token'];
        $user->sat_ruc = $request['sat_ruc'];
        $user->save();
        //return $redirect_location;
        return redirect('admin/usuarios');
    }
}
