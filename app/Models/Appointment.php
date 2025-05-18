<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $primaryKey = 'AppointmentID';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'PetID',
        'FirstName',
        'LastName',
        'OwnerEmail',
        'AppointmentDate',
        'AppointmentTime',
        'Description',
        'Status',
    ];

    
    protected $casts = [
        'AppointmentDate' => 'date',
        'AppointmentTime' => 'datetime:H:i:s',
    ];

 

    public function pets()
    {
        return $this->belongsTo(Pet::class, 'PetID');
    }

}
