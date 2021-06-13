class Login{

  static init(){
    if(  window.localStorage.getItem("token")){
      window.location = "index.html";
    }else{
      $('body').show();
    }
    var urlParams = new URLSearchParams(window.location.search);
     if (urlParams.has('token')){
       $("#change-password-token").val(urlParams.get('token'));
       showChangePasswordForm();
     }
     if(sessionStorage.getItem("showmsg")=='1'){
        toastr.success("Registred successfully");
        sessionStorage.removeItem("showmsg");
      }
  }

  static show_change_passwordForm(){
    $("#change-password-form-container").removeClass("hidden");
    $("#login-form-container").addClass("hidden");
    $("#register-form-container").addClass("hidden");
    $("#forgot-form-container").addClass("hidden");
  }

  static show_forgot_form(){
    $("#login-form-container").addClass("hidden");
    $("#forgot-form-container").removeClass("hidden");
  }

  static show_registration_form(){
    $("#login-form-container").addClass("hidden");
    $("#register-form-container").removeClass("hidden");
  }

  static show_login_form(){
    $("#login-form-container").removeClass("hidden");
    $("#register-form-container").addClass("hidden");
    $("#forgot-form-container").addClass("hidden");
  }

  static register(){
    $("#register-link").prop('disabled', true);
    RestClient.post("api/companies/register", AUtils.form2json("#register-form"), function(data){
      $("#register-form-container").addClass("hidden");
      window.location = "login.html";
      sessionStorage.setItem("showmsg", "1");
    }, function(jqXHR, textStatus, errorThrown){
      $("#register-link").prop('disabled', false);
      toastr.error(jqXHR.responseJSON.message);
    });
  }

    static login(){
      $("#login-link").prop('disabled', true);
      var radioValue = $("input[name='userType']:checked").val();
      var type = "NONE";
      if(radioValue == "company") type = "api/companies/login";
      else if(radioValue == "user") type = "api/user/login";
      RestClient.post(type, AUtils.form2json("#login-form"), function(data){
        window.localStorage.setItem("token", data.token);
        window.location = "index.html";
      }, function(jqXHR, textStatus, errorThrown){
        $("#login-link").prop('disabled', false);
        toastr.error(jqXHR.responseJSON.message);
      });
    }

    static forgot_password(){
      $("#forgot-link").prop('disabled', true);
      RestClient.post("api/companies/forgot", AUtils.form2json("#forgot-form"), function(data){
        $("#forgot-form-container").addClass("hidden");
        $("#form-alert").removeClass("hidden");
        $("#form-alert .alert").html(data.message);
      }, function(jqXHR, textStatus, errorThrown){
        $("#forgot-link").prop('disabled', false);
        $("#forgot-form-container").addClass("hidden");
        $("#form-alert").removeClass("hidden");
        $("#form-alert .alert").html(error.responseJSON.message);
      });
    }

    static change_password(){
      $("#change-link").prop('disabled', true);
      RestClient.post("api/companies/reset", AUtils.form2json("#change-form"), function(data){
        window.localStorage.setItem("token", data.token);
        window.location = "index.html";
      }, function(jqXHR, textStatus, errorThrown){
        $("#change-link").prop('disabled', false);
        alert(error.responseJSON.message);
      });
    }
}