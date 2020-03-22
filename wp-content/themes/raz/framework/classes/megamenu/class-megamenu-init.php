<?php if ( ! defined( 'ABSPATH' ) ) { die; }

if(!class_exists('Raz_MegaMenu_Init')){
    
    class Raz_MegaMenu_Init{

        protected $fields = array();

        protected $default_metakey = '';

        public function __construct() {

            $query_args = array(
                'post_type'         => 'elementor_library',
                'orderby'           => 'title',
                'order'             => 'ASC',
                'posts_per_page'    => -1
            );

            $this->default_metakey = '_mm_meta';
            $this->fields = array(
                'icon' => array(
                    'id'    => 'icon',
                    'type'  => 'icon',
                    'title' => esc_html__('Custom Icon','raz')
                ),
                'only_icon' => array(
                    'id'    => 'only_icon',
                    'type'  => 'switcher',
                    'title' => esc_html__("Show Only Icon",'raz')
                ),
                'menu_type' => array(
                    'id'    => 'menu_type',
                    'type'  => 'select',
                    'title' => esc_html__('Menu Type','raz'),
                    'options' => array(
                        'narrow'      => esc_html__('Narrow','raz'),
                        'wide'  => esc_html__('Wide','raz')
                    ),
                    'default' => 'narrow'
                ),
                'force_full_width' => array(
                    'id'    => 'force_full_width',
                    'type'  => 'switcher',
                    'title' => esc_html__('Force Full Width','raz'),
                    'info' => esc_html__('Set 100% window width for popup','raz')
                ),
                'popup_max_width' => array(
                    'id'    => 'popup_max_width',
                    'type'  => 'number',
                    'title' => esc_html__('Popup Max Width','raz'),
                    'after' => 'px',
                    'wrap_class' => 'la-element-popup-max-width'
                ),
                'popup_column' => array(
                    'id'    => 'popup_column',
                    'type'  => 'select',
                    'title' => esc_html__('Popup Columns','raz'),
                    'options' => array(
                        '1'         => esc_html__('1 Column','raz'),
                        '2'         => esc_html__('2 Columns','raz'),
                        '3'         => esc_html__('3 Columns','raz'),
                        '4'         => esc_html__('4 Columns','raz'),
                        '5'         => esc_html__('5 Columns','raz'),
                        '6'         => esc_html__('6 Columns','raz')
                    ),
                    'default'   => '4'
                ),
                'item_column' => array(
                    'id'    => 'item_column',
                    'type'  => 'text',
                    'title' => esc_html__('Columns','raz'),
                    'desc' => esc_html__('will occupy x columns of parent popup columns', 'raz')
                ),
                'block' => array(
                    'id'            => 'block',
                    'type'           => 'select',
                    'title'         => esc_html__('Custom Block Before Menu Item','raz'),
                    'options'       => 'posts',
                    'query_args'    => $query_args,
                    'default_option' => esc_html__('Select a block','raz')
                ),
                'block2' => array(
                    'id'            => 'block2',
                    'type'          => 'select',
                    'title'         => esc_html__('Custom Block After Menu Item','raz'),
                    'options'       => 'posts',
                    'query_args'    => $query_args,
                    'default_option' => esc_html__('Select a block','raz')
                ),
                'popup_background' => array(
                    'id'           => 'popup_background',
                    'type'         => 'background',
                    'title' 	   => esc_html__('Popup Background','raz')
                ),
                'tip_label' => array(
                    'id'        => 'tip_label',
                    'type'      => 'text',
                    'title' 	=> esc_html__('Tip Label','raz')
                ),
                'tip_color' => array(
                    'id'        => 'tip_color',
                    'type'      => 'color_picker',
                    'title' 	=> esc_html__('Tip Color','raz')
                ),
                'tip_background_color' => array(
                    'id'        => 'tip_background_color',
                    'type'      => 'color_picker',
                    'title' 	=> esc_html__('Tip Background','raz')
                )
            );

            $this->load_hooks();
        }

        private function load_hooks(){
            add_action( 'wp_loaded',                        array( $this, 'load_walker_edit' ), 9);
            add_filter( 'wp_setup_nav_menu_item',           array( $this, 'setup_nav_menu_item' ));
            add_action( 'wp_nav_menu_item_custom_fields',   array( $this, 'add_megamu_field_to_menu_item' ), 10, 4);
            add_action( 'wp_update_nav_menu_item',          array( $this, 'update_nav_menu_item' ), 10, 3);
            add_filter( 'nav_menu_item_title',              array( $this, 'add_icon_to_menu_item' ),10, 4);
        }

        public function load_walker_edit() {
            add_filter( 'wp_edit_nav_menu_walker', array( $this, 'detect_edit_nav_menu_walker' ), 99 );
        }

        public function detect_edit_nav_menu_walker( $walker ) {
            $walker = 'Raz_MegaMenu_Walker_Edit';
            return $walker;
        }

        public function setup_nav_menu_item($menu_item){
            $meta_value = Raz()->settings()->get_post_meta($menu_item->ID, '', $this->default_metakey, true);
            foreach ( $this->fields as $key => $value ){
                $menu_item->$key = isset($meta_value[$key]) ? $meta_value[$key] : '';
            }
            return $menu_item;
        }

        public function update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_args ) {
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                return;
            }
            check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

            $key = $this->default_metakey;

            if ( ! empty( $_POST[$key][$menu_item_db_id] ) ) {
                $value = $_POST[$key][$menu_item_db_id];
            }
            else {
                $value = null;
            }

            if(!empty($value)){
                update_post_meta( $menu_item_db_id, $key, $value );
            }
            else {
                delete_post_meta( $menu_item_db_id, $key );
            }
        }

        public function add_megamu_field_to_menu_item( $id, $item, $depth, $args ) {
            if(function_exists('la_fw_add_element')){
                ?><div class="lastudio-megamenu-settings description-wide la-content">
                <h3><?php esc_html_e('MegaMenu Settings','raz');?></h3>
                <div class="lastudio-megamenu-custom-fields">
                    <?php
                    foreach ( $this->fields as $key => $field ) {
                        $unique     = $this->default_metakey . '['.$item->ID.']';
                        $default    = ( isset( $field['default'] ) ) ? $field['default'] : '';
                        $elem_id    = ( isset( $field['id'] ) ) ? $field['id'] : '';

                        $field['name'] = $unique. '[' . $elem_id . ']';
                        $field['id'] = $elem_id . '_' . $item->ID;
                        $elem_value =  isset($item->$key) ? $item->$key : $default;
                        echo la_fw_add_element( $field, $elem_value, $unique );
                    }
                    ?>
                </div>
                </div><?php
            }
        }

        public function add_icon_to_menu_item($output, $item, $args, $depth){
            if ( !is_a( $args->walker, 'Raz_MegaMenu_Walker' ) && $item->icon){
                $icon_class = 'mm-icon ' . $item->icon;
                $icon = "<i class=\"".esc_attr($icon_class)."\"></i>";
                $output = $icon . $output;
            }
            return $output;
        }
    }
}