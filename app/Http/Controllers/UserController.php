<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCurrentUser()
    {
        return BaseResource::make(auth()->user());
    }
}
