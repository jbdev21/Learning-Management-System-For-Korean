<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\StudentRank;
use Illuminate\Database\Seeder;

class StudentRankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $month =  Carbon::now()->subMonths(1)->format('Y-m');
        $singleMonth = Carbon::parse($month)->month;
        $singleYear = Carbon::parse($month)->year;
        
        // $rank = $request->rank == 2 ? 1 : 0;

        $prevMonth = Carbon::now()->subMonth(1)->format('Y-m');
        $list = array();

        for($i = 0; $i < 7; $i++){
            $monthHere = Carbon::parse($prevMonth)->subMonth($i)->format('Y-m-d');
         
            
            $studentRank = new StudentRank;
            $studentRank->user_id = User::whereType('student')->whereIsActive(1)->inRandomOrder()->first()->id;
            $studentRank->month = $monthHere;
            $studentRank->rank = 1;
            $studentRank->save();
            
            $studentRank2 = new StudentRank;
            $studentRank2->user_id = User::whereType('student')->whereIsActive(1)->inRandomOrder()->first()->id;
            $studentRank2->month = $monthHere;
            $studentRank2->rank = 2;
            $studentRank2->save();

            // array_push($list, $array);
        }
    }
}
