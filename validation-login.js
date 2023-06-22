const loginForm = document.getElementById('login');

loginForm.addEventListener('submit', function (event) {
    event.preventDefault();

    // Effacer les messages d'erreur précédents
    const errorDivs = document.querySelectorAll('.erreur');
    errorDivs.forEach((errorDiv) => {
        errorDiv.textContent = '';
    });

    // Validation des champs du formulaire
    let isValid = true;
    const emailInput = document.getElementById('login_email');
    const passwordInput = document.getElementById('login_password');

    if (emailInput.value.trim() === '') {
        printError('loginEmailErr', 'Veuillez entrer votre adresse e-mail.');
        isValid = false;
    } 

    if (passwordInput.value.trim() === '') {
        printError('passwordErr', 'Veuillez entrer votre mot de passe.');
        isValid = false;
    }

    if (isValid) {
        // Création de l'objet utilisateur avec les données du formulaire
        const user = {
            login_email: emailInput.value.trim(),
            login_password: passwordInput.value.trim()
        };

        // Envoi des données au serveur
        console.log('Im Inside');
        fetch('../healthy-food/includes/login.inc.php', {
            method: 'POST',
            body: JSON.stringify(user),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
                if (data.status === 'success') {
                    loginForm.reset();

                    // Redirection vers la page appropriée
                    window.location.href = "accueil.php";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        alert('Invalid inputs info, please try again');
    }
});
