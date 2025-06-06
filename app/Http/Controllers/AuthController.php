<?php

namespace App\Http\Controllers;
use App\Models\Authentification as Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    // Admin credentials
    protected $adminEmail = 'walsa.admin@gmail.com';
    protected $adminPassword = 'W%A2L0S2&5';

    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('authentification.login');
    }

    /**
     * Gérer la demande de connexion
     */
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Check if admin credentials were provided
    if ($credentials['email'] === $this->adminEmail && $credentials['password'] === $this->adminPassword) {
        // Store admin status in session
        $request->session()->put('is_admin', true);
        return redirect()->route('admin.dashboard');
    }

    // Pour les utilisateurs normaux
    if (Auth::guard('client')->attempt([
        'email' => $credentials['email'],
        'password' => $credentials['password'],
    ])) {
        $request->session()->regenerate();
        $request->session()->put('is_admin', false);

        // Vérifier s'il y a une redirection vers une réservation
        if ($request->has('room_id')) {
            return redirect()->route('booking.create', ['room_id' => $request->room_id]);
        }

        // Vérifier s'il y a une URL de redirection dans la session
        if ($request->session()->has('intended_url')) {
            $intendedUrl = $request->session()->pull('intended_url');
            return redirect($intendedUrl);
        }

        return redirect()->route('client.dashboard');
    }

    return back()->withErrors([
        'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
    ])->onlyInput('email');
}

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegistrationForm()
    {
        return view('authentification.register');
    }

    /**
     * Gérer la demande d'inscription
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_naissance' => ['nullable', 'date'],
            'sexe' => ['nullable', 'string', 'in:homme,femme,autre'],
        ]);

        $client = Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'mot_de_passe' => Hash::make($request->password),
            'date_naissance' => $request->date_naissance,
            'sexe' => $request->sexe,
        ]);

        // Redirect to login page after registration instead of auto-login
        return redirect()->route('login')->with('success', 'Inscription réussie! Veuillez vous connecter.');
    }

    /**
     * Afficher le formulaire de mot de passe oublié
     */
    public function showForgotPasswordForm()
    {
        return view('authentification.forgot-password');
    }

    /**
     * Gérer la demande de réinitialisation de mot de passe
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Cette logique devrait être adaptée pour utiliser votre propre système
        // ou implémenter un système de réinitialisation de mot de passe personnalisé
        // Ceci est un exemple simple qui renvoie l'utilisateur avec un message

        $client = Client::where('email', $request->email)->first();

        if ($client) {
           
            return back()->with('status', 'Nous avons envoyé un lien de réinitialisation de mot de passe à votre adresse e-mail.');
        }

        return back()->withErrors(['email' => 'Nous ne trouvons pas d\'utilisateur avec cette adresse e-mail.']);
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}