<?php

namespace App\Models;

use Illuminate\Container\Attributes\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';
    protected $primaryKey = 'PetID';
    protected $fillable = ['UserID', 'Name', 'Species', 'Breed', 'AgeYears', 'AgeMonths', 'Gender', 'Image'];
   

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function appointment() {
        return $this->hasMany(Appointment::class, 'PetID');
    }

    public function vaccination() {
    return $this->hasMany(Vaccination::class, 'PetID', 'PetID');
}
    
    public function diagnosis() {
        return $this->hasMany(Diagnosis::class, 'PetID');
    }

    public function notes() {
        return $this->hasMany(Note::class, 'NoteID');
    }
}