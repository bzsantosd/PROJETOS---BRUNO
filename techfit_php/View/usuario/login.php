<?php include '../Layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Login</h3>
                <p class="text-muted">Acesse sua conta</p>
            </div>
            
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
            
            <hr class="my-4">
            <div class="text-center">
                <span class="text-muted">Não tem conta?</span> 
                <a href="usuario.php" class="text-decoration-none">Cadastre-se</a>
            </div>
        </div>
    </div>
</div>

<?php include '../Layout/footer.php'; ?>