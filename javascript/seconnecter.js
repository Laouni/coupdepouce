var form = document.getElementById('se-connecter-form');

form.onsubmit = function(){
    var log = this.elements['login'];
    var motdepasse = this.elements['mot_de_passe'];
    var erreur = document.getElementsByClassName('erreur-form')[0];
    
    var login = log.trim();
    
    if(login.value === ""){
        //erreur.innerHTML = 'Erreur de login! Veuillez entrer un login valide.';
        alert('Erreur de login! Veuillez entrer un login valide.');
        login.classList.add('invalide');
        return false;
    }else{
        login.classList.remove('invalide');
    }
    
    if(motdepasse.value === ""){
        erreur.innerHTML = 'Veuillez entrer un mot de passe valide!';
        alert('Mot de passe invalide!!!');
        return false;
    }
}

