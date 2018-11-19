<?php

namespace App\Controller;

require __DIR__ . '/../Model/provinsi.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Provinsi as Provinsi;

final class ProvinsiController {

    public function __construct(){}
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $provinsi = new Provinsi();

            // $provinsi->id = (Provinsi::all()->last()->id)+1;
            $provinsi->nama = $post['nama'];
            $provinsi->save();

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

    // Get semua data
    public function getall(Request $request, Response $response, $args){
        try{
            $provinsis = Provinsi::all();
            $response->write(json_encode($provinsis));
			//$response->write(json_encode($request->getHeaders()));
            $status=200;
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        //return $response->withHeader('Access-Control-Allow-Origin', '*')->withStatus($status);
		return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Get 1 data
    public function get(Request $request, Response $response, $args){
        try{
            $provinsi = Provinsi::find($args['id']);
            if(!$provinsi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Provinsi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($provinsi));
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

    //Update Provinsi
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $provinsi = Provinsi::find($post['id']);
            if(!$provinsi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Provinsi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $provinsi->nama = $post['nama'];
                $provinsi->save();

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

    //Hapus provinsi
    public function delete(Request $request, Response $response, $args){
        try{
            $provinsi = Provinsi::find($args['id']);
            if(!$provinsi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Provinsi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $provinsi->delete();
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