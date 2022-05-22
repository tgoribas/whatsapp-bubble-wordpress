<?php

function whatsAppBubble()
{

    register_setting(
        'groupWhatsAppBubble',
        'whatsBubbleTel',
        [ 'sanitize_callback' => 'sanitize_phone' ]
    );

    register_setting(
        'groupWhatsAppBubble',
        'whatsBubbleMsg',
        [ 'sanitize_callback' => 'sanitize_message' ]
    );

    register_setting(
        'groupWhatsAppBubble',
        'whatsBubbleBtn',
        [ 'sanitize_callback' => 'sanitize_button' ]
    );

    register_setting(
        'groupWhatsAppBubble',
        'whatsBubbleTitle',
        [ 'sanitize_callback' => 'sanitize_titleBtn' ]
    );

    // Adicionando seçãoo
    add_settings_section(
        'section_whatsAppBubble',
        'Dados do WhatsApp',
        function () {
           echo "<p>Insira as informações com os dados de telefone e mensagem.</p>";
        },
        'groupWhatsAppBubble'
    );

    add_settings_field(
        'whatsBubbleTel',
        'Número de telefone',
        function ($args) {
            $options = get_option('whatsBubbleTel');
            ?>
            <input id="<?php echo $args['label_for']; ?>" type="text" name="whatsBubbleTel" value="<?php echo esc_attr( $options );?>" required>
            <p class="description" id="tagline-description">Seu Número de telefone.</p>
            <?php
        },
        'groupWhatsAppBubble',
        'section_whatsAppBubble',
        [
            'label_for' => 'id_whatsBubbleTel',
            'class'     => 'tr_whatsBubbleTel'
        ]
    );

    add_settings_field(
        'whatsBubbleMsg',
        'Mensagem de texto',
        function ($args) {
            $options = get_option('whatsBubbleMsg');
            ?>
            <input id="<?php echo $args['label_for']; ?>" type="text" name="whatsBubbleMsg" value="<?php echo esc_attr( $options );?>" style="width: 550px;" >
            <p class="description" id="tagline-description">Insira sua Mensagem, máximo de 120 caracteres.</p>
            <?php
        },
        'groupWhatsAppBubble',
        'section_whatsAppBubble',
        [
            'label_for' => 'id_whatsBubbleMsg',
            'class'     => 'tr_whatsBubbleMsg'
        ]
    );

    add_settings_field(
        'whatsBubbleTitle',
        'Titulo do Botão',
        function ($args) {
            $options = get_option('whatsBubbleTitle');
            ?>
            <input id="<?php echo $args['label_for']; ?>" type="text" name="whatsBubbleTitle" value="<?php echo esc_attr( $options );?>" style="width: 550px;" >
            <p class="description" id="tagline-description">Insira o title do botão, máximo de 25 caracteres.</p>
            <?php
        },
        'groupWhatsAppBubble',
        'section_whatsAppBubble',
        [
            'label_for' => 'id_whatsBubbleTitle',
            'class'     => 'tr_whatsBubbleTitle'
        ]
    );

    add_settings_field(
        'whatsBubbleBtn',
        'Estilo do Botão',
        function ($args) {
            $options = get_option('whatsBubbleBtn');
            ?>
            <input type="radio" id="btn_float" name="whatsBubbleBtn" value="float" <?php echo (esc_attr($options) == 'float')? 'checked' : '' ; ?> >
            <label for="btn_float">Float (Icone Flutuante)</label><br>
            <input type="radio" id="btn_bar" name="whatsBubbleBtn" value="bar" <?php echo (esc_attr($options) == 'bar')? 'checked' : '' ; ?>  >
            <label for="btn_bar">Barra</label><br>
            <?php
        },
        'groupWhatsAppBubble',
        'section_whatsAppBubble',
        [
            'label_for' => 'id_whatsBubbleBtn',
            'class'     => 'tr_whatsBubbleBtn'
        ]
    );
}


/**
 * Funçñao para adicionar o WhatsApp Bubble no Menu 'Aparência'
 *
 * @return void
 */
function addMenu_WhatsAppBubble() {
    add_theme_page(
        'WhatsApp Bubble',
        'WhatsApp Bubble',
        'edit_theme_options',
        'whatsapp-bubble',
        'whatsAppBubble_HTMLAdmin'
    );
}

/**
 * Funão para adicionar HTML na pagina do Plugin
 *
 * @return void
 */
function whatsAppBubble_HTMLAdmin(){
    echo '
    <div class="wrap">
        <h1>' . esc_html( get_admin_page_title()) . '</h1>
        <form action="options.php" method="POST">';
            // Print message Errors
            settings_errors();
            settings_fields('groupWhatsAppBubble');
            do_settings_sections('groupWhatsAppBubble');
            submit_button();
            echo'
        </form>
    </div>
    ';
}

/**
 * Função que prepara o número de telefone para o whatsapp
 *
 * @param [type] $phone
 * @return void
 */
function sanitize_phone($phone)
{

    // Remove todas os caracteres e letras do Telefone
    $phone = preg_replace("/[^0-9]/", "", $phone);

    // Verifica que é numerico e é menor que 30 caracteres
    if (is_numeric($phone) && strlen($phone) < 30) {
        // return $phone;
    } else {
        // Prepara Mensagem de Erro
        add_settings_error(
            'whatsBubbleTel',
            esc_attr('whatsBubbleTel_error'),
            'Número de telefone invalido',
            'error'
        );
        $phone =  get_option('whatsBubbleTel');
    }

    return $phone;
}

/**
 * Função que prepara a mensagem de texto
 *
 * @param [type] $phone
 * @return void
 */
function sanitize_message($message)
{
    $message = sanitize_text_field($message);
    if (strlen($message) > 120) {
        // Prepara Mensagem de Erro
        add_settings_error(
            'whatsBubbleMsg',
            esc_attr('whatsBubbleMsg_error'),
            'Mensagem de Texto Inválida',
            'error'
        );
        $message = get_option('whatsBubbleMsg');
    }
    return $message;
}

/**
 * Função que prepara a mensagem de texto
 *
 * @param [type] $title
 * @return void
 */
function sanitize_titleBtn($title)
{
    $title = sanitize_text_field($title);
    if (strlen($title) > 25) {
        // Prepara Mensagem de Erro
        add_settings_error(
            'whatsBubbleTitle',
            esc_attr('whatsBubbleTitle_error'),
            'Titulo do botão Inválidao',
            'error'
        );
        $title = get_option('whatsBubbleTitle');
    }
    return $title;
}

/**
 * Função que prepara estilo do botão
 *
 * @param [type] $phone
 * @return void
 */
function sanitize_button($button)
{
    if ($button == "float" || $button == "bar") {
        // return $button;
    } else {
        // Prepara Mensagem de Erro
        add_settings_error(
            'whatsBubbleBtn',
            esc_attr('whatsBubbleBtn_error'),
            'Erro ao salvar o estilo do botão',
            'error'
        );
        $button = get_option('whatsBubbleBtn');
    }

    return $button;
}
add_action('admin_init', 'whatsappBubble');
add_action('admin_menu','addMenu_WhatsAppBubble');
?>