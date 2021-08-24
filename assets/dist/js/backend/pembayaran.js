var timmer;
function count_total(edit = false) {
  clearTimeout(timmer);
  count_val = 0;
  label_jasa = $("#jasa_count");
  label_pph = $("#pph_count");
  timmer = setTimeout(function callback() {
    if ($('input[name="manual_math"]').is(":checked") == true) {
      manual_math = true;
      console.log("checker");
      label_jasa.prop("readonly", false);
      label_pph.prop("readonly", false);
    } else {
      manual_math = false;
      label_jasa.prop("readonly", true);
      label_pph.prop("readonly", true);
    }

    p_jasa = $('input[name="percent_jasa"]').val();
    p_jasa = p_jasa.replace(",", ".");
    $("#percent_jasa").val(p_jasa);

    if (p_jasa == "") p_jasa = 0;
    p_pph = $('input[name="percent_pph"]').val();
    if (p_pph == "") p_pph = 0;

    var total_debit = 0;
    qyt = $('input[name="qyt[]"]');
    amount = $('input[name="amount[]"]');
    qyt_amount = $('input[name="qyt_amount[]"]');

    tmp_jasa = $("#jasa_count").val();
    tmp_pph = $("#pph_count").val();
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
          parseFloat(amount[i].value.replaceAll(".", "").replaceAll(",", ".")) *
          qyt[i].value;
        count_val = count_val + val1;
        console.log("here val1");
        console.log(val1);
        qyt_amount[i].value = formatRupiah2(val1);
      } else {
        qyt_amount[i].value = "";
      }

      i++;
    });

    $('input[name="sub_total"]').val(formatRupiah2(count_val));
    biaya_jasa = 0;
    biaya_pph = 0;
    console.log(tmp_jasa);
    if (manual_math && (tmp_jasa != "0" || tmp_jasa != "0,00")) {
      biaya_jasa = parseFloat(
        tmp_jasa.replaceAll(".", "").replaceAll(",", ".")
      );
    } else {
      if (p_jasa != "" && p_jasa != "0") {
        biaya_jasa = Math.ceil((p_jasa / 100) * count_val);
        $('input[name="am_jasa"]').val(formatRupiah2(biaya_jasa));
      } else {
        $('input[name="am_jasa"]').val(0);
      }
    }
    $('input[name="sub_total_2"]').val(formatRupiah2(count_val - biaya_jasa));
    setela_jasa = (count_val - biaya_jasa).toFixed(2);
    if (manual_math && (tmp_pph != "0" || tmp_pph != "0,00")) {
      biaya_pph = parseFloat(tmp_pph.replaceAll(".", "").replaceAll(",", "."));
    } else {
      if (count_val != "" && count_val != "0") {
        biaya_pph = Math.floor((p_pph / 100) * setela_jasa);
        $('input[name="am_pph"]').val(formatRupiah2(biaya_pph));
      } else {
        $('input[name="am_pph"]').val(0);
      }
    }

    total_final = (setela_jasa - biaya_pph).toFixed(2);
    if (total_final != "" && total_final != "0") {
      $('input[name="total_final"]').val(formatRupiah2(total_final));
    } else {
      $('input[name="total_final"]').val(0);
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

function formatRupiah2(angka, prefix) {
  var number_string = angka.toString();
  expl = number_string.split(".", 2);
  // console.log("ex");
  if (expl[1] == undefined) {
    expl[1] = "00";
  } else {
    if (expl[1].length == 1) expl[1] = expl[1] + "0";
    else expl[1] = expl[1].slice(0, 2);
  }
  // console.log(expl[1]);
  // console.log()
  // split = [];
  // split[0] = number_string.slice(0, -2);
  // split[1] = number_string.slice(-2);

  sisa = expl[0].length % 3;
  (rupiah = expl[0].substr(0, sisa)),
    (ribuan = expl[0].substr(sisa).match(/\d{3}/gi));

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = expl[1] != undefined ? rupiah + "," + expl[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function delete_row(row) {
  // console.log(row);

  i = 0;

  $('input[name="amount[]"]').each(function () {
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

  count_total(true);
}
