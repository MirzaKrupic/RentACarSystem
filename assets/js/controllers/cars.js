class Car{

  static init(){
    Car.getBrands();
    $("#add-car").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        data["brand_id"] = $("#brandsdropdown").val();
        console.log(data);
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
    var globalBrands = [];
    RestClient.get("api/brands/all", function(data){
      for(var i = 0; i < data.length; i++){
        globalBrands.push(data[i]);
      }
    });
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
          { "data": "brand_id",
            "render": function ( data, type, row, meta ) {
              var brandName = null;
              for(var i = 0; i < globalBrands.length; i++){
                if(globalBrands[i].id == data){
                  brandName = globalBrands[i].name;
                }
              }
              return brandName;
            }
          },
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

  static getBrands(){
    RestClient.get("api/brands/all", function(data){
      for(var i = 0; i < data.length; i++){
        var option = document.createElement("option");
        option.value = data[i].id;
        option.text = data[i].name;
        document.getElementById('brandsdropdown').appendChild(option);
      }
    });
  }

  static file2base64(event){
     var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
     var imgurl = null;
     console.log("event fgile");
     console.log(event.files);
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
                  url: "api/companies/cdn",
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
