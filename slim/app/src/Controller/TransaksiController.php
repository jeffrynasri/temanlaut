<?php

namespace App\Controller;

require __DIR__ . '/../Model/transaksi.php' ;
require __DIR__ . '/JasaController.php' ;
require __DIR__ . '/PemesananController.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Transaksi as Transaksi;
use \App\Controller\JasaController as JasaController;
use \App\Controller\PemesananController as PemesananController;
//use \App\Model\Pemesanan as Pemesanan;

final class TransaksiController {

    public function __construct(){}
        
    //Tambah data
    public function create(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $array=json_decode(json_encode($post),true);

            $transaksi = new Transaksi();
            $transaksi->id = (Transaksi::all()->last()->id)+1;
            $temp_id=$transaksi->id;
            $transaksi->id_pengguna = $array['id_pengguna'];
            $transaksi->total = 0;
            $transaksi->save();

            $transaksi = Transaksi::find($temp_id);
            
            $total=0;

            $data_pemesanan=array();
            
            foreach($array['paket'] as $item){
                 $id= $item['id_jasa'];
                 $jasa = new JasaController();
                 $pemesanan = new PemesananController();
                 $jasa =json_decode($jasa->get_json($id),true);

                $data_pemesanan=array(
                    array(
                        'kuantitas' => $item['kuantitas'],
                        'total'     =>  (int)$jasa['harga'],
                        'id_jasa'   => $item['id_jasa'],
                        'id_transaksi'  =>$transaksi->id,
                        'status_pemesanan'=>1
                    )
                );
                 $pemesanan->create($data_pemesanan);

                 //Menghitung Total Transaksi
                 $total=$total+((int)$jasa['harga']*(int)$item['kuantitas']);
            }
            $transaksi->total = $total;
            $transaksi->save();
            $response->write(json_encode([
                'status' => 'Sukses',
                'message'=> 'Pembelian Berhasil',
            ]));
            $status=200;
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Pembelian gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

	// Get semua data
    public function getall(Request $request, Response $response, $args){
        try{
            $transaksis = Transaksi::all();
            $pemesanan = new PemesananController();
            $output=array();
            foreach ($transaksis as $transaksi) {
                $transaksi_lengkap=array();
                $detail_transaksi=json_decode($pemesanan->get_by_transaksi($transaksi["id"]),true);
                $detail_pemesanan=Array();
                foreach ($detail_transaksi as $detail) {
                    $temp2=array(
                                'kuantitas' => $detail['kuantitas'],
                                'total'     =>  (int)$detail['total'],
                                'id_jasa'   => $detail['id_jasa'],
                                'id_transaksi'  =>$detail['id_transaksi'],
                                'status_pemesanan'=>$detail['status_pemesanan']
                        );
                    array_push($detail_pemesanan,$temp2);
                }
                $transaksi_lengkap=array(
                            "id" => $transaksi["id"],
                            "id_pengguna" =>$transaksi['id_pengguna'],
                            "total" => $transaksi['total'],
                            "updated_at" =>$transaksi['updated_at'],
                            "created_at" =>$transaksi['created_at'],
                            "pemesanan" =>$detail_pemesanan
                            );
                array_push($output,$transaksi_lengkap);
            }
            $response->write(json_encode($output));
            $status=200;
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan transaksi gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);
    }

    //Get 1 data
    public function get(Request $request, Response $response, $args){
        try{
            $transaksi = Transaksi::find($args['id']);
            if(!$transaksi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Transaksi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $pemesanan = new PemesananController();
                $output=array();
                $transaksi_lengkap=array();
                $detail_transaksi=json_decode($pemesanan->get_by_transaksi($transaksi["id"]),true);
                $detail_pemesanan=Array();
                foreach ($detail_transaksi as $detail) {
                    $temp2=array(
                                'kuantitas' => $detail['kuantitas'],
                                'total'     =>  (int)$detail['total'],
                                    'id_jasa'   => $detail['id_jasa'],
                                    'id_transaksi'  =>$detail['id_transaksi'],
                                    'status_pemesanan'=>$detail['status_pemesanan']
                            );
                        array_push($detail_pemesanan,$temp2);
                    }
                $transaksi_lengkap=array(
                                "id" => $transaksi["id"],
                                "id_pengguna" =>$transaksi['id_pengguna'],
                                "total" => $transaksi['total'],
                                "updated_at" =>$transaksi['updated_at'],
                                "created_at" =>$transaksi['created_at'],
                                "pemesanan" =>$detail_pemesanan
                                );
                array_push($output,$transaksi_lengkap);
                $status=200;
                $response->write(json_encode($output));
            }
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan transaksi gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json');
    }
    //Get 1 data
    public function get_byidpengguna(Request $request, Response $response, $args){
        try{
            //$transaksi = Transaksi::find($args['id']);
            $transaksi_json=Transaksi::where([
                ['id_pengguna', '=', $args['id']]
            ])->get();
            // $konr=json_decode(json_encode($transaksi_json),true);
            // echo $konr[0]["id"];
            
            if(!json_decode($transaksi_json)){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Transaksi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $transaksis=json_decode((json_encode($transaksi_json)),true);
                //var_dump($transaksi);
                $output=array();
                foreach ($transaksi_json as $transaksi) {
                    $pemesanan = new PemesananController();
                    
                    $transaksi_lengkap=array();
                    $detail_transaksi=json_decode($pemesanan->get_by_transaksi($transaksi["id"]),true);
                    $detail_pemesanan=Array();
                    foreach ($detail_transaksi as $detail) {
                        $temp2=array(
                                    'kuantitas' => $detail['kuantitas'],
                                    'total'     =>  (int)$detail['total'],
                                        'id_jasa'   => $detail['id_jasa'],
                                        'id_transaksi'  =>$detail['id_transaksi'],
                                        'status_pemesanan'=>$detail['status_pemesanan']
                                );
                            array_push($detail_pemesanan,$temp2);
                        }
                        $transaksi_lengkap=array(
                                    "id" => $transaksi["id"],
                                    "id_pengguna" =>$transaksi['id_pengguna'],
                                    "total" => $transaksi['total'],
                                    "updated_at" =>$transaksi['updated_at'],
                                    "created_at" =>$transaksi['created_at'],
                                    "pemesanan" =>$detail_pemesanan
                                    );
                    array_push($output,$transaksi_lengkap);
                }
                $status=200;
                $response->write(json_encode($output));
            }                
        }catch (\Illuminate\Database\QueryException $e){
            $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Penampilan transaksi gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;
        }
        return $response->withHeader('Content-type', 'application/json');
    }

    //Cari data
    public function search(Request $request, Response $response, $args){
        $transaksis = Transaksi::whereRaw('concat(total,"",updated_at,"",created_at) like ?', "%".$args['term']."%")->get();
        $response->withHeader('Content-type', 'application/json');
        $response->write(json_encode($transaksis));
        return $response;
    }

   

    //Hapus transaksi
    public function delete(Request $request, Response $response, $args){
        try{
            $transaksi = Transaksi::find($args['id']);
            if(!$transaksi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Transaksi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $pemesanan = new PemesananController();
                $pemesanan->delete($args['id']);
                $transaksi->delete();

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
        
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);;
    }
    //Menyetujui Pemesanan oleh Penjual
    public function disetujui(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $transaksi = Transaksi::find($post['id']);
            $id_jasa = $post['id_jasa'];
            if(!$transaksi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Transaksi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $pemesanan = new PemesananController();
                $pemesanan->ubah_status($post['id'],$id_jasa,2);                

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Ubah data pemesanan berhasil'
                ]));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
             $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Ubah data pemesanan gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;    
        }
        
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);;
    }
    //Menyetujui Pemesanan oleh Penjual
    public function ditolak(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $transaksi = Transaksi::find($post['id']);
            $id_jasa = $post['id_jasa'];
            if(!$transaksi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Transaksi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $pemesanan = new PemesananController();
                $pemesanan->ubah_status($post['id'],$id_jasa,3);                

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Ubah data pemesanan berhasil'
                ]));
                $status=200;
            }
        }catch (\Illuminate\Database\QueryException $e){
             $response->write(json_encode([
                'status' => 'Gagal',
                'message'=> 'Ubah data pemesanan gagal',
                'dev_message'=> $e->getMessage()
            ]));
            $status=500;    
        }
        
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);;
    }
    //Menyetujui Pemesanan oleh Penjual
    public function sukses(Request $request, Response $response, $args){
        try{
            $post = $request->getParsedBody();
            $transaksi = Transaksi::find($post['id']);
            $id_jasa = $post['id_jasa'];
            if(!$transaksi){
                $response->write(json_encode([
                    'status' => 'Gagal',
                    'message'=> 'Transaksi Tidak ditemukan'
                ]));
                $status=400;
            }else{
                $pemesanan = new PemesananController();
                $pemesanan->ubah_status($post['id'],$id_jasa,4);                

                $response->write(json_encode([
                    'status' => 'Sukses',
                    'message'=> 'Ubah data pemesanan berhasil'
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
        
        return $response->withHeader('Content-type', 'application/json')->withStatus($status);;
    }
}