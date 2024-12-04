<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Subscription;

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

    // Método para crear un nuevo usuario
    public function createNewUser()
    {
        // Obtener el último ID de usuario existente
        $lastId = User::max('user_id');
        $newId = $lastId ? $lastId + 1 : 2; // Si no hay usuarios, inicia en 2

        // Crear el nuevo usuario
        $user = User::create([
            'user_id' => $newId,
            'name' => $newId . 'username',
            'email' => $newId . 'new@user.com',
            'password' => bcrypt('asdasd12'), // Generar una contraseña segura
            'role_id' => 2, // Rol de usuario común
        ]);

        return redirect()->route('admin.users')->with('success', 'New user created successfully!');
    }

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Solo permite eliminar si el role_id es 2
        if ($user->role_id !== 2) {
            return redirect()->route('admin.users')->with('error', 'Cannot delete this user.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',user_id',
        ]);
    
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }
}
