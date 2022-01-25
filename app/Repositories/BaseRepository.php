<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (empty($attributes['ins_id'])) {
            $id = Auth::id();
            $attributes = array_merge($attributes, ['ins_id' => $id]);

        }
        if (empty($attributes['ins_datetime'])) {
            $attributes = array_merge($attributes, ['ins_datetime' => date('Y-m-d H:i:s')]);

        }
        try {
            foreach ($attributes as $key => $value) {
                $this->model->$key = $value;
            }
            DB::transaction(function(){
                $this->model->save();
            });
            session()->flash('success', __('messages.create_success'));
            return $this->model;

        } catch(\Exception $e){
            session()->flash('error', __('messages.create_fail'));
            return false;
        }
    }

    public function delete($id)
    {
        return $this->update($id, ['del_flag' => config('const.banned')]);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);

        if (empty($attributes['upd_id'])) {
            $id_upd = Auth::id();
            $attributes = array_merge($attributes, ['upd_id' => $id_upd]);

        }
        if (empty($attributes['upd_datetime'])) {
            $attributes = array_merge($attributes, ['upd_datetime' => date('Y-m-d H:i:s')]);

        }
        try {
            foreach ($attributes as $key => $value) {
                $result->$key = $value;
            }
            DB::transaction(function() use($result){
                $result->save();
            });
            session()->flash('success', __('messages.update_success'));
            return $result;

        } catch(\Exception $e){
            session()->flash('error', __('messages.update_fail'));
            return false;
        }
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
