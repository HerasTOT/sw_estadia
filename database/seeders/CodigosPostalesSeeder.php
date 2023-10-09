<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CodigosPostalesSeeder extends Seeder
{
    public function run()
    {
        ini_set('memory_limit', '-1');
        $documento = IOFactory::load('./database/CodigosPostales.xlsx');
        $hojaDeProductos = $documento->getSheet(0);
        $numeroMayorDeFila = $hojaDeProductos->getHighestRow(0);
        $i = 0;
        $data = [];
        DB::table('c_cod_postal')->truncate();
        for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
            if ($i++ > 4000) {
                DB::table('c_cod_postal')->insert($data);
                $i = 0;
                $data = [];
            }
            $data[] = [
                'id' => $hojaDeProductos->getCell('A' . $indiceFila),
                'codigo_postal' => $hojaDeProductos->getCell('B' . $indiceFila),
                'n_estado' => $hojaDeProductos->getCell('C' . $indiceFila),
                'n_municipio' => $hojaDeProductos->getCell('D' . $indiceFila),
                'n_colonia' => $hojaDeProductos->getCell('E' . $indiceFila),
                'id_entidad_federativa' => $hojaDeProductos->getCell('F' . $indiceFila),
                'id_municipio' => $hojaDeProductos->getCell('G' . $indiceFila),
                'id_estado_sepomex' => $hojaDeProductos->getCell('H' . $indiceFila),
                'id_municipio_sepomex' => $hojaDeProductos->getCell('I' . $indiceFila),
                'id_colonia_sepomex' => $hojaDeProductos->getCell('J' . $indiceFila),
                'id_municipio_sireho' => $hojaDeProductos->getCell('K' . $indiceFila),
                'id_colonia_sireho' => $hojaDeProductos->getCell('L' . $indiceFila)
            ];
        }
        DB::table('c_cod_postal')->insert($data);
    }
}
