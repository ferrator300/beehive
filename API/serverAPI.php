<?php
require 'BDDAPI.php';
class Server 
{
    
    /* 	Function: ValidarTokenInicial
		
		Valida si el Token passat per paràmetre es vàlid. Ho compara amb un token intern que sempre es el mateix
        Això ho fa per assegurar que passem un token per header.
			
        Parameters:
            $token - Token Taula Usuari.

		Returns:
			True si el token es vàlid o False si no ho es.
	*/
    private function ValidarTokenInicial($clau)
    {
        $token="93f6fcb6e19783a2c52c6049";
        $tokenHash=hash("sha256", $token);

        if($tokenHash==$clau){
            return true;
        }
        else 
            return false;
    }
    /* 	Function: ValidarTokenTaulaToken
		
		Valida si el Token passat per paràmetre es vàlid. El busca a la TaulaToken de la base de dades
			
        Parameters:
            $token - Token Taula Usuari.

		Returns:
			True si el token es vàlid o False si no ho es.
	*/
    private function ValidarTokenTaulaToken($clau)
    {
        $database = new BDD();
        $database->connect();

        if($database->validarToken($clau)){
            return true;
        }
        return false;
        
    }

    /* 	Function: ValidarTokenTaulaUsuari
		
		Valida si el Token passat per paràmetre es vàlid. El busca a la taula Usuari de la base de dades
			
        Parameters:
            $token - Token Taula Usuari.

		Returns:
			True si el token es vàlid o False si no ho es.
	*/
    private function ValidarTokenTaulaUsuari($clau)
    {
        $database = new BDD();
        $database->connect();

        if($database->validarTokenUsuari($clau)){
            return true;
        }
        return false;  
    }
    
    /* 	Function: generateToken
		
		Genera un Token Random
			
		Returns:
			Token random
	*/
    private function generateToken() 
    {
        return bin2hex(random_bytes(12));
    }

    /* 	Function: generarTokenUsuari
		
		Genera un Token amb informació de l'usuari passada per paràmetre
			
        Parameters:
            $email - Email de l'usuari (Clau Primària)
            $token- Token Usuari

		Returns:
            Token creat amb informació de l'usuari (Hash)
	*/
    private function generarTokenUsuari($email, $token) 
    {
        $email_hash = hash("md5", $email);
        $token_hash = hash("md5", $token);
        $validation_hash = hash("md5", $email.$token);
        return $email_hash . "." . $token_hash . "." . $validation_hash;
    }

    //Principal
    public function serve() 
    {        
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Això seria Localhost
        array_shift($paths); // /BEEHIVE
        array_shift($paths);// /API
        $resource = array_shift($paths); //Localitzador (Usuari, Token o Tasca)
        $accio = array_shift($paths); // Token o Ciutat

        //Si ens demanen Token
		if($resource == 'Token')
        {
            $token = json_decode(file_get_contents('php://input'));

            if($this->ValidarTokenInicial($token)){
                
                $tokenBDD=$this->generateToken();
                //echo json_encode($tokenBDD);

                $database = new BDD();
                $database->connect();

                if ($database->afegirTokenTaulaToken($tokenBDD)){
                    echo json_encode($tokenBDD);
                }

                
            }
            
		}
        else if($resource == 'Usuari'){
            
            if($accio=="Login"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaToken($data['token'])){

                    $database = new BDD();
                    $database->connect();

                    if($database->login($data['username'],$data['password']))
                    {
                        //Recuperem Informació de l'usuari
                        $usuari=$database->login($data['username'],$data['password']);

                        //Generem el Token amb informació de l'usuari
                        $tokenUsuari=$this->generarTokenUsuari($usuari["Email"],$data['token']);
                        
                        //Afegim el Token a la Taula Usuari, al usuari logejat
                        $database->afegirToken($usuari["Email"], $tokenUsuari);

                        //Eliminem el Token de TaulaToken
                        $database->eliminarTokenTaula($data['token']);

                        //Retornem el Token de l'usuari
                        header('HTTP/1.1 200 OK. Usuari Logejat Correctament');
                        echo json_encode($tokenUsuari);
                    }
                    else
                        header('HTTP/1.1 400 Usuari o Contrasenya Incorrecte.');
                    
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token no Vàlid');
                
            }
            else if($accio=="Crear"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();

                    $user=json_decode($database->recuperarUsauri($data['token']), true);
                    
                    if($user['Rol'] == "Admin")
                    {
                        if($database->addUser($data['username'],$data['password'],$data['email'],$data['rol']))
                            header('HTTP/1.1 200 OK. Usuari Registrat Correctament');
                        else
                            header('HTTP/1.1 400. Error al Inserir Usuari');
                        
                    }
                    else
                    {
                        header('HTTP/1.1 403 Forbidden. No ets Administrador, No pots Afegir Usuaris');
                    }      
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else if($accio=="Eliminar")
            {
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();
                    
                    $user=json_decode($database->recuperarUsauri($data['token']), true);
                    
                    if($user['Rol'] == "Admin")
                    {
                        if($database->comprovarLlistaTasques($data['email'])){
                            header('HTTP/1.1 403 Forbidden. No pots Eliminar un Usuari que té Tasques Assignades');
                        }
                        else{
                            $database->eliminarUsuari($data['email']);
                            header('HTTP/1.1 200 OK. Usuari Eliminat Correctament');
                        }
                        
                    }
                    else
                        header('HTTP/1.1 403 Forbidden. No ets Administrador, No pots Eliminar');
                     
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token no vàlid');
            }
            else if($accio=="Editar")
            {
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();
                    
                    $user=json_decode($database->recuperarUsauri($data['token']), true);
                    
                    if($user['Rol'] == "Admin")
                    {
                        $database->actualitzarUsuari($data['username'],$data['email'],$data['password'],$data['rol'],);
                        header('HTTP/1.1 200 OK. Usuari Actualitzat Correctament');
                    }
                    else
                    {
                        header('HTTP/1.1 403 Forbidden. No ets Administrador, No pots Actualitzar');
                    }      
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else if($accio=="Llistat")
            {
                $token = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($token)){

                    $database = new BDD();
                    $database->connect();

                    $user=json_decode($database->recuperarUsauri($token), true);
                    
                    if($user['Rol'] == "Admin" || $user['Rol'] == "Gestor"){
                        echo $database->llistaUsuaris();
                    }
                    else{
                        header('HTTP/1.1 403 Forbidden. No ets Administrador o Gestor, No pots demanar llistat de usuaris');
                    }   
                }
                else
                        header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else{
                header('HTTP/1.1 404 Not Found . Algo ha fallat');
            }
        }
        else if($resource == 'Tasca'){

            if($accio == "Crear"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();

                    $user=json_decode($database->recuperarUsauri($data['token']), true);

                    if($user['Rol'] == "Admin" || $user['Rol'] == "Gestor"){

                        if($database->afegirTasca($data['nomTasca'],$data['descripcio'],$data['dataInici'],$data['dataFi'],$data['estat'],$data['prioritat'],$data['comentaris'],$data['email'])){
                            header('HTTP/1.1 200 OK. Tasca Afegida Correctament');
                        }
                    }
                    else{
                        header('HTTP/1.1 403 Forbidden. No ets Administrador o Gestor, No pots crear Tasques');
                    }   
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else if($accio=="Llistat"){
                
                $token = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($token)){

                    $database = new BDD();
                    $database->connect();
                    
                    $user=json_decode($database->recuperarUsauri($token), true);

                    if($user['Rol'] == "Admin" || $user['Rol'] == "Gestor"){
                        echo $database->llistaTasques();
                    }
                    else if($user['Rol'] == "Tecnic"){
                        echo $database->llistaTasquesTecnic($user['Email']);
                    }  
                    else{
                        header('HTTP/1.1 400 Error al Recuperar el Llistat de les Tasques');
                    }   
                     
                    
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else if($accio=="Editar"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();

                    $user=json_decode($database->recuperarUsauri($data['token']), true);

                    if($user['Rol'] == "Admin" || $user['Rol'] == "Gestor")
                    {
                        if($database->actualitzarTasca($data['id'],$data['nomTasca'],$data['descripcio'],$data['dataInici'],$data['dataFi'],$data['estat'],$data['prioritat'],$data['comentaris'],$data['email'])){
                            header('HTTP/1.1 200 OK. Tasca Actualitzada Correctament');
                        }
                        else
                            header('HTTP/1.1 500 ERROR. Error al Actualitzar la Tasca');
                         
                    }
                    else{
                        header('HTTP/1.1 403 Forbidden. No ets Administrador o Gestor, No pots editar Tasques');
                    }  
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else if($accio=="Eliminar")
            {
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token']))
                {

                    $database = new BDD();
                    $database->connect();
                    
                    $user=json_decode($database->recuperarUsauri($data['token']), true);

                    if($user['Rol'] == "Admin" || $user['Rol'] == "Gestor")
                    {
                        if($database->eliminarTasca($data['id'])){
                            header('HTTP/1.1 200 OK. Tasca Eliminada Correctament');
                        }
                        else
                            header('HTTP/1.1 500 ERROR. Error al Eliminar la Tasca');
                    }
                    else{
                        header('HTTP/1.1 403 Forbidden. No ets Administrador o Gestor, No pots eliminar Tasques');
                    }   
                }
                else
                    header('HTTP/1.1 401 Unauthorized. Token No Vàlid');
            }
            else if($accio=="Tramit"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();
                    
                    if($database->actualitzarEstat($data['estat'],$data['id'])){
                        header('HTTP/1.1 200 OK. Tasca Tramitada Correctament');
                    }
                    else
                        header('HTTP/1.1 500 ERROR. Error al Tramitar la Tasca');
                }
                else
                    header('HTTP/1.1 401 Unauthorized Token No Valid');
            }
            else
                header('HTTP/1.1 404 Not Found . Algo ha fallat');

        }
        else{
            header('HTTP/1.1 404 Not Found . Algo ha fallat');
        }     
    } 
}
$server = new Server;
$server->serve();

?>