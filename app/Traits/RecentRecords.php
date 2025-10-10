<?php

namespace App\Traits;

trait RecentRecords
{

    public function scopeRecent($query){
        return $query->orderBy($this->getTable().'.created_at','>',now()->subDays(7));
    }
}
