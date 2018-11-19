<?php

namespace App\Controller;

require __DIR__ . '/../Model/kabupaten.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Kabupaten as Kabupaten;

final class KabupatenController {

    public function __construct(){}
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $kabupaten = new Kabupaten();

            // $kabupaten->id = (Kabupaten::all()->last()->id)+1;
            $kabupaten->nama = $post['nama'];
            $kabupaten->id_provinsi = $post['id_provinsi'];
            $kabupaten->save();

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
    public function get_byidprovinsi(Request $request, Response $response, $args){
        try{
            //$toko = Transaksi::find($args['id']);
            $toko_json=Kabupaten::where([
                ['id_provinsi', '=', $args['id']]
            ])->get();
            if(!json_decode($toko_json)){
                $response->write(json_encode([
                    // 'status' => 'Gagal',
                    // 'message'=> 'Kabupaten Tidak ditemukan'
                ]));
                $status=200;
            }else{
                 $status=200;
                $response->write(json_encode($toko_json));
            }
               

        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan Kabupaten gagal',
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
            $kabupatens = Kabupaten::all();
            $response->write(json_encode($kabupatens));
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
            $kabupaten = Kabupaten::find($args['id']);
            if(!$kabupaten){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kabupaten Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($kabupaten));
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

    //Update Kabupaten
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $kabupaten = Kabupaten::find($post['id']);
            if(!$kabupaten){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kabupaten Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $kabupaten->nama = $post['nama'];
                if(isset($post['id_provinsi'])) $kabupaten->id_provinsi = $post['id_provinsi'];
                $kabupaten->save();

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Update data berhasil'
                ]));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Update data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Hapus kabupaten
    public function delete(Request $request, Response $response, $args){
        try{
            $kabupaten = Kabupaten::find($args['id']);
            if(!$kabupaten){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kabupaten Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $kabupaten->delete();
                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Hapus data berhasil'
                ]));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Hapus data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }
}