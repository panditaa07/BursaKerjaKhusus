<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','job_post_id','cv_path','cover_letter_path','cover_letter','status','description','applied_at','status_changed_at'];

    protected $dates = ['applied_at', 'status_changed_at'];

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
        $validStatuses = ['submitted', 'reviewed', 'accepted', 'rejected', 'interview', 'test1', 'test2'];
        if (!in_array($value, $validStatuses)) {
            // Log the invalid value and set to default
            \Log::warning("Invalid status value attempted: {$value}. Setting to 'submitted'.");
            $this->attributes['status'] = 'submitted';
        } else {
            $this->attributes['status'] = $value;
        }

        // Update status_changed_at when status changes
        if ($value !== $this->getOriginal('status')) {
            $this->attributes['status_changed_at'] = now();
        }
    }
}
