<?php

namespace App\Http\Controllers;

use App\Http\Requests\Token\StoreTokenRequest;
use App\Http\Resources\Auth\Token\AuthTokenResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        private User $userModel
    ) {
    }

    public function store(StoreTokenRequest $request)
    {
        try {
            $data = $request->validated();

            $username = $data['username'];
            $password = $data['password'];

            $usernameColumn = $this->userModel::getUsernameColumn();
            $user = $this->userModel->where($usernameColumn, $username);

            if ($user->exists()) {
                $user = $user->first();
                if (password_verify($password, $user->password)) {
                    $token = $user->createToken('authToken');

                    return AuthTokenResource::make($token);
                }
            }
            throw new AuthenticationException('Invalid credentials');
        } catch (AuthenticationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy()
    {
        request()->user()->tokens()->delete();
    }
}
