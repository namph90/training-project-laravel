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

    public function create($attributes = [])
    {
        if (!array_key_exists('ins_id', $attributes)) {
            $id = Auth::id();
            $attributes = array_merge($attributes, ['ins_id' => $id]);

        }
        if (!array_key_exists('ins_datetime', $attributes)) {
            $attributes = array_merge($attributes, ['ins_datetime' => date('Y-m-d H:i:s')]);

        }

        return $this->model->create($attributes);
    }

    public function delete($id)
    {
        return $this->update($id, ['del_flag' => config('const.banned')]);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);

        if (!array_key_exists('upd_id', $attributes)) {
            $id_upd = Auth::id();
            $attributes = array_merge($attributes, ['upd_id' => $id_upd]);
        }

        if (!array_key_exists('upd_datetime', $attributes)) {
            $attributes = array_merge($attributes, ['upd_datetime' => date('Y-m-d H:i:s')]);
        }

        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
