<?php

namespace App\Exports;

use App\Models\Perfil;
use Maatwebsite\Excel\Concerns\FromCollection;

class PerfilesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Perfil::all();
    }
}
