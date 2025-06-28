<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number', 'user_id'];

    /**
     * Get the user that owns the contact message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
