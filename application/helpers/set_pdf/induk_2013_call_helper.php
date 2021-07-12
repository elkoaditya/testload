<?php 

function tgl_indo($tgl)
{
	$tanggal = substr($tgl,0,2);
	$bulan = getBulan(substr($tgl,3,2));
	$tahun = substr($tgl,6,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}	
function getBulan($bln)
{
	switch ($bln)
	{
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}
function induk_view_data1_v1() {
	$set_array = array(
		induk_view_data1a_v1(),
		induk_view_data1b_v1(),
		induk_view_data1c_v1(),
		induk_view_data1d_v1(),
		induk_view_data1e_v1(),
		induk_view_data1f_v1(),
		induk_view_data1g_v1(),
		induk_view_data1h_v1(),
		induk_view_data1i_v1(),
		induk_view_data1j_v1(),
	);
	return $set_array;
}

function induk_view_data1a_v1() {
	$set_array = array(
		array(
			'label' => 'NOMOR INDUK SISWA',
		//	'value' => '',
		),
		array(
			'label' => 'A. KETERANGAN TENTANG DIRI SISWA',
			'child' => 
				array(
					array(
						'label' => '1. Nama Siswa',
						'child' => 
							array(
								array(
									'label' => 'a. Nama Lengkap',
									'value' => '',
								),
								array(
									'label' => 'b. Nama Panggilan',
									'value' => '',
								),
							)
					),
					
					array(
						'label' => '2. Jenis Kelamin',
					),
					array(
						'label' => '3. Tempat dan Tanggal Lahir',
					),
					array(
						'label' => '4. Agama',
					),
					array(
						'label' => '5. Kewarganegaraan',
					),
					array(
						'label' => '6. Anak Ke Berapa',
					),
					array(
						'label' => '7. Jumlah Saudara Kandung',
					),
					array(
						'label' => '8. Jumlah Saudara Tiri',
					),
					array(
						'label' => '9. Jumlah Saudara Angkat',
					),
					array(
						'label' => '10. Anak Yatim/Piatu/Yatim Piatu',
					),
					array(
						'label' => '11. Bahasa Sehari-hari Di Rumah',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1b_v1() {
	$set_array = array(
		array(
			'label' => 'B. KETERANGAN TEMPAT TINGGAL',
			'child' => 
				array(
					array(
						'label' => '12. Alamat',
					),
					
					array(
						'label' => '13. Nomor Telepon',
					),
					array(
						'label' => '14. Tinggal Dengan Orang Tua/ Srd/ Asrama/ Kost',
					),
					array(
						'label' => '15. Jarak Tempat Tinggal Ke Sekolah',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1c_v1() {
	$set_array = array(
		array(
			'label' => 'C. KETERANGAN KESEHATAN',
			'child' => 
				array(
					array(
						'label' => '16. Golongan Darah',
					),
					
					array(
						'label' => '17. Penyakit Yang Pernah Diderita',
					),
					array(
						'label' => '18. Kelainan Jasmani',
					),
					array(
						'label' => '19. Tinggi dan Berat Badan',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1d_v1() {
	$set_array = array(
		
		
		array(
			'label' => 'D. KETERANGAN PENDIDIKAN',
			'child' => 
				array(
					array(
						'label' => '20. Pendidikan Sebelumnya',
						'child' => 
							array(
								array(
									'label' => 'a. Lulusan Dari',
									'value' => '',
								),
								array(
									'label' => 'b. Tanggal Dan Nomor STTB',
									'value' => '',
								),
								array(
									'label' => 'c. Lama Belajar',
									'value' => '',
								),
							)
					),
					array(
						'label' => '21. Pindahan',
						'child' => 
							array(
								array(
									'label' => 'a. Dari Sekolah',
									'value' => '',
								),
								array(
									'label' => 'b. Alasan',
									'value' => '',
								),
							)
					),
					array(
						'label' => '22. Diterima Di Sekolah Ini',
						'child' => 
							array(
								array(
									'label' => 'a. Tingkat',
									'value' => '',
								),
								array(
									'label' => 'b. Bidang Keahlian / Program',
									'value' => '',
								),
								array(
									'label' => 'c. Tanggal',
									'value' => '',
								),
							)
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1e_v1() {
	$set_array = array(
		array(
			'label' => 'E. KETERANGAN TENTANG AYAH KANDUNG',
			'child' => 
				array(
					array(
						'label' => '23. Nama',
					),
					array(
						'label' => '24. Tempat dan Tanggal Lahir',
					),
					array(
						'label' => '25. Agama',
					),
					array(
						'label' => '26. Kewarganegaraan',
					),
					array(
						'label' => '27. Pendidikan',
					),
					array(
						'label' => '28. Pekerjaan',
					),
					array(
						'label' => '29. Penghasilan Perbulan',
					),
					array(
						'label' => '30. Alamat Rumah/ No. Telepon',
					),
					array(
						'label' => '31. Masih Hidup/ Meninggal Dunia',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1f_v1() {
	$set_array = array(
		array(
			'label' => 'F. KETERANGAN TENTANG IBU KANDUNG',
			'child' => 
				array(
					array(
						'label' => '32. Nama',
					),
					array(
						'label' => '33. Tempat dan Tanggal Lahir',
					),
					array(
						'label' => '34. Agama',
					),
					array(
						'label' => '35. Kewarganegaraan',
					),
					array(
						'label' => '36. Pendidikan',
					),
					array(
						'label' => '37. Pekerjaan',
					),
					array(
						'label' => '38. Penghasilan Perbulan',
					),
					array(
						'label' => '39. Alamat Rumah/ No. Telepon',
					),
					array(
						'label' => '40. Masih Hidup/ Meninggal Dunia',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1g_v1() {
	$set_array = array(
		array(
			'label' => 'G. KETERANGAN TENTANG WALI',
			'child' => 
				array(
					array(
						'label' => '41. Nama',
					),
					array(
						'label' => '42. Tempat dan Tanggal Lahir',
					),
					array(
						'label' => '43. Agama',
					),
					array(
						'label' => '44. Kewarganegaraan',
					),
					array(
						'label' => '45. Pendidikan',
					),
					array(
						'label' => '46. Pekerjaan',
					),
					array(
						'label' => '47. Penghasilan Perbulan',
					),
					array(
						'label' => '48. Alamat Rumah/ No. Telepon',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1h_v1() {
	$set_array = array(
		array(
			'label' => 'H. KEGEMARAN SISWA',
			'child' => 
				array(
					array(
						'label' => '49. Kesenian',
					),
					array(
						'label' => '50. Olah Raga',
					),
					array(
						'label' => '51. Kemasyarakatan / Organisasi',
					),
					array(
						'label' => '52. Lain-Lain',
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1i_v1() {
	$set_array = array(
		array(
			'label' => 'I. KETERANGAN PERKEMBANGAN SISWA',
			'child' => 
				array(
					array(
						'label' => '53. Menerima Beasiswa',
						'child' => 
							array(
								array(
									'label' => ': Th ......../Kls ........ Dari ........',
								),
								array(
									'label' => ': Th ......../Kls ........ Dari ........',
								),
								array(
									'label' => ': Th ......../Kls ........ Dari ........',
								),
							)
					),
					array(
						'label' => '54. Menerima Beasiswa',
						'child' => 
							array(
								array(
									'label' => 'a. Tanggal Meninggalkan Sekolah',
								),
								array(
									'label' => 'b. Alasan',
								),
							)
					),
					array(
						'label' => '55. Akhir Pendidikan',
						'child' => 
							array(
								array(
									'label' => 'a. Tamat Belajar / Th',
								),
								array(
									'label' => 'b. STTB Nomor',
								),
							)
					),
				)
		),
	);
	return $set_array;
}
function induk_view_data1j_v1() {
	$set_array = array(
		array(
			'label' => 'J. KETERANGAN SETELAH SELESAI PENDIDIKAN',
			'child' => 
				array(
					array(
						'label' => '56. Melanjutkan Di',
					),
					array(
						'label' => '57. Bekerja',
						'child' => 
							array(
								array(
									'label' => 'a. Tanggal Mulai Kerja',
								),
								array(
									'label' => 'b. Nama Perusahaan / Lembaga / Lain-Lain',
								),
								array(
									'label' => 'c. Penghasilan',
								),
							)
					),
				)
		),
	);
	return $set_array;
}

function int2kata($n) {
    if (is_null($n) or !is_numeric($n))
        return '';

    if ($n == 0)
        return 'Nol';
    if ($n == 1)
        return 'Satu';
    if ($n == 2)
        return 'Dua';
    if ($n == 3)
        return 'Tiga';
    if ($n == 4)
        return 'Empat';
    if ($n == 5)
        return 'Lima';
    if ($n == 6)
        return 'Enam';
    if ($n == 7)
        return 'Tujuh';
    if ($n == 8)
        return 'Delapan';
    if ($n == 9)
        return 'Sembilan';

    return '';
}

function int2huruf($n) {
    if (is_null($n) OR !is_numeric($n))
        return '';

    if ($n >= 90)
        return 'A';

    if ($n >= 70)
        return 'B';

    if ($n >= 60)
        return 'C';

    //if ($n >= 41)
        return 'D';

    //return 'E';
}
?>