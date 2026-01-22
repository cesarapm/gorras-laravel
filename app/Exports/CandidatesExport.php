<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class CandidatesExport implements FromCollection, WithHeadings
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->map(function ($candidate) {
            return [
                'ID' => $candidate->id,
                'Nombre' => $candidate->nombre,
                'Email' => $candidate->email,
                'Celular' => $candidate->celular,
                'Autorización' => $candidate->autorizacion_datos_compartidos ? 'SI' : 'NO',
                'Estado' => ($candidate->autorizacion_datos_compartidos && $candidate->aviso_privacidad2_aceptado) ? 'COMPLETO' : 'INCOMPLETO',
                'Fecha' => $candidate->created_at->format('d/m/Y')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Celular',
            'Autorización',
            'Estado',
            'Fecha'
        ];
    }
}
