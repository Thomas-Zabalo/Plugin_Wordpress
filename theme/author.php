<?php
/* Template: Projets de l'auteur */

// HEADER
get_header();

// Récupérer les informations de l'auteur
$author_id = get_the_author_meta('ID');
$author_name = get_the_author_meta('display_name');
?>

<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Retour à la liste des étudiants -->
        <div class="flex justify-start mb-6">
            <a href="<?php echo home_url('/etudiants'); ?>" class="text-blue-500 flex items-center" aria-label="Retour aux étudiants">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour aux étudiants
            </a>
        </div>

        <!-- Titre de la page -->
        <h1 class="text-3xl font-bold mb-6">Projets de <?php echo esc_html($author_name); ?></h1>

        <!-- Affichage des projets -->
        <div class="flex justify-center">
            <ul class="space-y-6">
                <?php
                // Récupérer les projets publiés par cet auteur
                $projets_crees = new WP_Query([
                    'post_type' => 'project',
                    'author' => $author_id,
                    'posts_per_page' => -1, // Afficher tous les projets
                ]);

                // Si des projets sont trouvés, on les affiche
                if ($projets_crees->have_posts()) :
                    while ($projets_crees->have_posts()) :
                        $projets_crees->the_post();
                ?>
                        <li class="p-6 flex justify-between">
                            <div>
                                <!-- Titre et lien vers le projet -->
                                <a href="<?php echo get_permalink(); ?>" class="text-xl font-semibold hover:underline" aria-label="Lire le projet <?php echo esc_attr(get_the_title()); ?>">
                                    <?php echo get_the_title(); ?>
                                </a>

                                <!-- Description du projet -->
                                <p class="mt-2 text-sm text-gray-400">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </div>

                            <!-- Date de création du projet -->
                            <span class="block ml-6 text-xs text-gray-500 hidden md:block">
                                <?php echo get_the_date('Y-m-d'); ?>
                            </span>
                        </li>
                    <?php
                    endwhile;
                else :
                    ?>
                    <li class="text-gray-400">Aucun projet trouvé.</li>
                <?php
                endif;

                // Réinitialiser la requête
                wp_reset_postdata();
                ?>
            </ul>
        </div>

        <h2 class="text-2xl font-bold my-6 text-gray-600">Projets où <?php echo esc_html($author_name); ?> a collaboré</h2>

        <div class="flex justify-center">
            <ul class="space-y-6">
                <?php
                // Récupérer les projets publiés par cet auteur
                $projets_collabores = new WP_Query([
                    'post_type' => 'project',
                    'meta_query' => [
                        [
                            'key' => '_etudiants_associes',  // Champ personnalisé qui stocke les IDs des collaborateurs
                            'value' => $author_id,  // Cherche les projets où l'ID de l'auteur est présent
                            'compare' => 'LIKE',    // Comparaison de type "LIKE" pour vérifier la présence de l'ID dans le tableau
                        ]
                    ],
                    'posts_per_page' => -1, // Afficher tous les projets
                ]);

                // Si des projets sont trouvés, on les affiche
                if ($projets_collabores->have_posts()) :
                    while ($projets_collabores->have_posts()) :
                        $projets_collabores->the_post();
                ?>
                        <li class="p-6 flex justify-between">
                            <div>
                                <!-- Titre et lien vers le projet -->
                                <a href="<?php echo get_permalink(); ?>" class="text-xl font-semibold hover:underline" aria-label="Lire le projet <?php echo esc_attr(get_the_title()); ?>">
                                    <?php echo get_the_title(); ?>
                                </a>

                                <!-- Description du projet -->
                                <p class="mt-2 text-sm text-gray-400">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </div>

                            <!-- Date de création du projet -->
                            <span class="block ml-6 text-xs text-gray-500 hidden md:block">
                                <?php echo get_the_date('Y-m-d'); ?>
                            </span>
                        </li>
                    <?php
                    endwhile;
                else :
                    ?>
                    <li class="text-gray-400">Aucun projet trouvé où <?php echo esc_html($author_name); ?> a collaboré.</li>
                <?php
                endif;

                // Réinitialiser la requête
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?php get_footer(); ?>
