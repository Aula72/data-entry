let lim = localStorage.getItem("lim")




const xtime = 1000;
const add_date =()=>{
    let p = prompt("Enter Date:")
    if(p){
        $.ajax({
            type: "post",
            url: `${api_url}?date`,
            data: JSON.stringify({name:p}),
            headers,
            dataType: "json",
            success: function (response) {
                localStorage.setItem("date", p)
                // console.log(response)
                // console.log(p)
            }
        });
    }
    //reload()

}
const add_location = () => {
    // console.log(api_url)
    let p = prompt("Enter Location:")
    if(p){
        $.ajax({
            type: "post",
            url: `${api_url}?location`,
            data: JSON.stringify({name:p}),
            headers,
            dataType: "json",
            success: function (response) {
                // console.log(response)
                // console.log(p)
            }
        });
    }
    //reload()
}

$("#addItem").submit(function (e) { 
    e.preventDefault();
    submit_data();
});

const list_all = () =>{
    // let list = []
    
    $.ajax({
        type: "get",
        url: `${api_url}?lim=${localStorage.getItem("lim")}`,
        headers,
        dataType: "json",
        success: function (response) {
            let m = ""
            id = 1
            
            for(let y of response.nums){
                m+=`<tr>
                <td>${id}</td>
                <td>${y.name}</td>
                <td>${y.location}</td>
                <td>${y.date}</td>
                <td>${y.created_at}</td>
                <td><button class="btn btn-outline-primary btn-sm" onclick="edit_number('${y.id}', '${y.name}')">Edit</button></td>
                <td><button class="btn btn-outline-danger btn-sm" onclick="remove(${y.id})">Remove</button></td>
                </tr>`
                id++;
                // list.push(y.name)
            }
            $("#people").html(m);
        }
    });
    
}
const remove =(i)=>{
    let m = confirm("Are you sure you want to delete"+i)
    if(m){
        $.ajax({
            type: "delete",
            url: `${api_url}?id=${i}`,
            headers,
            dataType: "json",
            success: function (response) {
                // console.log(response)
                // setTimeout(()=>{
                //     $("#warning").html(`<strong>Success!</strong> ${reponse.message}`)
                // },5000)
            }
        });
    }
    
    list_all();
}
$(document).ready(function () {
    $.ajax({
        type: "get",
        url: `${api_url}?location`,
        headers,
        dataType: "json",
        success: function (response) {
            // console.log(response)
            let r = "<option>Select Street</option>"
            for(let x of response.locations){
                r+=`<option value="${x.id}">${x.name}</option>`
            }
            $("#location").html(r)
            $("#street").html(r)
        }
    });
    $.ajax({
        type: "get",
        url: `${api_url}?date`,
        headers,
        dataType: "json",
        success: function (response) {
            // console.log(response)
            let r = ""
            for(let x of response.dates){
                r+=`<option value="${x.id}">${x.name}</option>`
            }
            $("#dates").html(r)
            $("#day").html(r)
        }
    });
    $.ajax({
        type: "get",
        url: `${api_url}`,
        headers,
        dataType: "json",
        success: function (response) {
            // console.log(response)
            let r = "<option></option>"
            for(let x of response.nums){
                r+=`<option value="${x.name}">${x.name}</option>`
            }
            $("#nums").html(r)
        }
    });
    $("#nums").on("input", e=>{
        let date = $("#dates").val();
        let name = $("#nums").val();
        let location = $("#location").val();
        let list = []
        $.ajax({
            type: "get",
            url: `${api_url}?search=${name}&&l=${location}&&d=${date}`,
            headers,
            dataType: "json",
            success: function (response) {
                // console.log(response.nums)
                for(let m of response.nums){
                    list.push(m.names)
                }
                // console.log(list)
            }
        });
    
        $( function() {
        
            var availableTags = list;
            $( "#nums" ).autocomplete({
              source: availableTags
            });
          } );
        if(name.length>=8){
            submit_data();
        }
        
    })
    $("#records").val(localStorage.getItem('lim'));
    $("li").addClass("list-group-item")
    list_all()
});

const submit_data = () =>{
    let date = $("#dates").val();
    let name = $("#nums").val();
    let location = $("#location").val();
    $.ajax({
        type: "post",
        url: `${api_url}`,
        data: JSON.stringify({name, location, date}),
        dataType: "json",
        success: function (response) {
            $("#sdv").html(response.nums);
            // console.log(response)
        }
    });
    // list_all()
    $("#nums").val("");
}

const edit_number = (i, t) => {
    let j = prompt(`Edit ${t}`, t)
    if(j){
        $.ajax({
            type: "put",
            url: `${api_url}?id=${i}`,
            data: JSON.stringify({name:j}),
            headers,
            success: function (response) {
                // console.log(response)
            }
        });
        // console.log(j)
    }
    list_all()

}

setInterval(()=>{
    if($("#nums").val().length==8){
        submit_data()
    }
},xtime)

setInterval(list_all, 3*xtime)
// setInterval(()=>{
//     console.log(`${localStorage.getItem("lim")} is ${Math.floor(Math.random()*7)}`)
// }, 1000)
setInterval(()=>{
        showStats();
    },
    xtime
);

const showStats = ()=>{
    $.ajax({
        type: "get",
        url: `${api_url}?stats&&d=${$("#dates").val()}`,
        headers,
        dataType: "json",
        success: function (response) {
            let m = 1/(response.number/response.diff_name)
            $("#dt").html(response.dates);
            $("#st").html(response.streets);
            $("#un").html(response.diff_name);
            $("#np").html(response.number);
            $("#rp").html(response.number - response.diff_name);
            $("#rt").html(m.toFixed(4));
            $("#tdf").html(response.today)
            $("#tyy").html(response.tyy)

            let m0 = ``
            for(let j of response.complete){
                m0 += `<li class="list-group-item">${j}</li>`
            }
            $("#complete").html(m0)
            // $("#warning").hide()
        }
    })
}
const record_count = (x) =>{
    // console.log(x)
    localStorage.setItem("lim", x)
}

const change_date = (x) =>{
    localStorage.setItem("date", x)
}
const change_loc  = (x) =>{
    localStorage.setItem("loc", x)
}

showStats();





