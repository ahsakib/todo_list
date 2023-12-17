const inputFiledValue = document.querySelector(".input__value");
const tbodyData = document.querySelector(".insert_value");
const categoryBtn = document.querySelector("#categoryBtn");
const dropdownItem = document.querySelectorAll(".dropdown-item");
const dueDateId = document.querySelector("#dueDate");
// const date=new Date;

var selectedValue;
var badge;
var count = 0;
var dueDate;


function getDateWithFormat(picked){
    let FormattingDate;
    let daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    let currentTime=Date.now();
    let pickedDate=new Date(picked);
    let diff=pickedDate-currentTime;
    let differenceDay=Math.floor(diff/(1000*60*60*24))+1;
    let dayOfWeek =pickedDate.getDay();
    let formattedDate=pickedDate.toLocaleDateString('en-US',{
      weekday:'short',
      month:'long',
      day:'numeric'
    })

    if(differenceDay==0) FormattingDate="Today";
    else if(differenceDay==1) FormattingDate="Tomorrow";
    else if(differenceDay<=7) FormattingDate=daysOfWeek[dayOfWeek];
    else FormattingDate = formattedDate;

    return FormattingDate;
}

// Function to initialize the datepicker
function initDatepicker() {
  $("#datepicker-container").datepicker({
    dateFormat: "mm-dd-yy", // Format the date as YYYY-MM-DD
    onSelect: function (dateText) {
      dueDate=dateText;
      let FormattingDate=getDateWithFormat(dueDate);
      dueDateId.innerHTML=FormattingDate;
    },
  });
}

$("#dueDate").click(function () {
  // Check if datepicker is already initialized
  if ($("#datepicker-container").is(":empty")) {
    // If not, initialize datepicker
    initDatepicker();
  }
  
  // Show datepicker container
  $("#datepicker-container").show();
});

// Hide datepicker when clicking outside of it
$(document).mouseup(function (e) {
  var container = $("#datepicker-container");
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    container.hide();
  }
});




dropdownItem.forEach(function (item) {
  item.addEventListener("click", function (e) {
    selectedValue = e.target.text;
    switch (selectedValue) {
      case "High":
        badge = "text-bg-danger";
        break;
      case "Medium":
        badge = "text-bg-warning";
        break;
      default:
        badge = "text-bg-secondary";
    }
  });
});

inputFiledValue.addEventListener("keypress", function (e) {
  if (e.key == "Enter") {
    var saveData;
    var inputValue;
    if (inputFiledValue.hasAttribute("data-edit")) {
      inputValue = inputFiledValue.value;
      const taskId = inputFiledValue.getAttribute("data-edit");
      const taskRow = document.querySelector(`#task_row_${taskId}`);
      taskRow.querySelector("p").innerText = inputValue;
      inputFiledValue.removeAttribute("data-edit");
      saveData = "edit";
      $.ajax({
        type: "POST",
        url: "action.php",
        data: {
          TaskName: inputValue,
          saveData: saveData,
          id: taskId,
        },
        dataType: "json",
        success: function (response) {},
      });
    } else {
      saveData = "save";
      count++;
      inputValue = inputFiledValue.value;
      if (inputValue == "") {
        alert("please input some value");
        return;
      }
      $.ajax({
        type: "POST",
        url: "action.php",
        data: {
          TaskName: inputValue,
          saveData: saveData,
          dueDate: dueDate,
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
          var dueDateHtml='';
          if(dueDate){
            let due_date = getDateWithFormat(dueDate);
            dueDateHtml = `<span><i class="bi bi-calendar-event"></i> ${due_date}</span>`;
          }
          let priorityColumn = "";
          if (selectedValue) {
            priorityColumn = `
                <td class="align-middle">
                  <h6 class="mb-0">
                    <span class="badge ${badge}">${selectedValue} priority</span>
                  </h6>
                </td>
              `;
          } else {
            priorityColumn = `
                <td class="align-middle">
                  <h6 class="mb-0">
  
                  </h6>
                </td>
              `;
          }
          const html = `<tr class="task-box" id="task_row_${response.id}">
          <td class="align-middle">
            <label class="d-flex align-items-center">
              <input type="checkbox" id="0" class="ms-3" />
              <p class="mb-0 ms-2">${response.TaskName}</p>
            </label>
            <div class='all-siteElement'>
                <span>Task<i class="bi bi-dot dot-icon"></i></span>
                ${dueDateHtml}
                <span><i class="bi bi-bell"></i> Tomorrow</span>
                <span><i class="bi bi-tags"></i> shakib</span>
            </div>
          </td>
          ${priorityColumn}
          
          <td class="align-middle">
            <div class="settings">
              <i class="bi bi-repeat me-2"></i>
              <i onclick='showAction(this)' class="bi bi-three-dots"></i>
              <ul class="task-menu">
                <li onclick='editTask(${response.id})'><i class="bi bi-pencil-square"></i>Edit</li>
                <li onclick='deleteTask(${response.id})'><i class="bi bi-trash"></i>Delete</li>
              </ul>
            </div>
          </td>
        </tr>`;

          tbodyData.insertAdjacentHTML("afterbegin", html);
        },
      });
    }

    inputFiledValue.value = "";
  }
});

function showAction(element) {
  var taskMenu = element.nextElementSibling;

  taskMenu.classList.toggle("show");

  document.addEventListener("click", function (e) {
    if (
      !element.contains(e.target) &&
      !taskMenu.contains(e.target) &&
      taskMenu.classList.contains("show")
    ) {
      taskMenu.classList.remove("show");
    }
  });
}

function deleteTask(e) {
  $.ajax({
    type: "POST",
    url: "action.php",
    data: {
      delate: "deleteData",
      id: e,
    },
    success: function (response) {
      if (response) {
        var taskRow = document.querySelector(`#task_row_${e}`);
        if (taskRow) taskRow.remove();
      }
    },
  });
}

function editTask(taskId) {
  const taskRow = document.getElementById(`task_row_${taskId}`);
  const taskValue = taskRow.querySelector("p").innerText;
  inputFiledValue.value = taskValue;
  inputFiledValue.focus();
  inputFiledValue.setAttribute("data-edit", `${taskId}`);
}

$(document).ready(function () {
  $.ajax({
    url: "action.php", // URL to action.php
    type: "GET", // HTTP method
    data: {
      getData: "all-data"
    },
    dataType: "json",
    success: function (response) {
      response.forEach(function (data) {
        var dueDateHtml='';
        if(data.due_date){
          let due_date = getDateWithFormat(data.due_date);
          dueDateHtml= `<span><i class="bi bi-calendar-event"></i> ${due_date}</span>`;
        }
        let priorityColumn = "";
        if (selectedValue) {
          priorityColumn = `
              <td class="align-middle">
                <h6 class="mb-0">
                  <span class="badge ${badge}">${selectedValue} priority</span>
                </h6>
              </td>
            `;
        } else {
          priorityColumn = `
              <td class="align-middle">
                <h6 class="mb-0">

                </h6>
              </td>
            `;
        }
        const html = `<tr class="task-box" id="task_row_${data.id}">
        <td class="align-middle">
          <label class="d-flex align-items-center">
            <input type="checkbox" id="0" class="ms-3" />
            <p class="mb-0 ms-2">${data.task_name}</p>
          </label>
          <div class='all-siteElement'>
              <span>Task<i class="bi bi-dot dot-icon"></i></span>
              ${dueDateHtml}
              <span><i class="bi bi-bell"></i> Tomorrow</span>
              <span><i class="bi bi-tags"></i> shakib</span>
          </div>
        </td>
        ${priorityColumn}
        
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

        tbodyData.insertAdjacentHTML("afterbegin", html);
      });
    },
    error: function (error) {
      // Handle errors here
      console.error("Error:", error);
    },
  });
});

function datePickerValue(data){
  return data;
}