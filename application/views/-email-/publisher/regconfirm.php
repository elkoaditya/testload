<?php

foreach	(	array_keys($this->data)	as	$_dat	)
	${$_dat}	=	&	$this->data[$_dat];

echo	"Hi {$name},<br/>";
echo	p('',	"Tinggal 1 langkah lagi untuk mengikuti program COWS. Segera aktifkan akun Anda dengan mengikuti link dibawah ini. ");
echo	tag('p',	'',	a("home/regconfirm?code={$reg_code}",	'',	''));