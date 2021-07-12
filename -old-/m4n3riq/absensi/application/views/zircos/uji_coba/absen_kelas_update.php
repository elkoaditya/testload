<form action="<?=base_url()?>service/update_kelas_absensi" method="post">
	<table>
		<tr>
			<td>id</td>
			<td><input type="text" name="id"></td>
		</tr>
		<tr>
			<td>role</td>
			<td><input type="text" name="role" value="sdm"></td>
		</tr>
		<tr>
			<td>tanggal</td>
			<td><input type="text" name="tanggal"></td>
		</tr>
		<tr>
			<td>user_id</td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>kelas_nilai_id</td>
			<td><input type="text" name="kelas"></td>
		</tr>
		<!--<tr>
			<td>jam_ajar_id</td>
			<td><input type="text" name="jam_ajar"></td>
		</tr>-->
		<tr>
			<td>pelajaran_nilai_id</td>
			<td><input type="text" name="pelajaran"></td>
		</tr>
		<tr>
			<td>jam_masuk</td>
			<td><input type="text" name="jam_masuk"></td>
		</tr>
		<tr>
			<td>jam_keluar</td>
			<td><input type="text" name="jam_keluar"></td>
		</tr>
		<tr>
			<td><button type="submit">Submit</button></td>
		</tr>
	
	</table>
</form>