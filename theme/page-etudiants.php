<?php
/* Template: Liste des Étudiants */

// HEADER 
get_header(); ?>

<main class="px-6 lg:px-32">
  <div class="relative isolate">
    <div class="mx-auto max-w-2xl pt-24 pb-12 sm:pt-48 sm:pb-24 lg:pt-56 lg:pb-28 z-10 relative">
      <div class="text-center">
        <h2 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Liste des étudiants</h2>
      </div>
    </div>
  </div>
</main>

<section class="grid gap-[200px]">
  <div class="px-6 xl:px-32">
    <!-- Liste des étudiants -->
    <div class="container mx-auto py-12">
      <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 flex md:flex-col" id="students-container">
        <?php
        // Récupérer tous les utilisateurs ayant un rôle "etudiant"
        $etudiants = get_users([
          'role' => 'etudiant', // Récupère les utilisateurs ayant le rôle "etudiant"
        ]);

        // Vérifier s'il y a des étudiants récupérés
        if ($etudiants) {
          foreach ($etudiants as $etudiant) {
            // Récupérer l'URL de la photo de profil de l'utilisateur
            $avatar_url = get_avatar_url($etudiant->ID);
        ?>
            <!-- Carte de chaque étudiant -->
            <div class="card bg-white p-6 rounded-lg shadow-lg">
              <div class="flex items-center">
                <!-- Image de profil -->
                <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($etudiant->display_name); ?>'s Avatar" class="w-16 h-16 rounded-full mr-4">
                <div>
                  <!-- Nom de l'étudiant -->
                  <h3 class="text-xl font-semibold text-gray-900 capitalize"><?php echo esc_html($etudiant->display_name); ?></h3>
                  <!-- Lien vers le profil -->
                  <a href="<?php echo get_author_posts_url($etudiant->ID); ?>" class="text-indigo-600 hover:text-indigo-800">Voir le profil</a>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          // Message si aucun étudiant n'est trouvé
          echo '<p>Aucun étudiant trouvé.</p>';
        }
        ?>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<?php get_footer(); ?>