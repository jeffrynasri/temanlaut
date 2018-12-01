<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Schema {

    public static function createTables()
    {
        self::createPaketTable();
        self::createPelangganTable();
        self::createJasaTable();
        self::createTransaksiTable();

        //self::createKeyTable();
        //self::createLogTable();
    }

    final protected static function createPaketTable()
    {
        if(!Capsule::schema()->hasTable('paket'))
        {
            Capsule::schema()->create('paket', function($table)
            {
                $table->increments('id');
                $table->integer('id_jasa');
                $table->string('nama');
                $table->string('deskripsi');
                $table->integer('harga');
            });
        }
    }

    final protected static function createTransaksiTable()
    {
        if(!Capsule::schema()->hasTable('transaksi'))
        {
            Capsule::schema()->create('transaksi', function($table)
            {
                $table->increments('id');
                $table->integer('id_pelanggan');
                $table->integer('id_paket');
                $table->integer('jumlah');
                $table->integer('total_harga');
                $table->timestamps;
            });
        }
    }

    final protected static function createJasaTable()
    {
        if(!Capsule::schema()->hasTable('jasa'))
        {
            Capsule::schema()->create('jasa', function($table)
            {
                $table->increments('id');
                $table->integer('id_pelanggan');
                $table->string('nama');
                $table->string('alamat');
                $table->integer('no_telepon');
            });
        }
    }
    final protected static function createPelangganTable()
    {
        if(!Capsule::schema()->hasTable('pelanggan'))
        {
            Capsule::schema()->create('pelanggan', function($table)
            {
                $table->increments('id');
                $table->string('nama');
                $table->string('alamat');
                $table->integer('no_telepon');
            });
        }
    }
}