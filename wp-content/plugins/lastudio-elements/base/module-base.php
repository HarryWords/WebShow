<?php
namespace Lastudio_Elements\Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Module_Base {

	/**
	 * @var \ReflectionClass
	 */
	private $reflection;

	private $components = [];

	/**
	 * @var Module_Base
	 */
	protected static $_instances = [];

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'lastudio-elements' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'lastudio-elements' ), '1.0.0' );
	}

	public static function is_active() {
		return true;
	}

	public static function class_name() {
		return get_called_class();
	}

	/**
	 * @return static
	 */
	public static function instance() {
		if ( empty( static::$_instances[ static::class_name() ] ) ) {
			static::$_instances[ static::class_name() ] = new static();
		}

		return static::$_instances[ static::class_name() ];
	}

	abstract public function get_name();

	public function get_widgets() {
		return [];
	}

	public function __construct() {
		$this->reflection = new \ReflectionClass( $this );

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
	}

	public function init_widgets() {
		$widget_manager = \Elementor\Plugin::instance()->widgets_manager;

		foreach ( $this->get_widgets() as $widget ) {
            $widget_name = strtolower( $widget );
			$widget_filename = 'lastudio-' . str_replace( '_', '-', $widget_name );
            
            if ( $this->is_widget_active( $widget_filename ) ) {
                $class_name = $this->reflection->getNamespaceName() . '\Widgets\\' . $widget;
                $widget_manager->register_widget_type( new $class_name() );
            }
		}
	}
    
    public static function is_widget_active( $widget = '' ) {

    	if($widget == 'lastudio-products' || $widget == 'lastudio-contact-form7'){
	        return true;
        }

        $enabled_modules = lastudio_elements_get_enabled_modules();

        if ( !empty($widget) && in_array( $widget, $enabled_modules ) ) {
            return true;
        }
        return false;
    }
}
