<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
   public function store(Request $request): RedirectResponse
   {
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role'     => ['required', 'in:admin,farmer,authority'],
    ]);

    // Check if admin already exists
    if ($request->role === 'admin') {
        $adminExists = User::where('role', 'admin')->first();
        if ($adminExists) {
            return back()
                ->withInput()
                ->withErrors(['role' => 'An Admin account already exists. Only one Admin is allowed.']);
        }
    }

    // Check if authority already exists
    if ($request->role === 'authority') {
        $authorityExists = User::where('role', 'authority')->first();
        if ($authorityExists) {
            return back()
                ->withInput()
                ->withErrors(['role' => 'An Authority account already exists. Only one Authority is allowed.']);
        }
    }

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
    ]);

    // Auto-create owner profile when farmer registers
    if ($request->role === 'farmer') {
        \App\Models\Owner::create([
            'user_id' => (string) $user->id,
            'name'    => $request->name,
            'email'   => $request->email,
            'nic'     => 'N/A',
            'phone'   => 'N/A',
            'address' => '',
        ]);
    }

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
    }
}
