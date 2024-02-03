<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $question = Question::find(17);
        $correct = $question->checkForCorrect("Wla Alng");
        $this->assertTrue($correct);
    }


    
}
