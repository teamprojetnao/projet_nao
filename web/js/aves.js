
$( "#autocomplete" ).autocomplete({
    minLength: 3,
    delay: 500,
    source:  function(requete, reponse){
        var key = $('#autocomplete').val();

        $.ajax({

            url : $("#autocomplete").data('url'),
            dataType : 'json',
            data : {
                term: key
            },

            success : function(donnee){
                reponse($.map(donnee, function(objet){
                    return objet;
                }));
            }
        });

    }
});

