<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ProfilesController extends Controller
{
    public function index()
    {
        return view ("users.profile");
    }

    public function create()
    {
        return view ("");
    }
}
