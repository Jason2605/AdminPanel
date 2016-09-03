$(function(){

    // Storing some elements in variables for a cleaner code base

    var refreshButton = $('h1 img'),
        shoutboxForm = $('.shoutbox-form'),
        form = shoutboxForm.find('form'),
        closeForm = shoutboxForm.find('h2 span'),
        nameElement = form.find('#shoutbox-name'),
        commentElement = form.find('#shoutbox-comment'),
        ul = $('ul.shoutbox-content');


    // Replace :) with emoji icons:
    emojione.ascii = true;

    // Load the comments.
    load();
    
    // On form submit, if everything is filled in, publish the shout to the database
    
    var canPostComment = true;

    form.submit(function(e){
        e.preventDefault();

        if(!canPostComment) return;
        
        var name = nameElement.val().trim();
        var comment = commentElement.val().trim();

        if(name.length && comment.length && comment.length < 240) {
        
            publish(name, comment);

            // Prevent new shouts from being published

            canPostComment = false;

            // Allow a new comment to be posted after 5 seconds

            setTimeout(function(){
                canPostComment = true;
            }, 5000);

        }

    });
    
    // Toggle the visibility of the form.
    
    shoutboxForm.on('click', 'h2', function(e){
        
        if(form.is(':visible')) {
            formClose();
        }
        else {
            formOpen();
        }
        
    });
    
    // Clicking on the REPLY button writes the name of the person you want to reply to into the textbox.
    
    ul.on('click', '.shoutbox-comment-reply', function(e){
        
        var replyName = $(this).data('name');
        
        formOpen();
        commentElement.val('@'+replyName+' ').focus();

    });
    
    // Clicking the refresh button will force the load function
    
    var canReload = true;

    refreshButton.click(function(){

        if(!canReload) return false;
        
        load();
        canReload = false;

        // Allow additional reloads after 2 seconds
        setTimeout(function(){
            canReload = true;
        }, 2000);
    });

    // Automatically refresh the shouts every 20 seconds
    setInterval(load,20000);


    function formOpen(){
        
        if(form.is(':visible')) return;

        form.slideDown();
        closeForm.fadeIn();
    }

    function formClose(){

        if(!form.is(':visible')) return;

        form.slideUp();
        closeForm.fadeOut();
    }

    // Store the shout in the database
    
    function publish(name,comment){
    
        $.post('publish.php', {name: name, comment: comment}, function(){
            nameElement.val("");
            commentElement.val("");
            load();
        });

    }
    
    // Fetch the latest shouts
    
    function load(){
        $.getJSON('./load.php', function(data) {
            appendComments(data);
        });
    }
    
    // Render an array of shouts as HTML
    
    function appendComments(data) {

        ul.empty();

        data.forEach(function(d){
            ul.append('<li>'+
                '<span class="shoutbox-username">' + d.name + '</span>'+
                '<p class="shoutbox-comment">' + emojione.toImage(d.text) + '</p>'+
                '<div class="shoutbox-comment-details"><span class="shoutbox-comment-reply" data-name="' + d.name + '">REPLY</span>'+
                '<span class="shoutbox-comment-ago">' + d.timeAgo + '</span></div>'+
            '</li>');
        });

    }

});