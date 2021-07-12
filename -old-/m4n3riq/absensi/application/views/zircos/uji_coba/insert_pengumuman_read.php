<form action="<?=base_url()?>service/insert_pengumuman_read" method="post">
	<table>
		<tr>
			<td>role</td>
			<td><input type="text" name="role" value="admin"></td>
		</tr>
		<tr>
			<td>user_id</td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>pengumuman_id</td>
			<td><input type="text" name="pengumuman"></td>
		</tr>
		
		<tr>
			<td><button type="submit">Submit</button></td>
		</tr>
	</table>
</form>