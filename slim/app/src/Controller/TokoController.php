<?php

namespace App\Controller;

require __DIR__ . '/../Model/toko.php' ;
require __DIR__ . '/../Model/jasa.php' ;
require __DIR__ . '/../Model/pemesanan.php' ;
require __DIR__ . '/../Model/transaksi.php' ;
require __DIR__ . '/../Model/pengguna.php' ;
require __DIR__ . '/../Model/status_pemesanan.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Pengguna as Pengguna;
use \App\Model\Jasa as Jasa;
use \App\Model\Toko as Toko;
use \App\Model\Pemesanan as Pemesanan;
use \App\Model\Transaksi as Transaksi;
use \App\Model\Statuspemesanan as Statuspemesanan;
final class TokoController {

    public function __construct(){}
    
    public function gambar_testing(Request $request, Response $response, $args){
        try{
           
           // $toko = Toko::find(1);


            if(1){
                
                //$gambar = array();
                $files = $request->getUploadedFiles();
                //$cnt = count($files['name']);

                 //$upload_path = "E:\FILE\\XAMPP\htdocs\slim\Backend\src\public\gambar\\";
                 $upload_path = "/home/u619451712/public_html/public/gambar//";


                  //$request->getUri()->getBasePath()
//var_dump($files);

                foreach ($files as $file) {
                    $uploadFileName = $file->getClientFilename();

                    $full_img_path = $upload_path.$uploadFileName ;
                 echo $full_img_path;   
                    //var_dump($file);
 //move_uploaded_file ( string $filename , string $destination )
                    //echo $full_img_path;
                    $file->moveTo($full_img_path);
                    // echo $file->getClientFilename();
                    //  //echo $file->getStream();
                    // echo $file->getSize();
                    //  echo $file->getError();
                    //  echo $file->getClientFilename();
                    //  echo $file->getClientMediaType();
                }

                //$toko->save();


                $status=200;
            }else{
                 $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Pengguna Sudah Memiliki Toko'
                ]));
                $status=400;
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
    
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $toko_json=Toko::where([
                ['id_pengguna', '=', (int)$post['id_pengguna']]
            ])->get();
            if(!json_decode($toko_json)){
                $toko = new Toko();

                // $toko->id = (Toko::all()->last()->id)+1;
                $toko->nama = $post['nama'];
                $toko->alamat = $post['alamat'];
                $toko->kontak = $post['kontak'];
                // $toko->foto = $post['foto'];
                $toko->deskripsi = $post['deskripsi'];
                $toko->jamOperasional = $post['jamOperasional'];
                $toko->rating = 0;
                $toko->id_pengguna = (int)$post['id_pengguna'];
                $toko->id_kategori = (int)$post['id_kategori'];
                $toko->id_kecamatan = (int)$post['id_kecamatan'];
                $toko->save();

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Penambahan data berhasil'
                ]));

                $status=200;
            }else{
                 $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Pengguna Sudah Memiliki Toko'
                ]));
                $status=400;
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

	// Get semua data
    public function getall(Request $request, Response $response, $args){
        try{
            $array = $request->getQueryParams();
            $query=array();
            //Untuk Filter
            if(isset($array['id_kategori'])&&$array['id_kategori']>0){
                $temp=array(
                        'id_kategori','=',$array['id_kategori']
                    );
                array_push($query, $temp);
                
            }
            if(isset($array['id_kecamatan'])&&$array['id_kecamatan']>0){
                $temp=array(
                        'id_kecamatan','=',$array['id_kecamatan']
                    );
                array_push($query, $temp);
            }
            
            
            //Untuk Sorting

            // var_dump(json_encode($query));
            $tokos=Toko::where($query)->get();
            $toko_lengkap=Array();
            foreach ($tokos as $toko) {
                $harga_terendah = Jasa::where([
                    ['id_toko', '=', $toko->id]
                ])->min("harga");
                $temp=array(
                    // 'gambar' => $toko->gambar,
                    'id' => $toko->id,
                    'nama'=>$toko->nama,
                    'alamat' => $toko->alamat,
                    'kontak'=> $toko->kontak,
                    'deskripsi' => $toko->deskripsi,
                    'jamOperasional'=> $toko->jamOperasional,
                    'rating' => $toko->rating,
                    'id_pengguna'=> $toko->id_pengguna,
                    'id_kategori' => $toko->id_kategori,
                    'id_kecamatan'=> $toko->id_kecamatan,
                    'harga_terendah' => $harga_terendah
                );
                array_push($toko_lengkap,$temp);
            }
            //Untuk Sorting
            if(isset($array['sort'])){
                $array_harga=array();
                $array_rating=array();
                foreach ($toko_lengkap as $tokoo) {
                    array_push($array_harga,$tokoo['harga_terendah']);
                    array_push($array_rating,$tokoo['rating']);
                }
           
                if($array['sort']=="rating_asc"){
                    array_multisort($array_rating, SORT_ASC, $toko_lengkap);
                }elseif ($array['sort']=="harga_asc"){
                    array_multisort($array_harga, SORT_ASC, $toko_lengkap);
                }
                elseif ($array['sort']=="harga_dsc"){
                    array_multisort($array_harga, SORT_DESC, $toko_lengkap);
                }
                elseif ($array['sort']=="rating_dsc"){
                    array_multisort($array_rating, SORT_DESC, $toko_lengkap);
                }
            }
            $response->write(json_encode($toko_lengkap));
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
            $toko = Toko::find($args['id']);
            if(!$toko){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Toko Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $harga_terendah = Jasa::where([
                    ['id_toko', '=', $args['id']]
                ])->min("harga");
                $response->write(json_encode([
                    'id' => $toko->id,
                    'nama'=>$toko->nama,
                    'alamat' => $toko->alamat,
                    'kontak'=> $toko->kontak,
                    'deskripsi' => $toko->deskripsi,
                    'jamOperasional'=> $toko->jamOperasional,
                    'rating' => $toko->rating,
                    'id_pengguna'=> $toko->id_pengguna,
                    'id_kategori' => $toko->id_kategori,
                    'id_kecamatan'=> $toko->id_kecamatan,
                    'harga_terendah' => $harga_terendah
                ]));
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

    public function pesanan(Request $request, Response $response, $args){
        try{
            $toko = Toko::find($args['id']);
            if(!json_decode($toko)){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Toko Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $output=array();
                $tokolengkap=array();
                $detail_pemesanan=array();
                
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
                            $transaksi = Transaksi::find($pemesanan['id_transaksi']);
                            $pengguna = Pengguna::find($transaksi['id_pengguna']);
                            $status_pemesanan= Statuspemesanan::find($pemesanan['status_pemesanan']);
                            $temp_pembeli=array(
                                    "id"=> $pengguna['id'],
                                      "nama"=> $pengguna['nama'],
                                      "alamat"=> $pengguna['alamat'],
                                      "jenisKelamin"=> $pengguna['jenisKelamin'],
                                      "kontak"=> $pengguna['kontak']
                                );
                            $temp2=array(
                                    'id_transaksi' => $pemesanan['id_transaksi'],
                                    'id_jasa'   => $pemesanan['id_jasa'],
                                    'nama'      => $jasa['nama'],
                                    'harga'     =>$jasa['harga'],
                                    'kuantitas' => $pemesanan['kuantitas'],
                                    'total'     =>  (int)$pemesanan['total'],
                                    // 'id_transaksi'  =>$pemesanan['id_transaksi'],
                                    'status_pemesanan'=>strtolower($status_pemesanan['nama']),
                                    'data_pembeli'=>$temp_pembeli
                                );
                            array_push($detail_pemesanan,$temp2);
                        }
                    }
                $response->write(json_encode($detail_pemesanan));    
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
    //Get 1 data
    public function get_byidpengguna(Request $request, Response $response, $args){
        try{
            //$toko = Transaksi::find($args['id']);
            $toko_json=Toko::where([
                ['id_pengguna', '=', $args['id']]
            ])->get();
            if(!json_decode($toko_json)){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Toko Tidak ditemukan'
                ]));
                $status=400;
            }else{
                 $status=200;
                $response->write(json_encode($toko_json));
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
    //  //Filter Data
    // public function filterby(Request $request, Response $response, $args){
    //     try{
    //         $array = $request->getQueryParams();
    //         $query=array();
            
    //         if(isset($array['id_kategori'])&&$array['id_kategori']>0){
    //             $temp=array(
    //                     'id_kategori','=',$array['id_kategori']
    //                 );
    //             array_push($query, $temp);
                
    //         }

    //         if(isset($array['id_kecamatan'])&&$array['id_kecamatan']>0){
    //             $temp=array(
    //                     'id_kecamatan','=',$array['id_kecamatan']
    //                 );
    //             array_push($query, $temp);
    //         }
            
    //         // var_dump(json_encode($query));
    //         $toko=Toko::where($query)->get();

    //         if(!json_decode($toko)){
    //             $response->write(json_encode([
    //                 'status' => 'Gagal',
    //                 'message'=> 'Toko Tidak ditemukan'
    //             ]));
    //             $status=400;
    //         }else{
    //              $status=200;
    //             $response->write(json_encode($toko));
    //         }
    //         // //$response->write(json_encode(["hgjg"=>"hj"]));
    //     }catch (\Illuminate\Database\QueryException $e){
    //         $response->write(json_encode([
    //             'status' => 'Gagal',
    //             'message'=> 'Penampilan toko gagal',
    //             'dev_message'=> $e->getMessage()
    //         ]));
    //         $status=500;
    //     }
    //     return $response->withHeader('Content-type', 'application/json');
    // }
    //Cari data
    public function search(Request $request, Response $response, $args){
        try{
            $tokos = Toko::whereRaw('concat(alamat," ",nama,"",kontak,"",deskripsi,"",id_pengguna,"",jamOperasional) like ?', "%".$args['term']."%")->get();
            $response->write(json_encode($tokos));
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
    //Update Toko
    public function update(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();

            $toko = Toko::find($post['id']);
            if(!$toko){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Toko Tidak ditemukan'
                ]));
                $status=400;
            }else{
                if(isset($post['nama'])) $toko->nama = $post['nama'];
                if(isset($post['id_pengguna'])) $toko->id_pengguna = $post['id_pengguna'];
                if(isset($post['alamat'])) $toko->alamat = $post['alamat'];
                if(isset($post['kontak'])) $toko->kontak = $post['kontak'];
                // if(isset($post['foto'])) $toko->foto = $post['foto'];
                if(isset($post['deskripsi'])) $toko->deskripsi = $post['deskripsi'];
                if(isset($post['jamOperasional'])) $toko->jamOperasional = $post['jamOperasional'];
                if(isset($post['id_kategori'])) $toko->id_kategori = $post['id_kategori'];
                if(isset($post['id_kecamatan'])) $toko->id_kecamatan = $post['id_kecamatan'];
                if(isset($post['rating'])) $toko->rating = $post['rating'];
                $toko->save();

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

    //Hapus toko
    public function delete(Request $request, Response $response, $args){
        try{
            $toko = Toko::find($args['id']);
            if(!$toko){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Toko Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $toko->delete();

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