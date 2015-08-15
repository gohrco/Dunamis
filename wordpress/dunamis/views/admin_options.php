<h2>Dunamis Framework <small>Settings</small></h2>
<form method="post">
	<input type="hidden" name="task" value="save" />
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="debug">
					Enable Debug:
				</label>
			</th>
			<td>
				<input id="debug" name="debug" type="checkbox" value="1" <?php echo ( $debug ? 'checked="checked"' : '' ); ?> />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input id="dunamisUpdate" name="dunamisUpdate" type='submit' value="Save Settings" class="button-primary" />
			</td>
		</tr>
	</table>
</form>