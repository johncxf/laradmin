<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    public function users()
    {
        return $this->response->array(User::get()->toArray());
    }
}
