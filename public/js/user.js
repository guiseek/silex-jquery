$(document).ready(function() {
  Service.findAll('user').done(function(response) {
    $.each(response, function(i, user) {
      var tr = $('<tr>').append(
        $('<td>').text(user.id),
        $('<td>').text(user.name),
        $('<td>').text(user.email),
        $('<td>').append(
          $('<div>').addClass('btn-group').append(
            $('<button>').data('user', user).addClass('update btn btn-sm btn-default').text('Alterar'),
            $('<button>').data('id', user.id).addClass('delete btn btn-sm btn-danger').text('Remover')
          )
        )
      );
      $('#users').append(tr);
    });
    $('.update').on('click', function() {
      $('#user').modal('show');
      $.each($(this).data('user'), function(k, v) {
        $('[name='+k+']','form').val(v);
      });
    });
    $('.delete').on('click', function() {
      Service.delete('user', $(this).data('id')).done(function(response) {
        console.log(response);
      });
    });
  });
  $('form').on('submit', function (e) {
    e.preventDefault();
    Service.save('user', $(this).serialize()).done(function(response) {
      console.log(response);
    });
    $('#user').modal('hide');
  });
  $('#user').on('shown.bs.modal', function (e) {
    if (e.relatedTarget) {
      $('form').each(function() {
        this.reset();
      });
    };
  });
});