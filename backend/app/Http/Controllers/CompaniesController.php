<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompaniesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function companies(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'phone' => 'required|string',
            'description' => 'required|email|unique',
        ]);
    }
}
