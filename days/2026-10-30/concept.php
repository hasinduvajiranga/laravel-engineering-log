// app/Http/Livewire/SessionState.php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class SessionState extends Component
{
    public $sessionId;

    public function __construct()
    {
        parent::__construct();

        if (Auth::check()) {
            $this->sessionId = Auth::id();
        }
    }

    public function login(Request $request)
    {
        // Validate and validate user input
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Login user and update session state
        if (Auth::attempt($validatedData)) {
            Session::put('sessionId', Auth::id());
            return redirect()->route('session-state');
        }

        // Handle login failure
    }

    public function logout()
    {
        $this->sessionId = null;
        Session::forget('sessionId');

        // Clear session state
        Session::flush();

        // Redirect to login page
        return redirect()->route('login');
    }
}