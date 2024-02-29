<?php

namespace App\Models;

use Altwaireb\CountriesStatesCities\Models\State as Model;

class State extends Model
{
    protected static ?string $modelLabel = 'Provincia';
    protected static ?string $pluralModelLabel = 'Provincias';
}
