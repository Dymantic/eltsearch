<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviousEmploymentRequest;
use App\Teachers\PreviousEmployment;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Http\Request;

class TeacherPreviousEmploymentController extends Controller
{

    public function index()
    {
        return TeacherProfilePresenter::previousEmployment(request('teacherProfile'));
    }


    public function store(PreviousEmploymentRequest $request)
    {
        $request->teacher()->addPreviousEmployment($request->employmentInfo());
    }

    public function update(PreviousEmployment $employment, PreviousEmploymentRequest $request)
    {
        $employment->update($request->employmentInfo()->toArray());
    }

    public function delete(PreviousEmployment $employment)
    {
        $employment->delete();
    }
}
