<?php include('../global/haut.php'); ?><span class="sstitre">api : ups</span></div>

<p><u>Principe :</u><br />
Cette api vous permet de suivre vos colis UPS. Il n'est pas nécessaire d'avoir un compte UPS, il suffit simplement du numéro de colis (1Zxxxxxxxxxxxxxxxxx).<br />
</p>
<p><u>Utilisation :</u><br />
Appeler l'adresse : http://api.ntag.fr/ups/?id=id+du+colis<br />
Le format de retour est le <em>JSON</em>.<br /><br />
<u>Paramètres :</u><br />
<table>
	<thead>
		<tr>
			<td>Paramètre</td>
			<td>Valeurs</td>
			<td>Informations</td>
			<td>Optionnel</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>id</td>
			<td>Format 1Zxxxxxxxxxxxxxxxxx</td>
			<td>Numéro de colis UPS</td>
			<td>Obligatoire</td>
		</tr>
	</tbody>
</table>
<br />
<u>Réponse</u><br />
<table>
	<thead>
		<tr>
			<td>Nom</td>
			<td>Informations</td>
			<td>Optionnel</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>date_d</td>
			<td>Date de départ</td>
			<td>non</td>
		</tr>
		<tr>
			<td>date_a[date]</td>
			<td>Date d'arrivée</td>
			<td>non</td>
		</tr>
		<tr>
			<td>date_a[hour]</td>
			<td>Heure d'arrivée</td>
			<td>non</td>
		</tr>
		<tr>
			<td>weight</td>
			<td>Poids</td>
			<td>non</td>
		</tr>
		<tr>
			<td>number</td>
			<td>Nombre de colis</td>
			<td>non</td>
		</tr>
		<tr>
			<td>destination[city]</td>
			<td>Ville de destination</td>
			<td>non</td>
		</tr>
		<tr>
			<td>destination[country]</td>
			<td>Pays de destination</td>
			<td>non</td>
		</tr>
		<tr>
			<td>stapes</td>
			<td>Tableau contenant le parcours du colis</td>
			<td>non</td>
		</tr>
		<tr>
			<td>stapes[][city]</td>
			<td>Ville</td>
			<td>non</td>
		</tr>
		<tr>
			<td>stapes[][country]</td>
			<td>Pays</td>
			<td>non</td>
		</tr>
		<tr>
			<td>stapes[][date]</td>
			<td>Date</td>
			<td>non</td>
		</tr>
		<tr>
			<td>stapes[][hour]</td>
			<td>Heure</td>
			<td>non</td>
		</tr>
		<tr>
			<td>stapes[][activity]</td>
			<td>Activité (Scan de départ, d'arrivée...)</td>
			<td>non</td>
		</tr>
	</tbody>
</table>

<?php include('../global/bas.php'); ?>
