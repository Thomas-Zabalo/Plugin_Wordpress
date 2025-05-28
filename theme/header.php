<!-- Template: Header -->

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkFlow.</title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="sticky z-50 bg-[#F5F5F5] <?php echo is_user_logged_in() ? 'md:top-8 top-0' : 'top-0'; ?>">        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center justify-between p-4 lg:px-8" aria-label="Global">
            <div class="flex">
                <?php if (has_custom_logo()) {
                    the_custom_logo();
                } ?>
            </div>

            <?php wp_nav_menu(array(
                'theme_location'  => 'menu-principal',
                'container'       => 'nav',
                'container_class' => '',
                'container_aria_label' => 'Global',
                'menu_class'      => 'flex flex-row gap-2 sm:gap-4 text-sm font-medium text-gray-900',
                'link_before'     => '<span class="hover:underline">',
                'link_after'      => '</span>',
            ))
            ?>
            <div class="flex justify-center space-x-6">
            <?php if (!is_user_logged_in()) : ?>
                <!-- Affichage des boutons d'inscription et de connexion uniquement si l'utilisateur n'est pas connecté -->
                <button class="px-4 py-2 bg-[#EAEAEA] text-gray-800 rounded-md hover:bg-gray-200">
                    <a href="<?php echo site_url('wp-login.php?action=register'); ?>">S'inscrire</a>
                </button>
                <button class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                    <a href="<?php echo site_url('login'); ?>">Se connecter</a>
                </button>
            <?php else : ?>
                <!-- Affichage du lien vers le profil si l'utilisateur est connecté -->
                <button class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                    <a href="<?php echo get_edit_user_link(); ?>">Profil</a>
                </button>
            <?php endif; ?>
        </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden p-4 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
					<a href="https://zbt4714a.mmiweb.iut-tlse3.fr/" class="custom-logo-link" rel="home" aria-current="page">
                    <?php if (has_site_icon()) {
                    ?>
                        <img src="<?php site_icon_url(); ?>" alt="favicon du site" width="20">
                    <?php
                    } ?>
						</a>
                </div>
                <!-- Hamburger Icon -->
                <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="black">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Items -->
            <nav id="mobile-menu" class="hidden flex-col mt-4 space-y-2">
                <?php wp_nav_menu(array(
                    'theme_location'  => 'menu-principal',
                    'container'       => '',
                    'menu_class'      => 'flex flex-col gap-2 text-sm text-sm font-medium text-gray-900',
                    'link_before'     => '<span class="hover:underline text-black">',
                    'link_after'      => '</span>',
                ))
                ?>
              <div class="flex flex-col space-y-2">
                <?php if (!is_user_logged_in()) : ?>
                    <!-- Affichage des boutons d'inscription et de connexion uniquement si l'utilisateur n'est pas connecté -->
                    <button class="px-4 py-2 bg-[#EAEAEA] text-gray-800 rounded-md hover:bg-gray-200">
                        <a href="<?php echo site_url('wp-login.php?action=register'); ?>">S'inscrire</a>
                    </button>
                    <button class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                        <a href="<?php echo site_url('login'); ?>">Se connecter</a>
                    </button>
                <?php else : ?>
                    <!-- Affichage du lien vers le profil si l'utilisateur est connecté -->
                    <button class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                        <a href="<?php echo get_edit_user_link(); ?>">Profil</a>
                    </button>
                <?php endif; ?>
            </div>
            </nav>
        </div>
    </header>

    <script>
        // JavaScript pour gérer le menu mobile
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>