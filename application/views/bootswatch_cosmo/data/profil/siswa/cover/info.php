<?php

function info(){
	$info['tgl_masuk']='';
	$info['kepala_sekolah'] = '-';
	$info['nip']='';
	if (APP_DOMAIN == 'localhost'):
		$info['title'] ='SEKOLAH MENENGAH ATAS ';

	elseif (APP_SUBDOMAIN == 'sma_setiabudhi'):
		$info['title'] ='SEKOLAH MENENGAH ATAS SETIABUDHI';
		$info['kepala_sekolah']	= 'Drs. Gimin';
		$info['nip']			= '-';
	elseif (APP_SUBDOMAIN == 'sman8smg'):
		$info['title'] 			= 'SEKOLAH MENENGAH ATAS NEGERI 8';
		$info['kepala_sekolah']	= 'Poniman Slamet S.Pd, M.Kom';
		$info['nip']			= '19740604 199903 1007';
	elseif (APP_SUBDOMAIN == 'sman9smg'):
		$info['title'] 			= 'SEKOLAH MENENGAH ATAS NEGERI 9';
		$info['kepala_sekolah']	= 'Dr. Siswanto M. Pd. ';
		$info['nip']			= '19660608 199512 1 001';
	elseif (APP_SUBDOMAIN == 'sman14smg'):
		$info['title'] ='SEKOLAH MENENGAH ATAS NEGERI 14';
		
	elseif (APP_SUBDOMAIN == 'smaterbang'):
		$info['title'] ='SEKOLAH MENENGAH ATAS TERANG BANGSA';
		$info['kepala_sekolah']	= 'Drs. Sungkowo Prihadi';
		$info['nip']			= '-';
	elseif (APP_SUBDOMAIN == 'sma_michael'):
		$info['title'] ='SEKOLAH MENENGAH ATAS SANTO MICHAEL';
		$info['kepala_sekolah']	= 'L. Ruddy Sulistiawan, S. Pd';
		$info['nip']			= '-';
	elseif (APP_SUBDOMAIN == 'smk_penerbangan'):
		$info['title'] ='SEKOLAH MENENGAH KEJURUAN <br/>PENERBANGAN KARTIKA AQASA BHAKTI';
		$info['kepala_sekolah']	= 'Mukar S.Pd ';
		$info['nip']			= '-';
	elseif (APP_SUBDOMAIN == 'smknusaputera1'):
		$info['title'] ='SEKOLAH MENENGAH KEJURUAN <br/>NUSA PUTERA 1';	
		$info['kepala_sekolah']	= 'Drs. Ariawan Sudagijono, M.Kom';
		$info['nip']			= '-';
	elseif (APP_SUBDOMAIN == 'smakristen1-wsb'):
		$info['title'] ='SEKOLAH MENENGAH ATAS Kristen 1 ';
		
	elseif (APP_SUBDOMAIN == 'demo'):
		$info['title'] ='SEKOLAH MENENGAH ATAS ANDALUS';
	endif;
	
	if (APP_SUBDOMAIN == 'smakristen1-wsb'):
		$info['title'] .='<br/>
				WONOSOBO';
	else:
		$info['title'] .='<br/>
				SEMARANG';
	endif;
	
	return $info;
}
?>