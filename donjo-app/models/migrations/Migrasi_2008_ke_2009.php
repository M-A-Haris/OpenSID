<?php

/**
 * File ini:
 *
 * Model untuk migrasi database
 *
 * donjo-app/models/migrations/Migrasi_2008_ke_2009.php
 *
 */

/**
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:

 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.

 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package	OpenSID
 * @author	Tim Pengembang OpenDesa
 * @copyright	Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright	Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license	http://www.gnu.org/licenses/gpl.html	GPL V3
 * @link 	https://github.com/OpenSID/OpenSID
 */

class Migrasi_2008_ke_2009 extends CI_model {

	public function up()
	{
		// Hapus url parrent menu layanan mandiri
		$this->db->where('id', 14)
			->set('url', '')
			->update('setting_modul');

		// Catatan : u/ field dgn table referensi jika tdk ada maka nilainya NULL, jgn isi 0 agar sesuai saat difilter pd statistik
		$this->db->where('sakit_menahun_id', 0)
			->set('sakit_menahun_id', NULL)
			->update('tweb_penduduk');
		$this->db->where('cacat_id', 0)
			->set('cacat_id', NULL)
			->update('tweb_penduduk');

		// Update isi field_admin pd widget agenda
		$this->db->where('isi', 'agenda.php')
			->set('form_admin', 'web/tab/1000')
			->update('widget');

		// Hapus view lama yg tdk digunakan lagi
		$this->db->query("DROP VIEW IF EXISTS data_surat");

		// Struktur pemerintahan desa
		if (!$this->db->field_exists('atasan', 'tweb_desa_pamong'))
		{
  		$fields['atasan'] = [
	        	'type' => 'INT',
	        	'constraint' => 11,
	        ];
  		$fields['bagan_tingkat'] = array(
	        	'type' => 'TINYINT',
	        	'constraint' => 2,
	        );
  		$fields['bagan_offset'] = array(
	        	'type' => 'INT',
	        	'constraint' => 3,
	        );
  		$fields['bagan_layout'] = array(
	        	'type' => 'VARCHAR',
	        	'constraint' => 20,
	        );
			$this->dbforge->add_column('tweb_desa_pamong', $fields);
  	}

	}

}
