<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = ['industry_id','company_id','title','description','location','employment_type','vacancies','deadline','status','requirements','salary','company_logo'];

    protected $dates = ['deadline'];

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
}
