<div class="rem-settings-box ich-settings-main-wrap">
	<ul class="nav nav-tabs">
		<?php
			include 'single-property-fields.php';
			foreach ($tabsData as $name => $title) {
				echo '<li role="presentation"><a href="#'.$name.'">'.$title.'</a></li>';
			}
		?>
	</ul>
	
	<div class="tabs-data">
		<?php
			foreach ($tabsData as $name => $title) { ?>
				<div id="<?php echo $name; ?>" class="tabs-panel">
				<br>
					<?php
						foreach ($inputFields as $field) {
							if($field['tab'] == $name){ ?>
			                    <div class="form-group">
			                        <label for="<?php echo $field['key']; ?>" class="col-sm-3 control-label">
			                            <?php echo stripcslashes($field['title']); ?>
			                        </label>
			                        <div class="col-sm-9">
			                            <?php rem_render_field($field); ?>
			                            <p class="help-block"><?php echo stripcslashes($field['help']); ?>	</p>
			                        </div>
			                        <div class="clearfix"></div>
			                    </div>

							<?php }
						}
					?>
				</div>
			<?php }
		?>	
	</div>
	
</div>