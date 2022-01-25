<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller
{
    protected $sessionKey;

    public function __construct()
    {
        $this->getSession();
    }

    public function setSession($key)
    {
        $actionName =explode("@", Route::currentRouteAction());
        $actionName = end($actionName);
        return $this->sessionKey = $key.'_'.$actionName;
    }

    public function getSession()
    {
        return $this->sessionKey;
    }

    public function setFormData($data)
    {
        if (session()->has($this->sessionKey)) {
            session()->forget($this->sessionKey);
        }
            return session()->put($this->sessionKey, $data);

    }

    public function getFormData($clear = false)
    {
        if(session()->has($this->sessionKey)) {
            return $clear == true ? session()->flash($this->sessionKey, session($this->sessionKey)) : session($this->sessionKey);
        }
        return null;
    }
}
