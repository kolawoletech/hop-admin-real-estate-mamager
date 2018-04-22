<div class="wrap ich-settings-main-wrap">
	<table class="widefat">
		<thead>
			<tr>
				<th><?php _e( 'Title', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Shortcode', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Possible Attributes', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Details', 'real-estate-manager' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php _e( 'Agent Registration Form', 'real-estate-manager' ); ?></td>
				<td><code>[rem_register_agent]</code></td>
				<td>redirect</td>
				<td><?php _e( 'It will render a form to register new agent', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Create Property Form', 'real-estate-manager' ); ?></td>
				<td><code>[rem_create_property]</code></td>
				<td></td>
				<td><?php _e( 'It will render a form to create a property.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Edit Single Property', 'real-estate-manager' ); ?></td>
				<td><code>[rem_edit_property]</code></td>
				<td></td>
				<td><?php _e( 'It will render a form to edit property on frontend.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Login Form', 'real-estate-manager' ); ?></td>
				<td><code>[rem_agent_login]</code></td>
				<td>heading <br> redirect</td>
				<td><?php _e( 'It will render a form to login an agent.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'List My Properties', 'real-estate-manager' ); ?></td>
				<td><code>[rem_my_properties]</code></td>
				<td></td>
				<td><?php _e( 'It will render a list of properties of current logged in user.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Search Property Form', 'real-estate-manager' ); ?></td>
				<td><code>[rem_search_property]</code></td>
				<td>fields_to_show <br> columns <br> fixed_fields</td>
				<td><?php _e( 'It will render a form to search properties via AJAX.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'List Properties', 'real-estate-manager' ); ?></td>
				<td><code>[rem_list_properties]</code></td>
				<td>
					order <br>
					orderby <br>
					style <br>
					posts <br>
					class <br>
					purpose <br>
					status <br>
					type <br>
					tags <br>
					nearest_porperties <br>
					meta <br>
					pagination <br>
				</td>
				<td><?php _e( 'It will render a list of properties.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Search Results Page', 'real-estate-manager' ); ?></td>
				<td><code>[rem_search_results]</code></td>
				<td></td>
				<td><?php _e( 'It displays search results of properties searched from widget.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Multiple Properties on Map', 'real-estate-manager' ); ?></td>
				<td><code>[rem_maps]</code></td>
				<td>
					ids <br>
					total_properties <br>
					order <br>
					orderby <br>
					meta <br>
					tags <br>
					load_heading <br>
					load_desc <br>
					btn_bg_color <br>
					btn_text_color <br>
					btn_bg_color_hover <br>
					btn_text_color_hover <br>
					type_bar_bg_color <br>
					type_filtering <br>
					water_color <br>
					fill_color <br>
					poi_color <br>
					poi_color_hue <br>
					roads_lightness <br>
					lines_lightness <br>
					loader_color <br>
					type_filtering <br>
					map_height <br>
					bottom_btn_bg_color <br>
					bottom_btn_text_color <br>
					bottom_btn_bg_color_hover <br>
					bottom_btn_text_color_hover <br>
					bottom_btn_bg_color_active <br>
				</td>
				<td><?php _e( 'It displays multiple  properties on a map.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Display Agent Profile', 'real-estate-manager' ); ?></td>
				<td><code>[rem_agent_profile]</code></td>
				<td>author_id</td>
				<td><?php _e( 'It displays profile of a single agent.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Edit Agent Profile', 'real-estate-manager' ); ?></td>
				<td><code>[rem_agent_edit]</code></td>
				<td></td>
				<td><?php _e( 'It renders a form to edit current users profile.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Single Property', 'real-estate-manager' ); ?></td>
				<td><code>[rem_property]</code></td>
				<td>id</td>
				<td><?php _e( 'It displays a single property by id.', 'real-estate-manager' ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Touch Carousel', 'real-estate-manager' ); ?></td>
				<td><code>[rem_carousel]</code> <strong>Pro Feature</strong></td>
				<td>
					order <br>
					orderby <br>
					style <br>
					total_properties <br>
					tags <br>
					meta <br>
					slidestoshow <br>
					speed <br>
					slidestoscroll <br>
					autoplay <br>
					autoplayspeed <br>
					arrows <br>
					dots <br>
					ids <br>
				</td>
				<td><?php _e( 'It renders slider of selected properties based on settings.', 'real-estate-manager' ); ?></td>
			</tr>
		</tbody>
	</table>

	<p><?php _e( 'For more details, please visit', 'real-estate-manager' ); ?> <a href="http://rem.webcodingplace.com/real-estate-manager-documentation-and-help/shortcodes-detail/"><?php _e( 'Shortcode Details', 'real-estate-manager' ); ?></a></p>

</div>