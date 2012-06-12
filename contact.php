<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Agencement Auvergne, page de contact</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Augustin de Laveaucoupet">
	<link rel="stylesheet" type="text/css" href="design.css">
	<!-- Date: 2010-07-05 -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11573363-9']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
		<div id="menu_gauche">
				<div id="logo">
					<img alt="Agencement Auvergne logo" src="images/logo.jpg" >
				</div>		
				<div id="menu">
					<ul>
						<li><a href="index.htm">Accueil</a></li>
						<li><a href="competences.htm">Compétences</a></li>
						<li><a href="realisation.htm">Réalisations</a></li>
						<li><a href="references.htm" >Références</a></li>
						<li><a href="contact.php" class="selected">Contact</a></li>
					</ul>
				</div>		
			
		</div>
		<div id="centre">
			<div id="titre_acceuil"><h1>Contactez-nous</h1></div>
			<div id="contact_logo">
				<p  style="float:left;">Agencement Auvergne
					<br/>25, rue des Grands Champs 
					<br/>04 70 98 27 67      06 80 23 20 61
					<br/>contact@agencement-auvergne.com
			 </p>
				
			</div>
			<div style="width: 700px; margin: auto; clear:both;margin-top: 10px;">

<?php
/**
 *	@author adelavea
 *	@version 1
 * 	17 dec. 08
 */

	/*
		********************************************************************************************
		CONFIGURATION
		********************************************************************************************
	*/
	// destinataire est votre adresse mail. Pour envoyer √† plusieurs √† la fois, s√©parez-les par une virgule
	$destinataire = 'desvoilhes.herve@orange.fr';

	// copie ? (envoie une copie au visiteur)
	$copie = 'non';

	// Action du formulaire (si votre page a des param√®tres dans l'URL)
	// si cette page est index.php?page=contact alors mettez index.php?page=contact
	// sinon, laissez vide

	// Messages de confirmation du mail
	$message_envoye = "Votre message nous est bien parvenu !";
	$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

	// Message d'erreur du formulaire
	$message_formulaire_invalide = "Vérifiez que tous les champs sont bien remplis et que l'adresse mail ne comporte aucune erreur.";

	/*
		********************************************************************************************
		FIN DE LA CONFIGURATION
		********************************************************************************************
	*/

	/*
	 * cette fonction sert √† nettoyer et enregistrer un texte
	 */
	function Rec($text)
	{
		$text = trim($text); // delete white spaces after & before text
		if (1 === get_magic_quotes_gpc())
		{
			$stripslashes = create_function('$txt', 'return stripslashes($txt);');
		}
		else
		{
			$stripslashes = create_function('$txt', 'return $txt;');
		}

		// magic quotes ?
		$text = $stripslashes($text);
		$text = htmlspecialchars($text, ENT_QUOTES); // converts to string with " and ' as well
		$text = nl2br($text);
		return $text;
	};

	/*
	 * Cette fonction sert √† v√©rifier la syntaxe d'un email
	 */
	function IsEmail($email)
	{
		$pattern = "^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,7}$";
		return (eregi($pattern,$email)) ? true : false;
	};

	$err_formulaire = false; // sert pour remplir le formulaire en cas d'erreur si besoin

	// si formulaire envoy√©, on r√©cup√®re tous les champs. Sinon, on initialise les variables.
	$nom     = (isset($_POST['nom']))         ? Rec($_POST['nom'])     : '';
	$email   = (isset($_POST['email']))       ? Rec($_POST['email'])   : '';
    $soc     = (isset($_POST['societe']))     ? Rec($_POST['societe'])     : '';
    $coordonee     = (isset($_POST['coordonees']))  ? Rec($_POST['coordonees'])     : '';
	$objet   = (isset($_POST['objet']))       ? Rec($_POST['objet'])   : '';
	$message = (isset($_POST['message']))     ? Rec($_POST['message']) : '';

	if (isset($_POST['email']))
	{
		// On va v√©rifier les variables et l'email ...
		$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erron√©, soit il vaut l'email entr√©
		$err_formulaire = (IsEmail($email)) ? false : true;

		if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
		{
			// les 4 variables sont remplies, on g√©n√®re puis envoie le mail
			$headers = 'From: '.$nom.' <'.$email.'>' . "\r\n";
			$message .= "\n\nInformation du visiteur: \n Nom : $nom \n Email : $email \n Societe : $soc \n Coordonnees : $coordonee";
			
			// envoyer une copie au visiteur ?
			if ($copie == 'oui')
			{
				$cible = $destinataire.','.$email;
			}
			else
			{
				$cible = $destinataire;
			};

			// Remplacement de certains caract√®res sp√©ciaux
			$message = html_entity_decode($message);
			$message = str_replace('&#039;',"'",$message);
			$message = str_replace('&#8217;',"'",$message);
			$message = str_replace('<br>','',$message);
			$message = str_replace('<br />','',$message);

			// Envoi du mail
			if (mail($cible, $objet, $message, $headers))
			{
				$monmessg =  '<p>'.$message_envoye.'</p>'."\n";
			}
			else
			{
				$monmessg =  '<p>'.$message_non_envoye.'</p>'."\n";
			};
		}
		else
		{
			// une des 3 variables (ou plus) est vide ...
			$monmessg =  '<p>'.$message_formulaire_invalide.' <a href="contact.php">Retour au formulaire</a></p>'."\n";
			$err_formulaire = true;
		};
	}; // fin du if (!isset($_POST['envoi']))

	if (($err_formulaire) || (!isset($_POST['email'])))
	{
?>
			<form action="contact.php" method="POST" name="form">
			    <table>
			        <tr>
			            <td>Nom / Pr&eacute;nom : </td>
			            <td><input type="text" name="nom" size="39"></td>
			        </tr>
			        <tr>
			            <td>Email : </td>

			            <td><input type="text" value="" name="email" size="39"></td>
			        </tr>
			        <tr>
			            <td>Soci&eacute;t&eacute; : </td>
			            <td><input type="text" value="" name="societe" size="39"></td>
			        </tr>
			        <tr>

			            <td>Coordonn&eacute;es : </td>
			            <td><input type="text" value="" name="coordonees" size="39"></td>
			        </tr>
			        <tr>
			            <td>Objet : </td>
			            <td><input type="text" value="" name="objet" size="39"></td>
			        </tr>

			        <tr>
			            <td>Message : </td>
			            <td><textarea name="message" cols="34" rows="6"></textarea></td>
			        </tr>
			        <tr>
			            <td colspan="2"><?php echo $monmessg; ?></td>
			        </tr>
			        <tr>
			            <td></td>
			            <td><input type="submit" value="Envoyer"></td>
			        </tr>
			    </table>
			</form>

<?php

	};



?>

			</div>
		</div>		
</body>
</html>