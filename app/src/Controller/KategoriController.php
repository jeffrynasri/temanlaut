<?php

namespace App\Controller;

require __DIR__ . '/../Model/kategori.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Kategori as Kategori;

final class KategoriController {

    public function __construct(){}
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $kategori = new Kategori();

            // $kategori->id = (Kategori::all()->last()->id)+1;
            $kategori->nama = $post['nama'];
            $kategori->save();

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
            $kategoris = Kategori::all();
            $response->write(json_encode($kategoris));
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
            $kategori = Kategori::find($args['id']);
            if(!$kategori){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kategori Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($kategori));
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

    //Update Kategori
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $kategori = Kategori::find($post['id']);
            if(!$kategori){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kategori Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $kategori->nama = $post['nama'];
                $kategori->save();

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

    //Hapus kategori
    public function delete(Request $request, Response $response, $args){
        try{
            $kategori = Kategori::find($args['id']);
            if(!$kategori){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Kategori Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $kategori->delete();
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