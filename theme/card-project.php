<!-- Template : Card projets -->

<!-- Lien vers le projet -->
<a href="<?php the_permalink(); ?>" class="block p-6 bg-[#EDEEF0] rounded-lg shadow-md hover:shadow-lg transition-all duration-300">

    <article id="post-<?php the_ID(); ?>" class="flex flex-col h-full">
        <!-- Titre du projet -->
        <h3 class="text-base font-semibold mb-4 hover:text-blue-600">
            <?php wp_trim_words(the_title(), 10, '...'); ?>
        </h3>

        <!-- Tags ou attributs du projet -->
        <div class="space-x-2 text-gray-800 mb-4">
            <?php
            $tags = get_the_terms(get_the_ID(), 'attributs');
            $colors = ['#FEF8EB', '#E1EDFD'];
            $index = 0;

            if ($tags) {
                $tags = array_slice($tags, 0, 2); // Limiter à 2 tags
                foreach ($tags as $tag) {
                    $color = $colors[$index % count($colors)];
                    // Affichage du tag avec une couleur spécifique
                    echo '<span class="rounded-full px-3 py-0.5" style="background-color: ' . esc_attr($color) . ';">' . esc_html($tag->name) . '</span>';
                    $index++;
                }
            } else {
                echo '<span class="tag"></span>'; // Si aucun tag, afficher un tag vide
            }
            ?>
        </div>

        <!-- Image de l'article (avec image par défaut si non présente) -->
        <?php if (has_post_thumbnail()) : ?>
            <img
                class="object-cover w-full h-36 rounded mb-4"
                src="<?php the_post_thumbnail_url('full'); ?>"
                alt="<?php the_title_attribute(); ?>" />
        <?php else : ?>
            <img
                class="object-cover w-full h-36 rounded mb-4"
                src="<?php echo get_template_directory_uri(); ?>/dist/images/Project-image-default.png"
                alt="<?php the_title_attribute(); ?>" />
        <?php endif; ?>

        <!-- Extrait de l'article -->
        <p class="text-gray-600 mb-4 flex-grow">
            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
        </p>

        <!-- Section inférieure avec les icônes, commentaires, lien et avatar -->
        <div class="flex items-center justify-between space-x-2 mt-auto">
            <!-- Partie gauche: Commentaire et lien -->
            <div class="flex">
                <div class="flex items-center space-x-1">
                    <!-- Icon de commentaire -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="14" height="14">
                        <path d="M408 64H104a56.16 56.16 0 00-56 56v192a56.16 56.16 0 0056 56h40v80l93.72-78.14a8 8 0 015.13-1.86H408a56.16 56.16 0 0056-56V120a56.16 56.16 0 00-56-56z" fill="none" stroke="#5A5A5A" stroke-linejoin="round" stroke-width="32" />
                    </svg>
                    <?php $nb_comments = get_comments_number(get_the_ID()) ?>
                    <p class="text-[#5A5A5A]"><?php echo $nb_comments ?></p>
                </div>

                <div class="flex items-center space-x-1">
                    <!-- Icon de lien -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon rotate-90" viewBox="0 0 512 512" width="14" height="14">
                        <path d="M208 352h-64a96 96 0 010-192h64M304 160h64a96 96 0 010 192h-64M163.29 256h187.42" fill="none" stroke="#5A5A5A" stroke-linecap="round" stroke-linejoin="round" stroke-width="36" />
                    </svg>
                    <?php
                    // Récupérer les liens GitHub et Site du projet
                    $github_link = get_post_meta(get_the_ID(), '_github_link');
                    $site_link = get_post_meta(get_the_ID(), '_site_link');

                    // Compter combien de liens sont disponibles
                    $meta_count = 0;

                    // Vérifier si le lien GitHub existe
                    if (!empty($github_link[0])) {
                        $meta_count++;
                    }

                    // Vérifier si le lien Site existe
                    if (!empty($site_link[0])) {
                        $meta_count++;
                    }
                    ?>
                    <p class="text-[#5A5A5A]"><?php echo $meta_count; ?></p>
                </div>
            </div>

            <!-- Partie droite: Avatar de l'auteur et des collaborateurs -->
            <div class="flex -space-x-2 overflow-hidden">
                <?php
                // Récupérer les ID des collaborateurs associés au projet
                $collaborateurs_ids = get_post_meta(get_the_ID(), '_etudiants_associes', true);

                // Si des collaborateurs sont définis, afficher leur avatar
                if (!empty($collaborateurs_ids) && is_array($collaborateurs_ids)) {
                    foreach ($collaborateurs_ids as $collaborateur_id) {
                        // Récupérer l'avatar du collaborateur
                        $avatar_url = get_avatar_url($collaborateur_id);
                ?>
                        <img class="inline-block size-6 rounded-full" src="<?php echo esc_url($avatar_url); ?>" alt="">
                <?php
                    }
                }

                // Ajouter l'avatar de l'auteur du post
                $author_avatar_url = get_avatar_url(get_the_author_meta('ID'));
                ?>
                <img class="inline-block size-6 rounded-full" src="<?php echo esc_url($author_avatar_url); ?>" alt="">
            </div>

        </div>

    </article>
</a>