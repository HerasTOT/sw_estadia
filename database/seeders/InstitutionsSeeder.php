<?php

namespace Database\Seeders;

use App\Models\Institutions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class InstitutionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documento = glob('database/seeders/Instituciones.xlsx');

        $data = Excel::toArray([], $documento[0]);

        foreach ($data[0] as $row) {
            $model = new Institutions();
            $model->name = $row[1];
            $model->status = '1';

            $model->save();
        }

        Institutions::create(['name' => '', 'status' => '1']);
    }
}
