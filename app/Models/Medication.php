<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medications';
    protected $primaryKey = 'MedicationID';
    protected $fillable = [
        'ProductName', 'Dosage', 'Frequency', 
        'DurationDays', 'Price', 'Type', 'StockQuantity', 'ExpirationDate'
    ];


    public function diagnosis()
    {
        return $this->hasMany(Diagnosis::class, 'MedicationID', 'MedicationID');
    }
   

}