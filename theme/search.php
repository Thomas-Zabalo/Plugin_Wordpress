<?php
/* Template: Recherche */

// HEADER 
get_header();

global $wp_query; // Récupère l'objet de la requête WordPress globale (wp_query) qui contient les résultats de la recherche.
?>

<main class="px-6 lg:px-32">
  <div class="relative isolate">
    <div class="mx-auto max-w-2xl pt-16 pb-12 sm:pt-32 sm:pb-24 lg:pt-46 lg:pb-28 z-10 relative">
      <div class="hidden sm:mb-4 sm:flex sm:justify-center">
        <div class="mt-8 text-pretty text-lg font-medium text-gray-700 sm:text-xl/8">
          <h1>Les projets sur WorkFlow</h1>
        </div>
      </div>
      <div class="text-center">
        <h2 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Explorez les Projets Étudiants</h2>
      </div>
    </div>
  </div>

  <!-- Affiche le formulaire de recherche pour que l'utilisateur puisse soumettre une nouvelle requête. -->
  <?php get_search_form(); ?>
</main>

<div class="px-6 xl:px-32 font-semibold pt-8">
  <!-- Affiche le nombre total de résultats pour la recherche effectuée. Affiche également la requête de recherche de l'utilisateur. -->
  <h1>
    <?php
    // Affiche le nombre de résultats trouvés par la requête.
    echo $wp_query->found_posts();
    ?> Résultat(s) de recherche pour : <?php echo esc_html($_GET['s']); ?>
  </h1>
</div>

<section class="grid gap-[200px]">
  <div class="px-6 xl:px-32">
    <!-- Liste des projets -->
    <div class="container mx-auto py-12">
      <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 flex md:flex-col" id="projects-container">
        <?php
        // Vérifie si des projets correspondent à la recherche et sont présents dans les résultats.
        if (have_posts()) :
          // Parcourt chaque projet trouvé et l'affiche.
          while (have_posts()) : the_post();
        ?>
            <!-- Affiche la carte de chaque projet trouvé. -->
            <?php get_template_part('card', 'project'); ?>

          <?php
          endwhile;
        else : ?>
          <p>Aucun projet trouvé.</p>
        <?php endif;
        // Réinitialise la requête principale de WordPress après avoir parcouru les posts.
        wp_reset_postdata();
        ?>
      </div>

      <!-- Affiche la pagination si le nombre de projets est supérieur à la limite définie. -->
      <div class="mt-8 text-center">
        <?php
        the_posts_pagination([
          'prev_text' => '<i class="fas fa-chevron-left"></i> Précédent',
          'next_text' => 'Suivant <i class="fas fa-chevron-right"></i>',
          'mid_size' => 2,
          'screen_reader_text' => 'Navigation des projets'
        ]);
        ?>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<?php get_footer(); ?>