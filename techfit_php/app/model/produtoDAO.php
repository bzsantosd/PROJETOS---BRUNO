<?php 
 namespace techfit_php; 
class produtoDAO { 
    private $produtosArray = []; // array associativo

    private $arquivoJson = 'produtos.json'; // arquivo onde os dados serao salvos
    public function __construct() { //carrega os dados do arquivo JSON, se existir
        if (file_exists($this->arquivoJson)) {
            $conteudoArquivo = file_get_contents($this->arquivoJson); // lê o conteúdo do arquivo

                $dadosArquivosEmArray = json_decode($conteudoArquivo, true);

            if ($dadosArquivosEmArray) {
                foreach ($dadosArquivosEmArray as $nome => $info) { 
                    $this->produtosArray[$nome] = new Produto(
                        $info['idProduto'],
                        $info['nome'],
                        $info['descrição'],
                        $info['preco'],
                        $info['quantidadeestoque']
                    );
                }
            }
        }
    }

 private function salvarArquivo(){ 
    $dadosParaSalvar = []; 

    foreach ($this->produtosArray AS $nome => $produto) { // percorre o array de produtos
        $dadosParaSalvar[$nome] = [ // cria um array associativo para cada produto
            'nome' => $produto->getNome(), 
            'setor' => $produto->getSetor(),
            'email' => $produto->getEmail(),
            'senha' => $produto->getSenha(),
        ];
    }   
    file_put_contents($this->arquivoJson, json_encode($dadosParaSalvar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  } 
  // create
  public function criar(Produto $produto){ // adiciona novo produto ao array
    $this->produtosArray[$produto->getNome()] = $produto;
    $this->salvarArquivo();
  }

   // read 
    public function lerProdutos(){ // retorna todos os produtos
        return $this->produtosArray;
    }

  //update 
    public function atualizarProdutos($nome, $preço, $quantidadeestoque){ // atualiza valor e qtde da bebida
        if (isset($this->produtosArray[$nome])) { // verifica se a bebida existe
            $this->produtosArray[$preço]; // acessa a bebida pelo nome
            $this->produtosArray[$quantidadeestoque];

    
        }
        $this->salvarArquivo(); // salva as alterações no arquivo
    }

   // delete
    public function excluirProduto($nome){ // remove a bebida do array
        unset($this->produtosArray[$nome]); // remove a bebida do array
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