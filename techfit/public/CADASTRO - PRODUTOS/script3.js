document.addEventListener('DOMContentLoaded', () => {
    const statusButtons = document.querySelectorAll('.status-btn');
    const statusInput = document.getElementById('status');
    const productForm = document.getElementById('product-form');
    const actionButtons = document.querySelectorAll('.action-btn');

    // Função auxiliar para inicializar ou obter produtos do localStorage
    const getProducts = () => {
        const productsJSON = localStorage.getItem('techfitProducts');
        return productsJSON ? JSON.parse(productsJSON) : [];
    };

    // Função auxiliar para salvar produtos no localStorage
    const saveProducts = (products) => {
        localStorage.setItem('techfitProducts', JSON.stringify(products));
    };

    // Função auxiliar para limpar o formulário
    const clearForm = () => {
        productForm.reset();
        // Garante que o status 'ativo' padrão esteja selecionado visualmente
        statusButtons.forEach(btn => btn.classList.remove('selected'));
        document.querySelector('.status-btn[data-status="ativo"]').classList.add('selected');
        statusInput.value = 'ativo';
        document.getElementById('codigo').focus();
    };

    // --- 1. Lógica dos Botões de Status (ATIVO/INATIVO) ---
    statusButtons.forEach(button => {
        button.addEventListener('click', () => {
            statusButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            statusInput.value = button.getAttribute('data-status');
            console.log(`Status alterado para: ${statusInput.value}`);
        });
    });

    // --- 2. Lógica para Carregar Produto (simulação de busca pelo código) ---
    document.getElementById('codigo').addEventListener('change', (e) => {
        const productCode = e.target.value;
        if (!productCode) return;

        const products = getProducts();
        const productToEdit = products.find(p => p.codigo === productCode);

        if (productToEdit) {
            // Preenche o formulário com os dados do produto
            document.getElementById('nome-produto').value = productToEdit['nome-produto'];
            document.getElementById('descricao-produto').value = productToEdit['descricao-produto'];
            document.getElementById('categoria').value = productToEdit.categoria;
            document.getElementById('marca').value = productToEdit.marca;
            document.getElementById('quantidade').value = productToEdit.quantidade;
            document.getElementById('preco-unitario').value = productToEdit['preco-unitario'];
            
            // Atualiza o status visual
            statusButtons.forEach(btn => btn.classList.remove('selected'));
            document.querySelector(`.status-btn[data-status="${productToEdit.status}"]`).classList.add('selected');
            statusInput.value = productToEdit.status;

            alert(`Produto código ${productCode} carregado para edição.`);
        } else {
            // Se o produto não for encontrado, limpa campos relevantes para um novo cadastro
            document.getElementById('nome-produto').value = '';
            document.getElementById('descricao-produto').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('quantidade').value = '';
            document.getElementById('preco-unitario').value = '';
        }
    });
    
    // --- 3. Lógica CADASTRAR/ATUALIZAR no Submit (botão Cadastrar) ---
    productForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const formData = new FormData(productForm);
        const data = Object.fromEntries(formData.entries());
        let products = getProducts();
        const productCode = data.codigo;

        if (!productCode || !data['nome-produto'] || !data['preco-unitario']) {
            alert('Os campos Código, Nome e Preço Unitário são obrigatórios.');
            return;
        }

        const existingIndex = products.findIndex(p => p.codigo === productCode);

        if (existingIndex > -1) {
            // Ação de ATUALIZAR (se o código já existir)
            products[existingIndex] = data;
            saveProducts(products);
            alert(`Produto código ${productCode} Atualizado com Sucesso!`);
            console.log('Produto Atualizado:', data);
        } else {
            // Ação de CADASTRAR (se o código não existir)
            products.push(data);
            saveProducts(products);
            alert('Produto Cadastrado com Sucesso!');
            console.log('Produto Cadastrado:', data);
        }
        
        clearForm(); // Limpa o formulário após a operação
    });

    // --- 4. Lógica Deletar (botão Deletar) ---
    document.querySelector('.delete-btn').addEventListener('click', () => {
        const productCode = document.getElementById('codigo').value;
        
        if (!productCode) {
            alert('Por favor, preencha o campo "Código" para DELETAR.');
            return;
        }

        if (confirm(`Tem certeza que deseja DELETAR o produto código ${productCode}?`)) {
            let products = getProducts();
            const initialLength = products.length;
            
            // Filtra o produto a ser deletado
            products = products.filter(p => p.codigo !== productCode);

            if (products.length < initialLength) {
                saveProducts(products);
                alert(`Produto código ${productCode} Deletado com Sucesso!`);
                console.log('Produto Deletado:', productCode);
                clearForm();
            } else {
                alert(`Produto código ${productCode} não encontrado.`);
            }
        }
    });

    // --- 5. Lógica para o botão ATUALIZAR (Apenas chama o Submit, que já gerencia a atualização) ---
    document.querySelector('.update-btn').addEventListener('click', () => {
        // A lógica de atualização é acionada pelo 'submit' se o produto existir.
        // Simulamos o clique no botão 'Cadastrar' para unificar a lógica.
        const productCode = document.getElementById('codigo').value;
        if (!productCode) {
            alert('Para ATUALIZAR, preencha o campo "Código" e altere os dados desejados no formulário.');
            return;
        }
        // Se o código estiver preenchido, dispara o submit, que faz a atualização.
        productForm.dispatchEvent(new Event('submit', { cancelable: true }));
    });
    
    clearForm(); // Garante o estado inicial correto ao carregar a página
});