<?php

// Get Key
(isset($_GET['key']) && ($_GET['key'] == "AuqiDOu0C6DnzbWGFEr0KUWX0zsJoI2qsel5zOqJ")) or die('Forbidden');

// Connexion to DB
$dbhost = '';
$dbname = '';
$dbuser = '';
$dbpass = '';

try {
	$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
} catch(Exception $e) {
	die('The database is temporarily down.');
}

$q = $db->query('SELECT * FROM user, game WHERE user.user_id = game.user_id ORDER BY user.user_id DESC');
$r = $q->fetchall(PDO::FETCH_OBJ);
?>

<html>
<head>
	<title>Participants</title>
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<style>
		body {
			font-family: Arial;
			color: #171B1E;
			padding: 0;
			margin: 0;
		}
		table {
			width: 100%;
			margin-bottom: 40px;
		}
		td, th {
			padding:5px;
		}
		th {
			background: #47515b;
			color: #fff;
		}
		tr:nth-child(even) {
			background: #e3e7ea;
		}
		tr:nth-child(odd) {
			background: #f1f3f4;
		}
		tr:hover {
			background: #47515b;
			color: #fff;
		}
		.pin {
			background:#87D37C;
			font-weight:bold;
		}
	</style>
</head>
<body>
	<table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Score</th>
			<th>Answers</th>
			<th>Created at</th>
		</tr>
			<?php foreach ($r as $user) { ?>
				<tr>
					<td><?php echo $user->user_id ?></td>
					<td><?php echo $user->name ?></td>
					<td><?php echo $user->score ?></td>
					<td><?php echo $user->answers ?></td>
					<td><?php echo $user->created_at ?></td>
				</tr>
			<?php } ?>
	</table>

</body>
</html>