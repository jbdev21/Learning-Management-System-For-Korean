<?php
namespace App\Services;

use DB;
class StudentRankingService {
     
    function rank($month, $year){
        return DB::table('users')
            ->select('users.id','users.username', 'users.name', DB::raw("(SELECT avg(rating) FROM component_scores WHERE user_id = users.id AND MONTH(`created_at`) = ? AND YEAR(`created_at`) = ?) as average"))
            ->setBindings([$month, $year])
            ->where('users.branch_id','=', domainBranch()->id)
            ->orderBy('average','DESC');
    }
 }