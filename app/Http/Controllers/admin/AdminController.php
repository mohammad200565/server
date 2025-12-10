<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showRecent()
    {
        $recentUsers = User::where('id', '!=', 1)
            ->latest()
            ->take(6)
            ->get();

        $recentDepartments = Department::with('user:id,first_name,last_name')
            ->latest()
            ->take(5)
            ->get();

        $recentContracts = Rent::with([
            'user:id,first_name,last_name',
            'department:id,area,bedrooms,bathrooms,floor,location',
            'department.user:id,first_name,last_name'
        ])
            ->latest()
            ->take(6)
            ->get();

        return view('recent', compact('recentUsers', 'recentDepartments', 'recentContracts'));
    }

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

    public function indexDepartment(Request $request)
    {
        $query = Department::with('images');

        if ($request->has('filter') && $request->filter === 'pending') {
            $query->where('verification_state', 'pending');
        }

        $departments = $query->paginate(15);

        return view('/departments', compact('departments'));
    }

    public function showDepartment(Department $department)
    {
        return view('department-details', compact('department'));
    }

    public function indexContract(Request $request)
    {
        $query = Rent::with([
            'user:id,first_name,last_name,phone,verification_state',
            'department:id,area,bedrooms,bathrooms,floor,status,location,description,verification_state,user_id',
            'department.user:id,first_name,last_name,phone,verification_state'
        ]);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($tenantQuery) use ($searchTerm) {
                    $tenantQuery->where('first_name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
                })
                    ->orWhereHas('department.user', function ($ownerQuery) use ($searchTerm) {
                        $ownerQuery->where('first_name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('department', function ($deptQuery) use ($searchTerm) {
                        $deptQuery->where('location->city', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('location->district', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('location->street', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        if ($request->has('filter') && !empty($request->filter)) {
            $query->where('status', $request->filter);
        }

        $query->orderBy('created_at', 'desc');

        $rents = $query->paginate(10);

        $rents->appends($request->query());

        return view('contracts', compact('rents'));
    }

    public function showContract(Rent $rent)
    {
        $rent->load([
            'user:id,first_name,last_name,phone,verification_state',
            'department.user:id,first_name,last_name,phone,verification_state',
            'department:id,area,bedrooms,bathrooms,floor,status,location,description,verification_state,user_id',
            'department.images:id,path'
        ]);

        return view('contract-details', compact('rent'));
    }

    public function verifyDepartment(Department $department)
    {

        $department->verification_state = 'verified';
        $department->save();

        return redirect('/departments/' . $department->id)
            ->with('success', 'Department has been verified successfully!');
    }

    public function rejectDepartment(Department $department)
    {

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
    public function showLogin(Request $request)
    {
        return view('auth.login');
    }
}
