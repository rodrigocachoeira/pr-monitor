<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PullRequest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'github_id',
        'number',
        'repository',
        'title',
        'body',
        'published_at',
    ];
}
