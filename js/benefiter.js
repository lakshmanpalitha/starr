
$(document).ready(function () {
  var $filter_year = $('#cmb_filter_year');
  $filter_year.append($("<option />").val(0).text('All'));
  setYear($filter_year);
  $filter_year.val(0);
});
function setYear(dropdown) {
  var curr_year = (new Date).getFullYear();
  for (var i = 2017; i <= curr_year; i++) {
    if (i == curr_year) {
      dropdown.append($("<option selected />").val(i).text(i));
    }
    else {
      dropdown.append($("<option />").val(i).text(i));
    }
  }
}
$(function () {
  //search button click
  $("#btn_search").click(function () {
    dist_id = $("[id^=cmb_filter_district]").find(":selected").val();
    society_id = $("[id^=cmb_filter_society]").find(":selected").val();
    year = $("[id^=cmb_filter_year]").find(":selected").val();

    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'list_filter_benifiter', dist_id: dist_id, society_id: society_id, year: year },
      dataType: "html",
      success: function (res) {
        $("#benifiter_list").empty();
        $("#benifiter_list").html(res);

        $("#tbl_benifiter").DataTable({
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  });

  //add another permit
  $('body').on('click', "#btn_add_permit", function () {
    UpdatePermitTable();

    $('#txt_permit_no').val('');
    $('#txt_plot_no').val('');
    $('#txt_land_name').val('');
    $('#txt_land_size_init_ha').val('');
    $('#txt_land_size_act_ha').val('');
  });

  $('body').on('click', "#btn_save_permit", function () {
    url = service_url + "/save_permit";
    benifiter_id = $('#txt_id').val();

    var permit_id = $('#txt_permit_id').val();
    var permit_no = $('#txt_permit_no').val();
    var land_name = $('#txt_land_name').val();
    var plot_no = $('#txt_plot_no').val();
    var init_land_size = $('#txt_land_size_init_ha').val();
    var act_land_size = $('#txt_land_size_act_ha').val();

    if ($('#cmb_crop').find(":selected").val() != '') {
      crop_id = $('#cmb_crop').find(":selected").val();
      crop_name = $('#cmb_crop').find(":selected").text();
    }
    if ($('#cmb_district').find(":selected").val() != '') {
      dis_id = $('#cmb_district').find(":selected").val();
      dis_name = $('#cmb_district').find(":selected").text();
    }
    if ($('#cmb_ti').find(":selected").val() != '') {
      ti_id = $('#cmb_ti_range').find(":selected").val();
      ti_name = $('#cmb_ti_range').find(":selected").text();
    }
    if ($('#cmb_dsd').find(":selected").val() != '') {
      dsd_id = $('#cmb_dsd').find(":selected").val();
      dsd_name = $('#cmb_dsd').find(":selected").text();
    }
    if ($('#cmb_gnd').find(":selected").val() != '') {
      gnd_id = $('#cmb_gnd').find(":selected").val();
      gnd_name = $('#cmb_gnd').find(":selected").text();
    }
    if (crop_id > 0 && permit_no != '' && init_land_size > 0 && dis_id > 0 && ti_id > 0 && dsd_id > 0 && gnd_id > 0) {
      //if(permit_num_exists != true)
      $.ajax({
        type: "POST",
        url: url,
        async: false,
        data: { id: permit_id, benifiter_id: benifiter_id, permit_no: permit_no, land_name: land_name, plot_no: plot_no, crop_id: crop_id, land_size_init_ha: init_land_size, land_size_act_ha: act_land_size, district_id: dis_id, dsd_id: dsd_id, ti_id: ti_id, gnd_id: gnd_id },
        beforeSend: function (xhr) {
          // maybe tell the user that the request is being processed
          //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
        }
      }).done(function (result) {
        if (JSON.parse(result)[0].id !== undefined) {
          showMessage('Permit Data Saved');
          PermitDefaultDisplay();
          RefreshBenifiterPermits(benifiter_id);
        }
        else {
          showErrorMessage("Error saving permit details");
          //$("#message").html(JSON.parse(result)); //uncomment this and check the error message
        }

        hideLoader();
      });
    }
  });

  function RefreshBenifiterPermits(ben_id) {
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'list_permit', benifiter_id: ben_id },
      dataType: "html",
      success: function (res) {
        $("#permit_list").empty();
        $("#permit_list").html(res);
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  }

  function UpdatePermitTable() {
    var id = 0;
    var crop_id = 0;
    var permit_no = $('#txt_permit_no').val();
    var land_name = $('#txt_land_name').val();
    var plot_no = $('#txt_plot_no').val();
    var init_land_size = $('#txt_land_size_init_ha').val();
    var act_land_size = $('#txt_land_size_act_ha').val();
    var dis_id = 0;
    var ti_id = 0;
    var dsd_id = 0;
    var gnd_id = 0;
    var crop_name = 0;
    var dis_name = 0;
    var ti_name = 0;
    var dsd_name = 0;
    var gnd_name = 0;

    //admin_name = $('#infoTable tbody tr:eq('+i+')').find("td:eq(2)").text();

    var permit_num_exists = false;
    $('#tbl_permit > tbody  > tr').each(function (i, tr) {
      if (i > 0) {
        if ($('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(7)").text() == permit_no)
          permit_num_exists = true;
      }
    });

    if ($('#cmb_crop').find(":selected").val() != '') {
      crop_id = $('#cmb_crop').find(":selected").val();
      crop_name = $('#cmb_crop').find(":selected").text();
    }
    if ($('#cmb_district').find(":selected").val() != '') {
      dis_id = $('#cmb_district').find(":selected").val();
      dis_name = $('#cmb_district').find(":selected").text();
    }
    if ($('#cmb_ti').find(":selected").val() != '') {
      ti_id = $('#cmb_ti_range').find(":selected").val();
      ti_name = $('#cmb_ti_range').find(":selected").text();
    }
    if ($('#cmb_dsd').find(":selected").val() != '') {
      dsd_id = $('#cmb_dsd').find(":selected").val();
      dsd_name = $('#cmb_dsd').find(":selected").text();
    }
    if ($('#cmb_gnd').find(":selected").val() != '') {
      gnd_id = $('#cmb_gnd').find(":selected").val();
      gnd_name = $('#cmb_gnd').find(":selected").text();
    }

    if (crop_id > 0 && permit_no != '' && init_land_size > 0 && dis_id > 0 && ti_id > 0 && dsd_id > 0 && gnd_id > 0) {
      if (permit_num_exists != true) {
        $('#tbl_permit tr:last').after('<tr> \
                            <td style="display: none;">'+ id + '</td> \
                            <td style="display: none;">'+ crop_id + '</td> \
                            <td style="display: none;">'+ dis_id + '</td> \
                            <td style="display: none;">'+ ti_id + '</td> \
                            <td style="display: none;">'+ dsd_id + '</td> \
                            <td style="display: none;">'+ gnd_id + '</td> \
                            <td style="display: none;">'+ crop_name + '</td> \
                            <td>'+ permit_no + '</td> \
                            <td>'+ land_name + '</td> \
                            <td>'+ plot_no + '</td> \
                            <td>'+ init_land_size + '</td> \
                            <td>'+ act_land_size + '</td> \
                            <td style="display: none;">'+ dis_name + '</td> \
                            <td>'+ ti_name + '</td> \
                            <td>'+ dsd_name + '</td> \
                            <td style="display: none;">'+ gnd_name + '</td> \
                            <td><button class="view_this" type="button">select</button></td> </tr>'
        );
        //reset fields
        $('#txt_permit_no').val('');
        return 1;
      }
      else {
        alert('Permit number already exists');
        return -1;
      }
    }
    else {
      alert('Crop, permit no, land size, district, Ti, DSD and GND selections are required for permit details');
      return -1;
    }
  }

  $('body').on('click', '.view_this', function () {
    var tr = $(this).closest("tr");
    permit_id = tr.find("td:eq(0)").text();
    crop_id = tr.find("td:eq(1)").text();
    permit_no = tr.find("td:eq(7)").text();
    init_land_size = tr.find("td:eq(10)").text();
    act_land_size = tr.find("td:eq(11)").text();
    land_name = tr.find("td:eq(8)").text();
    plot_no = tr.find("td:eq(9)").text();
    dis_id = tr.find("td:eq(2)").text();
    ti_id = tr.find("td:eq(3)").text();
    dsd_id = tr.find("td:eq(4)").text();
    gnd_id = tr.find("td:eq(5)").text();

    $('#cmb_crop').selectpicker('val', crop_id);
    $('#cmb_crop').selectpicker('refresh');

    $('#txt_permit_id').val(permit_id);
    $('#txt_permit_no').val(permit_no);
    $('#txt_land_name').val(land_name);
    $('#txt_plot_no').val(plot_no);
    $('#txt_land_size_init_ha').val(init_land_size);
    $('#txt_land_size_act_ha').val(act_land_size);
    $('#cmb_district').selectpicker('val', dis_id);

    FillDSDsByDistrict(dis_id);
    FillTIsByDistrict(dis_id);

    $('#cmb_dsd').selectpicker('val', dsd_id);
    $('#cmb_ti_range').selectpicker('val', ti_id);

    FillGNDsByDSD(dsd_id);
    $('#cmb_gnd').selectpicker('val', gnd_id);

    $('#btn_add_permit').hide();
    $('#btn_save_permit').show();
  });

  $('body').on('click', '.view_dependant', function () {
    alert('found');
    /*
    var tr = $(this).closest("tr");
    permit_id = tr.find("td:eq(0)").text();
    crop_id = tr.find("td:eq(1)").text();
    permit_no = tr.find("td:eq(7)").text();
    init_land_size = tr.find("td:eq(8)").text();
    act_land_size = tr.find("td:eq(9)").text();
    dis_id = tr.find("td:eq(2)").text();
    ti_id = tr.find("td:eq(3)").text();
    dsd_id = tr.find("td:eq(4)").text();
    gnd_id = tr.find("td:eq(5)").text();
    
    $('#cmb_crop').selectpicker('val', crop_id);
    $('#cmb_crop').selectpicker('refresh');
    
    $('#txt_permit_id').val(permit_id);
    $('#txt_permit_no').val(permit_no);
    $('#txt_land_size_init_ha').val(init_land_size);
    $('#txt_land_size_act_ha').val(act_land_size);
    $('#cmb_district').selectpicker('val', dis_id);
    
    FillDSDsByDistrict(dis_id);
    FillTIsByDistrict(dis_id);
    
    $('#cmb_dsd').selectpicker('val', dsd_id);
    $('#cmb_ti_range').selectpicker('val', ti_id);
    
    FillGNDsByDSD(dsd_id);
    $('#cmb_gnd').selectpicker('val', gnd_id);
    
    $('#btn_add_permit').hide();
    $('#btn_save_permit').show();
    */
  });

  //start filtering section
  $('body').on('change', '[id^=cmb_filter_district]', function () {
    str = $(this)[0].id;

    var district_id = $(this).find(":selected").val();

    sos_list = $("[id^=cmb_filter_society]");

    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      async: false,
      data: { token: token, option: 'get_society_by_district', district_id: district_id },
      beforeSend: function (xhr) {
        // maybe tell the user that the request is being processed
        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
      }
    }).done(function (res) {
      var result = JSON.parse(res);
      sos_list.find('option')
        .remove()
        .end();
      var option = new Option('All', 0);
      sos_list.append($(option)).selectpicker('refresh'); //Add option All

      $.each(result, function (index, element) {
        var option = new Option(element.name, element.id);
        sos_list.append($(option)).selectpicker('refresh');
      });

      hideLoader();
    });
  });


  //end filtering section


  $('body').on('change', '[id^=cmb_district]', function () {
    str = $(this)[0].id;

    var district_id = $(this).find(":selected").val();

    FillDSDsByDistrict(district_id);

    FillTIsByDistrict(district_id);
  });

  function PermitDefaultDisplay() {
    $('#cmb_crop').selectpicker('val', 0);
    $('#cmb_crop').selectpicker('refresh');

    $('#cmb_district').selectpicker('val', 0);
    $('#cmb_district').selectpicker('refresh');

    $("#cmb_dsd").find('option').remove();
    $("#cmb_dsd").selectpicker("refresh");

    $("#cmb_ti_range").find('option').remove();
    $("#cmb_ti_range").selectpicker("refresh");

    $("#cmb_gnd").find('option').remove();
    $("#cmb_gnd").selectpicker("refresh");

    $('#txt_permit_no').val('');
    $('#txt_land_name').val('');
    $('#txt_plot_no').val('');
    $('#txt_land_size_init_ha').val('');
    $('#txt_land_size_act_ha').val('');

    $('#btn_add_permit').show();
    $('#btn_save_permit').hide();

  }

  function FillDSDsByDistrict(district_id) {
    $("#cmb_gnd").find('option').remove();
    $("#cmb_gnd").selectpicker("refresh");

    dsd_list = $("[id^=cmb_dsd]");

    //Set DSDs according to district selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'get_dsd_by_district', district_id: district_id },
      async: false,
      dataType: "json",
      success: function (result) {
        //result = JSON.parse(res);
        dsd_list.find('option')
          .remove()
          .end();
        var option = new Option('All', 0);
        dsd_list.append($(option)).selectpicker('refresh'); //Add option All

        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          dsd_list.append($(option)).selectpicker('refresh');
        });

        hideLoader();
      },
      failure: function () {
        alert("Failed!");

        hideLoader();
      }
    });
  }

  function FillTIsByDistrict(district_id) {
    ti_list = $("[id^=cmb_ti_range]");
    //Set TI range according to district selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'get_ti_by_district', district_id: district_id },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        ti_list.find('option')
          .remove()
          .end();
        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          ti_list.append($(option)).selectpicker('refresh');
        });

        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  }

  function FillGNDsByDSD(dsd_id) {
    gnd_list = $("[id^=cmb_gnd]");

    //Set DSDs according to district selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'get_gnd_by_dsd', dsd_id: dsd_id },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        gnd_list.find('option')
          .remove()
          .end();
        var option = new Option('All', 0);
        dsd_list.append($(option)).selectpicker('refresh'); //Add option All

        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          gnd_list.append($(option)).selectpicker('refresh');
        });

        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  }

  $('body').on('change', '[id^=cmb_dsd]', function () {
    str = $(this)[0].id;
    var dsd_id = $(this).find(":selected").val();
    FillGNDsByDSD(dsd_id);
  });

  $('body').on('change', '[id^=cmb_ben_district]', function () {
    str = $(this)[0].id;

    society_list = $("[id^=cmb_society]");

    var dist_id = $(this).find(":selected").val();

    //Set DSDs according to district selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'get_society_by_district', district_id: dist_id },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        society_list.find('option')
          .remove()
          .end();
        var option = new Option('None', 0);
        society_list.append($(option)).selectpicker('refresh'); //Add option All

        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          society_list.append($(option)).selectpicker('refresh');
        });

        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  });

  $('body').on('change', '[id^=cmb_filter_dsd]', function () {
    gnd_list = $("[id^=cmb_filter_gnd]");

    var dsd_id = $(this).find(":selected").val();

    //Set GNDs according to DSD selection
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'get_gnd_by_dsd', dsd_id: dsd_id },
      async: false,
      dataType: "json",
      success: function (result) {
        //data = JSON.parse(result);
        gnd_list.find('option')
          .remove()
          .end();
        $.each(result, function (index, element) {
          var option = new Option(element.name, element.id);
          gnd_list.append($(option)).selectpicker('refresh');
        });
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });

    //FilterBenifiterList(dsd_id);	  
  });

  $('body').on('change', '#cmb_permit', function () {
    var permit_vals = JSON.parse($('#cmb_permit').val());
    var benifiter_id = $('#txt_benifiter_id_payement').val();
    permit_no = permit_vals.permit_no;
    crop_id = permit_vals.crop_id;
    $.ajax({
      type: "GET",
      dataType: "json",
      url: "refresh_content.php",
      data: { token: token, option: 'get_dsd_by_district', benifiter_id: benifiter_id, permit_no: permit_no, crop_id: crop_id },
      success: function (data) {
        var $el = $('#cmb_pay_type_payment');
        $el.empty();
        var land_size = 0;
        $.each(data, function (index, element) {
          if (index == 0) {
            $el.append($("<option></option>")
              .attr("value", "{\"id\":" + element.id + ",\"rate_per_ha\":" + element.rate_per_ha + "}").text(element.name).attr('selected', ''));
          }
          else {
            $el.append($("<option></option>")
              .attr("value", element.id).text(element.name).attr('disabled', ''));
          }

        });
        $('.selectpicker').selectpicker('refresh');

        var land_size = $('#lblLandSize').text();
        if (permit_vals.land_size_act_ha != "")
          land_size = permit_vals.land_size_act_ha;
        else
          land_size = permit_vals.land_size_init_ha;
        $('#lblLandSize').text(land_size);

        var pay_type = $('#cmb_pay_type_payment').val();
        var paytypeObj = JSON.parse(pay_type);

        var val = paytypeObj.rate_per_ha * land_size;
        $('#txt_amount_payment').val(val.toFixed(2));

        $.ajax({
          type: "GET",
          url: "refresh_content.php",
          data: { benifiter_id: benifiter_id, permit_no: permit_vals.permit_no, token: token, option: 'list_benifiter_payments' },
          async: false,
          dataType: "html",
          success: function (result) {
            $("#prev_payment_tbl").empty();
            $("#prev_payment_tbl").html(result);
            setTimeout(function(){
              $("#overlay").fadeOut(300);
            },500);
          },
          failure: function () {
            alert("Failed!");

            setTimeout(function(){
              $("#overlay").fadeOut(300);
            },500);
          }
          
        });

        hideLoader();
      }
    });
  });

  $("#edit_form").submit(function (e) {
    /*
    var validation_ok = -1;
    if($('#txt_permit_no').val() != '')
        validation_ok = UpdatePermitTable();
    
    if(validation_ok == -1)
        return false;
    */
    // Grab all values
    var id = 0;

    id = $("#txt_id").val();
    var name = $("#txt_name").val().trim();
    var nic_no = $("#txt_nic_no").val();
    var gender = $("#cmb_gender").val();
    var year = $("#cmb_year").val();
    var address = $("#txt_address").val();
    var contact_number = $("#txt_contact_number").val();
    var bank_id = $("#cmb_bank").val();
    var branch_code = $("#txt_branch_code").val();
    var branch_name = $("#txt_branch_name").val();
    var account_no = $("#txt_account_no").val();
    var district_id = $("#cmb_ben_district").val();
    var society_id = $("#cmb_society").val();

    if (name != "") {
      e.preventDefault();
      var $form = $(this);

      var data = $form.serializeArray();

      var $inputs = $("#edit_form").find("input, select, button, textarea");
      $inputs.prop("disabled", true);

      //data.push({name: "benifiter_id", value: benifiter_id});      
      $.ajax({
        type: 'post',
        url: 'refresh_content.php',
        data: {
          token: token, option: "save_benifiter",
          data: $.param(data) //$("#edit_form").serialize()
        },
        dataType: 'json',
        success: function (res) {
          var benifiter_id = -1;
          if (JSON.parse(res)[0].id !== undefined) {
            $inputs.prop("disabled", false);
            showMessage("Benifiter data saved");
            benifiter_id = JSON.parse(res)[0].id;

            var new_permit_exists = false;
            $('#tbl_permit > tbody  > tr').each(function (i, tr) {
              if (i > 0)
                if ($('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(0)").text() == '0')//new record
                  new_permit_exists = true;
            });

            if (new_permit_exists || $('#txt_permit_no').val() != "") {
              var validation_ok = -1; //if user hasn't click add another and entered permit details
              if ($('#txt_permit_no').val() != "") {
                validation_ok = UpdatePermitTable();

                if (validation_ok == -1)
                  return false;
              }
              //Add or update permit details
              var permit_id = -1;
              var crop_id = 0;
              var permit_no = '';
              var land_name = '';
              var plot_no = '';
              var init_land_size = 0;
              var act_land_size = 0;
              var dis_id = 0;
              var ti_id = 0;
              var dsd_id = 0;
              var gnd_id = 0;
              var permit_num_exists = false;

              //url = service_url + "/save_permit";
              $('#tbl_permit > tbody  > tr').each(function (i, tr) {
                if ($('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(0)").text() != '')
                  permit_id = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(0)").text();
                else
                  permit_id = -1;

                if (i > 0 && permit_id == 0) {
                  crop_id = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(1)").text();
                  permit_no = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(7)").text();
                  land_name = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(8)").text();
                  plot_no = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(9)").text();
                  init_land_size = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(10)").text();
                  act_land_size = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(11)").text();
                  dis_id = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(2)").text();
                  ti_id = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(3)").text();
                  dsd_id = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(4)").text();
                  gnd_id = $('#tbl_permit tbody tr:eq(' + i + ')').find("td:eq(5)").text();

                  $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    async: false,
                    dataType: 'json',
                    data: { token: token, option: 'save_permit', id: permit_id, benifiter_id: benifiter_id, permit_no: permit_no, land_name: land_name, plot_no: plot_no, crop_id: crop_id, land_size_init_ha: init_land_size, land_size_act_ha: act_land_size, district_id: dis_id, dsd_id: dsd_id, ti_id: ti_id, gnd_id: gnd_id },
                    beforeSend: function (xhr) {
                      // maybe tell the user that the request is being processed
                      //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                    }
                  }).done(function (result) {
                    if (JSON.parse(result)[0].id !== undefined) {
                      showMessage("Benifiter and permit data saved");
                    }
                    else {
                      showErrorMessage(JSON.parse(result));
                    }
                    $inputs.prop("disabled", false);
                    //RefreshBenifiterList();
                  });
                }
              });
              //alert(JSON.parse(result));
              //alert(JSON.parse(result)[0].id);
              //$('#payModal').modal('toggle');
              if ($("#txt_id").val() == "") //refresh only if a new entries
                RefreshBenifiterList();
            }
          }
          else {
            //$("#message").html("Error saving benifiter details");
            showErrorMessage(JSON.parse(res)); //uncomment this and check the error message
          }

          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);
        }
      });
    }
  });
  function RefreshBenifiterList() {
    $.ajax({
      type: "GET",
      url: "refresh_content.php",
      data: { token: token, option: 'list_benifiter' },
      dataType: "html",
      success: function (res) {
        $("#benifiter_list").empty();
        $("#benifiter_list").html(res);
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  }
  var request;
  $("#payment_form").submit(function (e) {
    // Grab all values
    var pay_type = $('#cmb_pay_type_payment').val();
    var paytypeObj = JSON.parse(pay_type);

    var pay_type_id = paytypeObj.id;
    var benifiter_id = $('#txt_benifiter_id_payement').val();
    var nic = $('#lblNIC').text();
    var permit_vals = JSON.parse($('#cmb_permit').val());
    var permit_no = permit_vals.permit_no;
    var amount = $('#txt_amount_payment').val();
    var bank_code = $('#lblBankCode').text();
    var branch_code = $('#lblBranchCode').text();
    var account_no = $('#lblAccountNo').text();
    var land_size = $('#lblLandSize').text();

    e.preventDefault();
    var data = $(this).serializeArray(); // convert form to array
    data.push({ name: "benifiter_id", value: benifiter_id });
    data.push({ name: "nic", value: nic });
    data.push({ name: "pay_type_id", value: pay_type_id });
    data.push({ name: "permit_no", value: permit_no });
    data.push({ name: "amount", value: amount });
    data.push({ name: "bank_code", value: bank_code });
    data.push({ name: "branch_code", value: branch_code });
    data.push({ name: "account_no", value: account_no });
    data.push({ name: "land_size", value: land_size });

    var $inputs = $("#payment_form").find("input, select, button, textarea");
    $inputs.prop("disabled", true);
    e.preventDefault();

    $.ajax({
      type: 'post',
      url: 'refresh_content.php',
      data: {
        token: token, option: "save_payment",
        data: $.param(data) //$("#payment_form").serialize()
      },
      dataType: 'json',
      success: function (res) {
        showMessageOnDiv('message_pay', JSON.parse(res));
        $inputs.prop("disabled", false);
        alert(JSON.parse(res));
        $('#payModal').modal('toggle');
        hideLoader();
      }
    });
  });

  $('body').on('click', '.save_revert', function () {
    var id = this.id.substring(7, this.id.length);
    var comment = $("#txtRevComment").val();
    var status = 'R';
    if ($.trim(comment) == "") {
      alert('Please provide payment revert comment');
    }
    else {
      $.ajax({
        type: "GET",
        url: "refresh_content.php",
        async: false,
        data: { token: token, option: 'set_payment_status', id: id, comment: comment, status: status },
        dataType: "json",
        beforeSend: function (xhr) {
          // maybe tell the user that the request is being processed
          //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
        }
      }).done(function (result) {
        alert(JSON.parse(result));
        $('#payModal').modal('toggle');
        hideLoader();
      });
    }
  });

  $("#new_benifiter").on("click", function () {
    var id = 0;
    $.ajax({
      type: "GET",
      url: "edit_benifiter.php",
      data: { id: id },
      //contentType: "application/json; charset=utf-8",
      dataType: "html",
      success: function (result) {
        $("#model_content").empty();
        $("#model_content").html(result);
        $('.selectpicker').selectpicker({
          size: 7
        });
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  });

  $('body').on('click', '.edit', function () {
    var id = this.id;
    var farmer_id = id.substring(5, id.length);
    var $edit_year = $('#cmb_year');

    $.ajax({
      type: "GET",
      url: "edit_benifiter.php",
      data: { id: farmer_id },
      async: false,
      dataType: "html",
      success: function (result) {
        $("#model_content").empty();
        $("#model_content").html(result);
        $('.selectpicker').selectpicker({
          size: 7
        });
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  });

  $('body').on('click', '.pay', function () {
    var id = this.id;
    var benifiter_id = id.substring(4, id.length);
    $.ajax({
      type: "GET",
      url: "edit_payment.php",
      data: { id: 0, benifiter_id: benifiter_id }, //id is 0 for new payments
      async: false,
      dataType: "html",
      success: function (result) {
        $("#model_content_payModal").empty();
        $("#model_content_payModal").html(result);
        $('.selectpicker').selectpicker({
          size: 7
        });
        hideLoader();
      },
      failure: function () {
        alert("Failed!");
        hideLoader();
      }
    });
  });

  $('body').on('change', '#cmb_pay_type_payment', function () {
    var pay_type = $('#cmb_pay_type_payment').val();
    var paytypeObj = JSON.parse(pay_type);
    var land_size = $('#lblLandSize').text();

    var val = paytypeObj.rate_per_ha * land_size;
    $('#txt_amount_payment').val(val.toFixed(2));

  });

  $("#txt_search_tbl").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tbl_benifiter tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });


  //sort benifiter list or table
  //$("#tbl_benifiter").tablesorter();
});

function FilterBenifiterList(dsd_id) {
  $.ajax({
    type: "GET",
    url: "refresh_content.php",
    data: { token: token, option: 'list_filter_benifiter', dsd_id: dsd_id },
    dataType: "html",
    success: function (res) {
      console.log(res);
      $("#benifiter_list").empty();
      $("#benifiter_list").html(res);
      
      hideLoader();
    },
    failure: function () {
      alert("Failed!");
      hideLoader();
    }
  });
}

function hideLoader(){
  setTimeout(function(){
    $("#overlay").fadeOut(300);
  },200);
}





