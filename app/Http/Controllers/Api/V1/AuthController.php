<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Package\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function registerCliente(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'documento' => ['required', 'string', 'max:11'],
        ]);

        $customer = $this->resolveCustomer($data['documento'], $data['email']);

        if (User::where('customer_id', $customer->id)->exists()) {
            throw ValidationException::withMessages([
                'documento' => 'Este documento ya tiene una cuenta.',
            ]);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'customer_id' => $customer->id,
            'sucursal_id' => null,
            'isActive' => true,
        ]);
        $user->assignRole('Cliente');

        return $this->tokenResponse($user, 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password) || ! $user->isActive) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no son válidas.',
            ]);
        }

        if (! $user->hasAnyRole(['Cliente', 'Repartidor', 'Admin sucursal'])) {
            throw ValidationException::withMessages([
                'email' => 'Este usuario no tiene acceso a la aplicación móvil.',
            ]);
        }

        return $this->tokenResponse($user);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['user' => $this->userPayload($request->user())]);
    }

    private function resolveCustomer(string $documento, string $email): Customer
    {
        $customers = Customer::query()->where('code', $documento)->where('isActive', true)->get();

        if ($customers->isEmpty()) {
            throw ValidationException::withMessages([
                'documento' => 'No existe un cliente con ese documento.',
            ]);
        }

        $withEmail = $customers->first(function (Customer $customer) use ($email) {
            return $customer->email && strcasecmp($customer->email, $email) === 0;
        });

        if ($withEmail) {
            return $withEmail;
        }

        $requiresEmail = $customers->contains(fn (Customer $customer) => filled($customer->email));
        if ($requiresEmail) {
            throw ValidationException::withMessages([
                'email' => 'El correo debe coincidir con el registrado para ese documento.',
            ]);
        }

        if ($customers->count() > 1) {
            throw ValidationException::withMessages([
                'documento' => 'Hay más de un cliente con ese documento. Contacte a la sucursal.',
            ]);
        }

        return $customers->first();
    }

    private function tokenResponse(User $user, int $status = 200): JsonResponse
    {
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $this->userPayload($user),
        ], $status);
    }

    /**
     * @return array<string, mixed>
     */
    private function userPayload(User $user): array
    {
        $user->loadMissing(['sucursal', 'customer']);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'sucursal_id' => $user->sucursal_id,
            'sucursal' => $user->sucursal?->name,
            'customer_id' => $user->customer_id,
            'roles' => $user->getRoleNames()->values(),
        ];
    }
}
