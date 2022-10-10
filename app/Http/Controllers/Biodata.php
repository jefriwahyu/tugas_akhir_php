<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\tbl_biodata;

class Biodata extends Controller
{
    public function getData(){
        $data = DB::table('tbl_biodata')->get();
        if(count($data) > 0){
            $res['pesan'] = "Data berhasil di tampilkan !";
            $res['value'] = $data;
            return response($data);
        }else{
            $res['pesan'] = "Belum ada data tersimpan !";
            return response($res);
        }
    }

    public function store(Request $request){

        $this->validate($request, ['file' => 'required|max:2048']);     // untuk upload file
        $file = $request -> file('file');                               // menyimpan file
        $nama_file = time()."_".$file->getClientOriginalName();         // membuat nama file
        $simpan_file = $file->storeAs('public/foto', $nama_file);       // menyimpan file ke dalam tujuan folder
        if($file->move($simpan_file, $nama_file)){
            $data = tbl_biodata::create([
                'nama' => $request -> nama,
                'no_hp' => $request -> no_hp,
                'alamat' => $request -> alamat,
                'hobi' => $request -> hobi,
                'foto' => $nama_file
            ]);
            $res['pesan'] = "Data berhasil disimpan !";
            $res['value'] = $data;
            return response($res);
        }
    }

    public function update(Request $request){
        if(!empty($request->file)){
            $this->validate($request, ['file' => 'required|max:2048']);     // untuk upload file
            $file = $request -> file('file');                               // menyimpan file
            $nama_file = time()."_".$file->getClientOriginalName();         // membuat nama file
            $simpan_file = $file->storeAs('public/foto', $nama_file);       // menyimpan file ke dalam tujuan folder
            $file->move($simpan_file, $nama_file);
            $data = DB::table('tbl_biodata')->where('id', $request->id)->get();
            foreach($data as $biodata){
                Storage::delete('public/foto/'.$biodata->foto);
                $bio = DB::table('tbl_biodata')->where('id', $request->id)->update([
                    'nama' => $request -> nama,
                    'no_hp' => $request -> no_hp,
                    'alamat' => $request -> alamat,
                    'hobi' => $request -> hobi,
                    'foto' => $nama_file
                ]);
                $res['pesan'] = "Data berhasil di update !";
                $res['value'] = $bio;
                return response($res);
            }    
        }else {
            $data = DB::table('tbl_biodata')->where('id', $request->id)->get();
            foreach($data as $biodata){
                $bio = DB::table('tbl_biodata')->where('id', $request->id)->update([
                    'nama' => $request -> nama,
                    'no_hp' => $request -> no_hp,
                    'alamat' => $request -> alamat,
                    'hobi' => $request -> hobi,
                    'foto' => $nama_file
                ]);
                $res['pesan'] = "Data berhasil di update !";
                $res['value'] = $bio;
                return response($res);
            }
        }
    }

    public function hapus($id){
        $data = DB::table('tbl_biodata')->where('id', $id)->get();
        foreach($data as $biodata){
            if(file_exists('public/foto/'.$biodata->foto)){
                Storage::delete('public/foto/'.$biodata->foto);
                DB::table('tbl_biodata')->where('id', $id)->delete();
                $res['pesan'] = "Data berhasil dihapus !";
                return response($res);
            }else{
                $res['pesan'] = "Data tidak ada !";
                return response($res);
            }
        }
    }

    public function baca($id){
        $data = DB::table('tbl_biodata')->where('id', $id)->get();
        if(count($data) > 0){
            $res['pesan'] = "Berhasil mengambil data !";
            $res['value'] = $data;
            return response($res);
        }else{
            $res['pesan'] = "Data tidak ada !";
            return response($res);
        }
            
    }
}