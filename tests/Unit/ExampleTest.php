<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    public function testAudioBookSourceFormat(){
        $youtubeLink = "https://www.youtube.com/watch?v=E74_WZpjeKA&list=PL4cUxeGkcC9hL6aCFKyagrT1RCfVN4w2Q&index=2";
        $result = audioBookSourceFormat('yout1ube_video', $youtubeLink);
        $this->assertEquals($result, $youtubeLink);
    }

    public function testPos(){
        $this->assertTrue(strpos("https://www.youtube.com/watch?v=","https://www.youtube.com/watch?v=g33eo4WatiY"));
    }
}
