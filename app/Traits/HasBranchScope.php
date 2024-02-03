<?php
 namespace App\Traits;

 trait HasBranchScope {

    public function scopeBranched($query)
    {
        return $query->where('branch_id', domainBranch()->id);
    }
 }