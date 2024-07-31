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
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        // Validate the incoming request
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'], // Phone is optional
            'state' => ['required', 'string', 'max:255'], // State is optional
            'city' => ['required', 'string', 'max:255'], // City is optional
            'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Profile image validation
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Handle file upload for profile image
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Create a new user
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone, // Save phone number
            'state' => $request->state, // Save state
            'city' => $request->city,   // Save city
            'profile_image' => $profileImagePath, // Save profile image path
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Trigger the registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }
}
