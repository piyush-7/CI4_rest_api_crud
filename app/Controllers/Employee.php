<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;


class Employee extends ResourceController
{

    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new EmployeeModel();
        $data['employees'] = $model->orderBy('id','DESC')->findAll();

        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
       $model = new EmployeeModel();
       $data = $model->where('id',$id)->first();
       if($data):
        return $this->respond($data);

       else:
        return $this->failNotFound('record not found');
       endif;
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $model = new EmployeeModel();
        $data = ['name'=>$this->request->getVar('name'),
                 'email'=>$this->request->getVar('email')];

        $model->insert($data);
        $response = ['status'=>201,
                    'error'=>null,
                    'message'=>['success'=>'Created successfully']];

                    return $this->respond($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new EmployeeModel();
        $id = $this->request->getVar('id');

        $data =  ['name'=>$this->request->getVar('name'),
                'email'=>$this->request->getVar('email')];

        $model->update($id,$data);

        $response = ['status'=>200,
        'error'=>null,
        'message'=>['success'=>'Updated successfully']];

        return $this->respond($response);
}
    

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new EmployeeModel();
        $data = $model->where('id',$id)->delete();
        if($data):
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);

        else:
            return $this->failNotFound('No employee found');
        endif;
    }
}
