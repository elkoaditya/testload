<?php

foreach	(	array_keys($this->data)	as	$_dat	)
	${$_dat}	=	&	$this->data[$_dat];

echo	"Hi {$user['name']},<br/>";
echo	p('',	"Kami baru saja menerima permintaan reset akun COWS dari email ini. Jika permintaan ini benar, ikuti link dibawah ini. Jika tidak, maka abaikan saja pesan ini. ");
echo	tag('p',	'',	a("home/reset/{$reset['reset_code']}?redir=publisher/account",	'',	''));
