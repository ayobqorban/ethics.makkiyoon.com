<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_id', 
        'certificate_filename',
        'status',
        'completed_at'
    ];

    protected $dates = ['completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}
