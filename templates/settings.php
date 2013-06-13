<div id="topLine">
	<p>Bridge</p>
</div>
<div id="leftSideBar">
	<div id="setting_content">
		<form method="POST">
			<label>Approaches</label>
			<select name="approach" id="approach">
			<?php	
				$op0='';$op1='';
				if(OC_Appconfig::getValue('bridge', 'approach','')==0)
					$op0='selected';
				else if(OC_Appconfig::getValue('bridge', 'approach','')==1)
					$op1='selected';
				echo '<option '.$op0 .' value="0">Database Copy</option>';
				echo '<option '.$op1.' value="1">Multiple Backends</option>';
			?>	
			</select>
			<div id="r_s_div">
				<label>Run Style</label>	
				<select name="run_style" id="run_style">
				<?php	
					$op0='';$op1='';
					if(OC_Appconfig::getValue('bridge', 'run_style','')==0)
						$op0='selected';
					else if(OC_Appconfig::getValue('bridge', 'run_style','')==1)
						$op1='selected';				
					echo '<option '.$op0.' value="0">Automatic</option>';
					echo '<option '.$op1.' value="1">Manual</option>';
				?>					
				</select>
			</div>	
			<input type="submit"  id='setting_save' value= "Save">	
		</form>	
	</div>		
	<div id="setting">
		<div><img src='/owncloud/core/img/actions/settings.svg'></img></div>		
	</div>	
</div>
<div id="rightContent">
	<div id="backends_table">
	<table>
		<tr>
			<th colspan="2">Backend</th>
		</tr>
		<tr>
			<td>phpBB3</td>
			<td>
				<input type='button'  id='import' value= "Import">			
				<input type='button'  id='enable' value= "Enable">
				<input type='button'  id='modify' value= "Modify">				
			</td>		
		</tr>
	</table>
	</div>
	<div id="modifyForm">
	</div>
</div>
<div id="hidenContent">
<div id='dbForm'>
<form method="POST">
    <fieldset>
        <legend><strong>PHPBB3</strong></legend>
        <p>
            <label for="db_host">DB Host</label>
            <input type="text" id="db_host" name="db_host"
                value="<?php echo $_['db_host']; ?>" />
		</p>
		<p>
            <label for="db_name">DB Name</label>
            <input type="text" id="db_name" name="db_name" 
                value="<?php echo $_['db_name']; ?>" />
		</p>
		<p>
            <label for="db_prefix">DB Prefix</label>
            <input type="text" id="db_prefix" name="db_prefix" 
                value="<?php echo $_['db_prefix']; ?>" />
        </p>

        <p>
            <label for="db_user">DB User</label>
            <input type="text" id="db_user" name="db_user" 
                value="<?php echo $_['db_user']; ?>" />
		</p>
		<p>
            <label for="db_password">DB Password</label>
            <input type="text" id="db_password" name="db_password" 
                value="<?php echo $_['db_password']; ?>" />
        </p>

        <input type="submit" value="Save" />
    </fieldset>
</form>
</div>
</div>



