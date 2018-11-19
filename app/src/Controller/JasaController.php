<?php

namespace App\Controller;

require __DIR__ . '/../Model/jasa.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Jasa as Jasa;



final class JasaController {

    public function __construct(){}
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $jasa = new Jasa();

            // $jasa->id = (Jasa::all()->last()->id)+1;
            $jasa->id_toko = (int)$post['id_toko'];
            $jasa->nama = $post['nama'];
            $jasa->harga = (int)$post['harga'];
            $jasa->save();

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
            $jasas = Jasa::all();
            $response->write(json_encode($jasas));
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
            $jasa = Jasa::find((int)$args['id']);
            if(!$jasa){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Jasa Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($jasa));
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
    //Get 1 data
    public function get_byidtoko(Request $request, Response $response, $args){
        try{
            //$jasa = Transaksi::find($args['id']);
            $jasa_json=Jasa::where([
                ['id_toko', '=', (int)$args['id']]
            ])->get();
            if(!json_decode($jasa_json)){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Jasa Tidak ditemukan'
                ]));
                $status=400;
            }else{
                 $status=200;
                $response->write(json_encode($jasa_json));
            }
               

        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan jasa gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json');
    }
    //Get 1 data
    public function get_json($id){
        $jasa = Jasa::find((int)$id);
        return json_encode($jasa);
    }
    //Cari data
    public function search(Request $request, Response $response, $args){
        try{
            $jasas = Jasa::whereRaw('concat(nama,"",harga) like ?', "%".$args['term']."%")->get();
            $response->write(json_encode($jasas));
            $status=200;
        }
        catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penambahan data gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Update Jasa
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $jasa = Jasa::find((int)$post['id']);
            if(!$jasa){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Jasa Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['id_toko'])) $jasa->id_toko = (int)$post['id_toko'];
                if(isset($post['nama'])) $jasa->nama = $post['nama'];
                if(isset($post['harga'])) $jasa->harga = (int)$post['harga'];
                $jasa->save();

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

    //Hapus jasa
    public function delete(Request $request, Response $response, $args){
        try{
            $jasa = Jasa::find($args['id']);
            if(!$jasa){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Jasa Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $jasa->delete();
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