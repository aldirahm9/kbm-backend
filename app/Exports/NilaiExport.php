<?php

namespace App\Exports;

use App\KelasMahasiswa;
use App\Tugas;
use App\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class NilaiExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithStyles,FromView,ShouldAutoSize,WithColumnWidths
{

    public function __construct($id)
    {
        $this->kelas_id = $id;
    }

    public function view(): View
    {
        $usersid = KelasMahasiswa::where('kelas_id',$this->kelas_id)->get()->pluck('user_id');
        $users = User::find($usersid);
        $tugas = Tugas::where('kelas_id',$this->kelas_id)->where('tipe',0)->get();
        return view('exports.nilai', [
            'kelas_id' => $this->kelas_id,
            'users' => $users,
            'tugas' => $tugas
        ]);
    }

    public function columnWidths(): array
    {
        $alpha = range('C','Z');
        $arr = [];
        $tugas = Tugas::where('kelas_id',$this->kelas_id)->where('tipe',0)->count()+2;
        for($i=0;$i<$tugas;$i++) {
            $arr[$alpha[$i]] = 5;
        }
        return $arr;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin'
                ]
            ]
        ]);
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
        ];
    }


}
