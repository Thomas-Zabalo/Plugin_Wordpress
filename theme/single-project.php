<?php
/* Template: Projet */

// HEADER 
get_header();
?>

<!-- MAIN -->
<main class="px-6 lg:px-32 py-12">

    <div class="container mx-auto">
        <?php
        // Vérifie si le projet existe
        if (have_posts()) :
            while (have_posts()) : the_post();
        ?>
                <!-- Retour aux archives -->
                <div class="flex justify-start mb-6">
                    <a href="<?php echo home_url('/project') ?>" class="text-blue-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Retour aux archives
                    </a>
                </div>

                <!-- Conteneur principal du projet -->
                <article class="w-full max-w-[56rem] mx-auto">

                    <!-- Titre du projet -->
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center mb:text-left"><?php the_title(); ?></h1>

                    <div class="mb-4 flex flex-col space-y-4">
                        <!-- Taxonomy: Cours (affiche les cours associés) -->
                        <div>
                            <span class="text-gray-500 flex justify-center">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'cours'); // Récupère les termes de la taxonomy 'cours'
                                if (!empty($terms) && !is_wp_error($terms)) {
                                    echo implode(', ', wp_list_pluck($terms, 'name')); // Affiche les noms des termes
                                }
                                ?>
                            </span>
                        </div>

                        <!-- Taxonomy: Attributs (affiche les attributs associés) -->
                        <div>
                            <span class="text-gray-500 flex justify-center">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'attributs'); // Récupère les termes de la taxonomy 'attributs'
                                if (!empty($terms) && !is_wp_error($terms)) {
                                    echo implode(', ', wp_list_pluck($terms, 'name')); // Affiche les noms des termes
                                }
                                ?>
                            </span>
                        </div>

                        <!-- Informations sur l'auteur et la date -->
                        <div class="flex space-x-5 flex justify-center items-center">
                            <div class="flex items-center space-x-3">
                                <?php
                                // Obtenez l'avatar de l'auteur du post
                                $avatar_url = get_avatar_url(get_the_author_meta('ID'));
                                ?>
                                <img class="inline-block size-6 rounded-full" src="<?php echo esc_url($avatar_url); ?>" alt="Avatar de l'auteur">
                                <span class="text-gray-500 capitalize"><?php the_author(); ?></span>
                            </div>
                            <span class="dot"></span>
                            <span class="text-gray-500"><?php the_date('d F Y'); ?></span>
                        </div>

                        <!-- Liste des collaborateurs associés au projet -->
                        <div class="flex flex-col space-y-3 justify-center items-center">
                            <?php
                            // Récupérer les ID des étudiants associés au projet
                            $collaborateurs_ids = get_post_meta(get_the_ID(), '_etudiants_associes', true);

                            if ($collaborateurs_ids && is_array($collaborateurs_ids)) {
                                // Afficher la liste des collaborateurs associés
                                echo '<p class="font-semibold text-lg text-gray-700">Collaborateur(s) :</p>';
                                echo '<ul class="text-gray-500 capitalize flex flex-wrap gap-2">'; // Utilisation de flex-wrap et gap pour l'espacement
                                foreach ($collaborateurs_ids as $collaborateur_id) {
                                    // Récupérer l'utilisateur par ID
                                    $collaborateur = get_user_by('ID', $collaborateur_id);
                                    if ($collaborateur) {
                                        // Générer l'URL vers la page de l'utilisateur
                                        $user_url = get_author_posts_url($collaborateur->ID);
                                        // Afficher le nom du collaborateur avec un lien vers sa page utilisateur
                                        echo '<li class="px-3 py-1">';
                                        echo '<a href="' . esc_url($user_url) . '" class="hover:underline">' . esc_html($collaborateur->display_name) . '</a>';
                                        echo '</li>';
                                    }
                                }
                                echo '</ul>';
                            } else {
                                echo '<p class="text-gray-500">Aucun collaborateur</p>';
                            }
                            ?>
                        </div>


                    </div>

                    <!-- Image du projet (s'il y en a une) -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-6 flex justify-center">
                            <div class="w-full">
                                <?php the_post_thumbnail('large', ['class' => 'w-full rounded-lg']); ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Image par défaut si le projet n'a pas d'image -->
                        <div class="mb-6 flex justify-center">
                            <div class="w-full">
                                <img
                                    class="object-cover w-full h-36 rounded mb-4"
                                    src="<?php echo get_template_directory_uri(); ?>/dist/images/Project-image-default.png"
                                    alt="<?php the_title_attribute(); ?>" />
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Liens vers Github et le site du projet -->
                    <div class="flex justify-center mb-6 space-x-6">
                        <?php
                        $link_github = get_post_meta(get_the_ID(), '_github_link', true);
                        if ($link_github) {
                        ?>
                            <p>
                                Voir le projet :
                                <span class="text-gray-500">
                                    <a href="<?php echo esc_url($link_github); ?>" class="text-blue-500 underline">Github</a>
                                </span>
                            </p>
                        <?php
                        } else {
                        ?>
                            <p class="text-gray-500">Aucun lien Github</p>
                        <?php
                        }
                        ?>

                        <?php
                        $link_site = get_post_meta(get_the_ID(), '_site_link', true);
                        if ($link_site) {
                        ?>
                            <p>
                                Voir le site ou démo :
                                <span class="text-gray-500">
                                    <a href="<?php echo esc_url($link_site); ?>" class="text-blue-500 underline">Voir</a>
                                </span>
                            </p>
                        <?php
                        } else {
                        ?>
                            <p class="text-gray-500">Aucun lien de site</p>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- Description du projet -->
                    <div class="mb-6">
                        <div class="text-gray-600 prose"><?php the_content(); ?></div>
                    </div>

                    <!-- Section des commentaires -->
                    <?php
                    comments_template();
                    ?>

                </article>

        <?php endwhile;
        else :
            // Si le projet n'existe pas
            echo '<p>Ce projet n\'existe pas.</p>';
        endif;
        ?>

    </div>
</main>

<!-- FOOTER -->
<?php get_footer(); ?>
