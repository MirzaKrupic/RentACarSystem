class Profile{

  static init(){
    var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
    if (user_info.r == "USER"){
      Profile.get_profile();
      Profile.get_history();
    }
    if (user_info.r == "company" || user_info.r == "ADMIN"){
      $(".user-stuff").remove();
      Profile.get_profile();
    }
    $('body').show();
  }

  static get_profile(){
    var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
    if(user_info.r == "USER" || user_info.r == "ADMIN"){
      var url = "api/users/profile/";
    }else{
      var url = "api/companies/profile/";
    }
    $.ajax({
       url: url,
       type: 'GET',
       beforeSend: function(xhr){
         if (localStorage.getItem("token")){ // optional header token due login and other endpoints
           xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
         }
       },
       async: false,
       cache: false,
       timeout: 30000,
       fail: function(){
           return true;
       },
       done: function(msg){
           if (parseFloat(msg)){
               return false;
           } else {
               return true;
           }
       },
       success: function(data) {
         document.getElementById("user-name").innerHTML = data.name;
         document.getElementById("user-name-det").innerHTML = data.name;
         document.getElementById("user-mail").innerHTML = data.mail;
         document.getElementById("user-phone").innerHTML = data.phone;
         document.getElementById("user-address").innerHTML = data.address;
         document.getElementById("user-address-det").innerHTML = data.address;
         $("#profile-image").attr("src", data.image);

         if(sessionStorage.getItem("showmsg")=='1'){
            toastr.success("User updated successfully");
            sessionStorage.removeItem("showmsg");
          }
       },
       error: function(jqXHR, textStatus, errorThrown ){
         if (error){
           error(jqXHR, textStatus, errorThrown);
         }else{
           toastr.error(jqXHR.responseJSON.message);
         }
       }
   });
  }

  static user_pre_edit(){
    var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
    if(user_info.r == "USER" || user_info.r == "ADMIN"){
      var url = "api/users/profile/";
    }else{
      var url = "api/companies/profile/";
    }
    RestClient.get(url, function(data){
      AUtils.json2form("#edit-user", data);
      $("#edit-user-modal").modal("show");
    });
  }

  static save_user(){
    sessionStorage.setItem("showmsg", "1");
    var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
    var user = AUtils.form2json("#edit-user");
    if(user_info.r == "USER" || user_info.r == "ADMIN"){
      var url = "api/users/update/";
    }else{
      var url = "api/companies/update/";
    }
    RestClient.put(url, user, function(data){
      $("#edit-user-modal").modal("hide");
    });
      Profile.get_profile();
  }

  static get_history(){
    $('#history-table').DataTable( {
        processing: true,
        serverSide: true,
        bDestroy: true,
        pagingType: "simple",
        preDrawCallback: function( settings ) {
          if ( settings.jqXHR){
          settings._iRecordsTotal = settings.jqXHR.getResponseHeader('total-records');
          settings._iRecordsDisplay = settings.jqXHR.getResponseHeader('total-records');
          }
      },
        ajax: {
          url: "api/users/rentings/all/",
          type: "GET",
          beforeSend: function(xhr){
            xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
          },
          dataSrc: function(resp){
            console.log(resp);
            return resp;
          },
          data: function ( d ) {
            d.offset = d.start;
            d.limit = d.length;
            d.search = d.search.value;
            d.order = encodeURIComponent((d.order[0].dir == 'asc' ? "-" : "+")+d.columns[d.order[0].column].data);
            delete d.start;
            delete d.length;
            delete d.columns;
            delete d.draw;
            console.log(d);
          }
        },
        columns: [
          { "data": "model" },
          { "data": "rented_on_date" },
          { "data": "return_date" }
        ]
    } );
  }

  static file2base64(event){
     var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
     var imgurl = null;
     console.log(event.files);
     if(user_info.r == "USER" || user_info.r == "ADMIN") var url = "api/users/cdn";
     if(user_info.r == "company") var url = "api/companies/cdn";
     var f = event.files[0];

     var reader = new FileReader();
     // Closure to capture the file information.
     reader.onload = (function(theFile) {
         return function(e) {
             // Render thumbnail.
             //$('#upload-img').attr('src',e.target.result);
             var upload = {
               name: f.name,
               content: e.target.result.split(',')[1]
             };
             $.ajax({
                  url: url,
                  type: "POST",
                  data: JSON.stringify(upload),
                  contentType: "application/json",
                  beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
                  success: function(data) {
                    imgurl = data.url;
                    $('input[name="image"]').val(imgurl);
                    console.log($('#image').val());
                  },
                  error: function(jqXHR, textStatus, errorThrown ){
                    toastr.error(jqXHR.responseJSON.message);
                    console.log(jqXHR);
                  }
               });
         };
     })(f);
     // Read in the image file as a data URL.
     reader.readAsDataURL(f);
   }
}
