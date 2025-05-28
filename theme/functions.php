<?php

// ENQUEUE SCRIPTS & STYLES
// Enqueue des scripts et styles
if (!function_exists('mmi_enqueues')) {
    function mmi_enqueues()
    {
        // Récupère les données du thème (version)
        $theme = wp_get_theme();
        $theme_version = $theme->get('Version');
        global $post;

        // Chargement des fichiers CSS et JS
        // Chargement de Tailwind CSS depuis un CDN
        wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, 'all');
        
        // Enregistrement et chargement des polices Google Fonts
        wp_register_style('google-paytone', 'https://fonts.googleapis.com/css2?family=Paytone+One&display=swap', array(), null, 'all');
        wp_register_style('google-ubuntu', 'https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap', array(), null, 'all');
        
        // Enqueue des styles (Paytone One et Ubuntu)
        wp_enqueue_style('google-paytone');
        wp_enqueue_style('google-ubuntu');
        
        // Enqueue des styles principaux du thème
        wp_enqueue_style('main-css', get_template_directory_uri() . '/dist/style.css', array(), 1.0);
        wp_enqueue_style('prose-css', get_template_directory_uri() . '/dist/prose.css', array(), 1.0);

        // Enqueue un fichier JavaScript pour AJAX (interaction dynamique)
        wp_enqueue_script('ajax-projects', get_template_directory_uri() . '/dist/scriptajax.js', array('jquery'), '1.0', true);
        
        // Localisation du script pour l'URL de l'admin-ajax
        wp_localize_script('ajax-projects', 'adminAjax', admin_url('admin-ajax.php'));
    }
}
add_action('wp_enqueue_scripts', 'mmi_enqueues');



// Style pour la page de connexion
function mmi_enqueues_login()
{
    // Enqueue un style spécifique pour la page de connexion
    wp_enqueue_style('login-page', get_template_directory_uri() . '/dist/style-login.css', array('login'));
}
add_action('login_enqueue_scripts', 'mmi_enqueues_login');


// Fonction pour rediriger le logo de la page de connexion vers l'accueil
function mmi_custom_login_logo_url()
{
    return home_url(); // Redirige vers la page d'accueil de votre site
}
add_filter('login_headerurl', 'mmi_custom_login_logo_url');



// ENREGISTREMENT DES EMPLACEMENTS MENUS
function mmi_theme_register_menus()
{
    // Enregistrement de deux emplacements de menus : un principal et un pour le footer
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal', 'mmi-theme'),
        'menu-footer'    => __('Menu Pied de page', 'mmi-theme'),
    ));
}
add_action('init', 'mmi_theme_register_menus');


// Ajout de support pour certaines fonctionnalités du thème
function mmi_theme_support()
{
    // Support pour le logo personnalisé
    add_theme_support('custom-logo');
    // Support pour l'icône du site (favicon)
    add_theme_support('site-icon');
    // Support pour les images à la une (post-thumbnails)
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mmi_theme_support');


// Enregistrement d'une barre latérale pour le footer
register_sidebar(array(
    'id' => 'main-footer',
    'name' => 'Footer principal',
    'description' => 'SideBar pour mon site Workflow'
));


// SHORTCODE POUR LE COPYRIGHT
function mmi_current_year($atts)
{
    // Récupère l'année actuelle
    $year = date('Y');

    // Permet de personnaliser l'apparence avec une classe CSS si nécessaire
    $atts = shortcode_atts(array(
        'class' => '',
    ), $atts, 'current-year');

    // Génère le HTML avec la classe CSS si elle est fournie
    $output = '<span class="' . esc_attr($atts['class']) . '">' . esc_html($year) . '</span>';

    return $output; // Retourne l'année actuelle avec la classe
}
add_shortcode('current-year', 'mmi_current_year');




// DISPLAY DES 3 DERNIERS PROJETS
function mmi_query_projects($atts)
{
    // Attributs par défaut pour le shortcode
    $atts = shortcode_atts(array(
        'project' => 'project',  // Type de contenu à afficher
        'posts' => 3,            // Nombre de projets à afficher
        'post_status' => 'publish'  // Statut des publications
    ), $atts, 'latest-projects');

    // Début de la capture de contenu
    ob_start();

    // Requête pour récupérer les projets récents
    $recent_projects = new WP_Query([
        'post_type' => $atts['project'],
        'posts_per_page' => $atts['posts'],
        'post_status' =>  $atts['post_status'],
    ]);

    // Si des projets sont trouvés
    if ($recent_projects->have_posts()) :
        while ($recent_projects->have_posts()) : $recent_projects->the_post();
            // Chargement du template 'card-project.php' pour chaque projet
            get_template_part('card', 'project');
        endwhile;
    else :
        // Si aucun projet trouvé, affiche un message
        echo '<p>Aucun projet trouvé.</p>';
    endif;

    // Réinitialise les données de la requête
    wp_reset_postdata();

    // Capture du contenu généré et nettoyage du buffer
    $html = ob_get_contents();
    ob_end_clean();

    return $html; // Retourne les projets ou le message d'absence de projet
}
add_shortcode('latest-projects', 'mmi_query_projects');




// RECUPERE LES PROJETS DE DEVELOPPEMENT BACK
function mmi_taxo()
{
    // Récupérer le terme de taxonomie passé via AJAX
    $taxonomy_term = isset($_POST['taxonomy_term']) ? sanitize_text_field($_POST['taxonomy_term']) : '';

    // Vérifier que le terme est fourni
    if (empty($taxonomy_term)) {
        wp_send_json_error('Aucun terme de taxonomie spécifié', 400);
        wp_die();
    }

    // Paramètres de la requête pour récupérer les projets associés à un terme de taxonomie
    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => 9,
        'ignore_sticky_posts' => 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'attributs',  // Taxonomie à utiliser
                'field'    => 'slug',       // Recherche par slug
                'terms'    => $taxonomy_term,  // Terme de taxonomie spécifique
            )  
        )
    );

    // Création de la requête WP
    $query = new WP_Query($args);

    // Si des projets sont trouvés
    if ($query->have_posts()) {

        $html = ''; // Variable pour stocker le HTML des projets

        // Boucle sur les résultats et génération du HTML
        while ($query->have_posts()) {
            $query->the_post();
            // Capture le contenu généré par le template 'card-project.php'
            ob_start();
            get_template_part('card', 'project'); // Le template utilisé pour afficher chaque projet
            $html .= ob_get_clean(); // Ajouter chaque projet au HTML généré
        }

        // Renvoie la réponse avec les projets trouvés
        wp_send_json_success(array('html' => $html));

    } else {
        // Si aucun projet n'est trouvé, renvoie un message
        wp_send_json_success(array('html' => '<p>Aucun projet trouvé</p>'));
    }

    wp_die(); // Terminer l'exécution de l'action AJAX
}

// Enregistrement des actions AJAX pour utilisateurs connectés et non connectés
add_action('wp_ajax_mmi_taxo', 'mmi_taxo');
add_action('wp_ajax_nopriv_mmi_taxo', 'mmi_taxo');
