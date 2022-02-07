<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Team;

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
        $attributes['ins_datetime'] = date('Y-m-d H:i:s');
        $attributes['ins_id'] = !empty($attributes['ins_id']) ? $attributes['ins_id'] : Auth::id();

        DB::beginTransaction();
        try {
            foreach ($attributes as $key => $value) {
                if ($key != 'id' && in_array($key, $this->getFillable(), true)) {
                    $this->model->$key = $value;
                }
            }
            $this->model->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

        }
        return $this->model;
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if($result) {
            $attributes['upd_datetime'] = date('Y-m-d H:i:s');
            $attributes['upd_id'] = !empty($attributes['upd_id']) ? $attributes['upd_id'] : Auth::id();

            DB::beginTransaction();
            try {
                foreach ($attributes as $key => $value) {
                    if ($key != 'id' && in_array($key, $this->getFillable(), true)) {
                        $result->$key = $value;
                    }
                }
                $result->save();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
            }

            return $result;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->update($id, ['del_flag' => config('const.banned')]);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getFillable()
    {
        return $this->model->getFillable();
    }
}
