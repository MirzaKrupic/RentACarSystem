class Car{

  static init(){
    $("#add-car").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        data["brand_id"] = $("#brandsdropdown").val();
        if (data.id){
          Car.update(data);
        }else{
          Car.add(data);
        }
      }
    });

    Car.get_all();
  }

  static get_all(){
    $('#cars-table').DataTable( {
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
          url: "api/companies/cars",
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
              return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Car.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
            }
          },
          { "data": "model" },
          { "data": "brand_id" },
          { "data": "owner_id" },
          { "data": "created_at" },
          { "data": "number_of_doors" },
          { "data": "number_of_gears" },
          { "data": "number_of_seats" },
          { "data": "licence_plate" },
          { "data": "status" }
        ]
    } );
  }

  static add(car){
    RestClient.post("api/companies/cars/add", car, function(data){
      toastr.success("Car is successfully added");
      Car.get_all()
      $("#add-car").trigger("reset");
      $("#add-car-modal").modal("hide");
    });
  }

  static update(car){
    RestClient.put("api/companies/cars/"+car.id, car, function(data){
      toastr.success("Car has been updated");
      Car.get_all();
      $("#add-car").trigger("reset");
      $("#add-car *[name='id']").val("");
      $('#add-car-modal').modal("hide");
    });
  }

  static pre_edit(id){
  RestClient.get("api/companies/cars/"+id, function(data){
    AUtils.json2form("#add-car", data);
    $("#brandsdropdown").val(data.brand_id);
    $("#add-car-modal").modal("show");
  });
}
}
