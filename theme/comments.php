<!-- Template: Commentaire -->
 
<section class="pt-8" id="comments">
	<?php
	// Vérifie si les commentaires sont ouverts pour ce post
	if (!comments_open()) {
		echo '<p>Les commentaires sont fermés.</p>'; // Message si les commentaires sont fermés
	} else {
		// Affiche le formulaire de commentaires si les commentaires sont ouverts
		comment_form(array());
	} ?>

	<?php if (have_comments()) : // Si des commentaires existent pour ce post 
	?>
		<h2 class="comments-title">
			<?php
			// Récupère le nombre de commentaires et l'affiche
			$comments_number = get_comments_number();
			if ($comments_number === 1) {
				echo '1 commentaire'; // Si 1 commentaire, on affiche "1 commentaire"
			} else {
				echo $comments_number . ' commentaires'; // Affiche le nombre total de commentaires
			}
			?>
		</h2>
		<!-- Liste des commentaires -->
		<div class="comments-list">
			<?php
			// Liste et affiche les commentaires
			wp_list_comments(array());
			?>
		</div>
	<?php endif; ?>
</section>