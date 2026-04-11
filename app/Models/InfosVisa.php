<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfosVisa extends Model
{
    use HasFactory;

    /**
     * On précise le nom exact de la table
     * car Laravel chercherait "infos_visas" par défaut
     */
    protected $table = 'infos_visa';

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'service_id',
        'delai',
        'frais',
        'ambassade',
        'notes',
    ];

    /**
     * Les infos visa appartiennent à un service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}