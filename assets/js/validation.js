$(document).ready(function() {
  $('input').on('blur', function() {
      if ($("#register-form").valid()) {
          $('#register-link').prop('disabled', false);
      } else {
          $('#register-link').prop('disabled', 'disabled');
      }
      if ($("#login-form").valid()) {
          $('#login-link').prop('disabled', false);
      } else {
          $('#login-link').prop('disabled', 'disabled');
      }
      if ($("#forgot-form").valid()) {
          $('#forgot-link').prop('disabled', false);
      } else {
          $('#forgot-link').prop('disabled', 'disabled');
      }
      if ($("#change-form").valid()) {
          $('#change-link').prop('disabled', false);
      } else {
          $('#change-link').prop('disabled', 'disabled');
      }
  });

$("#register-form").validate({
    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 64
        },
        address: {
            required: true,
            minlength: 3,
            maxlength: 64
        },
        mail : {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 4,
            maxlength: 64
        }
    },
    messages : {
      name : {
        required : "You need to enter a name"
      },
      address: {
        required: "You need to enter an address"
      },
      mail: {
        required: "You need to enter an email",
        email: "Please enter valid email"
      },
      password: {
        required: "You need to enter a password between 4 and 64 chars"
      }
    }
  });

  $("#login-form").validate({
      rules: {
          mail : {
              required: true,
              email: true
          },
          password: {
              required: true,
              minlength: 4,
              maxlength: 64
          }
      },
      messages : {
        mail: {
          required: "You need to enter an email",
          email: "Please enter valid email"
        },
        password: {
          required: "You need to enter a password between 4 and 64 chars"
        }
      }
    });

    $("#forgot-form").validate({
        rules: {
            mail : {
                required: true,
                email: true
            }
        },
        messages : {
          mail: {
            required: "You need to enter an email",
            email: "Please enter valid email"
          }
        }
      });

      $("#change-form").validate({
          rules: {
              mail : {
                  required: true,
                  email: true
              }
          },
          messages : {
            password: {
              required: "You need to enter a password between 4 and 64 chars"
            }
          }
        });
});
