<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        $trades = Trade::withCount('students')->get();
        $students = Student::with('trade')->get();
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();

        $totalStudents = $students->count();
        $activeTrades = $trades->count();
        $totalCapacity = $trades->sum('capacity');

        return view('admin.dashboard', compact(
            'user',
            'trades',
            'students',
            'admins',
            'totalStudents',
            'activeTrades',
            'totalCapacity'
        ));
    }

    public function storeTrade(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Trade::create($request->only('name', 'capacity'));

        return redirect()->route('admin.dashboard')->with('success', 'Trade created successfully.');
    }

    public function destroyTrade(Trade $trade)
    {
        $trade->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Trade deleted successfully.');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,superadmin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully.');
    }

    public function destroyAdmin(User $admin)
    {
        if ($admin->id === Auth::guard('admin')->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $admin->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Admin deleted successfully.');
    }
}
