<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BasicProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $account_lookup = [
            User::ACCOUNT_TEACHER => 'teacher',
            User::ACCOUNT_SCHOOL => 'school',
            User::ACCOUNT_ADMIN => 'admin',
        ];

        return [
            'name' => $user->name,
            'email' => $user->email,
            'account_type' => $account_lookup[$user->account_type] ?? 'unknown',
            'avatar' => $user->isTeacher() ? $user->teacher->getAvatar() : '',
        ];
    }
}
