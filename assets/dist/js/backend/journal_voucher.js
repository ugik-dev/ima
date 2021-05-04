var timmer;
function count_debits(edit = false) {
  clearTimeout(timmer);

  timmer = setTimeout(function callback() {
    var total_debit = 0;
    $('input[name="debitamount[]"]').each(function () {
      if ($(this).val() != "") {
        curency = parseFloat(
          $(this)
            .val()
            .replace(/[^0-9]/g, "")
        );
        // loan_amt.value = loan_amt.value.replace(/[^0-9]/g, "");
        total_debit = total_debit + curency;
      }
    });

    $('input[name="total_debit_amount"]').val(formatRupiah(total_debit));
    //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
    if (edit) {
      count_credits();
    } else {
      check_validity();
    }
  }, 800);
}
function count_credits() {
  clearTimeout(timmer);

  timmer = setTimeout(function callback() {
    var total_credits = 0;
    $('input[name="creditamount[]"]').each(function () {
      if ($(this).val() != "") {
        curency = parseFloat(
          $(this)
            .val()
            .replace(/[^0-9]/g, "")
        );
        total_credits = total_credits + curency;
      }
    });

    $('input[name="total_credit_amount"]').val(formatRupiah(total_credits));

    //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
    check_validity();
  }, 800);
}
function check_validity() {
  console.log("r");

  var total_debit = $('input[name="total_debit_amount"]').val();
  var total_credit = $('input[name="total_credit_amount"]').val();
  total_debit = parseInt(total_debit.replace(/[^0-9]/g, ""));
  total_credit = parseInt(total_credit.replace(/[^0-9]/g, ""));
  // console.log(total_debit);
  if (total_debit != total_credit) {
    if (total_debit < total_credit) {
      $("#transaction_validity").html(formatRupiah(total_credit - total_debit));
    } else {
      $("#transaction_validity").html(formatRupiah(total_debit - total_credit));
    }

    //USED TO DISABLED THE BUTTON IF ANY ERROR OCCURED
    $("#btn_save_transaction").prop("disabled", true);
  } else {
    $("#transaction_validity").html("");
    $("#btn_save_transaction").prop("disabled", false);
  }
}

function formatRupiah(angka, prefix) {
  var number_string = angka.toString();
  split = [];
  split[0] = number_string.slice(0, -2);
  split[1] = number_string.slice(-2);

  sisa = split[0].length % 3;
  (rupiah = split[0].substr(0, sisa)),
    (ribuan = split[0].substr(sisa).match(/\d{3}/gi));

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function delete_row(row) {
  // console.log(row);

  i = 0;
  $('input[name="creditamount[]"]').each(function () {
    if (row == i) {
      if ($('input[name="delete_row[' + row + ']"]').prop("checked") == true) {
        $(this).val("");
        $(this).prop("readonly", true);
      } else if (
        $('input[name="delete_row[' + row + ']"]').prop("checked") == false
      ) {
        $(this).prop("readonly", false);
      }
    }
    i++;
  });
  i = 0;
  $('input[name="debitamount[]"]').each(function () {
    if (row == i) {
      if ($('input[name="delete_row[' + row + ']"]').prop("checked") == true) {
        $(this).val("");
        $(this).prop("readonly", true);
      } else if (
        $('input[name="delete_row[' + row + ']"]').prop("checked") == false
      ) {
        $(this).prop("readonly", false);
      }
    }
    i++;
  });

  count_debits(true);
}
