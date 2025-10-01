<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = ['industry_id','company_id','title','description','location','employment_type','vacancies','deadline','status','requirements','salary','company_logo','min_salary','max_salary','berkas_lamaran','total_pelamar','created_at'];

    protected $casts = [
        'deadline' => 'date',
    ];




    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_post_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
