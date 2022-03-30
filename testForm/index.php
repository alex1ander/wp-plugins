<?php
/*
Plugin Name: TestForm
*/



//создание таблицы

function add_orderTabel() {
   global $wpdb;

   $table_name = $wpdb->prefix . "test_orders";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
	    name tinytext NOT NULL,
	    email text NOT NULL,
	    number varchar(15) NOT NULL,
        date DATETIME  NOT NULL,
        UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

   }
}
register_activation_hook(__FILE__,'add_orderTabel');


//вывод информации в админке
add_action( 'admin_menu', 'add_menu_info', 25 );

function add_menu_info(){
 
	add_menu_page(
		'Заявки', // тайтл страницы
		'Все заявки', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'test_ordres', // ярлык страницы
		'test_order', // функция, которая выводит содержимое страницы
		'dashicons-format-chat', // иконка, в данном случае из Dashicons
		20 // позиция в меню
	);
}
 
function test_order(){
    
    global $wpdb;
    $first = $wpdb->get_results( 
        "
        SELECT * FROM `wp_test_orders`
        "
    );

    $column = $wpdb->get_results( 
        "
        SELECT *
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = N'Customers'
        "
    ); ?>

    <table class="testFormTabel">
        <thead>
		    <tr>
			    <th>ID</th>
			    <th>Имя</th>
			    <th>Почта</th>
			    <th>Номер телефона</th>
			    <th>Дата</th>
		    </tr>
	    </thead>
        <tbody>
        <? foreach ( $first as $second ) : ?>
            <tr>
            <? foreach ( $second as $third ) : ?>
              <td>
              <?= $third ?>
              </td>
            <? endforeach; ?>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table><?

}

//стили админки
function admin_plugin_styles() {
	wp_register_style( 'newcss-plugin', plugins_url( 'testForm/myadmin.css' ) );
	wp_enqueue_style( 'newcss-plugin' );
}
add_action('admin_enqueue_scripts', 'admin_plugin_styles');


//стили формы

add_action( 'wp_enqueue_scripts', 'style_testForm' );

function style_testForm() {
	wp_register_style( 'newcss-plugin', plugins_url( '/testForm.css', __FILE__ ) );
	wp_enqueue_style( 'newcss-plugin' );
}

//шорткод [testForm]
add_shortcode( 'testForm', 'add_shortkode_testForm' );

function add_shortkode_testForm() {
	ob_start();
    load_template( dirname( __FILE__ ) . '\form.php');
    $formOutput = ob_get_contents();
    ob_get_clean();
    return $formOutput;
}

