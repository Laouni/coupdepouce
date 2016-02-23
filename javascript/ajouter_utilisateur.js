$(document).ready(function(){                               
    $("#ajouter-utilisateur form input[type=text],"+        //Ce code permet d'ajouter à tous les champs du formulaire
      "#ajouter-utilisateur form input[type=password],"+    //un attribut class = 'web3il' qu'on peut vérifier avec les outils de developement
      "#ajouter-utilisateur form select"
     ).each(function(){
        this.estValide = null;
     });
});

$('#nom').blur(function(){
    this.value = this.value.toUpperCase();
    if(this.value.trim() === ""){
        this.estValide = false;
        $('p.erreur-form').html('Vous devez fournir un nom');  //.html() permet d'ajouter du contenu HTML à un élément, du texte ou un ensemblage de balise en texte
        $(this).addClass('invalide');                          // $(this) est l'objet DOM/JQuery
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#prenom').blur(function(){
    this.value = (this.value.charAt(0).toUpperCase() + this.value.substring(1).toLowerCase());
    if(this.value.trim() === ""){
        this.estValide = false;
        $('p.erreur-form').html('Vous devez fournir un prenom');  
        $(this).addClass('invalide');                          
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#login').blur(function(){
    if(this.value.trim().length < 4){
        this.estValide = false;
        $('p.erreur-form').html('Votre login doit avoir 4 caractères minimum!');
        $(this).addClass('invalide');
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
    }
    if(this.value.indexOf(' ') !== -1){
        this.estValide = false;
        $('p.erreur-form').html("Votre login ne doit pas avoir d'espace.");
        $(this).addClass('invalide');
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#email').blur(function(){
    var regex = /^[\w.-]+[^.]@[\w.-]+\.[a-zA-Z]{2,6}$/;
   if(regex.test(this.value) === false){
       this.estValide = false;
        $('p.erreur-form').html("Ceci n'est pas une adresse mail valide");
        $(this).addClass('invalide');
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
   } 
});

$('#mot_de_passe').blur(function(){
   if(this.value.trim().length < 5){
       this.estValide = false;
        $('p.erreur-form').html("Le mot de passe doit avoir 5 caractères minimum!");
        $(this).addClass('invalide');
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
   } 
});

$('#verification').blur(function(){
   if(this.value !== $('#mot_de_passe').val()){
       this.estValide = false;
        $('p.erreur-form').html("La vérifiaction doit être identique au mot de passe!");
        $(this).addClass('invalide');
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
   } 
});

$('#formation').change(function(){
   if(this.value === '---'){
       this.estValide = false;
        $('p.erreur-form').html("Veuillez choisir une formation!");
        $(this).addClass('invalide');
    } else{
        this.estValide = true;
        $(this).removeClass('invalide');
   } 
});