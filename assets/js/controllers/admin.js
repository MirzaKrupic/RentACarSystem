class Admin{

  static init(){
    $("#edit-user").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        console.log(data);
        if (data.id){
          Admin.update(data);
        }
      }
    });

    Admin.get_all();
  }

  static get_all(){
    $('#users-table').DataTable( {
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
          url: "api/admin/users",
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
          { "data": "id",
            "render": function ( data, type, row, meta ) {
              return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Admin.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
            }
          },
          { "data": "name" },
          { "data": "mail" },
          { "data": "address" },
          { "data": "status" }
        ]
    } );
  }

  static update(user){
    RestClient.put("api/admin/users/"+user.id, user, function(data){
      toastr.success("User has been updated");
      Admin.get_all();
      $("#edit-user").trigger("reset");
      $("#edit-user *[name='id']").val("");
      $('#edit-user-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("api/admin/users/"+id, function(data){
      AUtils.json2form("#edit-user", data);
      $("#edit-user-modal").modal("show");
    });
  }
}
