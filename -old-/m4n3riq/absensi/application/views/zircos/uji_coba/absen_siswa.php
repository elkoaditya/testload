<form action="<?=base_url()?>service/update_siswa_absensi" method="post">
	<table>
		<tr>
			<td>role</td>
			<td><input type="text" name="role" value="sdm"></td>
		</tr>
		<tr>
			<td>user_id</td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>id</td>
			<td><input type="text" name="id"></td>
		</tr>
		<tr>
			<td>kelas</td>
			<td><input type="text" name="kelas"></td>
		</tr>
		<tr>
			<td>absen</td>
			<td><input type="text" name="absen"></td>
		</tr>
		<tr>
			<td>status</td>
			<td><input type="text" name="status"></td>
		</tr>
		<tr>
			<td><button type="submit">Submit</button></td>
		</tr>
	
	</table>
</form>