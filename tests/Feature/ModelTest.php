<?php

namespace Tests\Feature;

use App\Models\Developer;
use Tests\TestCase;

class ModelTest extends TestCase
{
    public function test_developer()
    {
        $createDeveloperId = Developer::create([
            'uniq' => 'TEST',
            'duration' => 1,
            'difficulty' => 1
        ])->id;
        $this->assertIsInt($createDeveloperId, 'Developer eklenemedi');
        $getDeveloper = Developer::where(['uniq' => 'TEST'])->get();
        $this->assertCount(1, $getDeveloper, 'Developer çekilemedi');
        Developer::where(['uniq' => 'TEST'])->update(['duration' => 2]);
        $getDeveloper = Developer::where(['uniq' => 'TEST'])->first();
        $this->assertEquals($getDeveloper['duration'], 2, 'Developer Güncellenemedi');
        Developer::where(['uniq' => 'TEST'])->delete();
        $getDeveloper = Developer::where(['uniq' => 'TEST'])->get();
        $this->assertCount(0, $getDeveloper, 'Developer Silinemedi');
    }
}
