<?php

class GestionAutomovilesAuth {

    private $dbLink;

    public function __construct() {
        $host = 'host';
        $db   = 'db';       
        $user = 'user';         
        $pass = 'pass';            
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->dbLink = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            // Error de conexión: detenemos todo para que lo veas
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
    public function authenticate($username, $password) {
        
        // Verificamos credenciales
        if($username == 'ies' && $password == 'daw') {
            setcookie('usuario_logueado', 'true', time() + 3600, "/");

            return true;

        } else {
            throw new Exception('Wrong user/pass combination'); 
        } 
    }

    // obtener marcas y urls
    public function ObtenerMarcasUrl() {
        try {
            // cogemos columnas de la tabla 'marcas'
            $stmt = $this->dbLink->query("SELECT marca, url FROM marcas");
            
            $resultado = [];
            while ($row = $stmt->fetch()) {
                // Formato: ['Ford' => 'https://...', 'Audi' => 'https://...']
                $resultado[$row['marca']] = $row['url'];
            }
            
            return $resultado;

        } catch (PDOException $e) {
            return [];
        }
    }

    // lista de modelos 
    public function ObtenerModelosPorMarca($marcaNombre) {
        try {
            $query = "SELECT m.modelo 
                    FROM modelos m 
                    JOIN marcas ma ON m.marca = ma.id 
                    WHERE ma.marca = ?";
            
            $stmt = $this->dbLink->prepare($query);
            $stmt->execute([$marcaNombre]);
            
            //da un array simple
            return $stmt->fetchAll(PDO::FETCH_COLUMN);

        } catch (PDOException $e) {
            return [];
        }
    }
}

//inicializamos clase
$client = new GestionAutomovilesAuth();

?>