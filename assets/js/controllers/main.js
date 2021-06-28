class Main{

  static init(){
    Main.get_all_cars();
  }

  static get_all_cars(){
    var user_info = AUtils.parse_jwt(window.localStorage.getItem("token"));
    Main.clearBox("carcardssection");
    $.ajax({
         url: "api/cars/all",
         type: "GET",
         success: function(data) {
           var html = "";
           var today = new Date().toISOString().slice(0, 10);
           for(var i = 0; i < data.length; i++){
             html+='<div class="card mb-3">'
                  +'<div class="row no-gutters">'
                  +'<div class="col-md-4">'
                  +'<img src="'+data[i].image+'" class="card-img fit-image">'
                  +'</div>'
                  +'<div class="col-md-4">'
                  +'<div class="card-body">'
                  +'<h5 class="card-title">'+data[i].model+'</h5>'
                  +'<div class="row">'
                  +'<div class="col-sm-1"><img src="./assets/imgs/cardoor.png" alt="number of doors" class="miniimg"></div>'
                  +'<div class="col-sm-10">'+data[i].number_of_doors+'</div>'
                  +'</div>'
                  +'<br>'
                  +'<div class="row">'
                  +'<div class="col-sm-1"><img src="./assets/imgs/carshifter.png" alt="number of gears" class="miniimg"></div>'
                  +'<div class="col-sm-10">'+data[i].number_of_gears+'</div>'
                  +'</div>'
                  +'<br>'
                  +'<div class="row">'
                  +'<div class="col-sm-1"><img src="./assets/imgs/carseat.png" alt="number of seats" class="miniimg"></div>'
                  +'<div class="col-sm-10">'+data[i].number_of_seats+'</div>'
                  +'</div>'
                  +'</div>'
                  +'</div>'
                  +'<div class="col-md-4">'
                  +'<div class="card-body">'
                  +'<label for="start">Return date:</label>'
                  +'<input type="date" id="returnDate'+data[i].id+'" name="trip-start"'
                  +'value="'+today+'"'
                  +'min="'+today+'" max="2030-12-31">'
                  +'<br>'
                  +'<br>'
                  if(user_info.r == "USER")
                  {
                    if(data[i].status == "FOR RENT"){
                      html +='<button id="carbtn'+data[i].id+'" type="button" onclick="Main.add_rental('+data[i].id+')" class="btn btn-danger btn-lg btn-block align-bottom">Rent</button>'
                    }else{
                    html+='<button type="button" class="btn btn-danger btn-lg btn-block align-bottom" disabled>Rented out</button>'
                    }
                  }else{
                    html+='<button type="button" class="btn btn-danger btn-lg btn-block align-bottom" disabled>You cannot rent cars</button>'
                  }
                  html+='</div>'
                  +'</div>'
                  +'</div>'
                  +'</div>'
           }
           document.getElementById("carcardssection").innerHTML += html;
         }
      });
  }

  static add_rental(car){
    var date = document.getElementById("returnDate"+car).value;
    var carObj ='{ "car_id":"'+car+'" , "return_date":"'+date+'" }';
    var obj = JSON.parse(carObj);
    $("#carbtn"+car).prop('disabled', true);
    $("#carbtn"+car).html('Rented out');
    RestClient.post("api/users/rentings/add", obj, function(data){
      toastr.success("You rented this car successfully");
    });

    RestClient.put("api/users/rent/"+car, null, function(data){
    });
  }

  static clearBox(elementID) {
    var div = document.getElementById(elementID);

    while(div.firstChild) {
        div.removeChild(div.firstChild);
    }
  }
}
