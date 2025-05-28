 <!-- Template: Recherche de Projets -->

 <form action="<?php echo home_url('/'); ?>" method="get" class="max-w-md mx-auto">
     <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Rechercher</label>

     <div class="relative">
         <!-- Icône de recherche -->
         <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
             <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
             </svg>
         </div>

         <!-- Champ de recherche, avec sécurisation de la valeur -->
         <input
             value="<?php echo esc_attr(get_search_query()); ?>"
             type="text"
             id="search"
             name="s"
             class="block w-full p-4 ps-10 text-sm text-gray-900 rounded-lg bg-white"
             placeholder="Rechercher un projet"
             required />
     </div>
 </form>