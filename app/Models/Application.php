<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['user_id','job_post_id','cv_path','cover_letter','status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function setStatusAttribute($value)
    {
        $validStatuses = ['submitted', 'test1', 'test2', 'interview', 'accepted', 'rejected'];
        if (!in_array($value, $validStatuses)) {
            // Log the invalid value and set to default
            \Log::warning("Invalid status value attempted: {$value}. Setting to 'submitted'.");
            $this->attributes['status'] = 'submitted';
        } else {
            $this->attributes['status'] = $value;
        }
    }
}
