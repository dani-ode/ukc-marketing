<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filter_hari) {
            $filter_hari = $request->filter_hari;
            $users = Nasabah::orderBy('desa', 'ASC')->where('kelompok', $filter_hari)->get();
        } else {
            $users = Nasabah::orderBy('desa', 'ASC')->get();
        }

        $data = [
            'title' => 'test',
            'users' => $users,
        ];

        return view('list-user', $data);
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
        $foto_ktp = $request->file('foto_ktp')->store('images/ktp-nasabah');
        $foto_selfy = $request->file('foto_selfy')->store('images/selfy-nasabah');
        $foto_rumah = $request->file('foto_rumah')->store('images/rumah-nasabah');

        Nasabah::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'titipan'  => $request->titipan,
            'desa' => $request->desa,
            'koordinat' => $request->koordinat,
            'keterangan'  => $request->keterangan,
            'kelompok' => $request->kelompok,
            'foto_selfy' => $foto_selfy,
            'foto_ktp' => $foto_ktp,
            'foto_rumah' => $foto_rumah,
            'desa' => $request->resort,
            'user_id' => 1,
        ]);

        return "berhasil di Kirim";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Nasabah::where('id', $id)->first();


        $data = [
            'title' => 'test',
            'user' => $user,
        ];

        return view('detail-user', $data);
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
        //
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
}