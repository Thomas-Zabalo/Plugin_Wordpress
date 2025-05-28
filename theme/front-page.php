<?php
/* Template: Page Accueil */

// HEADER
get_header();
?>

<!-- MAIN -->
<main class="px-6 lg:px-32">
  <div class="relative isolate">
    <div class="mx-auto max-w-2xl py-24 sm:py-48 lg:py-56 z-10 relative">
      <div class="hidden sm:mb-4 sm:flex sm:justify-center">
        <div class="mt-8 text-lg font-medium text-gray-700 sm:text-xl">
          <h1>Bienvenue sur WorkFlow</h1>
        </div>
      </div>
      <div class="text-center">
        <h2 class="text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
          Gérez vos projets efficacement
        </h2>
        <p class="relative px-3 py-1 text-lg text-gray-600 mt-8">
          Publiez et partagez vos projets que vous avez réalisés
        </p>
      </div>
    </div>
  </div>
</main>

<!-- GRID AVEC UN ESPACEMENT DE 200px -->

<section class="grid gap-[200px]">
  <div class="px-6 xl:px-32 ">
    <!-- SECTION INTRODUCTION -->
    <div class="pb-12 lg:pb-32 container mx-auto">
      <section class="py-12 md:py-16 lg:py-20">
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
          <?php
          get_template_part('card', 'main');
          ?>
        </div>
      </section>
    </div>

    <!-- SECTION DERNIERS PROJETS -->
    <section class="lg:px-6 pb-12 lg:pb-32">
      <div class="container mx-auto">
        <div class="flex justify-between items-center mb-8 lg:mb-28">
          <h2 class="text-xl lg:text-3xl font-bold">Quelques projets réalisés.</h2>
          <a href="/project" class="text-sm sm:text-base hover:underline">Voir plus <span aria-hidden="true">→</span> </a>
        </div>
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
          <?php
          echo do_shortcode('[latest-projects]');
          ?>
        </div>
      </div>
    </section>

    <!-- SECTION AVEC WORKFLOW -->
    <section class="px-6 lg:py-32">
      <h2 class="text-xl lg:text-3xl font-bold mb-8 lg:mb-28">Conçu pour tous vos projets académiques</h2>
      <div class="container mx-auto grid gap-8 sm:grid-cols-1 md:grid-cols-2 items-center">
        <!-- Image -->
        <div class="flex justify-start mb-6 md:mb-0">
          <img src="<?php echo get_template_directory_uri(); ?>/dist/images/Workflow.png" alt="Présentation de WorkFlow" width="400">
        </div>
        <!-- Texte -->
        <div class="flex flex-col justify-between space-y-12 h-full">
          <h2 class="text-sm lg:text-2xl font-bold">Avec Workflow.</h2>
          <p class="text-sm lg:text-xl text-[#2E331C]">
            <strong>Explorez sans limites :</strong> Partagez vos réalisations, quelles que soient les disciplines ou les thématiques.
          </p>
          <p class="text-sm lg:text-xl text-[#2E331C]">
            <strong>Avantages pour les étudiants :</strong> Inspirez, connectez-vous et enrichissez votre portfolio.
          </p>
          <p class="text-sm lg:text-xl text-[#2E331C]">
            <strong>Simplifiez vos partages :</strong> Publiez facilement et gagnez en visibilité auprès d'une large audience.
          </p>

        </div>
      </div>
    </section>
  </div>
</section>

<!-- FOOTER -->
<?php get_footer(); ?>