<?php 
 namespace techfit_php; 
class usuarioDAO { 
    private $usuariosArray = []; // array associativo

    private $arquivoJson = 'usuarios.json'; // arquivo onde os dados serao salvos
    public function __construct() { //carrega os dados do arquivo JSON, se existir
        if (file_exists($this->arquivoJson)) {
            $conteudoArquivo = file_get_contents($this->arquivoJson); // lê o conteúdo do arquivo

                $dadosArquivosEmArray = json_decode($conteudoArquivo, true);

            if ($dadosArquivosEmArray) {
                foreach ($dadosArquivosEmArray as $nome => $info) { 
                    $this->usuariosArray[$nome] = new Usuario(
                        $info['idusuario'],
                        $info['nome'],
                        $info['email'],
                        $info['senha'],
                        $info['datacadastro'],
                        $info['ativo']
                    );
                }
            }
        }
    }

 private function salvarArquivo(){ 
    $dadosParaSalvar = []; 

    foreach ($this->usuariosArray AS $nome => $usuario) { // percorre o array de usuarios
        $dadosParaSalvar[$nome] = [ // cria um array associativo para cada usuario
            'idusuario' => $usuario->getIdusuario(),
            'nome' => $usuario->getNome(), 
            'email' => $usuario->getEmail(),
            'senha' => $usuario->getSenha(),
            'datacadastro' => $usuario->getDatacadastro(),
            'ativo' => $usuario->getAtivo()
        ];
    }   
    file_put_contents($this->arquivoJson, json_encode($dadosParaSalvar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  } 
  // create
  public function criarUsuarios(Usuario $usuario){ // adiciona novo usuario ao array
    $this->usuariosArray[$usuario->getNome()] = $usuario;
    $this->salvarArquivo();
  }

   // read 
    public function lerUsuarios(){ // retorna todos os usuarios
        return $this->usuariosArray;
    }

  //update 
    public function atualizarUsuarios($email, $senha, $ativo){ // atualiza valor e qtde da bebida
        if (isset($this->usuariosArray[$email])) { // verifica se a bebida existe
            $this->usuariosArray[$email]; // acessa a bebida pelo nome
            $this->usuariosArray[$email]->setSenha($senha);
            $this->usuariosArray[$email]->setAtivo($ativo);
    
        }
        $this->salvarArquivo(); // salva as alterações no arquivo
    }

   // delete
    public function excluirUsuario($email){ // remove a bebida do array
        unset($this->usuariosArray[$email]); // remove a bebida do array
        $this->salvarArquivo();
    }
    // editar bebida
    public function editarUsuario($email, $senha, $ativo, $nome){
        if (isset($this->bebidasArray[$nome])) {
            $this->usuariosArray[$email]; // acessa a bebida pelo nome
            $this->usuariosArray[$email]->setSenha($senha);
            $this->usuariosArray[$email]->setAtivo($ativo);
    
        }
        $this->salvarArquivo();
    }
    public function buscarporemail($email){

        return $this->usuariosArray[$email] ?? null;
}
}
?>