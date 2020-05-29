<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class RequestPasswordResetLinkController extends Controller
{
    use SendsPasswordResetEmails;

}
