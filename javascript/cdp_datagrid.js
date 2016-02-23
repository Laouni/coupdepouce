$('table.datagrid button.cmd_editer').click(function(){
   var id = $(this).siblings('input').val();
   //alert(id); 
   $('#commande-form').get(0).action = '?controller=coups_de_pouce&action=editer';
   $('#id').val(id);
   $('#commande-form').get(0).submit();
});

$('table.datagrid button.cmd_supprimer').click(function(){
   var id = $(this).siblings('input').val();
 
   $('#commande-form').get(0).action = '?controller=coups_de_pouce&action=supprimer';
   $('#id').val(id);
   /*$('#cdp'
   
   alert(cdp);*/
   if(confirm("Voulez-vous supprimer ce coup de pouce?")){
       $('#commande-form').get(0).submit();
   }  
});
