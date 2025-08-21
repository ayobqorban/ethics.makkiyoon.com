<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GfOption extends Model
{
    use HasFactory;

    protected $table = 'gf_options';

    protected $fillable = ['question_id', 'title'];

    public function question()
    {
        return $this->belongsTo(GfQuestions::class, 'question_id');
    }
}
