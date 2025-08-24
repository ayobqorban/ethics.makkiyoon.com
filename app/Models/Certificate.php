<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'cr_certificates';
    use HasFactory;
    protected $fillable = ['name', 'img'];

    // العلاقة مع الاختبارات المرتبطة
    public function relatedForms()
    {
        return $this->hasMany(CountExampSuccess::class, 'cr_certificates_id');
    }

    // الحصول على الاختبارات فقط
    public function forms()
    {
        return $this->belongsToMany(Form::class, 'count_examp_success', 'cr_certificates_id', 'forms_id');
    }
}
