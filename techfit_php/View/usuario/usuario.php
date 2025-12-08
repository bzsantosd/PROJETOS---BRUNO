<?php include '../Layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Cadastro de Usuário</h4>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control" name="cpf" placeholder="000.000.000-00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" class="form-control" name="senha" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirme a Senha</label>
                            <input type="password" class="form-control" name="confirma_senha" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="login.php" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Salvar Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../Layout/footer.php'; ?>