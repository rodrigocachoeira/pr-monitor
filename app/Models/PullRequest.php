<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PullRequest extends Model
{
    protected $fillable = [
        'number',
        'repository',
        'title',
        'body',
        'published_at',
    ];
}
