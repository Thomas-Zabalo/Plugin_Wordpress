<?php
/*
 * Plugin Name:       SAE501 plugins
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Ce plugin sert à gérer des projets réalisé en MMI.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Thomas ZABALO
 * Author URI:        https://zbt4714a.mmiweb.iut-tlse3.fr/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       MMI-plugin
 * Domain Path:       /languages
 */





/*
*** 1) Enregistrement du Custom Post Type
*/
function sae_custom_post_type()
{
    register_post_type(
        'project',
        array(
            'label' => 'Projects',
            'public' => true,
            'show_in_rest' => true,  // Pour pouvoir l'utiliser dans l'éditeur Gutenberg
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments', 'author'),
            'menu_position' => 5,
            'capability_type' => 'project',
            'map_meta_cap' => true,
            'has_archive' => true,
        )
    );
}
add_action('init', 'sae_custom_post_type');





/*
*** 2) Création de taxonomies personnalisées
*** - Taxonomie Cours
*** - Taxonomie Attribut
*/
function add_custom_taxonomies()
{
    $courses_labels = array(
        'name' => _x('Cours', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Cour', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Rechercher des cours', 'textdomain'),
        'all_items' => __('Tous les cours', 'textdomain'),
        'edit_item' => __('Éditer un cours', 'textdomain'),
        'update_item' => __('Mettre à jour un cours', 'textdomain'),
        'add_new_item' => __('Ajouter un nouveau cours', 'textdomain'),
        'new_item_name' => __('Nom du nouveau cours', 'textdomain'),
        'menu_name' => __('Cours', 'textdomain'),
    );

    $courses_args = array(
        'hierarchical' => true,
        'labels' => $courses_labels,
        'show_ui' => true,
        'show_in_menu' => true,
        'capabilities' => array(
            'assign_terms' => 'edit_projects',
        ),
        'query_var' => true,
        'rewrite' => array('slug' => 'cours'),
        'show_in_rest' => true, // Utilisation dans l'éditeur Gutenberg
        'public' => true,
    );
    register_taxonomy('cours', array('project'), $courses_args);



    $attributs_labels = array(
        'name' => _x('Attributs', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('attribut', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Rechercher des Attributs', 'textdomain'),
        'all_items' => __('Tous les Attributs', 'textdomain'),
        'edit_item' => __('Éditer un attribut', 'textdomain'),
        'update_item' => __('Mettre à jour un attribut', 'textdomain'),
        'add_new_item' => __('Ajouter un nouveau attribut', 'textdomain'),
        'new_item_name' => __('Nom du nouveau attribut', 'textdomain'),
        'menu_name' => __('Attributs', 'textdomain'),
    );

    $attributs_args = array(
        'hierarchical' => true,
        'labels' => $attributs_labels,
        'show_ui' => true,
        'show_in_menu' => true,
        'capabilities' => array(
            'assign_terms' => 'edit_projects',
        ),
        'query_var' => true,
        'rewrite' => array('slug' => 'attributs'),
        'show_in_rest' => true, // Utilisation dans l'éditeur Gutenberg
        'public' => true,
    );
    register_taxonomy('attributs', array('project'), $attributs_args);
}
add_action('init', 'add_custom_taxonomies');





/*
*** 3) Meta box
*** - Github
*** - Lien site ou démo
*** - Etudiants liée au projet
*/


/*
*** 3.1.a) Création de la meta box
*** - Github
*/
function ajouter_meta_box_github()
{
    add_meta_box(
        'github_link_metabox',             // ID unique de la méta box
        'Lien Github',            // Titre affiché dans l'éditeur
        'afficher_meta_box_github',   // Fonction callback pour afficher son contenu
        'project',                       // Type de contenu personnalisé (post type)
        'side',                          // Position (dans la colonne latérale de l'éditeur)
        'default'                        // Priorité d'affichage
    );
}
add_action('add_meta_boxes', 'ajouter_meta_box_github');

/*
*** 3.1.b) Affichage de la meta box
*** - Github
*/
function afficher_meta_box_github($post)
{
    // Récupérer la valeur actuelle du champ (s'il existe déjà)
    $github_link = get_post_meta($post->ID, '_github_link', true);
?>
    <!-- Affichage dans l'éditeur (Gutenberg ou Classic Editor) avec un champ HTML -->
    <label for="github_link">Lien GitHub :</label>
    <input type="url" name="github_link" id="github_link" value="<?php echo esc_attr($github_link); ?>" style="width: 100%;" placeholder="https://github.com/votre-projet">
<?php
}

/*
*** 3.1.c) Sauvegarde la valeur du champ lors de l'enregistrement du post
*** - Github
*/
function sauvegarder_meta_box_github($post_id)
{
    // Vérifier si le champ 'github_link' est défini dans la requête POST
    if (isset($_POST['github_link'])) {
        // Utiliser `esc_url_raw()` pour nettoyer et valider l'URL avant de l'enregistrer
        update_post_meta($post_id, '_github_link', esc_url_raw($_POST['github_link']));
    }
}
add_action('save_post', 'sauvegarder_meta_box_github');





/*
*** 3.2.a) Création de la meta box
*** - Site ou démo
*/
function ajouter_meta_box_site()
{
    add_meta_box(
        'site_link_metabox',             // ID unique de la méta box
        'Lien du Site ou de la démo',            // Titre affiché dans l'éditeur
        'afficher_meta_box_site',   // Fonction callback pour afficher son contenu
        'project',                       // Type de contenu personnalisé (post type)
        'side',                          // Position (dans la colonne latérale de l'éditeur)
        'default'                        // Priorité d'affichage
    );
}
add_action('add_meta_boxes', 'ajouter_meta_box_site');

/*
*** 3.2.b) Affichage de la meta box
*** - Site ou démo
*/
function afficher_meta_box_site($post)
{
    // Récupérer la valeur actuelle du champ (s'il existe déjà)
    $site_link = get_post_meta($post->ID, '_site_link', true);
?>
    <!-- Affichage dans l'éditeur (Gutenberg ou Classic Editor) avec un champ HTML -->
    <label for="site_link">Lien du Site :</label>
    <input type="url" name="site_link" id="site_link" value="<?php echo esc_attr($site_link); ?>" style="width: 100%;" placeholder="https://exemple.com">
<?php
}

/*
*** 3.2.c) Sauvegarde la valeur du champ lors de l'enregistrement du post
*** - Site ou démo
*/
function sauvegarder_meta_box_site($post_id)
{
    // Vérifier si le champ 'site_link' est défini dans la requête POST
    if (isset($_POST['site_link'])) {
        // Utiliser `esc_url_raw()` pour nettoyer et valider l'URL avant de l'enregistrer
        update_post_meta($post_id, '_site_link', esc_url_raw($_POST['site_link']));
    }
}
add_action('save_post', 'sauvegarder_meta_box_site');





/*
*** 3.3.a) Récupérer les étudiants inscrits
*** - Étudiant
*** - Source : Elias NODON 
*/
function get_listes_etudiants()
{
    $args = array(
        'role'    => 'étudiant',       // Filtrer les utilisateurs ayant le rôle "étudiant"
        'orderby' => 'display_name',  // Trier par le nom affiché
        'order'   => 'ASC',           // Ordre croissant
    );

    $utilisateurs = get_users($args); // Récupération des utilisateurs
    return $utilisateurs;            // Retourne une liste d'objets utilisateur
}

/*
*** 3.3.b) Création de la meta box
*** - Étudiant
*/
function ajouter_meta_box_etudiants()
{
    add_meta_box(
        'meta_box_etudiants',             // ID unique de la méta box
        'Étudiants associés',            // Titre affiché dans l'éditeur
        'afficher_meta_box_etudiants',   // Fonction callback pour afficher son contenu
        'project',                       // Type de contenu personnalisé (post type)
        'side',                          // Position (dans la colonne latérale de l'éditeur)
        'default'                        // Priorité d'affichage
    );
}
add_action('add_meta_boxes', 'ajouter_meta_box_etudiants');

/*
*** 3.3.c) Affichage de la meta box
*** - Étudiant
*/
function afficher_meta_box_etudiants($post)
{
    // Récupérer la liste des étudiants
    $etudiants = get_listes_etudiants();

    // Récupérer les étudiants associés à ce projet (si existant)
    $etudiants_selectionnes = get_post_meta($post->ID, '_etudiants_associes', true);
    $etudiants_selectionnes = is_array($etudiants_selectionnes) ? $etudiants_selectionnes : array();

    // Affichage de la liste des étudiants avec des cases à cocher
    foreach ($etudiants as $etudiant) {
        $selectionne = in_array($etudiant->ID, $etudiants_selectionnes) ? 'checked' : ''; // Vérifier si l'étudiant est déjà sélectionné
        echo '<p><input type="checkbox" name="etudiants_associes[]" value="' . esc_attr($etudiant->ID) . '" ' . $selectionne . '> ' . esc_html($etudiant->display_name) . '</p>';
    }

    // Message pour indiquer comment utiliser cette méta box
    echo '<p>' . __('Sélectionnez les étudiants associés à ce projet.') . '</p>';
}

/*
*** 3.3.d) Sauvegarder les étudiants associés lors de l'enregistrement du post
*** - Étudiant
*/
function sauvegarder_etudiants_associes($post_id)
{
    // Vérifications de sécurité pour éviter les erreurs
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return; // Éviter les sauvegardes automatiques
    if (!current_user_can('edit_post', $post_id)) return;    // Vérifier les autorisations de l'utilisateur

    // Si des étudiants sont sélectionnés, les enregistrer
    if (isset($_POST['etudiants_associes'])) {
        $etudiants = array_map('intval', $_POST['etudiants_associes']); // Nettoyer les IDs des étudiants
        update_post_meta($post_id, '_etudiants_associes', $etudiants); // Enregistrer dans les méta-données
    } else {
        delete_post_meta($post_id, '_etudiants_associes'); // Supprimer la méta donnée si aucune case n'est cochée
    }
}
add_action('save_post', 'sauvegarder_etudiants_associes');

/*
*** 3.3.e) Ajouter les étudiants associés à l'API REST pour les projets
*** - Étudiant
*/
function enrichir_api_rest_projet_avec_etudiants($response, $post)
{
    // Récupérer les étudiants associés au projet
    $etudiants_associes = get_post_meta($post->ID, '_etudiants_associes', true);
    if ($etudiants_associes) {
        $donnees_etudiants = array();

        // Parcourir les étudiants associés et récupérer leurs informations
        foreach ($etudiants_associes as $etudiant_id) {
            $utilisateur = get_user_by('ID', $etudiant_id); // Récupérer les informations de l'utilisateur
            if ($utilisateur) {
                $donnees_etudiants[] = array(
                    'ID'   => $utilisateur->ID,          // ID de l'étudiant
                    'name' => $utilisateur->display_name, // Nom affiché de l'étudiant
                );
            }
        }

        // Ajouter les données des étudiants au projet dans l'API REST
        $response->data['etudiants_associes'] = $donnees_etudiants;
    }

    return $response; // Retourner la réponse enrichie
}
add_filter('rest_prepare_project', 'enrichir_api_rest_projet_avec_etudiants', 10, 3);





/*
*** 4) Ajouter un rôle utilisateur avec des capacités spécifiques
*/
function project_add_role($role, $display_name, $capabilities = array())
{
    if (empty($role)) {
        return; // Arrêter si aucun rôle n'est fourni
    }

    return wp_roles()->add_role($role, $display_name, $capabilities);
}

/*
*** Créer les rôles et ajouter les capacités lors de l'activation du plugin
*/
register_activation_hook(__FILE__, 'ajouter_role');





/*
*** 5) Ajouter différents rôles utilisateurs avec des capacités spécifiques 
*/
function ajouter_role()
{
    /*
    ** Rôle "Enseignant" :
    ** - Accès complet aux projets (CRUD complet)
    */
    add_role('enseignant', 'Enseignant', array(
        'read'                        => true,  // Peut lire
        'edit_project'                => true,  // Peut éditer un projet
        'edit_projects'               => true,  // Peut éditer plusieurs projets
        'delete_project'              => true,  // Peut supprimer un projet
        'publish_projects'            => true,  // Peut publier des projets
        'edit_others_projects'        => true,  // Peut éditer les projets des autres
        'edit_published_projects'     => true,  // Peut éditer les projets publiés
        'delete_others_projects'      => true,  // Peut supprimer les projets des autres
        'delete_published_projects'   => true,  // Peut supprimer les projets publiés
        'delete_private_projects'     => true,  // Peut supprimer les projets privés
        'read_private_projects'       => true,  // Peut lire les projets privés
        'assign_terms'                => true,  // Peut attribuer des catégories/termes
        'moderate_comments'           => true,  // Peut modérer les commentaires
        'edit_comments'               => true,  // Peut éditer les commentaires
        'upload_files'                => true,  // Peut téléverser des fichiers
    ));

    /*
    ** Rôle "Étudiant" :
    ** - Accès limité aux projets
    */
    add_role('etudiant', 'Étudiant', array(
        'read'                  => true,  // Peut lire
        'edit_project'          => true,  // Peut éditer ses propres projets
        'edit_projects'         => true,  // Peut modifier ses propres projets
        'delete_project'        => true,  // Peut supprimer ses propres projets non publiés
        'publish_projects'      => false, // Ne peut pas publier ses projets
        'edit_others_projects'  => false, // Ne peut pas éditer les projets des autres
        'delete_others_projects' => false, // Ne peut pas supprimer les projets des autres
        'assign_terms'          => true,  // Peut attribuer des catégories/termes
        'upload_files'          => true,  // Peut téléverser des fichiers
    ));

    /*
    ** Ajouter des capacités au rôle "Administrateur" :
    ** - Pour s'assurer qu'un administrateur a toujours toutes les permissions sur les projets
    */
    $role = get_role('administrator');
    if ($role) {
        $capabilities = array(
            'read',                         // Lire
            'edit_project',                 // Éditer un projet
            'edit_projects',                // Éditer plusieurs projets
            'read_project',                 // Lire un projet
            'edit_others_projects',         // Éditer les projets des autres
            'delete_projects',              // Supprimer des projets
            'publish_projects',             // Publier des projets
            'read_private_projects',        // Lire des projets privés
            'delete_private_projects',      // Supprimer des projets privés
            'delete_published_projects',    // Supprimer des projets publiés
            'delete_others_projects',       // Supprimer les projets des autres
            'edit_private_projects',        // Éditer des projets privés
            'edit_published_projects',      // Éditer des projets publiés
        );

        // Ajouter les capacités au rôle administrateur
        foreach ($capabilities as $cap) {
            $role->add_cap($cap);
        }
    }

    /*
    ** Ajoute une option personnalisée à la base de données :
    */
    add_option("SAE501_options", "Je suis l'option de la SAE501");
}





/*
*** 6) Conserver l'auteur initial d'un article même après modification par un administrateur
*/
function conserver_auteur_initial($post_id)
{
    // Empêcher l'exécution lors d'un "autosave" (sauvegarde automatique de WordPress)
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    // Vérifier si le type de contenu est bien un "post"
    if ('post' == get_post_type($post_id)) {
        $post = get_post($post_id); // Récupérer l'objet post

        // Si l'article a été modifié par un administrateur mais qu'il n'est pas encore publié,
        // rétablir l'auteur original de l'article
        if (isset($post->post_author) && $post->post_author !== get_current_user_id()) {
            // Récupérer l'auteur original
            $original_author = get_post_field('post_author', $post_id);

            // Vérifier si l'auteur original existe et s'il est différent de l'actuel auteur
            if ($original_author && $original_author !== $post->post_author) {
                // Réassigner l'auteur original
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_author' => $original_author
                ));
            }
        }
    }

    return $post_id; // Retourner l'ID du post après modification
}

// Attacher cette fonction au hook 'save_post' pour qu'elle soit exécutée lors de l'enregistrement du post
add_action('save_post', 'conserver_auteur_initial');




/*
*** 7) Fonction pour la désinstallation du plugin
*/
function sae_uninstall_plugin_function()
{
    // Supprimer les rôles "etudiant" et "enseignant" lors de la désinstallation du plugin
    remove_role('etudiant');
    remove_role('enseignant');

    // Supprimer l'option personnalisée stockée dans la base de données
    delete_option('SAE501_options');
}

// Enregistrer la fonction de désinstallation
register_uninstall_hook(__FILE__, 'sae_uninstall_plugin_function');
