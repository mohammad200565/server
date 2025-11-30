<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function indexUsers(Request $request)
    {
        $query = User::where('id', '!=', 1);
        
        // Search by name (first name or last name)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Filter by pending status
        if ($request->has('filter') && $request->filter === 'pending') {
            $query->where('verification_state', 'pending');
        }
        
        $users = $query->get();
        
        return view('users', compact('users'));
    }

    public function showUser(User $user)
    {
        return view('user-details', compact('user'));
    }

    public function verifyUser(User $user)
    {
        $user->update(['verification_state' => 'verified']);

        return redirect()->route('users.show', $user)
            ->with('success', 'User has been verified successfully!');
    }

    public function rejectUser(User $user)
    {
        $user->update(['verification_state' => 'rejected']);

        return redirect()->route('users.show', $user)
            ->with('success', 'User verification has been rejected!');
    }

    public function indexDepartment(){
        $departments = Department::all();
        return view('departments', compact('departments'));
    }

    public function showDepartment(Department $department){
        return view('department-details', compact('department'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect('/')->with('success', 'Login successful');
        } else {
            return redirect('/login')->withErrors(['Invalid credentials'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
