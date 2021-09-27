<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect(string $provider): JsonResponse
    {
        try {
            return Response::json(['redirect' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()]);
        } catch (Exception $exception) {
            return Response::json([], 400);
        }
    }

    public function callback(string $provider): JsonResponse
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $exception) {
            return Response::json([], 400);
        }

        /** @var AbstractUser $user */
        /** @var User $localUser */

        $localUser = User::firstOrCreate(
            [
                $provider . "_id" => $user->getId()
            ],
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make(Str::random())
            ]
        );

        return Response::json(['token' => $localUser->createToken('Web')->plainTextToken]);
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return Response::json([]);
        } catch (Exception $exception) {
            return Response::json([], 400);
        }
    }
}
