<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::all();
    //     return view('admin.users', compact('users'));
    // }

    public function index()
    {
        $users = User::with(['subscription.bookPlan'])->get(); // Carga la suscripción y su plan asociado
        return view('admin.users', compact('users'));
    }
}
