<?php
/* Template: Tous les projets créés */

// HEADER
get_header();
?>

<!-- MAIN - Section principale de la page -->
<main class="px-6 lg:px-32">
  <!-- Section d'introduction avec un titre et une description des projets -->
  <div class="relative isolate">
    <div class="mx-auto max-w-2xl pt-24 pb-12 sm:pt-48 sm:pb-24 lg:pt-56 lg:pb-28 z-10 relative">

      <!-- Titre secondaire visible uniquement sur les écrans plus grands -->
      <div class="hidden sm:mb-4 sm:flex sm:justify-center">
        <div class="mt-8 text-pretty text-lg font-medium text-gray-700 sm:text-xl/8">
          <h1>Les projets sur WorkFlow</h1>
        </div>
      </div>

      <!-- Titre principal de la section -->
      <div class="text-center">
        <h2 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
          Explorez les Projets Étudiants
        </h2>
      </div>
    </div>
  </div>

  <!-- Affiche le formulaire de recherche pour les projets -->
  <?php get_search_form(); ?>
</main>

<!-- Section des filtres de projets (buttons pour différents types de projets) -->
<div class="button-container text-center py-6">
  <button class="btn-filter px-4 py-1 bg-gray-100 text-gray-800 border-2 border-gray-300 rounded-full font-bold text-sm transition duration-300 ease-in-out hover:bg-gray-200 hover:border-gray-400 focus:outline-none" id="btn-development-back">Développement Back</button>
  <button class="btn-filter px-4 py-1 bg-gray-100 text-gray-800 border-2 border-gray-300 rounded-full font-bold text-sm transition duration-300 ease-in-out hover:bg-gray-200 hover:border-gray-400 focus:outline-none" id="btn-development-front">Développement Front</button>
  <button class="btn-filter px-4 py-1 bg-gray-100 text-gray-800 border-2 border-gray-300 rounded-full font-bold text-sm transition duration-300 ease-in-out hover:bg-gray-200 hover:border-gray-400 focus:outline-none" id="btn-hebergement">Hébergement</button>
</div>

<!-- Liste des projets sous forme de grille -->
<section class="grid gap-[200px]">
  <div class="px-6 xl:px-32 ">
    <!-- Conteneur pour la liste des projets -->
    <div class="container mx-auto py-12"> <!-- Ajoutez un ID ici -->
      <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 flex md:flex-col" id="projects-container">

        <!-- Vérification si des projets sont disponibles -->
        <?php
        if (have_posts()) :
          while (have_posts()) : the_post();
        ?>
            <!-- Affichage de chaque projet -->
            <?php get_template_part('card', 'project'); ?>
          <?php
          endwhile;
        else : ?>
          <!-- Message s'il n'y a aucun projet -->
          <p>Aucun projet trouvé.</p>
        <?php endif;
        wp_reset_postdata();
        ?>
      </div>

      <!-- Pagination des projets -->
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
<?php
get_footer();
?>