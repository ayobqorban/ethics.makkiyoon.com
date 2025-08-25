<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GfSubmission extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','question_id', 'answer','certificate_id'];

    public function question()
    {
        return $this->belongsTo(GfSubmission::class, 'question_id');
    }
}
