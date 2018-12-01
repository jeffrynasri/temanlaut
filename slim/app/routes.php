<?php
// Routes

$app->get('/', App\Action\HomeAction::class)
    ->setName('homepage');
// 1. Pengguna
//     . register 
//     . login 
//     . kelola akun(update)
//     . kelolatoko
//         . lihat
//         . tambah
//         . hapus
//         . update
//         .
//     . kelolajasa
//     . membeli :
//         . masukkan ke keranjang
//         . beli

$app->group('', function(){
    //Route Table Toko
    $this->group('/dermaga', function(){
        $this->get('[/]', 'App\Controller\DermagaController:getall');
        $this->get('/{id}', 'App\Controller\DermagaController:get');
        $this->post('/', 'App\Controller\DermagaController:create');
        $this->put('/', 'App\Controller\DermagaController:update');
        $this->delete('/{id}', 'App\Controller\DermagaController:delete');
    });
    /* 	
 	//Route Table Pengguna
    $this->post('/register', 'App\Controller\PenggunaController:create');
    $this->post('/login', 'App\Controller\PenggunaController:login');    
    $this->group('/pengguna', function(){
        $this->get('[/]', 'App\Controller\PenggunaController:getall');
        $this->get('/{id}', 'App\Controller\PenggunaController:get');
        //$this->get('/{id}/pemesanan[/{status_pemesanan}]', 'App\Controller\PenggunaController:pesanan');
        //Proses search dilakukan pada semua kolom, BUKAN hanya 1 kolom tertentu (Tidak termasuk kolom primary key)
        $this->get('/search/{term}', 'App\Controller\PenggunaController:search');
        $this->put('/', 'App\Controller\PenggunaController:update');
        $this->delete('/{id}', 'App\Controller\PenggunaController:delete');
    });


    //Route Table Toko
    $this->group('/toko', function(){
        //Untuk Route /toko filter bisa dilakukan dengan menyertakan param id_kategori dan id_kecamatan
        //Untuk Route /toko sort bisa dilakukan dengan menyertakan param sort dg value = harga_asc / harga_dsc / rating_asc / rating_dsc
        $this->post('/gambarrr', 'App\Controller\TokoController:gambar_testing');
        $this->get('[/]', 'App\Controller\TokoController:getall');
        $this->get('/{id}', 'App\Controller\TokoController:get');
        $this->get('/id_pengguna/{id}', 'App\Controller\TokoController:get_byidpengguna');
        $this->get('/{id}/pemesanan[/{status_pemesanan}]', 'App\Controller\TokoController:pesanan');
        //Proses search dilakukan pada semua kolom, BUKAN hanya 1 kolom tertentu (Tidak termasuk kolom primary key)
        $this->get('/search/{term}', 'App\Controller\TokoController:search');
        $this->post('/', 'App\Controller\TokoController:create');
        $this->put('/', 'App\Controller\TokoController:update');
        $this->delete('/{id}', 'App\Controller\TokoController:delete');
    });
    //Route Jasa
 	$this->group('/jasa', function(){
        $this->get('[/]', 'App\Controller\JasaController:getall');
        $this->get('/{id}', 'App\Controller\JasaController:get');
        $this->get('/id_toko/{id}', 'App\Controller\JasaController:get_byidtoko');
        //Proses search dilakukan pada semua kolom, BUKAN hanya 1 kolom tertentu (Tidak termasuk kolom primary key)
        $this->get('/search/{term}', 'App\Controller\JasaController:search');
        $this->post('/', 'App\Controller\JasaController:create');
        $this->put('/', 'App\Controller\JasaController:update');
        $this->delete('/{id}', 'App\Controller\JasaController:delete');
    });
    //Route Kategori
    $this->group('/kategori', function(){
        $this->get('[/]', 'App\Controller\KategoriController:getall');
        $this->get('/{id}', 'App\Controller\KategoriController:get');
        $this->post('/', 'App\Controller\KategoriController:create');
        $this->put('/', 'App\Controller\KategoriController:update');
        $this->delete('/{id}', 'App\Controller\KategoriController:delete');
    });
    //Route Kecamatan
    $this->group('/kecamatan', function(){
        $this->get('[/]', 'App\Controller\KecamatanController:getall');
        $this->get('/id_kabupaten/{id}', 'App\Controller\KecamatanController:get_byidkabupaten');
        $this->get('/{id}', 'App\Controller\KecamatanController:get');
        $this->post('/', 'App\Controller\KecamatanController:create');
        $this->put('/', 'App\Controller\KecamatanController:update');
        $this->delete('/{id}', 'App\Controller\KecamatanController:delete');
    });
    //Route Kabupaten
    $this->group('/kabupaten', function(){
        $this->get('[/]', 'App\Controller\KabupatenController:getall');
        $this->get('/id_provinsi/{id}', 'App\Controller\KabupatenController:get_byidprovinsi');
        $this->get('/{id}', 'App\Controller\KabupatenController:get');
        $this->post('/', 'App\Controller\KabupatenController:create');
        $this->put('/', 'App\Controller\KabupatenController:update');
        $this->delete('/{id}', 'App\Controller\KabupatenController:delete');
    });
    //Route Provinsi
    $this->group('/provinsi', function(){
        $this->get('[/]', 'App\Controller\ProvinsiController:getall');
        $this->get('/{id}', 'App\Controller\ProvinsiController:get');
        $this->post('/', 'App\Controller\ProvinsiController:create');
        $this->put('/', 'App\Controller\ProvinsiController:update');
        $this->delete('/{id}', 'App\Controller\ProvinsiController:delete');
    });
    //Route Transaksi
    $this->post('/membeli', 'App\Controller\TransaksiController:create');
    $this->group('/transaksi', function(){
        $this->get('[/]', 'App\Controller\TransaksiController:getall');
        $this->get('/{id}', 'App\Controller\TransaksiController:get');
        $this->get('/id_pengguna/{id}', 'App\Controller\TransaksiController:get_byidpengguna');
        $this->delete('/{id}', 'App\Controller\TransaksiController:delete');
        $this->post('/disetujui', 'App\Controller\TransaksiController:disetujui');
        $this->post('/ditolak', 'App\Controller\TransaksiController:ditolak');
        // $this->post('/sukses', 'App\Controller\TransaksiController:sukses');
        //Proses search dilakukan pada semua kolom, BUKAN hanya 1 kolom tertentu(Tidak termasuk kolom primary key)
        // $this->get('/search/{term}', 'App\Controller\TransaksiController:search');
        // $this->post('/', 'App\Controller\TransaksiController:create');
        // $this->put('/', 'App\Controller\TransaksiController:update');
        
 
    });
    */
});

// $app->get('/table', function($req, $res){
//     \App\Schema::createTables();
//     $res->write('All required table created');
//     return $res;
// });


