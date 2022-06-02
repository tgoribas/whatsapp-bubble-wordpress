<?php
/**
 * Plugin Name: WhatsApp Bubble
 * Description: Mostrar uma 'Bubble' com o link do WhatsApp.
 * Version: 0.9.3
 * Author: Tiago Ribas | tgoribas@gmail.com
 * Author URI: https://www.tiagoribas.com
 */

/**
 * Função de teste
 *
 * @return void
 */


if (!defined('ABSPATH')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'includes/whatsapp-bubble-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/whatsapp-bubble-frontend.php';
