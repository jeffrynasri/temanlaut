<?php

namespace App\Controller;

require __DIR__ . '/../Model/kecamatan.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Kecamatan as Kecamatan;

final class KecamatanController {

    public function __construct(){}
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $kecamatan = new Kecamatan();

            // $kecamatan->id = (Kecamatan::all()->last()->id)+1;
            $kecamatan->nama = $post['nama'];
            $kecamatan->id_kabupaten = $post['id_kabupaten'];
            $kecamatan->save();

           $response->write(json_encode([
                'status' => 'Sukses',
                'message'=> 'Penambahan data berhasil'
            ]));

            $status=200;
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penambahan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }
    //Get 1 data
    public function get_byidkabupaten(Request $request, Response $response, $args){
        try{
            //$toko = Transaksi::find($args['id']);
            $toko_json=Kecamatan::where([
                ['id_kabupaten', '=', $args['id']]
            ])->get();
            if(!json_decode($toko_json)){
                $response->write(json_encode([
                    // 'status' => 'Gagal',
                    // 'message'=> 'Kecamatan Tidak ditemukan'
                ]));
                $status=200;
            }else{
                 $status=200;
                $response->write(json_encode($toko_json));
            }
               

        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan Kecamatan gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        //return $response->withHeader('Access-Control-Allow-Origin', '*')->withStatus($status);
		return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }   
    // Get semua data
    public function getall(Request $request, Response $response, $args){
        try{
            $kecamatans = Kecamatan::all();
            $response->write(json_encode($kecamatans));
            $status=200;
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Get 1 data
    public function get(Request $request, Response $response, $args){
        try{
            $kecamatan = Kecamatan::find($args['id']);
            if(!$kecamatan){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kecamatan Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($kecamatan));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Update Kecamatan
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $kecamatan = Kecamatan::find($post['id']);
            if(!$kecamatan){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kecamatan Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $kecamatan->nama = $post['nama'];
                if(isset($post['id_kabupaten'])) $kecamatan->id_kabupaten = $post['id_kabupaten'];
                $kecamatan->save();

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Update data berhasil'
                ]));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penambahan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Hapus kecamatan
    public function delete(Request $request, Response $response, $args){
        try{
            $kecamatan = Kecamatan::find($args['id']);
            if(!$kecamatan){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kecamatan Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $kecamatan->delete();
                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Hapus data berhasil'
                ]));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penambahan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }
}