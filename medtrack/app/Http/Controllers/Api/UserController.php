<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserController
{
    public function me(Request $request)
    {
        return $request->user();
    }
}
