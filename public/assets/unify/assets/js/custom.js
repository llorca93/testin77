//$('.brand').hide();
//$('.categories').hide();

 $('.bouton_marques').click(function() {
      $('.brand').toggle("slide");
    });
    
 $('.bouton_categories').click(function() {
      $('.categories').toggle("slide");
    });    
    
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);