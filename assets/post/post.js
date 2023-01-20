import './post.css';

$(document).ready(function () {

    var $wrapper = $('.new_post_form');
    $wrapper.on('submit',function (e) {
        e.preventDefault();
        var $form = $(e.currentTarget);
       $.ajax({
           url:$form.attr('action'),
           method: 'POST',
           data:$form.serialize(),
           success:function (data) {
               var $posts = $('.posts');
               $posts.prepend(data);
               $form.trigger('reset');
               console.log(data);
           }
       })

    })
});

var commentForm = $('.comment-form');
commentForm.on('submit',function (e) {
    e.preventDefault();
    var $form = $(e.currentTarget);
    var $postId = $form.data('post-id');
    $.ajax({
        url: $form.attr('action'),
        method:'Post',
        data: $form.serialize(),
        success:function (data){
            var $comments = $('.comments_'+$postId);
            $comments.append(data);
            var $commentCounter = $('.comments-counter-'+$postId);
            $commentCounter.text(parseInt($commentCounter.text())+1+' comments');
            $form.trigger('reset');
        }
    })
})
