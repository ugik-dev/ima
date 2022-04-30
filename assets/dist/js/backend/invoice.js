var timmer;

function count_total(edit = false) {
  clearTimeout(timmer);
  count_val = 0;
  timmer = setTimeout(function callback() {
    var total_debit = 0;
    qyt = $('input[name="qyt[]"]');
    date = $('input[name="date"]').val();
    fil_1 = $('input[name="fil_1[]"]');
    fil_2 = $('input[name="fil_2[]"]');
    fil_3 = $('input[name="fil_3[]"]');

    const d5 = new Date(date).getTime();
    const d6 = new Date("2022-04-01").getTime();

    if (d5 >= d6) {
      var_ppn = 0.11;
      console.log("PPH 11");
      $("#label_ppn").html("PPN 11%");
    } else {
      var_ppn = 0.1;
      $("#label_ppn").html("PPN 10%");
      console.log("PPH 10");
    }

    amount = $('input[name="amount[]"]');
    qyt_amount = $('input[name="qyt_amount[]"]');
    i = 0;
    $('input[name="qyt[]"]').each(function () {
      val1 = 0;
      ppn_pph = 0;
      if (
        qyt[i].value != "" &&
        qyt[i].value != "0" &&
        amount[i].value != "" &&
        amount[i].value != "0"
      ) {
        val1 =
          parseFloat(amount[i].value.replace(/[^0-9]/g, "")) * qyt[i].value;
        count_val = count_val + val1;
        qyt_amount[i].value = formatRupiah(val1);
      } else {
        qyt_amount[i].value = "";
      }

      if ($("#jenis_invoice").val() == 6) {
        console.log("ore x sn");
        console.log(fil_1[i].value * fil_2[i].value);
        fil_3[i].value = ((fil_2[i].value / 100) * fil_1[i].value).toFixed(3);
      }

      //   console.log(qyt[0]);
      //   if (qyt[i].val() != "") {
      //     curency = parseFloat(
      //       $(this)
      //         .val()
      //         .replace(/[^0-9]/g, "")
      //     );
      // loan_amt.value = loan_amt.value.replace(/[^0-9]/g, "");
      // total_debit = total_debit + curency;
      //   }
      //   console.log(amount[i].value.replace(/[^0-9]/g, ""));

      i++;
    });
    if (count_val != "" && count_val != "0") {
      $('input[name="sub_total"]').val(formatRupiah(count_val));
    } else {
      $('input[name="sub_total"]').val(0);
    }
    if ($('input[name="ppn_pph"]').is(":checked") == true) {
      console.log(count_val);
      str_count_val = count_val.toString();
      str_count_val = str_count_val.substring(0, str_count_val.length - 2);
      ppn_pph = Math.floor(str_count_val * var_ppn) + "00";
      ppn_pph = parseInt(ppn_pph);
      // console.log(ppn_pph + "00");
      $('input[name="ppn_pph_count"]').val(formatRupiah(ppn_pph));
    } else {
      $('input[name="ppn_pph_count"]').val(0);
    }
    total_final = ppn_pph + count_val;
    if (total_final != "" && total_final != "0") {
      $('input[name="total_final"]').val(formatRupiah(total_final));
    } else {
      $('input[name="total_final"]').val(0);
    }
    console.log(ppn_pph);

    // //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
    // if (edit) {
    //   count_credits();
    // } else {
    //   check_validity();
    // }
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
