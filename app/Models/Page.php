<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function post() {
        return $this->hasMany(PagePost::class, 'page_id');
    }

    public function followingPage() {
        return $this->hasMany(Follower::class, 'page_following_id');
    }

}
