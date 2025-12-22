<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get(); 
        return view('backend.user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'userName'     => 'required|min:3',
            'userEmail'    => 'required|email|unique:users,email', 
            'userPassword' => 'required|min:6',
            'status'       => 'nullable|in:active,inactive',
        ]);

        //store in the database 
        $user = new User();
        $user->name = $request->userName;
        $user->email = $request->userEmail;
        $user->password = bcrypt($request->userPassword); 
        $user->status = $request->status ?? 'active';
        $user->save();


        // Assign roles
        $user->syncRoles($request->roles);

        //redirect to list page
        return redirect()->route('users.index')->with('success', 'User created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('backend.user.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validation
        $request->validate([
            'userName'  => 'required|min:3',
            'userEmail' => 'required|email|min:3|unique:users,email,' . $user->id,
            'status'    => 'nullable|in:active,inactive',
           //'userPassword' => 'nullable|min:6', 
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Update user info
        $user->name = $request->userName;
        $user->email = $request->userEmail;

        if ($request->filled('userPassword')) {
            $user->password = bcrypt($request->userPassword);
        }

        if ($request->has('status')) {
            $user->status = $request->status;
        }

        $user->save();

        // Sync roles
        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user=User::find($id);
        $user->delete();
        return redirect()->route('users.index');   

    }
}
