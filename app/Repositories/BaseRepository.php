<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    /**
     * Set model
     * @throws BindingResolutionException
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($attributes = [])
    {
        $id = Auth::id();
        $arr = ['ins_id' => $id, 'ins_datetime' => date('Y-m-d H:i:s')];
        $attributes = array_merge($attributes, $arr);
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        $id_upd = Auth::id();
        $arr = ['upd_id' => $id_upd, 'upd_datetime' => date('Y-m-d H:i:s')];
        $attributes = array_merge($attributes, $arr);
        if ($result) {
            $result->update($attributes);
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        return $this->update($id, ['del_flag' => '1']);
    }
}
