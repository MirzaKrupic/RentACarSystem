class Admin{

  static init_user(){
    $("#edit-user").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        console.log(data);
        if (data.id){
          Admin.update_user(data);
        }
      }
    });

    Admin.get_all_users();
  }

  static init_company(){
    $("#edit-company").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        console.log(data);
        if (data.id){
          Admin.update_company(data);
        }
      }
    });
    Admin.get_all_companies();
  }

  static init_brand(){
    $("#edit-brand").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        console.log(data);
        if (data.id){
          Admin.update_brand(data);
        }
      }
    });
    Admin.get_all_brands();
  }

  static get_all_users(){
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
              return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Admin.pre_edit_user('+data+')"><i class="fa fa-edit"></i></a>';
            }
          },
          { "data": "name" },
          { "data": "mail" },
          { "data": "address" },
          { "data": "status" }
        ]
    } );
  }

  static get_all_companies(){
    $('#companies-table').DataTable( {
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
          url: "api/admin/companies",
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
              return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Admin.pre_edit_company('+data+')"><i class="fa fa-edit"></i></a>';
            }
          },
          { "data": "name" },
          { "data": "mail" },
          { "data": "address" },
          { "data": "status" }
        ]
    } );
  }

  static get_all_brands(){
    $('#brands-table').DataTable( {
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
          url: "api/brands/all",
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
              return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Admin.pre_edit_brand('+data+')"><i class="fa fa-edit"></i></a>';
            }
          },
          { "data": "name" }
        ]
    } );
  }

  static update_user(user){
    RestClient.put("api/admin/users/"+user.id, user, function(data){
      toastr.success("User has been updated");
      Admin.get_all_users();
      $("#edit-user").trigger("reset");
      $("#edit-user *[name='id']").val("");
      $('#edit-user-modal').modal("hide");
    });
  }

  static update_company(company){
    RestClient.put("api/admin/companies/"+company.id, company, function(data){
      toastr.success("Company has been updated");
      Admin.get_all_companies();
      $("#edit-company").trigger("reset");
      $("#edit-company *[name='id']").val("");
      $('#edit-company-modal').modal("hide");
    });
  }

  static update_brand(brand){
    RestClient.put("api/admin/brands/"+brand.id, brand, function(data){
      toastr.success("Brand has been updated");
      Admin.get_all_brands();
      $("#edit-brand").trigger("reset");
      $("#edit-brand *[name='id']").val("");
      $('#edit-brand-modal').modal("hide");
    });
  }

  static pre_edit_user(id){
    RestClient.get("api/admin/users/"+id, function(data){
      AUtils.json2form("#edit-user", data);
      $("#edit-user-modal").modal("show");
    });
  }

  static pre_edit_company(id){
    RestClient.get("api/admin/companies/"+id, function(data){
      AUtils.json2form("#edit-company", data);
      $("#edit-company-modal").modal("show");
    });
  }

  static pre_edit_brand(id){
    RestClient.get("api/brands/"+id, function(data){
      AUtils.json2form("#edit-brand", data);
      $("#edit-brand-modal").modal("show");
    });
  }
}
