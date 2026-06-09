<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
     * Crea un Taller nuevo y registra al usuario como admin del mismo.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'codigo_publico' => Taller::normalizarCodigoPublico($request->input('codigo_publico')),
        ]);

        $data = $request->validate([
            'nombre_taller' => ['required', 'string', 'max:255'],
            'codigo_publico' => [
                'nullable',
                'string',
                'min:3',
                'max:10',
                'regex:/^[A-Z0-9]+$/',
                Rule::unique('talleres', 'codigo_publico'),
            ],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $planBasico = SubscriptionPlan::where('slug', 'basico')->firstOrFail();

        [$taller, $user] = DB::transaction(function () use ($data, $planBasico) {
            $codigoPublico = $data['codigo_publico'] ?: Taller::generarCodigoPublico($data['nombre_taller']);

            // 1. Crear el taller con prueba gratuita.
            $taller = Taller::create([
                'nombre'             => $data['nombre_taller'],
                'plan_id'            => $planBasico->id,
                'codigo_publico'     => $codigoPublico,
                'trial_ends_at'      => now()->addDays(7),
                'subscription_status' => 'trial',
                'subscription_ends_at' => null,
                'suscripcion_activa' => true,
            ]);

            // 2. Crear el usuario admin asociado al taller.
            $user = User::create([
                'taller_id' => $taller->id,
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'rol'       => 'admin',
            ]);

            return [$taller, $user];
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('panel.inicio');
    }
}
