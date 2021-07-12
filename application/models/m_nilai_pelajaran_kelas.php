<?php

class M_nilai_pelajaran_kelas extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	function rerata_by_nipel($id) {

		/*
		 * 1 pelajaran_nilai_id
		 * 2 datetime
		 * 3 pelajaran_nilai_id
		 */

		$id = (int) $id;
		$d = & $this->ci->d;
		$sql = "
update nilai_pelajaran_kelas nipelkls
inner join
(
	select
		pelajaran_kelas_nilai_id,
		avg(nas_total) nas_total,
		avg(nas_teori) nas_teori,
		avg(nas_praktek) nas_praktek,
		avg(uas) uas,
		avg(uts) uts,
		avg(h1) h1,
		avg(h2) h2,
		avg(h3) h3,
		avg(h4) h4,
		avg(h5) h5,
		avg(h6) h6,
		avg(h7) h7,
		avg(h8) h8,
		avg(h9) h9,
		avg(h10) h10,
		avg(t1) t1,
		avg(t2) t2,
		avg(t3) t3,
		avg(t4) t4,
		avg(t5) t5,
		avg(t6) t6,
		avg(t7) t7,
		avg(t8) t8,
		avg(t9) t9,
		avg(t10) t10,
		avg(p1) p1,
		avg(p2) p2,
		avg(p3) p3,
		avg(p4) p4,
		avg(p5) p5,
		avg(p6) p6,
		avg(p7) p7,
		avg(p8) p8,
		avg(p9) p9,
		avg(p10) p10
	from nilai_siswa_pelajaran
	where pelajaran_nilai_id = ?
	group by pelajaran_kelas_nilai_id
) nisispel
	on nipelkls.id = nisispel.pelajaran_kelas_nilai_id
set
	nipelkls.nas_total = nisispel.nas_total,
	nipelkls.nas_teori = nisispel.nas_teori,
	nipelkls.nas_praktek = nisispel.nas_praktek,
	nipelkls.uas = nisispel.uas,
	nipelkls.uts = nisispel.uts,
	nipelkls.h1 = nisispel.h1,
	nipelkls.h2 = nisispel.h2,
	nipelkls.h3 = nisispel.h3,
	nipelkls.h4 = nisispel.h4,
	nipelkls.h5 = nisispel.h5,
	nipelkls.h6 = nisispel.h6,
	nipelkls.h7 = nisispel.h7,
	nipelkls.h8 = nisispel.h8,
	nipelkls.h9 = nisispel.h9,
	nipelkls.h10 = nisispel.h10,
	nipelkls.t1 = nisispel.t1,
	nipelkls.t2 = nisispel.t2,
	nipelkls.t3 = nisispel.t3,
	nipelkls.t4 = nisispel.t4,
	nipelkls.t5 = nisispel.t5,
	nipelkls.t6 = nisispel.t6,
	nipelkls.t7 = nisispel.t7,
	nipelkls.t8 = nisispel.t8,
	nipelkls.t9 = nisispel.t9,
	nipelkls.t10 = nisispel.t10,
	nipelkls.p1 = nisispel.p1,
	nipelkls.p2 = nisispel.p2,
	nipelkls.p3 = nisispel.p3,
	nipelkls.p4 = nisispel.p4,
	nipelkls.p5 = nisispel.p5,
	nipelkls.p6 = nisispel.p6,
	nipelkls.p7 = nisispel.p7,
	nipelkls.p8 = nisispel.p8,
	nipelkls.p9 = nisispel.p9,
	nipelkls.p10 = nisispel.p10,
	nipelkls.valid = 1,
	nipelkls.diolah = ?
";

		$this->db->trans_start();
		$this->db->query($sql, array($id, $d['datetime']));

		return $this->trans_done("Nilai rata-rata pelajaran-kelas berhasil diperbarui", 'Database error saat memperbarui rata-rata nilai pelajaran-kelas.');
	}

	function reratareset_by_nipel($id) {

		/*
		 * 1 pelajaran_nilai_id
		 */

		$id = (int) $id;
		$sql = "

		update nilai_pelajaran_kelas nipelkls
		inner join nilai_kelas nikls
		set
			nipelkls.valid = 0,
			nikls.valid = 0
		where
			nipelkls.pelajaran_nilai_id = ?

		";

		$this->db->trans_start();
		$this->db->query($sql, array($id));
		return $this->trans_done();
	}

}
