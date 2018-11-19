<?php

namespace App\Controller;

require __DIR__ . '/../Model/pengguna.php' ;
require __DIR__ . '/../Model/jasa.php' ;
require __DIR__ . '/../Model/toko.php' ;
require __DIR__ . '/../Model/pemesanan.php' ;
require __DIR__ . '/../Model/transaksi.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Pengguna as Pengguna;
use \App\Model\Jasa as Jasa;
use \App\Model\Toko as Toko;
use \App\Model\Pemesanan as Pemesanan;
use \App\Model\Transaksi as Transaksi;

final class PenggunaController {

    public function __construct(){}
        
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $pengguna = new Pengguna();
            $username_used = Pengguna::where([
                ['username', '=', $post['username']]
            ])->get();

            if(json_decode($username_used)){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Username sudah digunakan'
                ]));

                $status=400;
            }else{
                // $pengguna->id=(Pengguna::all()->last()->id)+1;
                $pengguna->nama = $post['nama'];
                $pengguna->alamat = $post['alamat'];
                $pengguna->jenisKelamin = $post['jenisKelamin'];
                $pengguna->kontak = $post['kontak'];
                $pengguna->username = $post['username'];
                $pengguna->password = $post['password'];
                $pengguna->token = $post['token'];
            
                $pengguna->save();

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Penambahan data berhasil'
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

//Login
    public function login(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $username=$post['username'];
            $password=$post['password'];
            $a=Pengguna::where([
                ['username', '=', $username],
                ['password', '=', $password]
            ])->get();
            
            
            if (json_decode($a)){
                foreach ($a as $b) {
                    $pengguna = Pengguna::find($b['id']);
                    if(isset($post['token'])){
                        $pengguna->token = $post['token'];
                        $pengguna->save();
                    }
                    $toko_json=Toko::where([
                        ['id_pengguna', '=', $b['id']]
                    ])->get();
                    
            
                    if(!json_decode($toko_json)){
                        $output=array(
                                    'id'=>$b['id'],
                                    'nama' => $b['nama'],
                                    'alamat'     =>  $b['alamat'],
                                    'jenisKelamin'   => $b['jenisKelamin'],
                                    'kontak'  =>$b['kontak'],
                                    'username'=>$b['username'],
                                    'password'=>$b['password'],
                                    'toko'=>0
                        );
                    }else{
                       $output=array(
                                    'id'=>$b['id'],
                                    'nama' => $b['nama'],
                                    'alamat'     =>  $b['alamat'],
                                    'jenisKelamin'   => $b['jenisKelamin'],
                                    'kontak'  =>$b['kontak'],
                                    'username'=>$b['username'],
                                    'password'=>$b['password'],
                                    'toko'=>1
                        ); 
                      
                    }
                    $response->write(json_encode($output));
                }
                

                $status=200;    
            }else{
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Login Gagal'
                ]));
                $status=400;    
            }
        }catch (\Illuminate\Database\QueryException $e){
             $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Login Gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;    
        }
        
        
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

	// Get semua data
    public function getall(Request $request, Response $response, $args){
        try{
            $penggunas = Pengguna::all();
            $response->write(json_encode($penggunas));
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
    public function get(Request $request, Response $response, $args){
        try{
            $pengguna = Pengguna::find($args['id']);
            if(!$pengguna){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Pengguna Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $response->write(json_encode($pengguna));
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
    //Get 1 data
    public function pesanan(Request $request, Response $response, $args){
        try{
            $tokos=Toko::where([
                ['id_pengguna', '=', $args['id']]
            ])->get();
            if(!json_decode($tokos)){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Toko Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $output=array();
                $tokolengkap=array();
                $detail_pemesanan=array();
                foreach ($tokos as $toko) {
                    $jasas=Jasa::where([
                        ['id_toko', '=', $toko['id']]
                    ])->get();
                    foreach ($jasas as $jasa) {
                        if(isset($args['status_pemesanan'])){
                            $pemesanans=Pemesanan::where([
                                ['id_jasa', '=', $jasa['id']],
                                ['status_pemesanan', '=', $args["status_pemesanan"]]
                            ])->get();
                            
                        }else{
                            $pemesanans=Pemesanan::where([
                                ['id_jasa', '=', $jasa['id']]
                            ])->get();
                        }

                        foreach ($pemesanans as $pemesanan) {
                            $temp2=array(
                                    'id_jasa'   => $pemesanan['id_jasa'],
                                    'nama'      => $jasa['nama'],
                                    'harga'     =>$jasa['harga'],
                                    'kuantitas' => $pemesanan['kuantitas'],
                                    'total'     =>  (int)$pemesanan['total'],
                                    // 'id_transaksi'  =>$pemesanan['id_transaksi'],
                                    'status_pemesanan'=>$pemesanan['status_pemesanan']
                                );
                            array_push($detail_pemesanan,$temp2);
                        }
                            $tokolengkap=array(
                                    "id" => $toko["id"],
                                    "nama" =>$toko['nama'],
                                    "alamat" => $toko['alamat'],
                                    "kontak" =>$toko['kontak'],
                                    "deskripsi" =>$toko['deskripsi'],
                                    "id_pengguna" =>$toko['id_pengguna'],
                                    "jamOperasional" =>$toko['jamOperasional'],
                                    "pemesananmasuk" =>$detail_pemesanan
                                );
                    //array_push($tokolengkap,$detail_pemesanan);
                    }
                    
                    array_push($output,$tokolengkap);   
                }
                $response->write(json_encode($output));    
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan toko gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }


    //Cari data
    public function search(Request $request, Response $response, $args){
        try{
            $penggunas = Pengguna::whereRaw('concat(nama," ",alamat,"",kontak,"",username,"",password) like ?', "%".$args['term']."%")->get();
            $response->withHeader('Content-type', 'application/json');
            $response->write(json_encode($penggunas));
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

    //Update Jasa
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $pengguna = Pengguna::find($post['id']);

            if(!$pengguna){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Pengguna Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $pengguna->nama = $post['nama'];
                if(isset($post['alamat'])) $pengguna->alamat = $post['alamat'];
                if(isset($post['kontak'])) $pengguna->kontak = $post['kontak'];
                if(isset($post['jenisKelamin'])) $pengguna->jenisKelamin = $post['jenisKelamin'];
                if(isset($post['username'])) $pengguna->username = $post['username'];
                if(isset($post['password'])) $pengguna->password = $post['password'];
                $pengguna->save();

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

    //Hapus pengguna
    public function delete(Request $request, Response $response, $args){
        try{
            $pengguna = Pengguna::find($args['id']);
            if(!$pengguna){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Pengguna Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $pengguna->delete();

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