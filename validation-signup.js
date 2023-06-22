const registerForm = document.getElementById('register');

registerForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const successMessage = document.getElementById('successMessage');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));

    // Effacer les messages d'erreur précédents
    const errorDivs = document.querySelectorAll('.erreur');
    errorDivs.forEach((errorDiv) => {
        errorDiv.textContent = '';
    });

    // Validation des champs du formulaire
    let isValid = true;

    const nomInput = document.getElementById('nom');
    const prenomInput = document.getElementById('prenom');
    const adresseInput = document.getElementById('adresse');
    const telephoneInput = document.getElementById('telephone');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');

    if (nomInput.value.trim() === '') {
        printError('nomErr', 'Veuillez entrer votre nom.');
        isValid = false;
    } else if (!isValidName(nomInput.value.trim())) {
        printError('nomErr', 'Veuillez entrer un nom valide (lettres uniquement).');
        isValid = false;
    }

    if (prenomInput.value.trim() === '') {
        printError('prenomErr', 'Veuillez entrer votre prénom.');
        isValid = false;
    } else if (!isValidName(prenomInput.value.trim())) {
        printError('prenomErr', 'Veuillez entrer un prénom valide (lettres uniquement).');
        isValid = false;
    }

    if (adresseInput.value.trim() === '') {
        printError('adresseErr', 'Veuillez entrer votre adresse.');
        isValid = false;
    }

    if (telephoneInput.value.trim() === '') {
        printError('telephoneErr', 'Veuillez entrer votre numéro de téléphone.');
        isValid = false;
    } else if (!isValidPhoneNumber(telephoneInput.value.trim())) {
        printError('telephoneErr', 'Veuillez entrer un numéro de téléphone valide (10 chiffres).');
        isValid = false;
    }

    if (emailInput.value.trim() === '') {
        printError('registerEmailErr', 'Veuillez entrer votre adresse e-mail.');
        isValid = false;
    } else if (!isValidEmail(emailInput.value.trim())) {
        printError('registerEmailErr', 'Veuillez entrer une adresse e-mail valide.');
        isValid = false;
    }

    if (passwordInput.value.trim() === '') {
        printError('passwordErr', 'Veuillez entrer votre mot de passe.');
        isValid = false;
    } 

    if (confirmPasswordInput.value.trim() === '') {
        printError('confirmPasswordErr', 'Veuillez confirmer votre mot de passe.');
        isValid = false;
    } else if (passwordInput.value.trim() !== confirmPasswordInput.value.trim()) {
        printError('confirmPasswordErr', 'Les mots de passe ne correspondent pas.');
        isValid = false;
    }

    if (isValid) {
        // Création de l'objet utilisateur avec les données du formulaire
        const user = {
          nom: nomInput.value.trim(),
          prenom: prenomInput.value.trim(),
          adresse: adresseInput.value.trim(),
          telephone: telephoneInput.value.trim(),
          email: emailInput.value.trim(),
          password: passwordInput.value.trim(),
          confirmPassword: confirmPasswordInput.value.trim()
        };
    
        // Envoi des données au serveur
        fetch('../healthy-food/includes/signup.inc.php', {
            method: 'POST',
            body: JSON.stringify(user),
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
        
                successMessage.textContent = 'User registered successfully!';
     
       
            successModal.show();
            nomInput.value= "";
            prenomInput.value= "";
            adresseInput.value= "";
            telephoneInput.value= "";
            emailInput.value= "";
            passwordInput.value= "";
            confirmPasswordInput.value = "";
        })
        
          .catch(error => {
    console.error('Error:', error);
    console.log('Server Response:', error.response);
    successMessage.textContent = 'An error occurred. Please try again.';
    successModal.showModal();
});

      } else {
        alert('Invalid inputs info, please try again');
      }
    });

function printError(elementId, message) {
    const errorDiv = document.getElementById(elementId);
    errorDiv.textContent = message;
}

function isValidName(nom) {
    const nameRegex = /^[A-Za-z\s']+$/;
    return nameRegex.test(nom);
}

function isValidName(prenom) {
    const nameRegex = /^[A-Za-z\s']+$/;
    return nameRegex.test(prenom);
}

function isValidAddress(adresse) {    
    const addressRegex = /^[a-zA-Z0-9\s,'-]*$/;
    return addressRegex.test(adresse);
}

function isValidPhoneNumber(telephone) {
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(telephone);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
