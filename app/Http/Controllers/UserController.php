<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Places;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::with('role')
        ->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->role, function ($query) use ($request) {
            $query->where('role_id', $request->role);
        })
        ->latest()
        ->paginate(10);

    $roles = Role::all();

    return view('admin.users.index', compact('users', 'roles'));
    }
    public function edit(User $user)
    {
        $roles = \App\Models\Role::pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validated);
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Updated User',
            'description' => 'Updated user ' . $user->name,
        ]);
        return redirect()->route('admin.users')->with('success', 'User updated');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Updated User',
            'description' => 'Updated user ' . $user->name,
        ]);
        return back()->with('success', 'User status updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Updated User',
            'description' => 'Updated user ' . $user->name,
        ]);
        return back()->with('success', 'User deleted');
    }

    public function bulk(Request $request)
{
    $request->validate([
        'selected' => 'required|array',
        'action' => 'required|string|in:activate,deactivate,delete'
    ]);

    $userIds = $request->input('selected');
    $action = $request->input('action');

    $count = 0;

    switch ($action) {
        case 'delete':
            $count = User::whereIn('id', $userIds)->delete();
            break;
        case 'activate':
            $count = User::whereIn('id', $userIds)->update(['is_active' => true]);
            break;
        case 'deactivate':
            $count = User::whereIn('id', $userIds)->update(['is_active' => false]);
            break;
    }

    return redirect()->back()->with('success', "$count user(s) {$action}d successfully.");
}
public function show(User $user)
{
    $places = Places::where('created_by', $user->id)->latest()->get();
    $logs = ActivityLog::where('user_id', $user->id)->latest()->take(10)->get();
    return view('admin.users.show', compact('user', 'places', 'logs'));
}


}

// ActivityLog::create([            FOR ACTIVITY LOGS
//     'user_id' => auth()->id(),
//     'action' => 'Updated User',
//     'description' => 'Updated user ' . $user->name,
// ]);