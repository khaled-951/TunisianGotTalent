$(function(){
    //Hide And Show Comments
  $("p").click(
      function(){
          if($(this).attr('id').substr(0, 13) == "show_comments"){
              let id = $(this).attr('id').substr( $(this).attr('id').indexOf("-") + 1) ;
              if($('#comments-' + id).is(":hidden"))
                  $('#comments-' + id).show();
              else if($('#comments-' + id).is(":visible"))
                  $('#comments-' + id).hide();
          }
      }
  );

  //Submit new Comment

  $("button").click(
      function(){
          let id = $(this).attr('id').substr( $(this).attr('id').indexOf("-") + 1) ;
          if($(this).attr('id').substr(0, 18 ) == "submit_new_comment"){
              let comment = $("#new_comment-" + id).val() ;
              $.ajax({
                  url: "/comment/new/" + id,
                  method: "POST",
                  data: { "publicationbundle_commentaire[commentaire]": comment },
                  success: function(comment_id){
              $("#comment-sec-" + id).append('<li id="commentaire-' + comment_id + '"><div class="comment-list"><div class="bg-img"><img src="/template/images/resources/bg-img1.png" alt="">'+
                  '</div><div class="comment"><div class="col-lg-push-12 accept-feat">' +
                  '<button id="edit_comment-' + comment_id + '" type="submit" class="close-req"><i class="la la-edit"></i></button>' +
                  '<button id="remove_comment-' + comment_id + '" type="submit" class="close-req"><i class="la la-remove"></i></button>' +
                  '</div><h3>John Doe</h3><span><img src="/template/images/clock.png" alt=""></span><p id="comment_content-' + comment_id + '" >' + comment
                  + '</p></div></div><!--comment-list end--></li>'
              );
                  },
              });
          }
          else if($(this).attr('id').substr(0, 12 ) == "edit_comment"){
              var new_comment = prompt("New Comment: ");
              $.ajax({
                  url: "/comment/" + id + "/edit",
                  method: "POST",
                  data: { "publicationbundle_commentaire[commentaire]": new_comment },
                  success: function(){$("#comment_content-" + id).html(new_comment)}
              });
          }
          else if($(this).attr('id').substr(0, 14 ) == "remove_comment"){
              $.ajax({
                  url: "/comment/" + id + "/delete",
                  method: "DELETE",
                  success: function(){$("#commentaire-" + id).remove()}
              });
          }
      }
  );

  //Submit new Post

  $("#publicationbundle_publication_typePublication").change(function(){
      if($("#publicationbundle_publication_typePublication").val() != "text") {
          $("#new_post_form").attr('action', '/new');
          $("#publication_input_type").html('<input type="file" id="publicationbundle_publication_src" name="publicationbundle_publication[src]" required="required">');
      }
      else {
          $("#new_post_form").attr('action', '/new_text');
          $("#publication_input_type").html('<input type="text" id="publicationbundle_publication_src" name="publicationbundle_publication[srcPublication]" required="required">');
      }
  });

  //Delete a Post

  $("a").click(function(){
      if($(this).attr("id")){
          let id = $(this).attr("id").substr($(this).attr("id").indexOf("-") + 1) ;
          if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "like_post") {
              $.ajax({
                  url: "/like/" + id,
                  method: "GET",
                  success: function(){
                      $("#like_post-" + id).attr('id', 'dislike_post-' + id);
                      $("#dislike_post-" + id).html('<i class="fas fa-heart"></i>Dislike');
                      $("#likes_count-" + id).html(parseInt($("#likes_count-" + id).html()) + 1);
                  },
              });
              //send ajax removal request
          }
          if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "dislike_post") {
              $.ajax({
                  url: "/dislike/" + id,
                  method: "GET",
                  success: function(){
                      $("#dislike_post-" + id).attr('id', 'like_post-' + id);
                      $("#like_post-" + id).html('<i class="fas fa-heart"></i>Like');
                      $("#likes_count-" + id).html( parseInt($("#likes_count-" + id).html()) - 1);
                  },
              });
              //send ajax removal request
          }
          if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "delete_post") {
              $.ajax({
                  url: "/" + id + "/delete",
                  method: "DELETE",
                  success: function(){$("#publication-" + id).remove();},
              });
              //send ajax removal request
          }
          if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "edit_post"){
              $("#edit_post_form").attr('action', '/' + id + '/edit');
              $("#publication_input_type_edit").html('<input type="file" id="edit_publicationbundle_publication_src" name="publicationbundle_publication[src]" required="required">');
              $("#edit_publicationbundle_publication_titrePublication").val($("#titre_publication-" + id).html());
              $("#edit_publicationbundle_publication_catPublication").val($("#cat_publication-" + id).val());
              $("#edit_publicationbundle_publication_typePublication").val($("#type_publication-" + id).val());
              $("#edit_form_id").attr('value', id);
              if($("#type_publication-" + id).val() == "text") {
                  $("#edit_post_form").attr('action', '/' + id + '/edit_text');
                  $("#publication_input_type_edit").html('<input type="text" id="publicationbundle_publication_src" name="publicationbundle_publication[srcPublication]" value="'+$("#src_publication-" + id).val()+'" required="required">');
              }
              else {
                  $("#edit_post_form").attr('action', '/' + id + '/edit');
                  $("#publication_input_type_edit").html('<input type="file" id="edit_publicationbundle_publication_src" name="publicationbundle_publication[src]" required="required">');
              }
          }
      }
  });

    //Edit Post Update form
    $("#edit_publicationbundle_publication_typePublication").change(function(){
        let id = $("#edit_form_id").val() ;
        if($("#edit_publicationbundle_publication_typePublication").val() != "text") {
            $("#edit_post_form").attr('action', '/' + id + '/edit');
            $("#publication_input_type_edit").html('<input type="file" id="edit_publicationbundle_publication_src" name="publicationbundle_publication[src]" required="required">');
        }
        else {
            $("#edit_post_form").attr('action', '/' + id + '/edit_text');
            if($("#src_publication-" + id).val())
                $("#publication_input_type_edit").html('<input type="text" id="edit_publicationbundle_publication_src" name="publicationbundle_publication[srcPublication]" value="'+$("#src_publication-" + id).val()+'" required="required">');
            else
                $("#publication_input_type_edit").html('<input type="text" id="edit_publicationbundle_publication_src" name="publicationbundle_publication[srcPublication]" required="required">');
        }
    });
var views=[];
var waitforme = 0 ;
//<i class="fas fa-eye"></i>Views
    $("div").mouseover(function(){
        if($(this).attr('id')){
            //alert($(this).attr('id').substr(0, $(this).attr('id').indexOf("-") + 1));
            if($(this).attr('id').substr(0, $(this).attr('id').indexOf("-") + 1) == "publication-"){
                //console.log(waitforme) ;
                let id = $(this).attr('id').substr( $(this).attr('id').indexOf("-") + 1) ;
                //alert(views.includes(id));
                if(!( views.includes(id) ) && !waitforme){
                    waitforme = 1 ;
                    //views.push(id);
                    $.ajax({
                        url: "/viewup/" + id,
                        method: "GET",
                        success: function(result){
                            views.push(id); waitforme = 0 ;
                                if(result == 1) {
                                    $('#views_count-' + id).html('<i class="fas fa-eye"></i>Views '
                                        + (parseInt($("#views_count-" + id).html().substr(-1, $("#views_count-" + id).html().indexOf("Views ") + 6 )) + 1));
                            }},
                });}
            }
        }
    });

    $("input").change(function(){
        if($(this).attr('id').substr(0, 11) == "new_comment"){
            let id = $(this).attr('id').substr($(this).attr('id').indexOf('-') + 1);
            for (var key in myObj){
                $(this).val($(this).val().replace(new RegExp(key,"g"), myObj[key]));
            }
            
        }
    });

    let myObj = {

        'o/'         : '👋',
        '</3'        : '💔',
        '<3'         : '💗',
        '8-D'        : '😁',
        '8D'         : '😁',
        ':-D'        : '😁',
        '=-3'        : '😁',
        '=-D'        : '😁',
        '=3'         : '😁',
        '=D'         : '😁',
        'B^D'        : '😁',
        'X-D'        : '😁',
        'XD'         : '😁',
        'x-D'        : '😁',
        'xD'         : '😁',
        ':\\)'       : '😂',
        ':-\\)'      : '😂',
        ':-\\)\\)'       : '😃',
        '8\\)'         : '😄',
        ':\\)'         : '😄',
        ':-\\)'        : '😄',
        ':3'         : '😄',
        ':D'         : '😄',
        ':]'         : '😄',
        ':^\\)'        : '😄',
        ':c\\)'        : '😄',
        ':o\\)'        : '😄',
        ':}'         : '😄',
        ':っ\\)'        : '😄',
        '=\\)'         : '😄',
        '=]'         : '😄',
        '0:\\)'        : '😇',
        '0:-\\)'       : '😇',
        '0:-3'       : '😇',
        '0:3'        : '😇',
        'O:-\\)'       : '😇',
        '3:\\)'        : '😈',
        '3:-\\)'       : '😈',
        '}:\\)'        : '😈',
        '}:-\\)'       : '😈',
        '\\*\\)'         : '😉',
        '\\*-\\)'        : '😉',
        ':-,'        : '😉',
        ';\\)'         : '😉',
        ';-\\)'        : '😉',
        ';-]'        : '😉',
        ';D'         : '😉',
        ';]'         : '😉',
        ';\\^\\)'        : '😉',
        ':-\\|'        : '😐',
        ':\\|'         : '😐',
        ':\\('         : '😒',
        ':-\\('        : '😒',
        ':-<'        : '😒',
        ':-\\['        : '😒',
        ':-c'        : '😒',
        ':<'         : '😒',
        ':\\['         : '😒',
        ':c'         : '😒',
        ':{'         : '😒',
        ':っC'        : '😒',
        ':-P'        : '😜',
        ':-b'        : '😜',
        ':-p'        : '😜',
        ':-Þ'        : '😜',
        ':-þ'        : '😜',
        ':P'         : '😜',
        ':b'         : '😜',
        ':p'         : '😜',
        ':Þ'         : '😜',
        ':þ'         : '😜',
        ';\\('         : '😜',
        '=p'         : '😜',
        'X-P'        : '😜',
        'XP'         : '😜',
        'd:'         : '😜',
        'x-p'        : '😜',
        'xp'         : '😜',
        ':-\\|\\|'       : '😠',
        ':@'         : '😠',
        ':-.'        : '😡',
        ':-/'        : '😡',
        ':/'         : '😡',
        ':L'         : '😡',
        ':S'         : '😡',
        '=\\/'         : '😡',
        '=L'         : '😡',
        ':\\('       : '😢',
        ':\\-\\('      : '😢',
        '\\^5'         : '😤',
        '\\^<_<'       : '😤',
        'o/\\o'      : '😤',
        '\\|-O'        : '😫',
        '\\|;-\\)'       : '😫',
        ':###..'     : '😰',
        ':-###..'    : '😰',
        'D-:'      : '😱',
        'D8'         : '😱',
        'D:'         : '😱',
        'D:<'        : '😱',
        'D;'         : '😱',
        'D='         : '😱',
        'DX'         : '😱',
        'v.v'        : '😱',
        '8-0'        : '😲',
        ':-O'        : '😲',
        ':-o'        : '😲',
        ':O'         : '😲',
        ':o'         : '😲',
        'O-O'        : '😲',
        'O_O'        : '😲',
        'O_o'        : '😲',
        'o-o'        : '😲',
        'o_O'        : '😲',
        'o_o'        : '😲',
        ':$'         : '😳',
        '#-\\)'        : '😵',
        ':#'         : '😶',
        ':&'         : '😶',
        ':-#'        : '😶',
        ':-&'        : '😶',
        ':-X'        : '😶',
        ':X'         : '😶',
        ':-J'        : '😼',
        ':\\*'         : '😽',
        ':\\^\\*'        : '😽',
        'ಠ_ಠ'        : '🙅',
        '\\*0/\\*'     : '🙆',
        'o/'       : '🙆',
        ':>'         : '😄',
        '>.<'        : '😡',
        '>:\\('        : '😠',
        '>:\\)'        : '😈',
        '>:-\\)'       : '😈',
        '>:/'        : '😡',
        '>:O'        : '😲',
        '>:P'        : '😜',
        '>:\\['        : '😒',
        '>:'       : '😡',
        '>;\\)'        : '😈',
        '>_>\\^'       : '😤',
    };

})