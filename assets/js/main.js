
  jQuery('.zoom-thumbnail-tile')
    // tiles mouse actions
    .on('mouseover', function(){
      $(this).children('.zoom-thumbnail-photo').css({'transform': 'scale('+ $(this).attr('data-scale') +')'});
    })
    .on('mouseout', function(){
      $(this).children('.zoom-thumbnail-photo').css({'transform': 'scale(1)'});
    })
    .on('mousemove', function(e){
      $(this).children('.zoom-thumbnail-photo').css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +'%'});
    })

    // tiles set up
    .each(function(){
      $(this)
        // add a photo container
        .append('<div class="zoom-thumbnail-photo single-featured"></div>')
        // some text just to show zoom level on current item in this example
        // .append('<div class="txt"><div class="x">'+ $(this).attr('data-scale') +'x</div>ZOOM ON<br>HOVER</div>')
        // set up a background image for each tile based on data-image attribute
        .children('.zoom-thumbnail-photo').css({'background-image': 'url('+ $(this).attr('data-image') +')'});
    })
