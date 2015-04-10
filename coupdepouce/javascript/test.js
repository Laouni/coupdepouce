var form = document.getElementById('se-connecter-form'); /*on déclare une variable form à laquelle on récupère
                                                          l'objet representant cette balise*/

form.onsubmit = function(){   //onsubmit est gestionnaire d'évènements. Est appelé automatiquement lors de la soumission du formulaire
    var login = document.getElementById('login');
    /*var mdp = document.getElementById('mot_de_passe');
    var erreur = document.getElementsByClassName('erreur-form')[0];*/
    
    //erreur.innerHTML = 'message JS'; // change le message mis dans le formMessage pour une erreur détectée
    login.classList.add('invalide');
    //this.elements['login'].classList.add('invalide');
    alert("Pas tout de suite");
    return false;  //bloque l'envoi du formulaire
};
//this.elements['login'].value  représentera la valeur du login
//this.elements['login'].classList.add('invalide');
//var monObjetDOM = document.getElementsByClassName('erreur-form')[0];
//monObjetDOM.innerHTML = 'message JS';