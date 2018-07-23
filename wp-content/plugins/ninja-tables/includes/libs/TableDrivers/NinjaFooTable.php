<?php namespace NinjaTable\TableDrivers;

class NinjaFooTable {
	public static $version = NINJA_TABLES_VERSION;

	public static function run( $tableArray ) {

		$styleSrc = NINJA_TABLES_DIR_URL . "assets/css/ninjatables-public.css";

		if ( is_rtl() ) {
			$styleSrc = NINJA_TABLES_DIR_URL . "assets/css/ninjatables-public-rtl.css";
		}
        
		wp_enqueue_style(
			'footable_styles',
			$styleSrc,
			array(),
			self::$version,
			'all'
		);
		
		$customCss = get_post_meta($tableArray['table_id'], '_ninja_tables_custom_css', true);
		if($customCss) {
		    add_action('wp_footer', function () use ($customCss) {
		       echo "<style>". $customCss ."</style>";
            });
        }
		
		self::render( $tableArray );
		
		self::enqueue_assets();
	}

	private static function enqueue_assets() {

		wp_enqueue_script( 'footable',
			NINJA_TABLES_PUBLIC_DIR_URL . "libs/footable/js/footable.min.js",
			array( 'jquery' ), '3.1.5', true );

		wp_enqueue_script( 'footable_init',
			NINJA_TABLES_DIR_URL . "assets/js/ninja-tables-footable.".NINJA_TABLES_ASSET_VERSION.".js",
			array( 'footable' ), self::$version, true );

		wp_localize_script( 'footable_init', 'ninja_footables', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'tables'   => array(),
			'i18n'     => array(
				'search_in'  => __( 'Search in', 'ninja-tables' ),
				'search'     => __( 'Search', 'ninja-tables' ),
				'empty_text' => __( 'No Result Found', 'ninja-tables' ),
			)
		) );
	}

	private static function render( $tableArray ) {
	    
		extract( $tableArray );
		if ( ! count( $columns ) ) {
			return;
		}
		
		$renderType = 'ajax_table';
		if ( isset( $settings['render_type'] ) && $settings['render_type'] ) {
			$renderType = $settings['render_type'];
		}
		
		$formatted_columns = array();
		$sortingType       = ( isset( $settings['sorting_type'] ) ) ? $settings['sorting_type'] : 'by_created_at';

		$globalSorting = ( isset( $settings['column_sorting'] ) )
			? (bool) $settings['column_sorting'] : false;

		$customCss = array();
		
		foreach ( $columns as $index => $column ) {
			$columnType       = self::getColumnType( $column );
			
			$cssColumnName = 'ninja_column_'.$index;
			
			$columnClasses = array($cssColumnName);
			if(isset($column['classes'])) {
				$userClasses = explode( ' ', $column['classes'] );
				$columnClasses = array_unique(array_merge($columnClasses, $userClasses));
            }

			$customCss[$cssColumnName] = array();
			if(isset($column['width']) && $column['width']) {
				$customCss[$cssColumnName]['width'] = $column['width'].'px';
            }
            
            if((isset($column['textAlign']) && $column['textAlign'])) {
	            $customCss[$cssColumnName]['textAlign'] = $column['textAlign'];
            }
            $columnTitle = $column['name'];
			if(isset($column['enable_html_content']) && $column['enable_html_content'] == 'true') {
			    if(isset($column['header_html_content'])) {
				    $columnTitle = do_shortcode($column['header_html_content']);
                }
            }
            
			$formatted_column = array(
				'name'        => $column['key'],
				'title'       => $columnTitle,
				'breakpoints' => $column['breakpoints'],
				'type'        => $columnType,
				'sortable'    => $globalSorting,
				'visible'     => ( $column['breakpoints'] == 'hidden' ) ? false : true,
				'classes'     => $columnClasses
			);
            
			if ( $columnType == 'date' ) {
				wp_enqueue_script(
					'moment',
					NINJA_TABLES_DIR_URL . "public/libs/moment/moment.min.js",
					[],
					'2.22.0',
					true
				);

				$formatted_column['formatString'] = $column['dateFormat'] ?: 'MM/DD/YYYY';
			}

			if ( $sortingType == 'by_column' && $column['key'] == $settings['sorting_column'] ) {
				$formatted_column['sorted']    = true;
				$formatted_column['direction'] = $settings['sorting_column_by'];
			}

			$formatted_columns[] = apply_filters( 'ninja_table_column_attributes', $formatted_column, $column,
				$table_id, $tableArray );
		}
		
		if ( $settings['show_all'] ) {
			$pagingSettings = false;
		} else {
			$pagingSettings = ( $settings['perPage'] ) ? $settings['perPage']
				: 20;
		}

		$enableSearch = ( isset( $settings['enable_search'] ) )
			? $settings['enable_search'] : false;

		$default_sorting = false;
		if($sortingType == 'manual_sort') {
		    $default_sorting = 'manual_sort';
        } else if(isset( $settings['default_sorting'] )) {
			$default_sorting = $settings['default_sorting'];
        }
		
		$configSettings = array(
			'filtering'       => $enableSearch,
			'paging'          => $pagingSettings,
			'sorting'         => true,
			'default_sorting' => $default_sorting,
			'defualt_filter'  => isset( $default_filter ) ? $default_filter : false,
            'expandFirst' => (isset($settings['expand_type']) && $settings['expand_type'] == 'expandFirst') ? true : false,
            'expandAll' => (isset($settings['expand_type']) && $settings['expand_type'] == 'expandAll') ? true : false,
			'i18n'     => array(
				'search_in'  => (isset($settings['search_in_text'])) ? sanitize_text_field($settings['search_in_text']) : __( 'Search in', 'ninja-tables' ),
				'search'  => (isset($settings['search_placeholder'])) ? sanitize_text_field($settings['search_placeholder']) : __( 'Search', 'ninja-tables' ),
				'no_result_text'  => (isset($settings['no_result_text'])) ? sanitize_text_field($settings['no_result_text']) : __( 'No Result Found', 'ninja-tables' ),
			)
		);

		$table_classes = self::getTableCssClass( $settings );

		$tableHasColor = '';

		if ( isset( $settings['table_color'] ) && $settings['table_color']
		     && $settings['table_color'] != 'ninja_no_color_table'
		) {
			$tableHasColor = 'colored_table';
			$table_classes .= ' inverted';
		}

		if ( isset( $settings['hide_all_borders'] ) && $settings['hide_all_borders'] ) {
			$table_classes .= ' hide_all_borders';
		}

		if ( isset( $settings['hide_header_row'] ) && $settings['hide_header_row'] ) {
			$table_classes .= ' ninjatable_hide_header_row';
		}

		if ( ! $enableSearch ) {
			$table_classes .= ' ninja_table_search_disabled';
		}

		if ( defined( 'NINJATABLESPRO' ) ) {
			$table_classes .= ' ninja_table_pro';
        }
		
        $table_inline_css = '';
        
		if ( isset( $settings['table_color'] ) && $settings['table_color'] == 'ninja_table_custom_color' ) {
			$table_color_primary   = isset( $settings['table_color_primary'] ) ? $settings['table_color_primary'] : '';
			$table_color_secondary = isset( $settings['table_color_secondary'] ) ? $settings['table_color_secondary']
				: '';
			if ( $table_color_primary && $table_color_secondary ) {
				$table_inline_css = 'background-color: ' . $table_color_primary . ';color: ' . $table_color_secondary . ';border: none;';
			}
		}

		$table_vars = array(
			'table_id'    => $table_id,
			'columns'     => $formatted_columns,
			'settings'    => $configSettings,
			'render_type' => $renderType,
            'custom_css' => $customCss
		);
		
		self::addInlineVars( json_encode( $table_vars, true ), $table_id );

		$foo_table_attributes = self::getFootableAtrributes( $table_id );
		?>
        <div id="footable_parent_<?php echo $table_id; ?>"
             class="footable_parent ninja_table_wrapper loading_ninja_table wp_table_data_press_parent <?php echo $settings['css_lib']; ?> <?php echo $tableHasColor; ?>">
			<?php if ( isset( $settings['show_title'] )
			           && $settings['show_title']
			) : ?>
				<?php do_action( 'ninja_tables_before_table_title', $table ); ?><h3
                        class="table_title footable_title"><?php echo esc_attr( $table->post_title ); ?></h3>
				<?php do_action( 'ninja_tables_after_table_title', $table ); ?>
			<?php endif; ?>
			<?php if ( isset( $settings['show_description'] )
			           && $settings['show_description']
			) : ?>
				<?php do_action( 'ninja_tables_before_table_description',
					$table ); ?>
                <div class="table_description footable_description"><?php echo wp_kses_post( $table->post_content ); ?></div>
				<?php do_action( 'ninja_tables_after_table_description',
					$table ); ?>
			<?php endif; ?>
			<?php do_action( 'ninja_tables_before_table_print', $table ); ?>
            <table style="<?php echo $table_inline_css; ?>" <?php echo $foo_table_attributes; ?>
                   id="footable_<?php echo intval( $table_id ); ?>"
                   class=" foo-table ninja_footable foo_table_<?php echo intval( $table_id ); ?> <?php echo esc_attr( $table_classes ); ?>">
				   <colgroup>
						<?php foreach ($formatted_columns as $index => $column) { ?>
							<col class="ninja_column_<?php echo $index.' '.$column['breakpoints']; ?> "></col>
						<?php } ?>
					</colgroup>
				   <?php do_action( 'ninja_tables_inside_table_render',
					$table, $table_vars ); ?>
					</table>
			<?php do_action( 'ninja_tables_after_table_print', $table ); ?>
        </div>
		<?php
	}

	public static function getTableHTML( $table, $table_vars ) {
	    
		if ( $table_vars['render_type'] == 'ajax_table' ) {
			return;
		}
		if ( $table_vars['render_type'] == 'legacy_table' ) {
			self::generateLegacyTableHTML( $table, $table_vars );
			return;
		}
	}

	private static function generateLegacyTableHTML( $table, $table_vars ) {
		$disableCache = apply_filters( 'ninja_tables_disable_caching', false, $table->ID );

		$tableHtml = get_post_meta( $table->ID, '_ninja_table_cache_html', true );
		
		if ( $tableHtml && ! $disableCache ) {
			echo $tableHtml;
			return;
		}
		$tableColumns     = $table_vars['columns'];
		$formattedColumns = array();
		$formatted_data   = ninjaTablesGetTablesDataByID( $table->ID, $table_vars['settings']['default_sorting'] );
		$tableHtml        = self::loadView( 'public/views/table_inner_html', array(
			'table_columns' => $tableColumns,
			'table_rows'    => $formatted_data
		) );

		if ( ! $disableCache ) {
			update_post_meta( $table->ID, '_ninja_table_cache_html', $tableHtml );
		}
		echo do_shortcode($tableHtml);
		return;
	}

	private static function loadView( $file, $data ) {
		$file = NINJA_TABLES_DIR_PATH . $file . '.php';
		ob_start();
		extract( $data );
		include $file;
		return ob_get_clean();
	}

	private static function getTableCssClass( $settings ) {
		$baseClass      = self::getTableClassByLib( $settings['css_lib'] );
		$userClass      = ( isset( $settings['extra_css_class'] ) )
			? $settings['extra_css_class'] : '';
		$colorClass     = ( isset( $settings['table_color'] ) )
			? $settings['table_color'] : '';
		$definedClass   = implode( ' ', $settings['css_classes'] );
		$concatClasses  = $baseClass . ' ' . $userClass . ' ' . $definedClass
		                  . ' ' . $colorClass;
		$classArray     = explode( ' ', $concatClasses );
		$uniqueCssArray = array_unique( $classArray );

		return implode( ' ', $uniqueCssArray );
	}

	private static function getTableClassByLib( $lib = 'bootstrap3' ) {
		switch ( $lib ) {
			case 'bootstrap3':
			case 'bootstrap4':
				return 'table';
			case 'semantic_ui':
				return 'ui table';
			default:
				return '';
		}
	}

	private static function addInlineVars( $vars, $table_id ) {

		add_action( 'wp_footer', function () use ( $vars, $table_id ) {
			?>
            <script type="text/javascript">
                window.ninja_footables_tables_<?php echo $table_id;?> = <?php echo $vars ?>;
            </script>
			<?php
		} );
	}

	public static function getColumnType( $column ) {
		$type          = ( isset( $column['data_type'] ) ) ? $column['data_type'] : 'text';
		$acceptedTypes = array(
			'text',
			'number',
			'date',
			'html'
		);

		if ( in_array( $type, $acceptedTypes ) ) {
			return $type;
		}

		return 'text';
	}

	private static function getFootableAtrributes( $tableID ) {
		$atts = array(
			'data-footable_id' => $tableID,
		);

		$atts_string = '';
		foreach ( $atts as $att_name => $att ) {
			$atts_string .= $att_name . '="' . $att . '"';
		}

		return (string) $atts_string;
	}
}
