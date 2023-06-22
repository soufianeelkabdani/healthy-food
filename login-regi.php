<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-regi.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login-Registre</title>
</head>
<body>
    <div class="container">
    <div class="form-container">
    <div class="title-scroll">
        <img src="img/logo.png" alt="logo" width="200" height="100">
    </div>
    <!-- Le formulaire de connexion -->
    <form id="login" class="input-group-login">
        <input type="email" name="login_email" id="login_email" placeholder="Email" required>
        <div class="erreur" id="loginEmailErr"></div>
        <input type="password" name="login_password" id="login_password" placeholder="Mot de passe" required>
        <input type="submit" name="submit_login" value="Se connecter">
    </form>
</div>



        <div class="form-container">
    <div class="title-scroll">
        <img src="img/logo.png" alt="logo" width="200" height="100">
    </div>
    <form id="register" class="input-group-register">
        <input type="text" name="nom" id="nom" placeholder="Nom" >
        <div class="erreur" id="nomErr"></div>
        <input type="text" name="prenom" id="prenom" placeholder="Prénom" >
        <div class="erreur" id="prenomErr"></div>
        <input type="text" name="adresse" id="adresse" placeholder="Adresse" >
        <div class="erreur" id="adresseErr"></div>
        <input type="text" name="telephone" id="telephone" placeholder="Numéro de téléphone" >
        <div class="erreur" id="telephoneErr"></div>
        <input type="email" name="email" id="email" placeholder="Email" >
        <div class="erreur" id="registerEmailErr"></div>
        <input type="password" name="password" id="password" placeholder="Mot de passe" >
        <div class="erreur" id="passwordErr"></div>
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmer le mot de passe" >
        <div class="erreur" id="confirmPasswordErr"></div>
        <input type="submit" name="submit_register" id="submit_register" value="S'inscrire">
    </form>
</div>
<!-- Register Modal -->
<div class="modal" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Success!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="successMessage">User registered successfully!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-annuler-btn" data-dismiss="modal" style="background-color: #f34949">Annuler</button>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap library -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include validation-signup.js script -->
<script src="validation-signup.js"></script>
<script src="validation-login.js"></script>


</body>
</html>

