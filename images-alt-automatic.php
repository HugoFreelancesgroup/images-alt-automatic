<?php
/**
 * Plugin Name: Images Alt Automatic
 * Plugin URI: https://freelancesgroup.com
 * Description: Plugin para colocar el Alt del nombre del archivo 
 * Version: 1.10
 * Author: Freelances Group
 * Author URI: https://freelancesgroup.com
 * Text Domain: images-alt-automatic
 */

// ==============================================
// Plugin Update Checker
require plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';

$updateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/TU_USUARIO/TU_REPOSITORIO',
    __FILE__,
    'images-alt-automatic'
);

$updateChecker->setBranch('main');
// ==============================================


 /* Automatizar atributos alt, title, leyenda y description al subir imagenes */
add_action( 'add_attachment', 'ayudawp_atributos_imagen_auto' );
function ayudawp_atributos_imagen_auto( $post_ID ) {
// Comprobamos si el archivo subido es imagen, sino no hacemos nada
if ( wp_attachment_is_image( $post_ID ) ) {
$my_image_title = get_post( $post_ID )->post_title;
// Saneamos el nombre de archivo:  quitamos guiones, guiones bajos, espacios, subrayados, etc
$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );
// Capitalizamos la primera letra de cada palabra, si quieres, sino borra la siguiente linea o comentala como esta
$my_image_title = ucwords( strtolower( $my_image_title ) );
// Creamos un array con los datos meta de imagen para actualizarlos
// Nota:  comenta el extracto/leyenda/contenido/descripcion o lo que sea si no lo necesitas
$my_image_meta = array(
'ID' => $post_ID, // Specify the image (ID) to be updated
//'post_title' => $my_image_title, // Convertimos el nombre de archivo saneado en el titulo
//'post_excerpt' => $my_image_title, // Convertimos el nombre de archivo saneado en la leyenda
//'post_content' => $my_image_title, // Convertimos el nombre de archivo saneado en la descripcion
);
// Creamos el texto ALT
update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );
// Creamos los meta de la imagen: titulo, extracto, contenido
wp_update_post( $my_image_meta );
} 
}