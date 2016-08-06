/*
* Mirko Gueregat - 17/11/2015
*/

$(document).ready(function () {
  "use strict";
  $("#rut").Rut({
    format_on: 'keyup'
  });
  $('input[name=rut], input[name=year]').keyup(function () {
    $('.alert').hide();
  });
  $('button[type=submit]').click(function (e) {
    e.preventDefault();
    if ($('input[name=rut]').val() && $('input[name=year]').val()) {
      $.ajax({
        url: 'backend/api/users/login',
        type: 'POST',
        data: $('form').serialize(),
        success: function (data) {
          if (data.result === true) {
            var employee = data.data[0];
            $('#search').hide();
            $('#result').show();
            $('#nombre').html(employee.nombre);
            $('#rut2').html(employee.rut);
            $('#cargo').html(employee.cargo);
            $('#servicio').html(employee.servicio);
            $('#profesion').html(employee.profesion);
            $('#ingreso').html(employee.fecha_ingreso);
            $('#grado').html(employee.grado);
            $('#turno').html(employee.sistema_turno);
            $('#base-anterior').html(employee.base_antigua);
            $('#base-nueva').html(employee.base_nueva);
            $('#base-diferencia').html(employee.diferencia_bases);
            $('#bono-noche').html(employee.turno_noche);
            $('#especial').html(employee.especial);
            $('#total-base-antigua').html(employee.total_base_antigua);
            $('#total-base-nueva').html(employee.total_base_nueva);
            $('#diferencia-totales').html(employee.diferencia_total_base);
            $('#detalle-asig').html(employee.tipo_asignacion);
            $('.number').number(true, 0, ',', '.');
            $('window').trigger('resize');
          } else {
            console.log("error");
            $('.alert').html("El rut y/o el año de ingreso es erróneo");
            $('.alert').show();
          }
        }
      });
    } else {
      $('.alert').html("Debe proporcionar el rut y la fecha de ingreso a la institucion, ambos son requeridos.");
      $('.alert').show();
    }
  });
  $('button[type=button]').click(function (e) {
    $('input[name=rut], input[name=year]').val("");
    $('#search').show();
    $('#result').hide();
  });
});