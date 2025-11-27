<?php 
 namespace techfit_php; 
class administradorDAO { 
    private $administradoresArray = []; // array associativo

    private $arquivoJson = 'administradores.json'; // arquivo onde os dados serao salvos
    public function __construct() { //carrega os dados do arquivo JSON, se existir
        if (file_exists($this->arquivoJson)) {
            $conteudoArquivo = file_get_contents($this->arquivoJson); // lê o conteúdo do arquivo

                $dadosArquivosEmArray = json_decode($conteudoArquivo, true);

            if ($dadosArquivosEmArray) {
                foreach ($dadosArquivosEmArray as $nome => $info) { 
                    $this->administradoresArray[$nome] = new Administrador(
                        $info['nome'],
                        $info['setor'],
                        $info['email'],
                        $info['senha'],
                    );
                }
            }
        }
    }

 private function salvarArquivo(){ 
    $dadosParaSalvar = []; 

    foreach ($this->administradoresArray AS $nome => $administrador) { // percorre o array de administradores
        $dadosParaSalvar[$nome] = [ // cria um array associativo para cada administrador
            'nome' => $administrador->getNome(), 
            'setor' => $administrador->getSetor(),
            'email' => $administrador->getEmail(),
            'senha' => $administrador->getSenha(),
        ];
    }   
    file_put_contents($this->arquivoJson, json_encode($dadosParaSalvar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  } 
  // create
  public function criarAdministradores(Administrador $administrador){ // adiciona novo administrador ao array
    $this->administradoresArray[$administrador->getNome()] = $administrador;
    $this->salvarArquivo();
  }

   // read 
    public function lerAdministradores(){ // retorna todos os administradores
        return $this->administradoresArray;
    }

  //update 
    public function atualizarAdministradores($email, $senha, $ativo){ // atualiza valor e qtde da bebida
        if (isset($this->administradoresArray[$email])) { // verifica se a bebida existe
            $this->administradoresArray[$email]; // acessa a bebida pelo nome
            $this->administradoresArray[$email]->setSenha($senha);
    
        }
        $this->salvarArquivo(); // salva as alterações no arquivo
    }

   // delete
    public function excluirAdministrador($email){ // remove a bebida do array
        unset($this->administradoresArray[$email]); // remove a bebida do array
        $this->salvarArquivo();
    }
    // editar bebida
    public function editarAdministrador($email, $senha, $ativo, $nome){
        if (isset($this->administradoresArray[$nome])) {
            $this->administradoresArray[$email]; // acessa a bebida pelo nome
            $this->administradoresArray[$email]->setSenha($senha);
    
        }
        $this->salvarArquivo();
    }
    public function buscarporemail($email){

        return $this->usuariosArray[$email] ?? null;
}
}
?>