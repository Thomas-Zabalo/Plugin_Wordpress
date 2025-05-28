<!-- Template: ERREUR 404 -->
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>
</head>

<body class="overflow-hidden">
    <main class="h-screen w-full flex flex-col justify-center items-center">
        <h1 class="text-9xl font-extrabold tracking-widest text-[#11827]">404</h1>
        <div class="bg-[#88bbff] px-2 text-sm rounded rotate-12 absolute">
            Cette page est introuvable
        </div>
        <div class="flex gap-x-10">
            <button class="mt-5">
                <a
                    href="<?php echo site_url('/'); ?>"
                    class="relative inline-block text-sm font-medium text-[#88bbff] group active:text-[#3f679d] focus:outline-none focus:ring">
                    <span
                        class="absolute inset-0 transition-transform translate-x-0.5 translate-y-0.5 bg-[#88bbff] group-hover:translate-y-0 group-hover:translate-x-0"></span>

                    <span class="relative block px-8 py-3 bg-[#E1EDFD] border border-current">
                        Accueil
                    </span>
                </a>
            </button>
            <button class="mt-5"  onclick="history.back();">
                <a 
                    class="relative inline-block text-sm font-medium text-[#88bbff] group active:text-[#3f679d] focus:outline-none focus:ring">
                    <span
                        class="absolute inset-0 transition-transform translate-x-0.5 translate-y-0.5 bg-[#88bbff] group-hover:translate-y-0 group-hover:translate-x-0"></span>

                    <span class="relative block px-8 py-3 bg-[#E1EDFD] border border-current">
                        Page précedente
                    </span>
                </a>
            </button>
        </div>
    </main>

    <?php wp_footer(); ?>

</body>

</html>