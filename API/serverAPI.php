<?php
require 'BDDAPI.php';
class Server 
{
    
    //Funcio que valida si la Token es vàlida. Si es vàlida retornem true.
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
    private function ValidarTokenTaulaToken($clau)
    {
        $database = new BDD();
        $database->connect();

        if($database->validarToken($clau)){
            return true;
        }
        return false;
        
    }
    private function ValidarTokenTaulaUsuari($clau)
    {
        $database = new BDD();
        $database->connect();

        if($database->validarTokenUsuari($clau)){
            return true;
        }
        return false;  
    }
    
    private function generateToken() 
    {
        return bin2hex(random_bytes(12));
    }

    private function generarTokenUsuari($email, $token) 
    {
        $email_hash = hash("md5", $email);
        $token_hash = hash("md5", $token);
        $validation_hash = hash("md5", $email.$token);
        return $email_hash . "." . $$token_hash . "." . $validation_hash;
    }

    //Principal
    public function serve() 
    {        
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Això seria Localhost
        // array_shift($paths); // /BEEHIVE
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
                        $usuari=$database->login($data['username'],$data['password']);

                        $tokenUsuari=$this->generarTokenUsuari($usuari["Email"],$data['token']);
                        
                        $database->afegirToken($usuari["Email"], $tokenUsuari);

                        $database->eliminarTokenTaula($data['token']);

                        echo json_encode($tokenUsuari);
                    }
                    else
                        header('HTTP/1.1 400 Usuari o Contrasenya Incorrecta.');
                    
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
                            echo json_encode("Usuari Afegit");
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
                        $database->eliminarUsuari($data['email']);
                        echo json_encode("Usuari Eliminat");
                    }
                    else
                    {
                        header('HTTP/1.1 403 Forbidden. No ets Administrador, No pots Eliminar');
                    }     
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
                        echo json_encode("Usuari Actualitzat");
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
                header('HTTP/1.1 401 Unauthorized. Error General');
            }
        }
        else if($resource == 'Tasca'){

            if($accio == "Crear"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();

                    if($user['Rol'] == "Admin" || $user['Rol'] == "Gestor"){

                        if($database->afegirTasca($data['nomTasca'],$data['descripcio'],$data['dataInici'],$data['dataFi'],$data['estat'],$data['prioritat'],$data['comentaris'],$data['email'])){
                            echo json_encode("Tasca Afegida");
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
                    header('HTTP/1.1 401 Unauthorized');
            }
            else if($accio=="Editar"){
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();

                     if($database->actualitzarTasca($data['id'],$data['nomTasca'],$data['descripcio'],$data['dataInici'],$data['dataFi'],$data['estat'],$data['prioritat'],$data['comentaris'],$data['email'])){
                         echo json_encode("Tasca Actualitzada");
                     }
                     else
                         header('HTTP/1.1 401 Unauthorized');
                    
                }
                else
                    header('HTTP/1.1 401 Unauthorized');
            }
            else if($accio=="Eliminar"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();
                    
                    $database->eliminarTasca($data['id']);

                    echo json_encode("Tasca Eliminada");
                }
                else
                        header('HTTP/1.1 401 Unauthorized');
            }
            else if($accio=="Tramit"){
                
                $data = json_decode(file_get_contents('php://input'), true);

                if($this->ValidarTokenTaulaUsuari($data['token'])){

                    $database = new BDD();
                    $database->connect();
                    
                    $database->actualitzarEstat($data['estat'],$data['id']);

                    echo json_encode("Tasca Tramitada");
                }
                else
                        header('HTTP/1.1 401 Unauthorized');
            }

        }
        else{
            header('HTTP/1.1 404 Not Found');
        }

           
    } 

}
  

$server = new Server;
$server->serve();

?>