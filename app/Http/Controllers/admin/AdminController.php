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

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->has('filter') && $request->filter === 'pending') {
            $query->where('verification_state', 'pending');
        }

        $users = $query->paginate(15);

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

    public function indexDepartment(Request $request){
        $query = Department::with('images');
        
        if ($request->has('filter') && $request->filter === 'pending') {
            $query->where('verification_state', 'pending');
        }
        
        $departments = $query->paginate(15);
        
        return view('/departments', compact('departments'));
    }

    public function showDepartment(Department $department){
        return view('department-details', compact('department'));
    }

    public function verifyDepartment(Department $department)
    {
        // It's not working I don't know why.
        //$department->update(['verification_state' => 'verified']);

        $department->verification_state = 'verified';
        $department->save();

        return redirect('/departments/' . $department->id)
            ->with('success', 'Department has been verified successfully!');
    }

    public function rejectDepartment(Department $department)
    {
        //$department->update(['verification_state' => 'rejected']);

        $department->verification_state = 'rejected';
        $department->save();

        logger($department->verification_state);

        return redirect('/departments/' . $department->id)
            ->with('success', 'Department verification has been rejected!');
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
