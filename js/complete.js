"use strict";

$(document).ready(function () {
    $("tbody.insert_value.all").removeClass("display-none");

    $(".filters span").on("click", function (e) {
        $(".filters span").removeClass("active");
        $(this).addClass("active");
        $(".insert_value").addClass("display-none");
        var clickId = $(this).attr("id");
        $("." + clickId).removeClass("display-none");
        if(clickId=="all"){
          $.ajax({
            url: "action.php", // URL to action.php
            type: "GET", // HTTP method
            data: {
              getData: "all-data"
            },
            dataType: "json",
            success: function (response) {
              $("."+clickId).empty();
              var data=response.data
              data.forEach(function (data) {
                  renderTaskRow(data, selectedValue, badge);
              });
            },
            error: function (error) {
              // Handle errors here
              console.error("Error:", error);
            },
          });
        }
    });


    $("#completed").on("click",function(e){
        $.ajax({
            type:"POST",
            url:"action.php",
            data:{
                getCompleteData:"completeData"
            },
            dataType:"json",
            success:function(response){
                console.log(response);
                var getData=response.data;
                var totalComplete=getData.length;

                $("#noti__badge").html(totalComplete);

                $(".completed").empty();
                getData.forEach(function (data) {

                    const html = `<tr class="task-box dashboard" id="task_row_${data.id}">
                    <td class="align-middle">
                      <label class="d-flex align-items-center">
                        <input type="checkbox" value="n" checked id="${data.id}" class="ms-3" />
                        <del class="mb-0 ms-2">${data.task_name}</del>
                      </label>
                    </td>
                    
                    <td class="align-middle">
                      <div class="settings">
                        <i class="bi bi-repeat me-2"></i>
                        <i onclick='showAction(this)' class="bi bi-three-dots"></i>
                        <ul class="task-menu">
                          <li onclick='editTask(${data.id})'><i class="bi bi-pencil-square"></i>Edit</li>
                          <li onclick='deleteTask(${data.id})'><i class="bi bi-trash"></i>Delete</li>
                        </ul>
                      </div>
                    </td>
                  </tr>`;

                    $(".completed").append(html)
                  });
                
            }
        })
    })


    $(document).on('click', 'input[type="checkbox"]', function () {
        var id=$(this).attr("id");
        var value= $(this).val();
        var audioFilePath = 'sound/mixkit-correct-answer-tone-2870.wav';
        var notificationSound = new Audio(audioFilePath);
        $.ajax({
            type: "POST",
            url: "action.php",
            data: {
                completeId:id,
                completeValue:value
            },
            dataType:'json',
            success: function (response) {
              console.log(response);
                if(response.data){
                    $("#task_row_"+id).remove();
                    $("#noti__badge").html(response.count);
                    notificationSound.play();
                }
            }
        });
    });
});

