<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model{
    protected $table = 'contacts';
    protected $fillable = ['name', 'phone', 'notes', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function validate(array $data) {
        $errors = [];

        if (! $data['name']) {
            $errors['name'] = 'Name is required.';
        }
        $validPhone = preg_match('/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/', $data['phone']);
        
        if (! $validPhone) {
            $errors['phone'] = 'Invalid phone number.';
        }
        
        if (strlen($data['notes']) > 255) {
            $errors['notes'] = 'Notes must be at most 255 characters.';
        }
        
        return $errors;
    }
}