/**
 * Created by MatrixOfDeath on 24/11/2015.
 */
function query(httpMethod, data){
    var urlp = '';
    if(httpMethod == "DELETE"){
        urlp = '?method=data&content='+ data;
    }
    $.ajax({
        url: "http://localhost/CW16_Rest/serveur/server.php"+urlp,
        type: httpMethod,
        dataType: "json",
        data    : 'method=data&content='+ data,
        success : function(response){
                console.log(response);
        },
        error   : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        },
    });
}

$(document).ready(function(){
    $('input').dblclick(function(e){
        console.log("double clicked");
        //$(this).hide();
        $(this).parent().siblings().find("input").prop("value", "Delete");
        $(this).parent().siblings().find("input").removeClass();
        $(this).parent().siblings().find("input").prop("class", "buttonDelete");
        var elem = $(this);
        $(this).parent().siblings().find("input").click(function(b){

            if($text = e.target.value){
                console.log($text);
                console.log('Sending Delete');
                query('DELETE',  $text);
            }else{
                alert('Pas de données trouver' );
            }
        });
    });
    if($('.buttonGet').length != 0){
        $('.buttonGet').click(function(){
            if($('.inputGet').length != 0 && $('.inputGet').val()){
                console.log('Sending Get');
                query('GET',  $('.inputGet').val());
            }else{
                alert('Veuillez saisir une donnée' );
            }

        });
    }
    if($('.buttonPut').length != 0){
        $('.buttonPut').click(function(){
            if($('.inputPut').length != 0 && $('.inputPut').val()){
                console.log('Sending Put');
                query('PUT',  $('.inputPut').val() + '&old_content=' + $(this).parent().siblings().find("input").val());
            }else{
                alert('Veuillez saisir une donnée' );
            }
        });
    }
    if($('.buttonPost').length != 0){
        $('.buttonPost').click(function(){
            if($('.inputPost').length != 0 && $('.inputPost').val()){
                console.log('Sending Post');
                query('POST',  $('.inputPost').val());
            }else{
                alert('Veuillez saisir une donnée' );
            }
        });
    }
    /**
    if($('.buttonDelete').length != 0){
        $('.buttonDelete').click(function(){
            if($text = $(this).parent().siblings().find("input").val()){
                console.log($text);
                console.log('Sending Delete');
                query('DELETE',  $('.inputDelete').val());
            }else{
                alert('Pas de données trouver' );
            }

        });
    }**/
});