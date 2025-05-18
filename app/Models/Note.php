<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';
    protected $primaryKey = 'NoteID';
    protected $fillable = [
        'PetID', 'NoteContent'
    ];

    public function pets() {
        return $this->belongsTo(Pet::class, 'NoteID', 'PetID');
    }
}