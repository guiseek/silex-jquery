$(document).ready(function() {
  Service.setEntity('user');
  var list = function() {
    Service.findAll().done(function(response) {
      $('#users').html('');
      $.each(response, function(i, user) {
        $('#users').append(
          $('<tr>').append(
            $('<td>').text(user.id),
            $('<td>').text(user.name),
            $('<td>').text(user.email),
            $('<td>').append(
              $('<div>').addClass('btn-group').append(
                $('<button>').data('user', user).addClass('update btn btn-sm btn-default').text('Alterar'),
                $('<button>').data('id', user.id).addClass('delete btn btn-sm btn-danger').text('Remover')
              )
            )
          )
        );
      });
      $('.update').on('click', function() {
        $('#user').modal('show');
        $.each($(this).data('user'), function(k, v) {
          $('[name='+k+']','form').val(v);
        });
      });
      $('.delete').on('click', function() {
        Service.delete($(this).data('id')).done(function(response) {
          console.log(response);
        });
      });
    });
  }
  list();
  $('form').on('submit', function (e) {
    e.preventDefault();
    var id = $(this).find('#id').val();
    if (id) {
      Service.update(id, $(this).serialize()).done(function(response) {
        console.log(response);
      });
    } else {
      Service.create($(this).serialize()).done(function(response) {
        console.log(response);
      });
    }
    list();
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