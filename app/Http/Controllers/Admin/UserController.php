<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash; // Import Hash facade

class UserController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display users
    $users = User::all(); // Fetch all users
    return view('admin.users.index', compact('users')); // Pass users to the view
    }

    public function create()
    {
        // Logic to show the user creation form
        return view('admin.users.create'); // Assuming a view exists for this
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to the users index with a success message
        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }
}
