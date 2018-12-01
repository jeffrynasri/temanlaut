#[Dokumentasi Jasaku API](#jasaku-api)

##
Catatan :

	Home Directory Api :

	`jasaq.esy.es/public/`
	
##

- [Register](#register)
- [Login](#login)
- [Membeli](#membeli)
- [Pengguna](#pengguna)
	- Get Semua Data
	- Get 1 Data
	- Ubah Data
	- Hapus Data
- [Toko](#toko)
	- Get Semua Data(Sisipkan id_kategori / id_kecamtan untuk lakukan filter Atau sisipkan metode sort untuk lakukan sorting)
	- Get 1 Data
	- Get 1 Data dg id pengguna
	- Get Pesanan Masuk
	- Buat Data
	- Ubah Data
	- Hapus Data
- [Jasa](#jasa)
	- Get Semua Data
	- Get 1 Data
	- Get 1 Data dg id toko
	- Buat Data
	- Ubah Data
	- Hapus Data
- [Transaksi](#transaksi)
	- Get Semua Data
	- Get 1 Data
	- Get 1 Data dg id pengguna
	- Hapus Data
	- Disetujui
	- Ditolak
- [Kategori](#kategori)
	- Get Semua Data
	- Get 1 Data
	- Buat Data
	- Ubah Data
	- Hapus Data
- [Kecamatan](#kecamatan)
	- Get Semua Data
	- Get 1 Data
	- Get 1 Data dg id kabupaten
	- Buat Data
	- Ubah Data
	- Hapus Data
- [Kabupaten](#kabupaten)
	- Get Semua Data
	- Get 1 Data
	- Get 1 Data dg id provinsi
	- Buat Data
	- Ubah Data
	- Hapus Data
- [Provinsi](#provinsi)
	- Get Semua Data
	- Get 1 Data
	- Buat Data
	- Ubah Data
	- Hapus Data
	
## Jasaku API

### Register
Untuk melakukan pendaftaran bagi pengguna baru.

+ Menggunakan metode HTTP`POST`.

##### URL
+ [jasaq.esy.es/public/register](). Tanpa Parameter.

##### Parameters

	*Tanpa Parameter*

##### Post Request Data
+ `nama` **(wajib)**. 
+ `alamat` **(wajib)**.
+ `jenisKelamin` **(wajib)**.
+ `kontak` **(wajib)**. 
+ `username` **(wajib)**.
+ `password` **(wajib)**.
##### Contoh Respon Sukses
```json
{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
```

+ Status Code `200`.
##### Contoh Respon Gagal (1)
Username telah digunakan

```json
{
  "status": "Gagal",
  "message": "Username sudah digunakan"
}
```

+ Status Code `400`.
##### Contoh Respon Gagal (2)
Error Sql, sbg contoh pengguna tdk menyertakan variabel username dan pasword

```json
{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'username' cannot be null (SQL: insert into `pengguna` (`id`, `nama`, `alamat`, `jenisKelamin`, `kontak`, `username`, `password`) values (5, Adik, Jl Dr Wahidin SH, P, 031567892, , ))"
}
```

+ Status Code `500`.

### Login
Untuk melakukan aktivitas sign in bagi pengguna yang sudah terdaftar

+ Menggunakan metode HTTP`POST`.

##### URL
+ [jasaq.esy.es/public/login](). Tanpa Parameter.

##### Parameters

*Tanpa Parameter*

##### Post Request Data
+ `username` **(wajib)**.
+ `password` **(wajib)**.
##### Contoh Respon Sukses
```json
[
  {
    "id": 1,
    "nama": "Amin",
    "alamat": "Jl Pahlawan Rt 2 No 1",
    "jenisKelamin": "L",
    "kontak": "08133546789",
    "username": "admin",
    "password": "admin"
  }
]
```

+ Status Code `200`.
##### Contoh Respon Gagal (1)
Username telah digunakan

```json
{
  "status": "Gagal",
  "message": "Login Gagal"
}
```

+ Status Code `400`.
##### Contoh Respon Gagal (2)
Error Sql

```json
{
  "status": "Gagal",
  "message": "Login Gagal",
  "dev_message": "blablablablabl"
}
```

+ Status Code `500`.
+ 
### Membeli
Untuk melakukan Pembelian.

+ Menggunakan metode HTTP `POST`.

##### URL
+ [jasaq.esy.es/public/membeli](). Tanpa Parameter

##### Parameters

*Tidak ada Parameter*

##### Post Reuqst Data

```json
{
  "id_pengguna": $id,
  "paket":[
    {
        "kuantitas": $kuantitas,
        "id_jasa": $id_jasa
    },


    .
    .
    .......
    .......
    .......
    .
    .


    {
        "kuantitas": $kuantitas,
        "id_jasa": $id_jasa
    }
  ]
}
```
- Ket = `paket` sejumlah barang yang akan dipesan pengguna
- Dalam header sertakan `Content-Type` dengan isian `application/json`
##### Contoh Respon Sukses
```json
{
  "status": "Sukses",
  "message": "Pembelian Berhasil"
}
```
+ Request : [jasaq.esy.es/public/membeli](). Dengan data:

```json
{
  "id_pengguna": 1,
  "paket":[
    {
        "kuantitas": 8,
        "id_jasa": 1
    },
    {
        "kuantitas": 2,
        "id_jasa": 3
    }
  ]
}
```
+ Status Code `200`.
##### Contoh Respon Gagal 
Error Sql

```json
{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "blablabla"
}
```

+ Status Code `500`.
### Pengguna
Semua operasi dengan tabel pengguna

- Get Semua Data
	
	Request semua data yang ada di tabel pelanggan.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/pengguna](). Tanpa Parameter.
	- Parameter
	
		*Tidak ada Parameter*

	- Contoh Respon Sukses
		- ```json[
  {
    "id": 1,
    "nama": "Amin",
    "alamat": "Jl Pahlawan Rt 2 No 1",
    "jenisKelamin": "L",
    "kontak": "08133546789",
    "username": "admin",
    "password": "admin"
  },
  {
    "id": 2,
    "nama": "Sueb",
    "alamat": "Jl Keputih 3 no 21",
    "jenisKelamin": "P",
    "kontak": "3987089",
    "username": "admin2",
    "password": "admin2"
  },
  {
    "id": 3,
    "nama": "Adik",
    "alamat": "Jl Dr Wahidin SH",
    "jenisKelamin": "P",
    "kontak": "031567892",
    "username": "admin3",
    "password": "admin"
  }]
		```

		- Status Code `200`.
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Login Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data pelanggan dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/pengguna/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 1,
  "nama": "Amin",
  "alamat": "Jl Pahlawan Rt 2 No 1",
  "jenisKelamin": "L",
  "kontak": "08133546789",
  "username": "admin",
  "password": "admin"
}
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Pengguna Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Login Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Ubah Data

	Merubah data pelanggan dengan id tertentu.Menggunakan metode HTTP `PUT`. Pada hedaer sertakan 'Content-Type' dengan nilai 'application/x-www-form-urlencoded`

	- URL
		- [jasaq.esy.es/public/pengguna/](). Tanpa Parameter.

	- Parameter(x-www-form-urlencoded)
	
		*Tidak ada Parameter*
		
	- Put Request Data

		+ `id` **(wajib)**.
		+ `nama` *optional*. 
		+ `alamat` *optional*.
		+ `jenisKelamin` *optional*.
		+ `kontak` *optional*. 
		+ `username` *optional*.
		+ `password` *optional*.
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/pengguna/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Pengguna Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/pengguna/]() Dengan argumen id dan nama
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Login Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data pelanggan dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/pengguna/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/pengguna/4](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Pengguna Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/pengguna/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Login Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

### Toko
Semua operasi dengan tabel toko

- Get Semua Data
	
	Request semua data yang ada di tabel toko.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/toko/](). Tanpa Parameter.
	
		- [jasaq.esy.es/public/toko/?id_kategori={id_kategori}&id_kecamatan={id_kecamatan}&sort={sort}](). Dengan Parameter.
	- Parameter
	
		- `{id_kategori}` *(optional)* bernilai angka
		- `{id_kecamatan}`*(optional)* bernilai angka
		- `{sort}`*(optional)* bernilai :
			- harga_asc (untuk sorting ascending berdasarkan harga)
			- harga_dsc (untuk sorting descending berdasarkan harga)
			- rating_asc (untuk sorting ascending berdasarkan rating)
			- rating_dsc (untuk sorting ascending berdasarkan harga)
			
	- Contoh Respon Sukses(1)
		- ```json
		[
  {
    "id": 1,
    "nama": "Bengkel",
    "alamat": "Jl Keputih No 2 , Surabaya",
    "kontak": "0897865789",
    "deskripsi": "Menerima Spededa 4 tak dan matik",
    "jamOperasional": "8.00-16.00",
    "rating": 3,
    "id_pengguna": 2,
    "id_kategori": 6,
    "id_kecamatan": 16,
    "harga_terendah": 35000
  },
  {
    "id": 2,
    "nama": "Laundry",
    "alamat": "Jl Mulyorejo No 1, Surabaya",
    "kontak": "3987654",
    "deskripsi": "Menerima Segala macam cucian",
    "jamOperasional": "07.00-15.00",
    "rating": 3.5,
    "id_pengguna": 1,
    "id_kategori": 1,
    "id_kecamatan": 20,
    "harga_terendah": 10000
  },
  {
    "id": 3,
    "nama": "jahitin23",
    "alamat": "Jl Gebang timur no 27, Surabaya",
    "kontak": "089980789567",
    "deskripsi": "Menerima permak jeans, jahit seragam, memperbaiki tas,dll",
    "jamOperasional": "07.00-17.00",
    "rating": 4,
    "id_pengguna": 2,
    "id_kategori": 5,
    "id_kecamatan": 16,
    "harga_terendah": 5000
  }
]
		```
		
		- Request = [jasaq.esy.es/public/toko/]()
		- Status Code `200`.
- Contoh Respon Sukses(2)
		- ```json
		[
  {
    "id": 3,
    "nama": "jahitin23",
    "alamat": "Jl Gebang timur no 27, Surabaya",
    "kontak": "089980789567",
    "deskripsi": "Menerima permak jeans, jahit seragam, memperbaiki tas,dll",
    "jamOperasional": "07.00-17.00",
    "rating": 4,
    "id_pengguna": 2,
    "id_kategori": 5,
    "id_kecamatan": 16,
    "harga_terendah": 5000
  },
  {
    "id": 1,
    "nama": "Bengkel",
    "alamat": "Jl Keputih No 2 , Surabaya",
    "kontak": "0897865789",
    "deskripsi": "Menerima Spededa 4 tak dan matik",
    "jamOperasional": "8.00-16.00",
    "rating": 3,
    "id_pengguna": 2,
    "id_kategori": 6,
    "id_kecamatan": 16,
    "harga_terendah": 35000
  }
]
		```
		
		- Request = [jasaq.esy.es/public/toko/?id_kategori=&id_kecamatan=16&sort=harga_asc]()
		- Status Code `200`.
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data toko dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/toko/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 2,
  "nama": "Laundry",
  "alamat": "Jl Mulyorejo No 1, Surabaya",
  "kontak": "3987654",
  "deskripsi": "Menerima Segala macam cucian",
  "jamOperasional": "07.00-15.00",
  "rating": 3.5,
  "id_pengguna": 1,
  "id_kategori": 1,
  "id_kecamatan": 20,
  "harga_terendah": 10000
}
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Toko Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get Pesanan Masuk


	Request data pesanan masuk pada toko yg dimaksud.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/toko/{id}/pemesanan](). Tanpa Parameter.
			- `{id}` berupa angka
		- [jasaq.esy.es/public/pengguna/{id}/pesanan/{status_pemesanan}](). Tanpa Parameter.
			- `{id}` berupa angka
			- `{status pemesanan}` berupa angka dimana
				- Menunggu Persetujuan penjual
				- Diterima Penjual
				- Ditolak penjual
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- Request : [jasaq.esy.es/public/toko/2/pemesanan]()
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		
		- Request : [jasaq.esy.es/public/toko/225/pemesanan]()
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Toko Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get By Id Pengguna


	Request data toko dengan menyertakan ```id_pengguna``` pada argumen request.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/toko/id_pengguna/{id_pengguna}](). Tanpa Parameter.
			- `{id_pengguna}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		[
  {
    "id": 1,
    "nama": "Bengkel",
    "alamat": "Jl Keputih No 2 , Surabaya",
    "kontak": "0897865789",
    "deskripsi": "Menerima Spededa 4 tak dan matik",
    "jamOperasional": "8.00-16.00",
    "rating": 3,
    "id_pengguna": 2,
    "id_kategori": 6,
    "id_kecamatan": 16
  },
  {
    "id": 3,
    "nama": "jahitin23",
    "alamat": "Jl Gebang timur no 27, Surabaya",
    "kontak": "089980789567",
    "deskripsi": "Menerima permak jeans, jahit seragam, memperbaiki tas,dll",
    "jamOperasional": "07.00-17.00",
    "rating": 4,
    "id_pengguna": 2,
    "id_kategori": 5,
    "id_kecamatan": 16
  }
]
		```
		- Request : [jasaq.esy.es/public/toko/id_pengguna/2]()
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id_pengguna}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Toko Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/toko/id_pengguna/234]()
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Toko Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Buat Data

	Mendaftarkan toko pada database tertentu.Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/toko/](). Tanpa Parameter.

	- Parameter
	
		*Tidak ada parameter*
	- Post Request Data

		+ `nama` **(wajib)**.
		+ `alamat` **(wajib)**. 
		+ `kontak` **(wajib)**.
		+ `deskripsi` **(wajib)**.
		+ `jamOperasional` **(wajib)**.
		+ `id_pengguna` **(wajib)**.
		+ `id_kategori` **(wajib)**. 
		+ `id_kecamatan` **(wajib)**.
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/toko/](). 
		- Status Code `200`.
	
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'nama' cannot be null (SQL: insert into `toko` (`id`, `nama`, `alamat`, `kontak`, `deskripsi`, `jamOperasional`, `rating`, `id_pengguna`, `id_kategori`, `id_kecamatan`) values (5, , Jl Gebang timur no 27, Surabaya, 089980789567, Menerima permak jeans, jahit seragam, memperbaiki tas,dll, 07.00-17.00, 0, 2, 6, 16))"
}
		```
		- Status Code `500`.
- Ubah Data

	Merubah data toko dengan id tertentu.Menggunakan metode HTTP `PUT`.Pada hedaer sertakan 'Content-Type' dengan nilai 'application/x-www-form-urlencoded'

	- URL
		- [jasaq.esy.es/public/toko/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Put Request Data(x-www-form-urlencoded)

		+ `id` **(wajib)**.
		+ `nama`  *optional*.
		+ `alamat`  *optional*. 
		+ `kontak`  *optional*.
		+ `deskripsi`  *optional*.
		+ `jamOperasional`  *optional*.
		+ `id_pengguna`  *optional*.
		+ `id_kategori`  *optional*. 
		+ `id_kecamatan`  *optional*.
		+ `rating`  *optional*.
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/toko/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Toko Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/toko/]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Update Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data toko dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/toko/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/toko/3](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Toko Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/pengguna/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

### Jasa
Semua operasi dengan tabel jasa

- Get Semua Data
	
	Request semua data yang ada di tabel jasa.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/jasa/](). Tanpa Parameter.
	
	- Parameter
	
		*Tanpa Parameter*.
			
	- Contoh Respon Sukses(1)
		- ```json
		[
  {
    "id": 1,
    "nama": "Cuci Kering",
    "harga": 20000,
    "id_toko": 2
  },
  {
    "id": 2,
    "nama": "Cuci Basah",
    "harga": 10000,
    "id_toko": 2
  },
  {
    "id": 3,
    "nama": "Ganti Oli",
    "harga": 35000,
    "id_toko": 1
  },
  {
    "id": 4,
    "nama": "Permak Jeans",
    "harga": 5000,
    "id_toko": 3
  }
]
		```
		
		- Request = [jasaq.esy.es/public/jasa/]()
		- Status Code `200`.

	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data jasa dengan id tertentu. Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/jasa/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 2,
  "nama": "Cuci Basah",
  "harga": 10000,
  "id_toko": 2
}
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Jasa Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get By Id Toko


	Request data jasa dengan menyertakan `id_toko` pada argumen request. Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/jasa/id_toko/{id_toko}](). Tanpa Parameter.
			- `{id_toko}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		[
  {
    "id": 1,
    "nama": "Cuci Kering",
    "harga": 20000,
    "id_toko": 2
  },
  {
    "id": 2,
    "nama": "Cuci Basah",
    "harga": 10000,
    "id_toko": 2
  }
]
		```
		- Request : [jasaq.esy.es/public/toko/id_toko/2]()
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id_toko}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Jasa Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/jasa/id_toko/234]()
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Jasa Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Buat Data

	Mendaftarkan jasa pada database . Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/jasa/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Post Request Data

		+ `id_toko` **(wajib)**.
		+ `nama` **(wajib)**. 
		+ `harga` **(wajib)**.
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/jasa/](). 
		- Status Code `200`.
	
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'id_toko' cannot be null (SQL: insert into `jasa` (`id`, `id_toko`, `nama`, `harga`) values (6, , dsfsdfsdf, 324324))"
}
		```
		- Status Code `500`.
- Ubah Data

	Merubah data jasa dengan id tertentu.Menggunakan metode HTTP `PUT`.
	Pada hedaer sertakan 'Content-Type` dengan nilai 'application/x-www-form-urlencoded'

	- URL
		- [jasaq.esy.es/public/jasa/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Put Request Data(x-www-url-encoded)

		+ `id` **(wajib)**.
		+ `id_toko` **(optional)**.
		+ `nama` **(optional)**. 
		+ `harga` **(optional)**.
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/jasa/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Jasa Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/toko/]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Update Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data jasa dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/jasa/{id}](). Tidak ada Parameter.
			- ```{id}``` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/jasa/3](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Jasa Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/jasa/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

### Transaksi

Semua operasi dengan tabel transaki dan pemesanan

- Get Semua Data
	
	Request semua data yang ada di tabel transaksi dan pemesanan.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/transaksi/](). Tanpa Parameter.
	
	- Parameter
	
		*Tanpa Parameter*.
			
	- Contoh Respon Sukses(1)
		- ```json
		[
  {
    "id": 1,
    "id_pengguna": 2,
    "total": 45000,
    "updated_at": {
      "date": "2017-04-22 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-04-22 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 1,
        "total": 10000,
        "id_jasa": 2,
        "id_transaksi": 1,
        "status_pemesanan": 1
      },
      {
        "kuantitas": 1,
        "total": 25000,
        "id_jasa": 3,
        "id_transaksi": 1,
        "status_pemesanan": 1
      }
    ]
  },
  {
    "id": 2,
    "id_pengguna": 1,
    "total": 200000,
    "updated_at": {
      "date": "2017-04-24 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-04-24 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 3,
        "total": 20000,
        "id_jasa": 1,
        "id_transaksi": 2,
        "status_pemesanan": 1
      }
    ]
  },
  {
    "id": 3,
    "id_pengguna": 1,
    "total": 110000,
    "updated_at": {
      "date": "2017-04-25 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-04-25 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 2,
        "total": 20000,
        "id_jasa": 1,
        "id_transaksi": 3,
        "status_pemesanan": 1
      },
      {
        "kuantitas": 2,
        "total": 35000,
        "id_jasa": 3,
        "id_transaksi": 3,
        "status_pemesanan": 1
      }
    ]
  },
  {
    "id": 4,
    "id_pengguna": 1,
    "total": 230000,
    "updated_at": {
      "date": "2017-05-01 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-05-01 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 8,
        "total": 20000,
        "id_jasa": 1,
        "id_transaksi": 4,
        "status_pemesanan": 1
      },
      {
        "kuantitas": 2,
        "total": 35000,
        "id_jasa": 3,
        "id_transaksi": 4,
        "status_pemesanan": 1
      }
    ]
  }
]
		```
		
		- Request = [jasaq.esy.es/public/jasa/]()
		- Status Code `200`.

	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Transaksi Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data transaksi dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/transaksi/{id}](). Tanpa Parameter.
			- ```{id}``` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		[
  {
    "id": 1,
    "id_pengguna": 2,
    "total": 45000,
    "updated_at": {
      "date": "2017-04-22 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-04-22 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 1,
        "total": 10000,
        "id_jasa": 2,
        "id_transaksi": 1,
        "status_pemesanan": 1
      },
      {
        "kuantitas": 1,
        "total": 25000,
        "id_jasa": 3,
        "id_transaksi": 1,
        "status_pemesanan": 1
      }
    ]
  }
]
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Transaksi Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Transaksi Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get By Id Pengguna


	Request data Transaksi dengan menyertakan `id_pengguna` pada argumen request.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/transaksi/id_pengguna/{id_toko}](). Tanpa Parameter.
			- `{id_toko}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		[
  {
    "id": 2,
    "id_pengguna": 1,
    "total": 200000,
    "updated_at": {
      "date": "2017-04-24 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-04-24 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 3,
        "total": 20000,
        "id_jasa": 1,
        "id_transaksi": 2,
        "status_pemesanan": 1
      }
    ]
  },
  {
    "id": 3,
    "id_pengguna": 1,
    "total": 110000,
    "updated_at": {
      "date": "2017-04-25 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-04-25 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 2,
        "total": 20000,
        "id_jasa": 1,
        "id_transaksi": 3,
        "status_pemesanan": 1
      },
      {
        "kuantitas": 2,
        "total": 35000,
        "id_jasa": 3,
        "id_transaksi": 3,
        "status_pemesanan": 1
      }
    ]
  },
  {
    "id": 4,
    "id_pengguna": 1,
    "total": 230000,
    "updated_at": {
      "date": "2017-05-01 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "created_at": {
      "date": "2017-05-01 00:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe/Berlin"
    },
    "pemesanan": [
      {
        "kuantitas": 8,
        "total": 20000,
        "id_jasa": 1,
        "id_transaksi": 4,
        "status_pemesanan": 1
      },
      {
        "kuantitas": 2,
        "total": 35000,
        "id_jasa": 3,
        "id_transaksi": 4,
        "status_pemesanan": 1
      }
    ]
  }
]
		```
		- Request : [jasaq.esy.es/public/transaksi/id_pengguna/1]()
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id_pengguna}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Transaksi Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/id_pengguna/234]()
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Transaksi Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Hapus Data

	Menghapus data transaksi dengan id tertentu beserta pemesanannya.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/transaksi/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/4](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Transaksi Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Menolak Status Pemesanan

	Mengubah status pemesanan menjadi `ditolak` dengan menyertakan id transaksi.Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/transaksi/ditolak](). Tidak ada Parameter.

	- Parameter

		*Tidak ada Parameter*
	- POST Request Data
		- `{id}` berupa angka. id transaksi
		- `{id_jasa}` berupa angka. Id jasa yang ditolak
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Ubah data pemesanan berhasil"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/ditolak](). Dengan id 2 dan id_jasa 1 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Transaksi Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/ditolak]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Ubah data pemesanan gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Menyetujui status pemesanan

	Mengubah status pemesanan menjadi `disetujui` dengan menyertakan id transaksi.Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/transaksi/disetujui](). Tidak ada Parameter.

	- Parameter

		*Tidak ada Parameter*
	- POST Request Data
		- `{id}` berupa angka. id transaksi
		- `{id_jasa}` berupa angka. Id jasa yang ditolak
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Ubah data pemesanan berhasil"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/disetujui](). Dengan id 2 dan id_jasa 1 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Transaksi Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/transaksi/disetujui]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Ubah data pemesanan gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.


### Kategori

Semua operasi dengan tabel kategori

- Get Semua Data
	
	Request semua data yang ada di tabel kategori.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kategori/](). Tanpa Parameter.
	
	- Parameter
	
		*Tanpa Parameter*.
			
	- Contoh Respon Sukses(1)
		- ```json
	[
  {
    "id": 1,
    "nama": "Laundry"
  },
  {
    "id": 2,
    "nama": "Makanan Ringan"
  },
  {
    "id": 3,
    "nama": "Makanan Berat"
  },
  {
    "id": 4,
    "nama": "Minuman"
  },
  {
    "id": 5,
    "nama": "Fashion"
  },
  {
    "id": 6,
    "nama": "Otomotif"
  }
]
		```
		
		- Request = [jasaq.esy.es/public/kategori/]()
		- Status Code `200`.

	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data kategori dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kategori/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 3,
  "nama": "Makanan Berat"
}
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kategori Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Buat Data

	Mendaftarkan kategori pada database .Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/kategori/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Post Request Data

		+ `nama` **(wajib)**. 
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kategori/](). 
		- Status Code `200`.
	
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "blablablab"
}
		```
		- Status Code `500`.
- Ubah Data

	Merubah data kategori dengan id tertentu.Menggunakan metode HTTP `PUT`.
	Pada hedaer sertakan 'Content-Type` dengan nilai 'application/x-www-form-urlencoded'

	- URL
		- [jasaq.esy.es/public/kategori/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Put Request Data(x-www-url-encoded)

		+ `id` **(wajib)**.
		+ `nama` **(optional)**. 
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kategori/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kategori Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kategori/]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Update Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data kategori dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/kategori/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kategori/7](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kategori Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kategori/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.


### Kecamatan

Semua operasi dengan tabel kecamatan 

- Get Semua Data
	
	Request semua data yang ada di tabel kecamatan .Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kecamatan/](). Tanpa Parameter.
	
	- Parameter
	
		*Tanpa Parameter*.
			
	- Contoh Respon Sukses(1)
		- ```json
	[
  {
    "id": 1,
    "nama": "GENTENG",
    "id_kabupaten": 1
  },
  {
    "id": 2,
    "nama": "BUBUTAN",
    "id_kabupaten": 1
  },
  {
    "id": 3,
    "nama": "TEGALSARI",
    "id_kabupaten": 1
  },
  {
    "id": 4,
    "nama": "SIMOKERTO",
    "id_kabupaten": 1
  },
  {
    "id": 5,
    "nama": "TAMBAKSARI",
    "id_kabupaten": 1
  },
  {
    "id": 6,
    "nama": "GUBENG",
    "id_kabupaten": 1
  },
  {
    "id": 7,
    "nama": "KREMBANGAN",
    "id_kabupaten": 1
  },
  {
    "id": 8,
    "nama": "SEMAMPIR",
    "id_kabupaten": 1
  },
  {
    "id": 9,
    "nama": "PABEAN CANTIAN",
    "id_kabupaten": 1
  },
  {
    "id": 10,
    "nama": "WONOKROMO",
    "id_kabupaten": 1
  },
  {
    "id": 11,
    "nama": "SAWAHAN",
    "id_kabupaten": 1
  },
  {
    "id": 12,
    "nama": "TANDES",
    "id_kabupaten": 1
  },
  {
    "id": 13,
    "nama": "KARANG PILANG",
    "id_kabupaten": 1
  },
  {
    "id": 14,
    "nama": "WONOCOLO",
    "id_kabupaten": 1
  },
  {
    "id": 15,
    "nama": "RUNGKUT",
    "id_kabupaten": 1
  },
  {
    "id": 16,
    "nama": "SUKOLILO",
    "id_kabupaten": 1
  },
  {
    "id": 17,
    "nama": "KENJERAN",
    "id_kabupaten": 1
  },
  {
    "id": 18,
    "nama": "BENOWO",
    "id_kabupaten": 1
  },
  {
    "id": 19,
    "nama": "LAKARSANTRI",
    "id_kabupaten": 1
  },
  {
    "id": 20,
    "nama": "MULYOREJO",
    "id_kabupaten": 1
  },
  {
    "id": 21,
    "nama": "TENGGILIS MEJOYO",
    "id_kabupaten": 1
  },
  {
    "id": 22,
    "nama": "GUNUNG ANYAR",
    "id_kabupaten": 1
  },
  {
    "id": 23,
    "nama": "JAMBANGAN",
    "id_kabupaten": 1
  },
  {
    "id": 24,
    "nama": "GAYUNGAN",
    "id_kabupaten": 1
  },
  {
    "id": 25,
    "nama": "WIYUNG",
    "id_kabupaten": 1
  },
  {
    "id": 26,
    "nama": "DUKUH PAKIS",
    "id_kabupaten": 1
  },
  {
    "id": 27,
    "nama": "ASEMROWO",
    "id_kabupaten": 1
  },
  {
    "id": 28,
    "nama": "SUKO MANUNGGAL",
    "id_kabupaten": 1
  },
  {
    "id": 29,
    "nama": "BULAK",
    "id_kabupaten": 1
  },
  {
    "id": 30,
    "nama": "PAKAL",
    "id_kabupaten": 1
  },
  {
    "id": 31,
    "nama": "SAMBIKEREP",
    "id_kabupaten": 1
  },
  {
    "id": 32,
    "nama": "Balongpanggang",
    "id_kabupaten": 2
  },
  {
    "id": 33,
    "nama": "Benjeng",
    "id_kabupaten": 2
  },
  {
    "id": 34,
    "nama": "Bungah",
    "id_kabupaten": 2
  },
  {
    "id": 35,
    "nama": "Cerme",
    "id_kabupaten": 2
  },
  {
    "id": 36,
    "nama": "Driyorejo",
    "id_kabupaten": 2
  },
  {
    "id": 37,
    "nama": "Duduk Sampeyan",
    "id_kabupaten": 2
  },
  {
    "id": 38,
    "nama": "Dukun ",
    "id_kabupaten": 2
  },
  {
    "id": 39,
    "nama": "Gresik ",
    "id_kabupaten": 2
  },
  {
    "id": 40,
    "nama": "Kebomas ",
    "id_kabupaten": 2
  },
  {
    "id": 41,
    "nama": "Kedamean ",
    "id_kabupaten": 2
  },
  {
    "id": 42,
    "nama": "Manyar ",
    "id_kabupaten": 2
  },
  {
    "id": 43,
    "nama": "Menganti",
    "id_kabupaten": 2
  },
  {
    "id": 44,
    "nama": " Panceng ",
    "id_kabupaten": 2
  },
  {
    "id": 45,
    "nama": "Sangkapura ",
    "id_kabupaten": 2
  },
  {
    "id": 46,
    "nama": "Sidayu ",
    "id_kabupaten": 2
  },
  {
    "id": 47,
    "nama": "Tambak ",
    "id_kabupaten": 2
  },
  {
    "id": 48,
    "nama": "Ujung Pangkah ",
    "id_kabupaten": 2
  },
  {
    "id": 49,
    "nama": "Wringinanom",
    "id_kabupaten": 2
  }
]
		```
		
		- Request = [jasaq.esy.es/public/kecamatan/]()
		- Status Code `200`.

	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data kecamatan dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kecamatan/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 4,
  "nama": "SIMOKERTO",
  "id_kabupaten": 1
}
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kecamatan Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get By Id Kabupaten


	Request data kecamatan dengan menyertakan `id_kabupaten` pada argumen request.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kecamatan/id_kabupaten/{id_toko}](). Tanpa Parameter.
			- `{id_kabupaten}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		[
  {
    "id": 32,
    "nama": "Balongpanggang",
    "id_kabupaten": 2
  },
  {
    "id": 33,
    "nama": "Benjeng",
    "id_kabupaten": 2
  },
  {
    "id": 34,
    "nama": "Bungah",
    "id_kabupaten": 2
  },
  {
    "id": 35,
    "nama": "Cerme",
    "id_kabupaten": 2
  },
  {
    "id": 36,
    "nama": "Driyorejo",
    "id_kabupaten": 2
  },
  {
    "id": 37,
    "nama": "Duduk Sampeyan",
    "id_kabupaten": 2
  },
  {
    "id": 38,
    "nama": "Dukun ",
    "id_kabupaten": 2
  },
  {
    "id": 39,
    "nama": "Gresik ",
    "id_kabupaten": 2
  },
  {
    "id": 40,
    "nama": "Kebomas ",
    "id_kabupaten": 2
  },
  {
    "id": 41,
    "nama": "Kedamean ",
    "id_kabupaten": 2
  },
  {
    "id": 42,
    "nama": "Manyar ",
    "id_kabupaten": 2
  },
  {
    "id": 43,
    "nama": "Menganti",
    "id_kabupaten": 2
  },
  {
    "id": 44,
    "nama": " Panceng ",
    "id_kabupaten": 2
  },
  {
    "id": 45,
    "nama": "Sangkapura ",
    "id_kabupaten": 2
  },
  {
    "id": 46,
    "nama": "Sidayu ",
    "id_kabupaten": 2
  },
  {
    "id": 47,
    "nama": "Tambak ",
    "id_kabupaten": 2
  },
  {
    "id": 48,
    "nama": "Ujung Pangkah ",
    "id_kabupaten": 2
  },
  {
    "id": 49,
    "nama": "Wringinanom",
    "id_kabupaten": 2
  }
]
		```
		- Request : [jasaq.esy.es/public/kecamatan/id_kabupaten/2]()
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id_kabupaten}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kecamatan Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kecamatan/id_kabupaten/234]()
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Kecamatan Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Buat Data

	Mendaftarkan Kecamatan pada database .Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/kecamatan/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Post Request Data

		+ `nama` **(wajib)**.
		+ `id_kabupaten` **(wajib)**.  
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kecamatan/](). 
		- Status Code `200`.
	
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "blablablab"
}
		```
		- Status Code `500`.
- Ubah Data

	Merubah data kecamatan dengan id tertentu.Menggunakan metode HTTP `PUT`.
	Pada hedaer sertakan `Content-Type' dengan nilai 'application/x-www-form-urlencoded'

	- URL
		- [jasaq.esy.es/public/kecamatan/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Put Request Data(x-www-url-encoded)

		+ `id` **(wajib)**.
		+ `nama` **(optional)**. 
		+ `id_kabupaten` **(wajib)**. 
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kecamatan/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kecamatan Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kecamatan/]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Update Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data kecamatan dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/kecamatan/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kecamatan/7](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "kecamatan Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/provinsi/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
`.


### Kabupaten

Semua operasi dengan tabel kabupaten 

- Get Semua Data
	
	Request semua data yang ada di tabel kabupaten .Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kabupaten/](). Tanpa Parameter.
	
	- Parameter
	
		*Tanpa Parameter*.
			
	- Contoh Respon Sukses(1)
		- ```json
	[
  {
    "id": 1,
    "nama": "Surabaya",
    "id_provinsi": 15
  },
  {
    "id": 2,
    "nama": "Gresik",
    "id_provinsi": 15
  }
]
		```
		
		- Request = [jasaq.esy.es/public/kabupaten/]()
		- Status Code `200`.

	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data kabupaten dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kabupaten/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 4,
  "nama": "SIMOKERTO",
  "id_kabupaten": 1
}
		```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kabupaten Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get By Id Provinsi


	Request data kabupaten dengan menyertakan `id_provinsi` pada argumen request.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/kabupaten/id_provinsi/{id_toko}](). Tanpa Parameter.
			- `{id_provinsi}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		[
  {
    "id": 1,
    "nama": "Surabaya",
    "id_provinsi": 15
  },
  {
    "id": 2,
    "nama": "Gresik",
    "id_provinsi": 15
  }
]
		```
		- Request : [jasaq.esy.es/public/kabupaten/id_provinsi/15]()
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id_provinsi}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kabupaten Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kabupaten/id_provinsi/234]()
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Kabupaten Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Buat Data

	Mendaftarkan kabupaten pada database .Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/kabupaten/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Post Request Data

		+ `nama` **(wajib)**.
		+ `id_provinsi` **(wajib)**.  
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kabupaten/](). 
		- Status Code `200`.
	
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "blablablab"
}
		```
		- Status Code `500`.
- Ubah Data

	Merubah data kabupaten dengan id tertentu.Menggunakan metode HTTP `PUT`.
	Pada hedaer sertakan 'Content-Type' dengan nilai `application/x-www-form-urlencoded`

	- URL
		- [jasaq.esy.es/public/kabupaten/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Put Request Data(x-www-url-encoded)

		+ `id` **(wajib)**.
		+ `nama` **(optional)**. 
		+ `id_provinsi` **(wajib)**. 
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kabupaten/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kabupaten Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kabupaten/]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Update Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data kabupaten dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/kabupaten/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/kabupaten/7](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
	
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Kabupaten Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/kabupaten/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

### Provinsi


Semua operasi dengan tabel provinsi

- Get Semua Data
	
	Request semua data yang ada di tabel provinsi.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/provinsi/](). Tanpa Parameter.
	
	- Parameter
	
		*Tanpa Parameter*.
			
	- Contoh Respon Sukses(1)
		- ```json
	[
  {
    "id": 1,
    "nama": "Aceh"
  },
  {
    "id": 2,
    "nama": "Sumatera Utara"
  },
  {
    "id": 3,
    "nama": "Bengkulu"
  },
  {
    "id": 4,
    "nama": "Jambi"
  },
  {
    "id": 5,
    "nama": "Riau"
  },
  {
    "id": 6,
    "nama": "Sumatera Barat"
  },
  {
    "id": 7,
    "nama": "Sumatera Selatan"
  },
  {
    "id": 8,
    "nama": "Lampung"
  },
  {
    "id": 9,
    "nama": "Kepulauan Bangka Belitung"
  },
  {
    "id": 10,
    "nama": "Kepulauan Riau"
  },
  {
    "id": 11,
    "nama": "Banten"
  },
  {
    "id": 12,
    "nama": "Jawa Barat"
  },
  {
    "id": 13,
    "nama": "DKI Jakarta"
  },
  {
    "id": 14,
    "nama": "Jawa Tengah"
  },
  {
    "id": 15,
    "nama": "Jawa Timur"
  },
  {
    "id": 16,
    "nama": "Daerah Istimewa Yogyakarta"
  },
  {
    "id": 17,
    "nama": "Bali"
  },
  {
    "id": 18,
    "nama": "Nusa Tenggara Barat"
  },
  {
    "id": 19,
    "nama": "Nusa Tenggara Timur"
  },
  {
    "id": 20,
    "nama": "Kalimantan Barat"
  },
  {
    "id": 21,
    "nama": "Kalimantan Selatan"
  },
  {
    "id": 22,
    "nama": "Kalimantan Tengah"
  },
  {
    "id": 23,
    "nama": "Kalimantan Timur"
  },
  {
    "id": 24,
    "nama": "Gorontalo"
  },
  {
    "id": 25,
    "nama": "Sulawesi Selatan"
  },
  {
    "id": 26,
    "nama": "Sulawesi Tenggara"
  },
  {
    "id": 27,
    "nama": "Sulawesi Tengah"
  },
  {
    "id": 28,
    "nama": "Sulawesi Utara"
  },
  {
    "id": 29,
    "nama": "Sulawesi Barat"
  },
  {
    "id": 30,
    "nama": "Maluku"
  },
  {
    "id": 31,
    "nama": "Maluku Utara"
  },
  {
    "id": 32,
    "nama": "Papua"
  },
  {
    "id": 33,
    "nama": "Papua Barat"
  }
]
		```
		
		- Request = [jasaq.esy.es/public/provinsi/]()
		- Status Code `200`.

	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Get 1 Data

	Request data provinsi dengan id tertentu.Menggunakan metode HTTP `GET`.
	- URL
		- [jasaq.esy.es/public/provinsi/{id}](). Tanpa Parameter.
			- `{id}` berupa angka
	- Parameter
	
		*Tidak ada Parameter*
	- Contoh Respon Sukses
		- ```json
		{
  "id": 3,
  "nama": "Bengkulu"
}	```
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		```{id}``` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Provinsi Tidak ditemukan"
}
		```
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Penampilan Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.

- Buat Data

	Mendaftarkan Provinsi pada database .Menggunakan metode HTTP `POST`.

	- URL
		- [jasaq.esy.es/public/provinsi/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Post Request Data

		+ `nama` **(wajib)**. 
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Penambahan data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/provinsi/](). 
		- Status Code `200`.
	
	- Contoh Respon Gagal
		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Penambahan data gagal",
  "dev_message": "blablablab"
}
		```
		- Status Code `500`.
- Ubah Data

	Merubah data provinsi dengan id tertentu.Menggunakan metode HTTP `PUT`.
	Pada hedaer sertakan '''Content-Type'''dengan nilai '''application/x-www-form-urlencoded'''

	- URL
		- [jasaq.esy.es/public/provinsi/](). Tanpa Parameter.

	- Parameter
	
		*Tidak Ada Parameter*
	- Put Request Data(x-www-url-encoded)

		+ `id` **(wajib)**.
		+ `nama` **(optional)**. 
		
		
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Update data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/provinsi/](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Provinsi Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/provinsi/]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Update Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.
- Hapus Data

	Menghapus data provinsi dengan id tertentu.Menggunakan metode HTTP `DELETE`.

	- URL
		- [jasaq.esy.es/public/provinsi/{id}](). Tidak ada Parameter.
			- `{id}` berupa angka

	- Parameter

		*Tidak ada Parameter*
	- Contoh Respon Sukses
		
		- ```json
		{
  "status": "Sukses",
  "message": "Hapus data berhasil"
}
		```
		- Request : [jasaq.esy.es/public/provinsi/7](). 
		- Status Code `200`.
	- Contoh Respon Gagal (1)
		
		`{id}` yang dimasukkan tidak ditemukan		
		Error Sql
		- ```json
		{
  "status": "Gagal",
  "message": "Provinsi Tidak ditemukan"
}
		```
		- Request : [jasaq.esy.es/public/provinsi/456]() 
		- Status Code `400`.
	- Contoh Respon Gagal (2)
		
		Error Sql
		- ```json
		{
			"status": "Gagal",
  			"message": "Hapus Data Gagal",
  			"dev_message": "blablablablabl"
  		}
		```
		- Status Code `500`.