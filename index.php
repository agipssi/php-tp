<?php
phpinfo();

echo "<hr><h2>Test connexion MySQL</h2>";

$host = 'mysql';
$db = 'ma_base';
$user = 'user';
$pass = 'user123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "<p style='color: green;'>✅ Connexion MySQL réussie!</p>";
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Erreur MySQL: " . $e->getMessage() . "</p>";
}
?>
