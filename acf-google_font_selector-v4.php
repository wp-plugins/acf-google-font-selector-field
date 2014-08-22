<?php

class acf_field_google_font_selector extends acf_field {
	
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options

	public $enqueue_fonts_option;


	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct()
	{
		$this->enqueue_fonts_option = 'acfgfs_enqueue_fonts_v4';
		// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

		$api_key = ( defined( 'ACFGFS_API_KEY' ) ) ? ACFGFS_API_KEY : null;
		$refresh = ( defined( 'ACFGFS_REFRESH' ) ) ? ACFGFS_REFRESH : 259200;
		$option_name = ( defined( 'ACFGFS_OPTION_NAME' ) ) ? ACFGFS_OPTION_NAME : 'bonsai_wp_google_fonts';

		$this->bonsai_WP_Google_Fonts = new Bonsai_WP_Google_Fonts( $api_key, $refresh, $option_name );
		$this->name = 'google_font_selector';
		$this->label = __('Google Font Selector', 'acf-google_font_selector');
		$this->category = 'Choice';

		$this->defaults = array(
			'include_web_safe_fonts' => true,
			'enqueue_font'           => true,
			'default_font'           => 'Droid Sans',
		);

		parent::__construct();

		add_action( 'wp_ajax_acfgfs_get_font_details', array( $this, 'action_get_font_details') );

		add_action( 'wp_enqueue_scripts', array( $this, 'google_font_enqueue' ) );

	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like below) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// defaults?
		/*
		$field = array_merge($this->defaults, $field);
		*/
		
		// key is needed in the field names to correctly save the data
		$key = $field['name'];
		
		
		// Create Field Options HTML
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Web Safe Fonts?",'acf'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'true_false',
			'name'		=>	'fields['.$key.'][include_web_safe_fonts]',
			'value'		=>	$field['include_web_safe_fonts'],
			'layout'	=>	'horizontal',
			'message'    	=> __('Include web safe fonts?','acf-google_font_selector'),
		));
		
		?>
	</td>
</tr>

		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Enqueue Font?",'acf'); ?></label>
			</td>
			<td>
				<?php

				do_action('acf/create_field', array(
					'type'		=>	'true_false',
					'name'		=>	'fields['.$key.'][enqueue_font]',
					'value'		=>	$field['enqueue_font'],
					'layout'	=>	'horizontal',
					'message'    	=> __('Automatically load font?','acf-google_font_selector'),
				));

				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Default Font",'acf'); ?></label>
			</td>
			<td>
				<?php

				do_action('acf/create_field', array(
					'type'		=>	'select',
					'name'		=>	'fields['.$key.'][default_font]',
					'value'		=>	$field['default_font'],
					'choices'       => $this->bonsai_WP_Google_Fonts->get_font_dropdown_array()
				));

				?>
			</td>
		</tr>

		<?php

	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		// defaults?
		/*
		$field = array_merge($this->defaults, $field);
		*/
		
		// perhaps use $field['preview_size'] to alter the markup?
		
		
		// create Field HTML
		$current_font_family = ( empty( $field['value'] ) ) ? $field['default_font'] : $field['value']['font'];


		?>
		<div class="acfgfs-font-selector">
			<div class="acfgfs-loader"></div>
			<div class="acfgfs-form-control acfgfs-font-family">
				<div class="acfgfs-form-control-title"><?php _e('Font Family', 'acf-google_font_selector') ?></div>

				<select name="<?php echo esc_attr($field['name']) ?>">
					<?php
					$options = $this->bonsai_WP_Google_Fonts->get_font_dropdown_array();
					foreach( $options as $option ) {
						echo '<option ' . selected( $option, $current_font_family ) . ' value="' . $option . '">' . $option . '</option>';
					}
					?>
				</select>
			</div>

			<div class="acfgfs-form-control acfgfs-font-variants">
				<div class="acfgfs-form-control-title"><?php _e('Variants', 'acf-google_font_selector') ?></div>
				<div class="acfgfs-list">
					<?php
					$font_variants = $this->bonsai_WP_Google_Fonts->get_font_variant_array( $current_font_family );
					$this->display_variant_list( $font_variants, $field );
					?>
				</div>

			</div>

			<div class="acfgfs-form-control acfgfs-font-subsets">
				<div class="acfgfs-form-control-title"><?php _e('Subsets', 'acf-google_font_selector') ?></div>
				<div class="acfgfs-list">

					<?php
					$font_subsets = $this->bonsai_WP_Google_Fonts->get_font_subset_array( $current_font_family );
					$this->display_subset_list( $font_subsets, $field );
					?>

				</div>

			</div>

			<textarea name="acfgfs-font-data" class="acfgfs-font-data"><?php echo json_encode( $field ) ?></textarea>

		</div>


	<?php
	}
	
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts()
	{
		// Note: This function can be removed if not used
		
		
		// register ACF scripts
		wp_register_script( 'acf-input-google_font_selector', $this->settings['dir'] . 'js/input.js', array('acf-input'), $this->settings['version'] );
		wp_register_style( 'acf-input-google_font_selector', $this->settings['dir'] . 'css/input.css', array('acf-input'), $this->settings['version'] ); 
		
		
		// scripts
		wp_enqueue_script(array(
			'acf-input-google_font_selector',	
		));

		// styles
		wp_enqueue_style(array(
			'acf-input-google_font_selector',	
		));
		
		
	}
	

	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field )
	{
		$new_value = array();
		$new_value['font'] = $value;
		if( empty( $_POST[$field['key'] . '_variants'] ) ) {
			$_POST[$field['key'] . '_variants'] = $this->bonsai_WP_Google_Fonts->get_font_variant_array( $new_value['font'] );
		}

		if( empty( $_POST[$field['key'] . '_subsets'] ) ) {
			$_POST[$field['key'] . '_subsets'] = $this->bonsai_WP_Google_Fonts->get_font_subset_array( $new_value['font'] );
		}

		$new_value['variants'] = $_POST[$field['key'] . '_variants'];
		$new_value['subsets'] = $_POST[$field['key'] . '_subsets'];
		return $new_value;
	}


	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = acf)
	*
	*  @return	$field - the modified field
	*/

	function update_field( $field, $post_id )
	{
		$enqueues = get_option( $this->enqueue_fonts_option );
		$enqueues = ( empty( $enqueues ) ) ? array() : $enqueues;

		$enqueued = array_search( $field['key'], $enqueues );
		if( empty( $field['enqueue_font'] ) && $enqueued !== false ) {
			unset( $enqueues[$enqueued] );
		}
		elseif( !empty( $field['enqueue_font'] ) && $enqueued === false ) {
			$enqueues[] = $field['key'];
		}
		update_option( $this->enqueue_fonts_option, $enqueues );

		return $field;
	}


	/**
	 * Display a variant list for a font
	 *
	 * @param array $variants variant list
	 * @param array $field field to display for
	 */
	function display_variant_list( $variants = array(), $field ) {
		$i = 1;
		foreach( $variants as $variant ) :
			$checked = ( empty( $field['value'] ) || ( !empty( $field['value'] ) && in_array( $variant, $field['value']['variants'] ) ) ) ? 'checked="checked"' : '';
			?>

			<input <?php echo $checked ?> type="checkbox" id="<?php echo $field['key'] ?>_variants_<?php echo $i ?>" name="<?php echo $field['key'] ?>_variants[]" value="<?php echo $variant ?>"><label for="<?php echo $field['key'] ?>_variants_<?php echo $i ?>"><?php echo $variant ?></label> <br>

			<?php $i++; endforeach;

	}


	/**
	 * Displays a list of subsets for a font
	 *
	 * @param array $subsets array of subsets
	 * @param array $field field to display subsets for
	 */
	function display_subset_list( $subsets = array(), $field ) {
		$i = 1;
		foreach( $subsets as $subset ) :
			$checked = ( empty( $field['value'] ) || ( !empty( $field['value'] ) && in_array( $subset, $field['value']['subsets'] ) ) ) ? 'checked="checked"' : '';
			?>
			<input <?php echo $checked ?> type="checkbox" id="<?php echo $field['key'] ?>_subsets_<?php echo $i ?>" name="<?php echo $field['key'] ?>_subsets[]" value="<?php echo $subset ?>"><label for="<?php echo $field['key'] ?>_subsets_<?php echo $i ?>"><?php echo $subset ?></label> <br>

			<?php $i++; endforeach;

	}


	/**
	 * Get the font details via AJAX
	 */
	function action_get_font_details() {
		$details = array();
		$field = json_decode( stripslashes( $_POST['data'] ), true );
		unset( $field['value'] );
		$subsets = $this->bonsai_WP_Google_Fonts->get_font_subset_array( $_POST['font_family'] );
		$variants = $this->bonsai_WP_Google_Fonts->get_font_variant_array( $_POST['font_family'] );
		ob_start();
		$this->display_subset_list( $subsets, $field );
		$details['subsets'] = ob_get_clean();

		ob_start();
		$this->display_variant_list( $variants, $field );
		$details['variants'] = ob_get_clean();

		echo json_encode( $details );

		die();
	}

	/*
	*  Build Google Font Request
	*
	*  Retrieves all font settings and builds a Google Font query
	*
	*/
	function google_font_enqueue(){
		$enqueues = get_option( $this->enqueue_fonts_option );
		$fonts = array();
		foreach( $enqueues as $enqueue ) {
			$font = get_field( $enqueue, 'options' );
			if( empty( $font ) && is_singular() ) {
				global $post;
				$font = get_field( $enqueue, $post->ID );
			}

			$fonts[] = $font;
		}

		$fonts = array_filter( $fonts );

		$subsets = array();
		$font_element = array();
		foreach( $fonts as $font ) {
			$subsets = array_merge( $subsets, $font['subsets'] );
			$font_name = str_replace( ' ', '+', $font['font'] );
			if( $font['variants'] == array( 'regular' ) ) {
				$font_element[] = $font_name;
			}
			else {
				$regular_variant = array_search( 'regular', $font['variants'] );
				if( $regular_variant !== false ) {
					$font['variants'][$regular_variant] = '400';
				}
				$font_element[] = $font_name . ':' . implode( ',', $font['variants'] );
			}
		}
		$subsets = ( empty( $subsets ) ) ? array('latin') : array_unique( $subsets );
		$subset_string = implode( ',', $subsets );

		$font_string = implode( '|', $font_element );

		$subset_string = '';
		$request = 'http://fonts.googleapis.com/css?family=' . $font_string . '&subset=' . $subset_string;

		wp_enqueue_style( 'acfgfs-enqueue-fonts', $request );


	}

}


// create field
new acf_field_google_font_selector();

?>
