<?php

if (!function_exists('oldData')) {
    function oldData($data, $field, $default= "")
    {
        return old($field, isset($data[$field]) ? $data[$field] : $default);
    }
}

if (!function_exists('getDataEditForm')) {
    function getDataEditForm($data, $sessionName, $field)
    {
        return session()->has($sessionName) ? data_get(session($sessionName), $field) : oldData($data, $field);
    }
}
if (!function_exists('getDataCreateForm')) {
    function getDataCreateForm($sessionName, $textBoxName)
    {
        return session()->has($sessionName) ? data_get(session($sessionName), $textBoxName) : old($textBoxName);

    }
}
if (!function_exists('validateImage')) {
    function validateImage($fileName)
    {
        session()->put('tmp_url', request()->file($fileName)->getPathname());

        $name = request()->file('avatar')->getClientOriginalName();
        Storage::putFileAs(config('const.TEMP_DIR'), request()->file($fileName), $name);
        return ['src_img' => "storage/tmp/$name", 'avatar' => $name];

    }
}
