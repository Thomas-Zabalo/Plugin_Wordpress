document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.btn-filter');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttons.forEach(btn => btn.classList.remove('bg-white', 'border-gray-800', 'text-gray-800', 'shadow-md'));
            this.classList.add('bg-white', 'border-gray-800', 'text-gray-800', 'shadow-md');

            const action = this.id;
            fetchProjects(action);
        });
    });

    function fetchProjects(action) {
        let taxonomyTerm = '';
        let actionreq = '';
        switch (action) {
            case 'btn-development-front':
                taxonomyTerm = 'developpement-front-end';
                break;
            case 'btn-development-back':
                taxonomyTerm = 'developpement-back-end';
                break;
            case 'btn-hebergement':
                taxonomyTerm = 'hebergement';
                break;
        }
        console.log(actionreq)
        // Envoi de la requête AJAX
        jQuery.ajax({
            url: adminAjax,
            type: "POST",
            data: {
                action: 'mmi_taxo',
                taxonomy_term: taxonomyTerm,
            },
            success: function (response) {
                if (response.success) {
                    // Remplacer le contenu de la section avec les nouveaux projets
                    document.getElementById('projects-container').innerHTML = response.data.html;
                } else {
                    console.error('Erreur:', response.data);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});
