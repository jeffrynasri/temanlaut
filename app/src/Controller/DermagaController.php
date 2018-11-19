<?php

namespace App\Controller;

require __DIR__ . '/../Model/dermaga.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Dermaga as Dermaga;

final class DermagaController {

    public function __construct(){}
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $dermaga = new Dermaga();

            // $dermaga->id_dermaga = (Dermaga::all()->last()->id_dermaga)+1;
            $dermaga->nama = $post['nama'];
            $dermaga->lat = $post['lat'];
            $dermaga->lon = $post['lon'];
            $dermaga->save();

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
            $dermagas = Dermaga::all();
            $response->write(json_encode($dermagas));
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
            $dermaga = Dermaga::find($args['id_dermaga']);
            if(!$dermaga){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Dermaga Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($dermaga));
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

    //Update Dermaga
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $dermaga = Dermaga::find($post['id_dermaga']);
            if(!$dermaga){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Dermaga Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $dermaga->nama = $post['nama'];
                if(isset($post['lat'])) $dermaga->lat = $post['lat'];
                if(isset($post['lon'])) $dermaga->lat = $post['lon'];
                $dermaga->save();

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

    //Hapus dermaga
    public function delete(Request $request, Response $response, $args){
        try{
            $dermaga = Dermaga::find($args['id_dermaga']);
            if(!$dermaga){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Dermaga Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $dermaga->delete();
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