
$( "#autocomplete" ).autocomplete({
    source:  function(requete, reponse){
        var key = $('#autocomplete').val();

        $.ajax({

            url : "{{ path('ajax_search') }}",
            dataType : 'json',
            data : key,

            success : function(donnee){
                reponse($.map(donnee, function(objet){
                    return objet;
                }));
            }
        });

    }
});

