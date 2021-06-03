<?php

namespace Tests\Unit\Teachers;

use App\DateFormatter;
use App\Locations\Area;
use App\Locations\Region;
use App\Nation;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use App\Teachers\TeacherGeneralInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeachersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_update_general_info()
    {
        $nation = factory(Nation::class)->create();
        $teacher = factory(Teacher::class)->create();

        $general_info = new TeacherGeneralInfo([
            'name'          => 'test name',
            'nation_id'   => $nation->id,
            'email'         => 'test@test.test',
            'date_of_birth' => Carbon::today()->subYears(35)->format(DateFormatter::STANDARD),
            'native_language' => 'test native language',
            'other_languages' => 'test other languages'
        ]);

        $teacher->updateGeneralInfo($general_info);
        $teacher->refresh();

        $this->assertSame('test name', $teacher->name);
        $this->assertSame($nation->id, $teacher->nation_id);
        $this->assertSame('test@test.test', $teacher->email);
        $this->assertSame('test native language', $teacher->native_language);
        $this->assertSame('test other languages', $teacher->other_languages);
        $this->assertTrue($teacher->date_of_birth->isSameDay(Carbon::today()->subYears(35)));
    }

    /**
     *@test
     */
    public function can_update_teachers_education_info()
    {
        $teacher = factory(Teacher::class)->create();
        $education_info = new TeacherEducationInfo([
            'education_level'         => Teacher::EDUCATION_BACHELOR,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);

        $teacher->updateEducationInfo($education_info);

        $this->assertSame(Teacher::EDUCATION_BACHELOR, $teacher->education_level);
        $this->assertSame('test college', $teacher->education_institution);
        $this->assertSame('BTest', $teacher->education_qualification);

    }

    /**
     *@test
     */
    public function can_publish_a_teacher_profile()
    {
        $teacher = factory(Teacher::class)->state('private')->create();

        $teacher->publish();

        $this->assertTrue($teacher->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_retract_a_teacher()
    {
        $teacher = factory(Teacher::class)->state('public')->create();

        $teacher->retract();

        $this->assertFalse($teacher->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_get_the_current_job_search()
    {
        $teacher = factory(Teacher::class)->create();
        $jobSearch = factory(JobSearch::class)->create(['teacher_id' => $teacher->id]);

        $current = $teacher->currentJobSearch();

        $this->assertTrue($current->is($jobSearch));
    }

    /**
     *@test
     */
    public function can_query_teacher_signed_up_since_a_given_date()
    {
        $this->travel(-15)->days();

        $old = factory(Teacher::class)->create();

        $this->travelBack();

        factory(Teacher::class, 3)->create();

        $since_last_week = Teacher::signedUpSince(now()->subDays(7))->get();

        $this->assertFalse($since_last_week->contains($old));
    }

    /**
     *@test
     */
    public function can_scope_teacher_profiles_as_complete()
    {
        Storage::fake('media');
        $diligent = factory(Teacher::class)->create();
        $diligent->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $diligent->refresh();
        $no_pic = factory(Teacher::class)->create();
        $uneducated = factory(Teacher::class)->create([
            'education_level' => '',
            'education_institution' => '',
            'education_qualification' => '',
        ]);
        $uneducated->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $uneducated->refresh();
        $nowhere = factory(Teacher::class)->create(['nation_id' => null]);
        $nowhere->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $nowhere->refresh();
        $ageless = factory(Teacher::class)->create(['date_of_birth' => null]);
        $ageless->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $ageless->refresh();
        $no_language = factory(Teacher::class)->create(['native_language' => '']);
        $no_language->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $no_language->refresh();
        $inexperienced = factory(Teacher::class)->create(['years_experience' => null]);
        $inexperienced->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $inexperienced->refresh();

        $completed = Teacher::complete()->get();

        $this->assertCount(1, $completed);
        $this->assertTrue($completed->first()->is($diligent));
    }

    /**
     *@test
     */
    public function can_scope_teacher_profiles_as_incomplete()
    {
        Storage::fake('media');
        $diligent = factory(Teacher::class)->create();
        $diligent->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $diligent->refresh();
        $no_pic = factory(Teacher::class)->create();
        $uneducated = factory(Teacher::class)->create([
            'education_level' => '',
            'education_institution' => '',
            'education_qualification' => '',
        ]);
        $uneducated->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $uneducated->refresh();
        $nowhere = factory(Teacher::class)->create(['nation_id' => null]);
        $nowhere->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $nowhere->refresh();
        $ageless = factory(Teacher::class)->create(['date_of_birth' => null]);
        $ageless->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $ageless->refresh();
        $no_language = factory(Teacher::class)->create(['native_language' => '']);
        $no_language->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $no_language->refresh();
        $inexperienced = factory(Teacher::class)->create(['years_experience' => null]);
        $inexperienced->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $inexperienced->refresh();

        $no_nation_other = factory(Teacher::class)->create([
            'nation_id' => null, 'nation_other' => ''
        ]);
        $no_nation_other->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $no_nation_other->refresh();

        $incomplete = Teacher::incomplete()->get();

        $this->assertCount(7, $incomplete);
        $this->assertFalse($incomplete->contains(fn (Teacher $t) => $t->is($diligent)));
    }

    /**
     *@test
     */
    public function a_teacher_with_an_other_nationality_can_still_be_complete()
    {
        Storage::fake('media');
        $nomad = factory(Teacher::class)->create([
            'nation_id' => null,
            'nation_other' => 'test other nation',
        ]);
        $nomad->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $nomad->refresh();
        $uneducated = factory(Teacher::class)->create([
            'education_level' => '',
            'education_institution' => '',
            'education_qualification' => '',
        ]);
        $uneducated->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $uneducated->refresh();
        $nowhere = factory(Teacher::class)->create(['nation_id' => null, 'nation_other' => null]);
        $nowhere->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $nowhere->refresh();
        $ageless = factory(Teacher::class)->create(['date_of_birth' => null]);
        $ageless->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $ageless->refresh();
        $no_language = factory(Teacher::class)->create(['native_language' => '']);
        $no_language->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $no_language->refresh();

        $inexperienced = factory(Teacher::class)->create(['years_experience' => null]);
        $inexperienced->setAvatar(UploadedFile::fake()->image('test1.jpg'));
        $inexperienced->refresh();

        $completed = Teacher::complete()->get();

        $this->assertCount(1, $completed);
        $this->assertTrue($completed->first()->is($nomad));
    }

    /**
     *@test
     */
    public function can_scope_teachers_to_near_area()
    {
        $regionA = factory(Region::class)->create();
        $regionB = factory(Region::class)->create();

        $areaA = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaB = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaC = factory(Area::class)->create(['region_id' => $regionB->id]);
        $areaD = factory(Area::class)->create(['region_id' => $regionB->id]);

        $teacherA = factory(Teacher::class)->create(['area_id' => $areaA->id]);
        $teacherB = factory(Teacher::class)->create(['area_id' => $areaC->id]);
        $teacherC = factory(Teacher::class)->create(['area_id' => $areaD->id]);
        $teacherD = factory(Teacher::class)->create(['area_id' => $areaB->id]);

        $scoped = Teacher::nearArea($areaA)->get();

        $this->assertCount(2, $scoped);
        $this->assertTrue($scoped->contains($teacherA));
        $this->assertTrue($scoped->contains($teacherD));

    }

    /**
     *@test
     */
    public function can_check_if_profile_is_complete()
    {
        $complete = factory(Teacher::class)->create();
        $incomplete = factory(Teacher::class)->state('incomplete')->create();

        $this->assertTrue($complete->hasCompleteProfile());
        $this->assertFalse($incomplete->hasCompleteProfile());
    }

    /**
     *@test
     */
    public function can_disable_a_teacher_profile()
    {
        $teacher = factory(Teacher::class)->state('enabled')->create();
        $teacher->disable();

        $this->assertTrue($teacher->isDisabled());
        $this->assertTrue($teacher->disabled_on->isToday());
    }

    /**
     *@test
     */
    public function can_reinstate_a_teacher()
    {
        $teacher = factory(Teacher::class)->state('disabled')->create();
        $teacher->reinstate();

        $this->assertFalse($teacher->isDisabled());
        $this->assertNull($teacher->disabled_on);
    }


}
