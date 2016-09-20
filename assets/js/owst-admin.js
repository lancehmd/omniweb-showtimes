jQuery(document).ready( function ($) {
  if ( typeof wp.media !== 'undefined' ) {
    var _custom_media = true,
    _orig_send_attachment = wp.media.editor.send.attachment;
    $('.rational-metabox-media').click(function(e) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
      var id = button.attr('id').replace('_button', '');
      _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment){
        if ( _custom_media ) {
          $("#"+id).val(attachment.url);
          $("#"+id+"-preview").attr('src', attachment.url);
        } else {
          return _orig_send_attachment.apply( this, [props, attachment] );
        };
      }
      wp.media.editor.open(button);
      return false;
    });
    $('.add_media').on('click', function(){
      _custom_media = false;
    });
  }

  $('#wpbody').on('click', '.owst-add-ticket', function(e) {
      e.preventDefault();
      var ticket_group = $('.owst-ticket-group').clone().first();
      ticket_group.children('input').val('');
      ticket_group.find('button').prop('disabled', false);
      ticket_group.appendTo('#owst-tickets');
  });

  $('#wpbody').on('click', '.owst-remove-ticket', function(e) {
      e.preventDefault();
      $(this).parents('.owst-ticket-group').remove();
  });
});
