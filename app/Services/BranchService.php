<?php
namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Facades\Cache;

class BranchService {
    function branchFromRequest(){
        $domain = $_SERVER['HTTP_HOST'];
        $key = 'domain-' . $domain;
        return Cache::rememberForever($key, function() use($domain){
            if(in_array($domain,config('branch.main_domain'))){
                return Branch::find(config('branch.main_domain_id'));
            }else{
                return Branch::where('domain', $domain)->first();
            }
        });
    }
}
