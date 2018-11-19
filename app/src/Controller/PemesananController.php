<?php

namespace App\Controller;

require __DIR__ . '/../Model/pemesanan.php' ;
require __DIR__ . '/../Model/status_pemesanan.php' ;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Model\Pemesanan as Pemesanan;
use \App\Model\Statuspemesanan as Statuspemesanan;

final class PemesananController {

    public function __construct(){}
    //Tambah data
    public function create($data_pemesanan){
        foreach($data_pemesanan as $pemesanan2){
            $pemesanan = new Pemesanan();
            $pemesanan->id_jasa = $pemesanan2['id_jasa'];
            $pemesanan->id_transaksi = $pemesanan2['id_transaksi'];
            $pemesanan->total = $pemesanan2['total'];
            $pemesanan->kuantitas = $pemesanan2['kuantitas'];
            $pemesanan->status_pemesanan = $pemesanan2['status_pemesanan'];
            $pemesanan->save();            
        }
    }

    
    // Get data by id transaksi
    public function get_by_transaksi($id_transaksi){
        $detail_transaksi=Pemesanan::where([
                ['id_transaksi', '=', $id_transaksi]
        ])->get();

        return json_encode($detail_transaksi);
    }
	// Get data by id transaksi
    public function gettra(Request $request, Response $response, $args){
        $pemesanans = Pemesanan::all();

        $response->withHeader('Content-type', 'application/json');
        $response->write(json_encode($pemesanans));
        return $response;
    }


    //Cari data
    public function search(Request $request, Response $response, $args){
        $pemesanans = Pemesanan::whereRaw('concat(id_jasa," ",id_pelanggan,"",id_transaksi,"",total) like ?', "%".$args['term']."%")->get();
        $response->withHeader('Content-type', 'application/json');
        $response->write(json_encode($pemesanans));
        return $response;
    }

    //Update Jasa
    public function update(Request $request, Response $response, $args){
        $post = $request->getParsedBody();

        $pemesanan = Pemesanan::find($post['id']);


        if(isset($post['id_jasa'])) $pemesanan->id_jasa = $post['id_jasa'];
        if(isset($post['id_transaksi'])) $pemesanan->id_transaksi = $post['id_transaksi'];
        if(isset($post['id_pelanggan'])) $pemesanan->id_pelanggan = $post['id_pelanggan'];
        if(isset($post['total'])) $pemesanan->total = $post['total'];
        if(isset($post['kuantitas'])) $pemesanan->kuantitas = $post['kuantitas'];
        if(isset($post['status_pemesanan'])) $pemesanan->status_pemesanan = $post['status_pemesanan'];
        $pemesanan->save();

        $response->withHeader('Content-type', 'application/json');
        $response->write(json_encode([
            'status' => 'success'
        ]));
        return $response;
    }

    //Hapus pemesanan
    public function delete($id){
        $pemesanan = Pemesanan::where([
                ['id_transaksi', '=', $id]
            ])->delete();
        // if($pemesanan){
        //     $pemesanan->delete();
        // }
    }
    //Ubah Status pemesanan
    public function ubah_status($id_transaksi,$id_jasa,$status_pemesanan){
        $pemesanan = Pemesanan::where([
                ['id_transaksi', '=', $id_transaksi],
                ['id_jasa', '=', $id_jasa]
            ])->update([
                'status_pemesanan' => $status_pemesanan
                ]);

        // if($pemesanan){
        //     $pemesanan->status_pemesanan=$status_pemesanan;
        //     $pemesanan->update();
        // }
    }
}