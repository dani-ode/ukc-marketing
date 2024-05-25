<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->status == 'tidak aktif') {
            $data = [
                'title' => 'nonactive',
            ];
            return view('pages.user.nonactive', $data);
        }

        // $resort = 3;

        if (isset($_COOKIE['withNonActive'])) {
            $with_non_active = $_COOKIE['withNonActive'];
        } else {
            $with_non_active = false;
        }


        $resort = Auth::user()->resort;

        // return print_r($resort);

        if (isset($_COOKIE['day'])) {
            $filter_hari = $_COOKIE['day'];

            if ($filter_hari == 'semua') {

                if ($with_non_active == 'true') {

                    $nasabahs = Nasabah::orderBy('desa', 'ASC')->where('resort', $resort)->get();
                } else {
                    $nasabahs = Nasabah::orderBy('desa', 'ASC')->where('resort', $resort)->where('status', 'aktif')->get();
                }
            } else {
                if ($with_non_active == 'true') {
                    $nasabahs = Nasabah::orderBy('desa', 'ASC')->where('kelompok', $filter_hari)->where('resort', $resort)->get();
                } else {
                    $nasabahs = Nasabah::orderBy('desa', 'ASC')->where('kelompok', $filter_hari)->where('resort', $resort)->where('status', 'aktif')->get();
                }
            }
        } else {

            $carbon = Carbon::now();
            $day = $carbon->format('l');
            // to indonesian
            if ($day == 'Monday') {
                $filter_hari = 'senin';
            } elseif ($day == 'Tuesday') {
                $filter_hari = 'selasa';
            } elseif ($day == 'Wednesday') {
                $filter_hari = 'rabu';
            } elseif ($day == 'Thursday') {
                $filter_hari = 'kamis';
            } elseif ($day == 'Friday') {
                $filter_hari = 'jumat';
            } else {
                $filter_hari = 'senin';
            }

            if ($with_non_active == 'true') {
                $nasabahs = Nasabah::orderBy('desa', 'ASC')->where('kelompok', $filter_hari)->where('resort', $resort)->get();
            } else {
                $nasabahs = Nasabah::orderBy('desa', 'ASC')->where('kelompok', $filter_hari)->where('resort', $resort)->where('status', 'aktif')->get();
            }
        }

        $data = [
            'title' => 'List All Nasabah',
            'nasabahs' => $nasabahs,
            'hari' => $filter_hari,
            'resort' => $resort,
            'with_non_active' => $with_non_active,
        ];

        return view('pages.nasabah.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $foto_ktp = '';
        if ($request->file('foto_ktp')) {
            $foto_ktp = $request->file('foto_ktp')->store('images/ktp-nasabah');
        }
        $foto_selfy = '';
        if ($request->file('foto_selfy')) {
            $foto_selfy = $request->file('foto_selfy')->store('images/selfy-nasabah');
        }
        $foto_rumah = '';
        if ($request->file('foto_rumah')) {
            $foto_rumah = $request->file('foto_rumah')->store('images/rumah-nasabah');
        }

        $nasabah = Nasabah::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'titipan'  => $request->titipan,
            'desa' => $request->desa,
            'koordinat' => $request->koordinat,
            'koordinat_titipan' => $request->koordinat_titipan,
            'keterangan'  => $request->keterangan,
            'kelompok' => $request->kelompok,
            'foto_selfy' => $foto_selfy,
            'foto_ktp' => $foto_ktp,
            'foto_rumah' => $foto_rumah,
            'resort' => $request->resort,
            'user_id' => $request->user_id,
        ]);

        // return 'ok';

        $data = [
            'title' => 'Input Nasabah',
            'nasabah' => $nasabah,
            'user' => User::where('id', Auth::user()->id)->first(),
        ];

        return view('pages.nasabah.add-notif', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->status == 'tidak aktif') {
            $data = [
                'title' => 'nonactive',
            ];
            return view('pages.user.nonactive', $data);
        }
        $nasabah = Nasabah::where('id', $id)->first();

        if (!$nasabah) {
            return redirect('/')->withError('Nasabah not found');
        }
        $user = User::where('id', Auth::user()->id)->first();

        $data = [
            'title' => 'Detail Nasabah',
            'nasabah' => $nasabah,
            'user' => $user,
        ];

        return view('pages.nasabah.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if ($request->destroy == 'true') {
            $nasabah = Nasabah::where('id', $id)->first();
            $nasabah->delete();
            return redirect('/')->withSuccess('Nasabah deleted successfully');
        }

        $nasabah = Nasabah::where('id', $id)->first();

        $foto_ktp = $nasabah->foto_ktp;
        if ($request->file('foto_ktp')) {
            $foto_ktp = $request->file('foto_ktp')->store('images/ktp-nasabah');
        }
        $foto_selfy = $nasabah->foto_selfy;
        if ($request->file('foto_selfy')) {
            $foto_selfy = $request->file('foto_selfy')->store('images/selfy-nasabah');
        }
        $foto_rumah = $nasabah->foto_rumah;
        if ($request->file('foto_rumah')) {
            $foto_rumah = $request->file('foto_rumah')->store('images/rumah-nasabah');
        }

        $resort = $nasabah->resort;
        if ($request->resort != $resort) {
            $resort = $request->resort;
        }
        $status = $nasabah->status;
        if ($request->status != $status) {
            $status = $request->status;
        }
        $rating = $nasabah->rating;
        if ($request->rating != $rating) {
            $rating = $request->rating;
        }
        $checked = $nasabah->checked;
        if ($request->checked != $checked) {
            $checked = $request->checked;
        }

        $nasabah->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'titipan'  => $request->titipan,
            'desa' => $request->desa,
            'koordinat' => $request->koordinat,
            'koordinat_titipan' => $request->koordinat_titipan,
            'keterangan'  => $request->keterangan,
            'kelompok' => $request->kelompok,
            'foto_selfy' => $foto_selfy,
            'foto_ktp' => $foto_ktp,
            'foto_rumah' => $foto_rumah,
            'resort' => $resort,
            'rating' => $rating,
            'status' => $status,
            'checked' => $checked,
            'user_id' => $request->user_id,
        ]);

        $data = [
            'title' => 'Update Nasabah',
            'nasabah' => $nasabah,
            'user' => User::where('id', Auth::user()->id)->first(),
        ];

        return view('pages.nasabah.add-notif', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importNasabah(Request $request)
    {
        if (Auth::user()->status == 'tidak aktif') {
            $data = [
                'title' => 'nonactive',
            ];
            return view('pages.user.nonactive', $data);
        }

        $request->validate([
            'data_nasabah' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('data_nasabah');

        $reader = new Xlsx();

        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();

        $total_data = 0;

        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }


            $total_data++;

            if (!$data[0]) {


                $data = [
                    'title' => 'Import Nasabah',
                    'total_data' => $total_data,
                    'nasabah' => 0,
                ];

                return view('pages.nasabah.add-notif', $data);
            }

            // (C2) INSERT INTO DATABASE
            $dataNasabah = [
                'nama' => $data[0],
                'no_hp' => $data[1],
                'titipan'  => $data[2],
                'desa' => $data[3],
                'koordinat' => $data[4],
                'koordinat_titipan' => $data[5],
                'keterangan'  => $data[6],
                'kelompok' => $data[13],
                'foto_selfy' => $data[7],
                'foto_ktp' => $data[8],
                'foto_rumah' => $data[9],
                'rating' => $data[10],
                'resort' => $data[11],
                'status' => $data[12],
                'user_id' => Auth::user()->id,
            ];

            Nasabah::create($dataNasabah);
        }
    }

    public function exportNasabah(Request $request)
    {

        $spreadsheet = new Spreadsheet();

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at"];

        $loop_index = 1;

        foreach ($days as $day) {


            $sheet = $spreadsheet->getActiveSheet();
            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = [
                'font' => ['bold' => true], // Set font nya jadi bold
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                ]
            ];
            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                ]
            ];



            $sheet->setCellValue('A1', "DATA NASABAH HARI " . strtoupper($day)); // Set kolom A1 dengan tulisan "DATA SISWA"
            $sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
            $sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            // Buat header tabel nya pada baris ke 3
            $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
            $sheet->setCellValue('B3', "NAMA"); // Set kolom B3 dengan tulisan "NIS"
            $sheet->setCellValue('C3', "HANDPHONE"); // Set kolom C3 dengan tulisan "NAMA"
            $sheet->setCellValue('D3', "TITIPAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
            $sheet->setCellValue('E3', "DESA"); // Set kolom E3 dengan tulisan "TELEPON"
            $sheet->setCellValue('F3', "KOORDINAT"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('G3', "KOORDINAT TITIPAN"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('H3', "KETERANGAN"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('I3', "FOTO SELFY"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('J3', "FOTO KTP"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('K3', "FOTO RUMAH"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('L3', "RATING"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('M3', "RESORT"); // Set kolom F3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('N3', "STATUS"); // Set kolom F3 dengan tulisan "ALAMAT"

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header

            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);
            $sheet->getStyle('I3')->applyFromArray($style_col);
            $sheet->getStyle('J3')->applyFromArray($style_col);
            $sheet->getStyle('K3')->applyFromArray($style_col);
            $sheet->getStyle('L3')->applyFromArray($style_col);
            $sheet->getStyle('M3')->applyFromArray($style_col);
            $sheet->getStyle('N3')->applyFromArray($style_col);
            // // Set height baris ke 1, 2 dan 3
            $sheet->getRowDimension('1')->setRowHeight(20);
            $sheet->getRowDimension('2')->setRowHeight(20);
            $sheet->getRowDimension('3')->setRowHeight(20);
            // Buat query untuk menampilkan semua data siswa

            $clean_day = str_replace("'", "", $day); // Remove the apostrophe
            $clean_day = strtolower($clean_day); // Convert to lowercase

            $semua_nasabah = Nasabah::orderBy('desa', 'ASC')->where('resort', Auth::user()->resort)->where('kelompok', $clean_day)->get();
            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $row = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($semua_nasabah as $nasabah) {

                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $nasabah->nama);
                $sheet->setCellValueExplicit('C' . $row, $nasabah->no_hp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('D' . $row, $nasabah->titipan);
                // Khusus untuk no telepon. kita set type kolom nya jadi STRING
                $sheet->setCellValue('E' . $row, $nasabah->desa);
                $sheet->setCellValue('F' . $row, $nasabah->koordinat);
                $sheet->setCellValue('G' . $row, $nasabah->koordinat_titipan);
                $sheet->setCellValue('H' . $row, $nasabah->keterangan);
                $sheet->setCellValue('I' . $row, $nasabah->foto_selfy);
                $sheet->setCellValue('J' . $row, $nasabah->foto_rumah);
                $sheet->setCellValue('K' . $row, $nasabah->foto_ktp);
                $sheet->setCellValue('L' . $row, $nasabah->rating);
                $sheet->setCellValue('M' . $row, $nasabah->resort);
                $sheet->setCellValue('N' . $row, $nasabah->status);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $sheet->getStyle('A' . $row)->applyFromArray($style_row);
                $sheet->getStyle('B' . $row)->applyFromArray($style_row);
                $sheet->getStyle('C' . $row)->applyFromArray($style_row);
                $sheet->getStyle('D' . $row)->applyFromArray($style_row);
                $sheet->getStyle('E' . $row)->applyFromArray($style_row);
                $sheet->getStyle('F' . $row)->applyFromArray($style_row);
                $sheet->getStyle('G' . $row)->applyFromArray($style_row);
                $sheet->getStyle('H' . $row)->applyFromArray($style_row);
                $sheet->getStyle('I' . $row)->applyFromArray($style_row);
                $sheet->getStyle('J' . $row)->applyFromArray($style_row);
                $sheet->getStyle('K' . $row)->applyFromArray($style_row);
                $sheet->getStyle('L' . $row)->applyFromArray($style_row);
                $sheet->getStyle('M' . $row)->applyFromArray($style_row);
                $sheet->getStyle('N' . $row)->applyFromArray($style_row);
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Set text left untuk kolom NIS
                // $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row
                $no++; // Tambah 1 setiap kali looping
                $row++; // Tambah 1 setiap kali looping
            }
            // Set width kolom
            $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
            $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
            $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
            $sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
            $sheet->getColumnDimension('E')->setWidth(10); // Set width kolom E
            $sheet->getColumnDimension('F')->setWidth(30); // Set width kolom F
            $sheet->getColumnDimension('G')->setWidth(30); // Set width kolom F
            $sheet->getColumnDimension('H')->setWidth(30); // Set width kolom F
            $sheet->getColumnDimension('I')->setWidth(30); // Set width kolom F
            $sheet->getColumnDimension('J')->setWidth(30); // Set width kolom F
            $sheet->getColumnDimension('K')->setWidth(30); // Set width kolom F
            $sheet->getColumnDimension('L')->setWidth(8); // Set width kolom F
            $sheet->getColumnDimension('M')->setWidth(8); // Set width kolom F
            $sheet->getColumnDimension('N')->setWidth(10); // Set width kolom F
            // Set orientasi kertas jadi LANDSCAPE
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya


            //create new sheet
            $sheet->setTitle($day);
            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex($loop_index);

            $loop_index++; // Tambah 1 setiap kali looping
        }


        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Nasabah (Resort ' . Auth::user()->resort . ').xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new WriterXlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function searchNasabah(Request $request)
    {
        $search = $request->search;
        $nasabahs = Nasabah::where('nama', 'like', '%' . $search . '%')->orWhere('no_hp', 'like', '%' . $search . '%')->orWhere('titipan', 'like', '%' . $search . '%')->get();

        $data = [
            'title' => 'test',
            'nasabahs' => $nasabahs,
            'hari' => 'semua',
            'with_non_active' => 'false',
        ];

        return view('pages.nasabah.search', $data);
    }

    public function updateCheckin(Request $request)
    {
        if ($request->id) {
            $nasabah = Nasabah::find($request->id);

            if ($nasabah->checked == 1) {
                $nasabah->checked = 0;
            } else {
                $nasabah->checked = 1;
            }

            $nasabah->save();
        } else {
            $nasabahs = Nasabah::where('checked', 1)->where('resort', Auth::user()->resort)->get();

            foreach ($nasabahs as $nasabah) {
                $nasabah->checked = 0;
                $nasabah->save();
            }
        }
    }
}
