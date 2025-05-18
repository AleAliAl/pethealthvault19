<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis';
    protected $primaryKey = 'DiagnosisID';
    public $timestamps = true;

    protected $fillable = [
        'PetID',
        'RecordDate',
        'Diagnosis',
        'MedicationID',
        'Veterinarian',
        'Notes'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'PetID', 'PetID');
    }

    public function medication()
{
    return $this->belongsTo(Medication::class,'MedicationID', 'MedicationID');
}



}
