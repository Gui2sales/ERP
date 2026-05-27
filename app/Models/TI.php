<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TI extends Model
{
    public $timestamps = false;

    protected $connection = "glpi";

    protected $table = "glpi_tickets";

    protected $casts = [
        'dn_observers_users' => 'array', // ou 'json'
        'dn_requesters_users' => 'array',
        'dn_solvers_users' => 'array',
        
        'dn_observers_groups' => 'array', // ou 'json'
        'dn_requesters_groups' => 'array',
        'dn_solvers_groups' => 'array',
    ];
}
