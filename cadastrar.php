<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro</title>
  </head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


    <style>
      body{
        background-color: #f0eff0;
      }

      div.container{
        width:300px;
        height: 400;
        margin-left: -150px; /* metade da largura */
        margin-top: -200px; /* metade da altura */
        position: absolute;
        top: 50%;
        left: 50%;
      }

      div button{
        width: 270px;
      }

      div img{
        height: 54px;
        width: 288px;
        align: center;
      }

    </style>

  <body>

  <div class="container">
    <form action="cadastro-validar.php" method="post">
      <img src="easydns2.png" alt="">
      <div class="form-group">
        <label for="">Nome</label>
        <input type="text" class="form-control" name="Name" placeholder="Nome" required>
      </div>
      <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" name="Email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <label for="">Informe o login</label>
        <input type="text" class="form-control" name="Login" placeholder="Digite  seu login" required>
      </div>
      <div class="form-group">
        <label for="">Senha</label>
        <input type="password" class="form-control" name="senha" placeholder="Digite a senha da conta" required>
      </div>
      <div class="form-group">
        <label for="">Confirme a senha</label>
        <input type="password" class="form-control" name="confirmarsenha" placeholder='Confirme a senha' required>
      </div>


      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

</body>
</html>
