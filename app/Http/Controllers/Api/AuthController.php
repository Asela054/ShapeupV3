<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'logintype' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $username = $request->input('username');
        $password = (string) $request->input('password');
        $loginType = (int) $request->input('logintype', 0);

        try {
            $user = User::query()
                ->where('status', 1)
                ->where('username', $username)
                ->with([
                    'employeeProfile:idtbl_employee,name,phone,tbl_user_type_idtbl_user_type,useraccountid',
                    'salesManagerProfile:idtbl_sales_manager,salesmanagername,contactone,tbl_user_idtbl_user',
                ])
                ->first();

            if (!$user) {
                return response()->json([
                    'code' => '500',
                    'refid' => '',
                    'empid' => '',
                    'name' => '',
                    'mobile' => '',
                    'userType' => '',
                ]);
            }

            $storedPassword = (string) $user->password;
            $isLegacyMd5 = hash_equals($storedPassword, md5($password));

            $isBcryptHash = str_starts_with($storedPassword, '$2y$')
                || str_starts_with($storedPassword, '$2a$')
                || str_starts_with($storedPassword, '$2b$');

            $isBcrypt = $isBcryptHash ? Hash::check($password, $storedPassword) : false;

            if (!$isLegacyMd5 && !$isBcrypt) {
                return response()->json([
                    'code' => '500',
                    'refid' => '',
                    'empid' => '',
                    'name' => '',
                    'mobile' => '',
                    'userType' => '',
                ]);
            }

            $empProfile = $loginType === 0 ? $user->employeeProfile : $user->salesManagerProfile;

            if (!$empProfile) {
                return response()->json([
                    'code' => '500',
                    'refid' => (string) $user->idtbl_user,
                    'empid' => '',
                    'name' => '',
                    'mobile' => '',
                    'userType' => '',
                ]);
            }

            // Transparently upgrade legacy MD5 password to bcrypt after successful login
            if ($isLegacyMd5 && !$isBcryptHash) {
                $user->password = Hash::make($password);
                $user->updatedatetime = now();
                $user->save();
            }

            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token'
            ], 500);
        }

        $empId = '';
        $name = '';
        $mobile = '';
        $userType = '';
        $userAccountId = '';

        if ($loginType === 0 && $user->employeeProfile) {
            $empId = (string) $user->employeeProfile->idtbl_employee;
            $name = (string) $user->employeeProfile->name;
            $mobile = (string) $user->employeeProfile->phone;
            $userType = (string) 0;
            $userAccountId = (string) $user->employeeProfile->useraccountid;
        } elseif ($loginType !== 0 && $user->salesManagerProfile) {
            $empId = (string) $user->salesManagerProfile->idtbl_sales_manager;
            $name = (string) $user->salesManagerProfile->salesmanagername;
            $mobile = (string) $user->salesManagerProfile->contactone;
            $userType = (string) 1;
            $userAccountId = (string) $user->salesManagerProfile->tbl_user_idtbl_user;
        }

        return response()->json([
            'code' => '200',
            'refid' => (string) $user->idtbl_user,
            'empid' => $empId,
            'name' => $name,
            'mobile' => $mobile,
            'userType' => $userType,
            'userAccountId' => $userAccountId,
            'data' => [
                'user' => [
                    'employeeId' => $empId,
                    'id' => $user->idtbl_user,
                    'name' => $user->name,
                    'username' => $user->username,
                    'tbl_user_type_idtbl_user_type' => $user->tbl_user_type_idtbl_user_type ?? null,
                    'imagepath' => $user->imagepath ?? null,
                ],
                'token' => $token,
                'token_type' => 'bearer',
                
            ]
        ]);
    }
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout'
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Token refreshed',
                'data' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh token'
            ], 500);
        }
    }
    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => Auth::user()
        ]);
    }
}