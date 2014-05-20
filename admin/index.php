<?php
             //--------------------------------------------------------------------------
            //                      CONNEXION AU RCON POUR ENVOYER DES COMMANDES AU SERVEUR
            //--------------------------------------------------------------------------
            require_once('Rcon.class.php');

            $r = new rcon("127.0.0.1",25567,"ichbinpassword"); // Remplacer l'ip, le port et le mot de passe par les votres

            if(isset($_POST['submit'])){

                    $command = $_POST['command'];

                            if($r->Auth())
                            {
                            $r->rconCommand($command);
                            }
            }

            //--------------------------------------------------------------------------
            //              CONNEXION AU QUERY POUR RECEVOIR DES INFORMATIONS DE VOTRE SERVEUR
            //--------------------------------------------------------------------------
	// Edit this ->
	define( 'MQ_SERVER_ADDR', '127.0.0.1' );
	define( 'MQ_SERVER_PORT', 25566 );
	define( 'MQ_TIMEOUT', 1 );
	// Edit this <-

	// Display everything in browser, because some people can't look in logs for errors
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', true );

	require __DIR__ . '/MinecraftQuery.class.php';

	$Timer = MicroTime( true );

	$Query = new MinecraftQuery( );

	try
	{
		$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	}
	catch( MinecraftQueryException $e )
	{
		$Exception = $e;
	}

	$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Admin Minecraft</title>
	<link rel="shortcut icon" href="//cedced19.github.io/img/favicon.ico" type="image/x-icon" />
        	<link rel="icon" href="//cedced19.github.io/img/favicon.ico" type="image/x-icon" />

	<link rel="stylesheet" href="bootstrap.css">
	<style type="text/css">
		.jumbotron {
			margin-top: 30px;
			border-radius: 0;
		}

		.table thead th {
			background-color: #428BCA;
			border-color: #428BCA !important;
			color: #FFF;
		}
	</style>
</head>

<body>
    <div class="container">
    	<div class="jumbotron">
			<h1>Serveur de Cedced19</h1>

			<p>C'est une page d'administration.</p>

                                       <p>
                                       <a class="btn btn-large btn-success" href="serverping.php">Serveur Ping</a>
                                       </p>

			<p>
				<a class="btn btn-large btn-primary" href="//cedced19.github.io">Crée par Cedced19</a>
				<a class="btn btn-large btn-primary" href="//github.com/cedced19/CLaunch/tree/gh-pages/admin/">Regarder sur GitHub</a>
				<a class="btn btn-large btn-danger" href="//creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0</a>
			</p>
		</div>

<?php if( isset( $Exception ) ): ?>
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo htmlspecialchars( $Exception->getMessage( ) ); ?></div>
			<p><?php echo nl2br( $e->getTraceAsString(), false ); ?></p>
		</div>
<?php else: ?>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th colspan="2">Server Info <em>(en <?php echo $Timer; ?>s)</em></th>
						</tr>
					</thead>
					<tbody>
<?php if( ( $Info = $Query->GetInfo( ) ) !== false ): ?>
<?php foreach( $Info as $InfoKey => $InfoValue ): ?>
						<tr>
							<td><?php echo htmlspecialchars( $InfoKey ); ?></td>
							<td><?php
	if( Is_Array( $InfoValue ) )
	{
		echo "<pre>";
		print_r( $InfoValue );
		echo "</pre>";
	}
	else
	{
		echo htmlspecialchars( $InfoValue );
	}
?></td>
						</tr>
<?php endforeach; ?>
<?php else: ?>
						<tr>
							<td colspan="2">Aucune information</td>
						</tr>
<?php endif; ?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Players</th>
						</tr>

					</thead>
					<tbody>
<?php if( ( $Players = $Query->GetPlayers( ) ) !== false ): ?>
<?php foreach( $Players as $Player ): ?>
						<tr>
							<td><?php echo htmlspecialchars( $Player ); ?><?php echo '<img src="skin.php?a=5&w=5&wt=-25&abg=0&abd=-30&ajg=-25&ajd=30&ratio=15&format=png&displayHairs=²true&headOnly=false&login='.htmlspecialchars( $Player ).'"  alt="'.htmlspecialchars( $Player ).'" height="507" width="252" />';?></td>
						</tr>
<?php endforeach; ?>
<?php else: ?>
						<tr>
							<td>Pas de player</td>
						</tr>
<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
                            <!-- Envoie de commande -->
                                <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                        <th>Envoyer une commande</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                                <tr>
                                                        <td>
                                                                <form method="post" role="form">
                                                                        <div class="input-group">
                                                                                <input type="text" name="command" class="form-control" placeholder="Entrez votre commande">
                                                                                <span class="input-group-btn">
                                                                                <input type="submit" name="submit" class="btn btn-default" value="Envoyer" />
                                                                                </span>
                                                                        </div>
                                                                </form>

                                                        </td>
                                                </tr>
                                        </tbody>

                                </table>

                        </div>
                </div>
<?php endif; ?>
	</div>
</body>
</html>
