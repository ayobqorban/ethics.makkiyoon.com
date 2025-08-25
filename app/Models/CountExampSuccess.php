<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountExampSuccess extends Model
{
    use HasFactory;

    protected $table = 'count_examp_success';

    protected $fillable = [
        'cr_certificates_id',
        'forms_id',
        'users_id',
        'form_type', // 'form' أو 'gf_form'
    ];

    // العلاقة مع الشهادات
    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'cr_certificates_id');
    }

    // العلاقة مع النماذج/الاختبارات
    public function form()
    {
        return $this->belongsTo(Form::class, 'forms_id');
    }

    // العلاقة مع النماذج العامة
    public function gfForm()
    {
        return $this->belongsTo(GfForm::class, 'forms_id');
    }

    // العلاقة مع المستخدمين
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
