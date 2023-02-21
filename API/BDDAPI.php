<?php
class BDD {
    private $host = "localhost";
    private $dbname = "BEEHIVE";
    private $username = "adminer";
    private $password = "03PfgNRL8!";
    private $conn;

    /* 	Function: connect
		
		Ens Connecta a la Base de Dades
			
		Returns:
			Si falla ens retorna missatge d'error
	*/
    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            // Configura la conexión para que muestre errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
    
    /* 	Function: addUser
		
		Afageix un usuari a la Base de Dades
		
		Parameters:
			$username - Nom d'usuari
			$password - Contrasenya Encriptada de l'usuari
            $email - Correu Electronic de l'usuari (Clau Primària)
			$rol - Rol de l'usuari
			
		Returns:
			True o False depenent si la inserció s'ha executat correctament
	*/
    public function addUser($username, $password, $email, $rol) {
    
        $stmt = $this->conn->prepare("INSERT INTO Usuari (Contrasenya, Email, Nom, Rol) VALUES (:password, :email, :username,  :rol)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    }
     /* 	Function: afegirTasca
		
		Afageix una Tasca a la Base de Dades
		
		Parameters:
			$nom - Nom de la Tasca
			$descripcio - Descripció de la Tasca
            $datainici - Data d'inici de la Tasca
			$datafi - Data final de la Tasca
            $estat - Estat de la Tasca
			$prioritat - Prioritat de la Tasca
            $comentaris - Comentaris de la Tasca
			$email - Persona a qui esta assignada la Tasca
			
		Returns:
			True o False depenent si la inserció s'ha executat correctament
	*/
    public function afegirTasca($nom, $descripcio, $datainici, $datafi, $estat, $prioritat, $comentaris, $email) {
    
        $stmt = $this->conn->prepare("INSERT INTO Tasca (Nom, Descripcio, DataInici, DataFi, Estat, Prioritat, Comentaris, Email) VALUES (:nom, :descripcio, :datainici,  :datafi, :estat, :prioritat, :comentaris, :email)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':descripcio', $descripcio);
        $stmt->bindParam(':datainici', $datainici);
        $stmt->bindParam(':datafi', $datafi);
        $stmt->bindParam(':estat', $estat);
        $stmt->bindParam(':prioritat', $prioritat);
        $stmt->bindParam(':comentaris', $comentaris);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
        //Insert Into Tasca (Nom, Descripcio, DataInici, DataFi, Estat, Prioritat, Comentaris, Email) Values ("Treballar", "DescTreb", "2023-02-01", "2023-02-02" , "todo", 7, "Coments", "sendwaifu@gmail.com");
    }

    /* 	Function: afegirTokenTaulaToken
		
		Afageix un Token a la taula TaulaToken de la Base de Dades
		
		Parameters:
			$token - Token
			
			
		Returns:
			True o False depenent si la inserció s'ha executat correctament
	*/
    public function afegirTokenTaulaToken($token) {

        $stmt = $this->conn->prepare("INSERT INTO TaulaToken (Token, DataCad) VALUES (:token, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
        
        return false;
    }

    /* 	Function: validarToken
		
		Comprova si el Token existeix a la TaulaToken de la Base de Dades
		
		Parameters:
			$token - Token
			
			
		Returns:
			True o False depenent si el token existeix o no.
	*/
    public function validarToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM TaulaToken WHERE Token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    /* 	Function: validarTokenUsuari
		
		Comprova si el Token de la Taula Usuari existeix.
		
		Parameters:
			$token - Token
			
			
		Returns:
			True o False depenent si el token existeix o no.
	*/
    public function validarTokenUsuari($token) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuari WHERE Token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /* 	Function: login
		
		Verifica si el username i la contrasenya són correctes.
		
		Parameters:
			$username - Nom d'usuari
			$password - Contrasenya Encriptada de l'usuari
			
		Returns:
			Ens retorna l'informació de l'usuari (Nom, Email, Rol)
	*/
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuari WHERE Email = :email AND Contrasenya = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	
    }

    /* 	Function: actualitzarEstat
		
		Canvia el estat d'una tasca (To do, On Going)
		
		Parameters:
			$estat - Nou estat de la Tasca a canviat
			$id - Id de la Tasca (Numeric autoincremental)
			
		Returns:
			True o False depenent si la actualització s'ha fet correctament
	*/
    public function actualitzarEstat($estat, $id, $comentaris) {
        $stmt = $this->conn->prepare("UPDATE Tasca SET Estat = :estat, Comentaris = :comentaris WHERE IdTasca = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':comentaris', $comentaris);
        $stmt->bindParam(':estat', $estat);
        return $stmt->execute();
    }

    /* 	Function: actualitzarUsuari
		
		Actualitza camps d'un Usuari de la Taula Usuari
		
		Parameters:
			$token - Token Usuari (Admin)
			$nom - Nou Nom d'usuari
            $email - Nou email de l'usuari
			$contrasenya - Nova Contrasenya (Encriptada) de l'usuari
            $rol - Nou Rol de l'usuari (Gestor o Tècnic)
			
		Returns:
			True o False depenent si la actualització s'ha fet correctament
	*/
    public function actualitzarUsuari($nom,$email,$contrasenya,$rol) {
        $stmt = $this->conn->prepare("UPDATE Usuari SET Nom = :nom,Contrasenya = :contrasenya, Rol = :rol WHERE Email = :email");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasenya', $contrasenya);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    }

    /* 	Function: actualitzarTasca
		
		Actualitza camps d'una Tasca de la Taula Tasca
		
		Parameters:
			$id - Id de la Tasca
			$nom - Nou Nom de la Tasca
            $descripcio - Nova descripció de la Tasca
			$datainici - Nova data d'inici de la Tasca
            $datafi - Nova data final de la Tasca
            $estat - Nou Estat de la Tasca
            $prioritat - Nova prioritat de la Tasca
			$comentaris - Nous Comentaris de la Tasca
            $email - Nou Encarregat de la Tasca
			
		Returns:
			True o False depenent si la actualització s'ha fet correctament
	*/
    public function actualitzarTasca($id,$nom, $descripcio, $datainici, $datafi, $estat, $prioritat, $comentaris, $email) {
        $stmt = $this->conn->prepare("UPDATE Tasca SET Nom = :nom, Descripcio = :descripcio, DataInici = :datainici, DataFi = :datafi, Estat = :estat, Prioritat = :prioritat, Comentaris = :comentaris, Email = :email WHERE IdTasca = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':descripcio', $descripcio);
        $stmt->bindParam(':datainici', $datainici);
        $stmt->bindParam(':datafi', $datafi);
        $stmt->bindParam(':estat', $estat);
        $stmt->bindParam(':prioritat', $prioritat);
        $stmt->bindParam(':comentaris', $comentaris);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    /* 	Function: afegirToken
		
		Afageix un token al camp Token de la Taula Usuari de la Base de Dades
		
		Parameters:
            $email - Email de l'usuari (Clau Primària)
            $id - Token Usuari
			
		Returns:
			True o False depenent si la actualització s'ha fet correctament
	*/
    public function afegirToken($email, $token) {
        $stmt = $this->conn->prepare("UPDATE Usuari SET Token = :token WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    /* 	Function: eliminarTokenTaula
		
		Elimina un Token de la Taula TaulaToken
		
		Parameters:
            $Token - Token a Eliminar
			
		Returns:
			True o False depenent si la eliminació s'ha fet correctament
	*/
    public function eliminarTokenTaula($token) {
        $stmt = $this->conn->prepare("DELETE from TaulaToken where Token = :token");
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    /* 	Function: eliminarUsuari
		
		Elimina un Usuari de la Taula Usuari
		
		Parameters:
            $email - Correu electrònic de l'Usuari a Eliminar
			
		Returns:
			True o False depenent si la eliminació s'ha fet correctament
	*/
    public function eliminarUsuari($email) {
        $stmt = $this->conn->prepare("DELETE from Usuari where Email = :email");
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    /* 	Function: eliminaTasca
		
		Elimina una Tasca de la Taula Tasca
		
		Parameters:
            $id - Id de la Tasca a Eliminar
			
		Returns:
			True o False depenent si la eliminació s'ha fet correctament
	*/
    public function eliminarTasca($id) {
        $stmt = $this->conn->prepare("DELETE from Tasca where IdTasca = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /* 	Function: llistaUsuaris
		
		Recupera un llistat d'usuaris
			
		Returns:
			Llista dels Usuari de la Taula Usuaris de la Base de Dades en format JSON
	*/
    public function llistaUsuaris() {
        try {
            $stmt = $this->conn->prepare("SELECT Nom, Email, Rol FROM Usuari WHERE Rol != 'Admin'");
            $stmt->execute();
            $result = $stmt->fetchAll();
            return json_encode($result);
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
    

    /* 	Function: recuperarUsauri
		
		Recupera l'informació de l'usuari a partir del seu Token
			
        Parameters:
            $token - Token Taula Usuari.

		Returns:
			Recupera l'informació de l'usuari de la Base de Dades en format JSON
	*/
    public function recuperarUsauri($token) {
        try {
            $stmt = $this->conn->prepare("SELECT Nom, Email, Rol FROM Usuari WHERE Token= :token");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

    /* 	Function: llistaTasques
		
		Recupera totes les Tasques de la Taula Tasca de la Base de Dades
			
		Returns:
			Llista de totes les Tasques de la Taula Tasca de la Base de Dades en format JSON
	*/
    public function llistaTasques() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Tasca");
            $stmt->execute();
            $result = $stmt->fetchAll();
            return json_encode($result);
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
    /* 	Function: llistaTasquesTecnic
		
		Recupera les Tasques de la Taula Tasca de la Base de Dades Assignades a un Usuari que passem per paràmetre
			
        Parameters:
            $email - Correu Electrònic de l'usuari.

		Returns:
			Llista de totes les Tasques de la Taula Tasca de la Base de Dades en format JSON
	*/
    public function llistaTasquesTecnic($email) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Tasca WHERE Email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return json_encode($result);
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

    /* 	Function: comprovarLlistaTasques
		
		Comprova si l'usuari el qual passem per paràmetre, té tasques assignades.
			
        Parameters:
            $email - Correu Electrònic de l'usuari.

		Returns:
			True o False depenent si te tasques assignades
	*/
    public function comprovarLlistaTasques($email) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Tasca WHERE Email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

}
?>