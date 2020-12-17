<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Placements\RecruitmentAttempt;
use Illuminate\Http\Request;

class DismissedRecruitmentAttemptsController extends Controller
{
    public function store()
    {
        $recruitment_attempt = RecruitmentAttempt::findOrFail(request('recruitment_attempt_id'));
        $this->authorize('dismiss', $recruitment_attempt);

        $recruitment_attempt->dismiss();
    }
}
