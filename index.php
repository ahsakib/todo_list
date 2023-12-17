<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8" />
  <title>Todo List App</title>
  <!-- link custom css -->
  <link rel="stylesheet" href="css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- bootstrap linkup js icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Include jQuery UI for datePicker -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>


  <!-- profile section -->
  <section class="gradient-custom-2">
    <div class="image-section">
      <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height: 200px">
        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px">
          <img src="img/avatar-1.webp" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
            style="width: 150px; z-index: 1" />
          <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1">
            Edit profile
          </button>
        </div>
        <div class="ms-3" style="margin-top: 130px">
          <h5>Andy Horwitz</h5>
          <p>New York</p>
        </div>
        <div class="settingsBtn">
          <i class="bi bi-gear-fill"></i>
        </div>
      </div>
    </div>
  </section>


  <div class="wrapper">

    <!-- input filed section -->
    <input class="searchBox form-control" placeholder="Search..." type="text" name="" id="" />
    <div class="task-input mt-5">
      <img src="bars-icon.svg" alt="icon" />
      <input class="input__value" type="text" placeholder="Add a new task" />
    </div>
    <div class="task-tag mt-3 d-flex align-items-center justify-content-between">
      <!-- Set Due Date -->

      <button class="btn btn-info" id="dueDate"><i class="bi bi-calendar-event me-2"></i>Set Due Date</button>

      <!-- Container to hold the datepicker -->
      <div id="datepicker-container" class="datePicker" style="display: none;"></div>
      <!-- Reminder Me -->
      <div class="dropdown ms-2">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-bell"></i> Reminder Me
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Ascending</a></li>
          <li><a class="dropdown-item" href="#">Descending</a></li>
          <li><a class="dropdown-item" href="#">High</a></li>
        </ul>
      </div>

      <!-- Category -->
      <div class="dropdown ms-2">
        <button class="btn btn-info dropdown-toggle" id="categoryBtn" type="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <i class="bi bi-tags"></i> Category
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">High</a></li>
          <li><a class="dropdown-item" href="#">Medium</a></li>
          <li><a class="dropdown-item" href="#">Low</a></li>
        </ul>
      </div>
    </div>

    <!-- filter option -->
    <div class="controls">
      <div class="filters">
        <span class="active" id="all">All</span>
        <span id="pending">Pending</span>
        <span id="completed">Completed</span>
      </div>
      <button class="clear_btn btn btn-info">Clear All</button>

      <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Filter
        </button>
        <ul class="dropdown-menu" style="">
          <li><a class="dropdown-item" href="#">Ascending</a></li>
          <li><a class="dropdown-item" href="#">Descending</a></li>
          <li><a class="dropdown-item" href="#">High</a></li>
          <li><a class="dropdown-item" href="#">Medium</a></li>
          <li><a class="dropdown-item" href="#">Low</a></li>
          <li><a class="dropdown-item" href="#">Latest</a></li>
          <li><a class="dropdown-item" href="#">Oldest</a></li>
        </ul>
      </div>
    </div>

    <table class="table text-white mb-0">
      <tbody class="insert_value">

      </tbody>
    </table>
  </div>

  <!-- <script src="script.js"></script> -->
  <script src="js/app.js"></script>

<script>
  // $(document).ready(function () {
    // // Function to initialize the datepicker
    // function initDatepicker() {
    //   $("#datepicker-container").datepicker({
    //     dateFormat: "yy-mm-dd", // Format the date as YYYY-MM-DD
    //     onSelect: function (dateText) {
    //       console.log("Selected date:", dateText);
    //       // You can do more with the selected date here
    //     },
    //   });
    // }

    // // Show datepicker when the button is clicked
    // $("#dueDate").click(function () {
    //   // Check if datepicker is already initialized
    //   if ($("#datepicker-container").is(":empty")) {
    //     // If not, initialize datepicker
    //     initDatepicker();
    //   }
      
    //   // Show datepicker container
    //   $("#datepicker-container").show();
    // });

    // // Hide datepicker when clicking outside of it
    // $(document).mouseup(function (e) {
    //   var container = $("#datepicker-container");
    //   if (!container.is(e.target) && container.has(e.target).length === 0) {
    //     container.hide();
    //   }
    // });
  // });
</script>
</body>

</html>