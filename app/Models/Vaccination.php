<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $table = 'vaccinations';
    protected $primaryKey = 'VaccinationID';
    protected $fillable = [
        'PetID', 'RecordDate', 'VaccinationName', 
        'NextDueDate', 'Veterinarian'
    ];

    public function pet(){
        return $this->belongsTo(Pet::class, 'PetID');
    }
}