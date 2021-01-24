$(document).ready(function () {});

$(function () {
  $("body").on("change", "#district_id", function () {
    var district_id = $(this).val();
    dsd_list = $("#dsd_id");

    //Set DSDs according to district selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: {
        token: token,
        option: "get_dsd_by_district",
        district_id: district_id,
      },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        dsd_list.find("option").remove().end();
        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          dsd_list.append($(option)).selectpicker("refresh");
        });
      },
      failure: function () {
        alert("Failed!");
      },
    });

    ti_list = $("#ti_id");

    //Set TI range according to district selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: {
        token: token,
        option: "get_ti_by_district",
        district_id: district_id,
      },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        ti_list.find("option").remove().end();
        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          ti_list.append($(option)).selectpicker("refresh");
        });
      },
      failure: function () {
        alert("Failed!");
      },
    });
  });

  $("body").on("change", "[id^=dsd_id]", function () {
    str = $(this)[0].id;
    //var index=str.substring(str.lastIndexOf("[")+1,str.lastIndexOf("]"));

    gnd_list = $("[id^=gnd_id]");

    //gnd = gnd_list[index];//this is not used but this is how to get relavent gnd combo from array

    var dsd_id = $(this).find(":selected").val();

    //Set GNDs according to DSD selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: "get_gnd_by_dsd", dsd_id: dsd_id },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        gnd_list.find("option").remove().end();
        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          gnd_list.append($(option)).selectpicker("refresh");
        });
      },
      failure: function () {
        alert("Failed!");
      },
    });
  });

  $("#edit_form").submit(function (e) {
    e.preventDefault();
    var $form = $(this);

    var data = $form.serializeArray();

    //freez form
    var $inputs = $("#edit_form").find("input, select, button, textarea");
    $inputs.prop("disabled", true);

    // make a POST ajax call
    $.ajax({
      type: "POST",
      url: "refresh_content.php",
      data: {
        token: token,
        option: "save_society",
        data: $.param(data),
      },
      dataType: "json",
      async: false,
      beforeSend: function (xhr) {
        // maybe tell the user that the request is being processed
        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
      },
    }).done(function (result) {
      $inputs.prop("disabled", false);
      if (JSON.parse(result)[0].id !== undefined) {
        showMessage("Data Saved");
        $("#id").val(JSON.parse(result)[0].id);
      } else {
        showErrorMessage("Error saving society details");
        //$("#message").html(JSON.parse(result)); //uncomment this and check the error message
      }

      RefreshSocietyList();
    });
  });

  $("#new_society").on("click", function () {
    var id = this.id;
    var farmer_id = id.substring(5, id.length);
    $.ajax({
      type: "GET",
      url: "edit_society.php",
      data: { farmer_id: farmer_id },
      //contentType: "application/json; charset=utf-8",
      dataType: "html",
      success: function (result) {
        $("#model_content").empty();
        $("#model_content").html(result);

        $(".selectpicker").selectpicker({
          size: 4,
        });
      },
      failure: function () {
        alert("Failed!");
      },
    });
  });

  $("body").on("click", ".edit", function () {
    var obj_id = this.id;
    var id = obj_id.substring(5, obj_id.length);
    $.ajax({
      type: "GET",
      url: "edit_society.php",
      data: { id: id },
      async: false,
      dataType: "html",
      success: function (result) {
        $("#model_content").empty();
        $("#model_content").html(result);

        $(".selectpicker").selectpicker({
          size: 4,
        });
      },
      failure: function () {
        alert("Failed!");
      },
    });
  });
});

function RefreshSocietyList() {
  $.ajax({
    type: "GET",
    url: "refresh_content.php",
    data: { token: token, option: "list_society" },
    dataType: "html",
    success: function (res) {
      $("#society_list").empty();
      $("#society_list").html(res);
    },
    failure: function () {
      alert("Failed!");
    },
  });
}
