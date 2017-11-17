
  jQuery('.zoom-thumbnail-tile')
    // tiles mouse actions
    .on('mouseover', function(){
      jQuery(this).children('.zoom-thumbnail-photo').css({'transform': 'scale('+ jQuery(this).attr('data-scale') +')'});
    })
    .on('mouseout', function(){
      jQuery(this).children('.zoom-thumbnail-photo').css({'transform': 'scale(1)'});
    })
    .on('mousemove', function(e){
      jQuery(this).children('.zoom-thumbnail-photo').css({'transform-origin': ((e.pageX - jQuery(this).offset().left) / jQuery(this).width()) * 100 + '% ' + ((e.pageY - jQuery(this).offset().top) / jQuery(this).height()) * 100 +'%'});
    })

    // tiles set up
    .each(function(){
      jQuery(this)
        // add a photo container
        .append('<div class="zoom-thumbnail-photo single-featured"></div>')
        // some text just to show zoom level on current item in this example
        // .append('<div class="txt"><div class="x">'+ jQuery(this).attr('data-scale') +'x</div>ZOOM ON<br>HOVER</div>')
        // set up a background image for each tile based on data-image attribute
        .children('.zoom-thumbnail-photo').css({'background-image': 'url('+ jQuery(this).attr('data-image') +')'});
    })
