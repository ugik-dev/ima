function barcode_val(url = '') {
  var qty = prompt('How many barcodes you want to print ?', '30')

  if (qty == null || qty == '') {
  } else {
    window.location = url + '/' + qty
  }
}

function confirmation_alert(message, url = '') {
  var result = confirm('Do you really want to ' + message + ' ?')

  if (result) {
    window.location = url
  }
}

var swalSaveConfigure = {
  title: 'Konfirmasi simpan',
  text: 'Yakin akan menyimpan data ini?',
  icon: 'info',
  showCancelButton: true,
  confirmButtonColor: '#18a689',
  confirmButtonText: 'Ya, Simpan!',
  reverseButtons: true,
}

var swalSuccessConfigure = {
  title: 'Simpan berhasil',
  icon: 'success',
  timer: 500,
}
function swalLoading() {
  swal.fire({
    title: 'Loading...',
    allowOutsideClick: true,
  })
  swal.showLoading()
}
// validate the Category Add  Model form
$('#Category_form').validate({
  rules: {
    category_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the Category edit  Model form
$('#Edit_Category_form').validate({
  rules: {
    edit_category_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the Expense  Model form
$('#add_expense_form').validate({
  rules: {
    bill_total: {
      required: true,
      minlength: 1,
    },
    bill_paid: {
      required: true,
      minlength: 1,
    },
    date: {
      required: true,
    },
  },
})

// validate the Expense  Model form
$('#edit_expense_form').validate({
  rules: {
    bill_total: {
      required: true,
      minlength: 1,
    },
    bill_paid: {
      required: true,
      minlength: 1,
    },
    date: {
      required: true,
    },
  },
})

// validate the barcode  Add  Model form
$('#barcode_form').validate({
  rules: {
    brand_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the barcode  Add  Model form
$('#edit_barcode').validate({
  rules: {
    brand_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the create purchase Model form
$('#create_purchase_form').validate({
  rules: {
    pur_total: {
      required: true,
      maxlength: 255,
    },
    pur_date: {
      required: true,
    },
    pur_paid: {
      required: true,
      minlength: 1,
    },
    pur_balance: {
      required: true,
      minlength: 1,
    },
  },
})

// validate the create purchase Model form
$('#create_supply_form').validate({
  rules: {
    cash_recieved: {
      required: true,
      minlength: 1,
    },
  },
})

// validate the create driver Model form
$('#driver_form').validate({
  rules: {
    driver_name: {
      required: true,
      maxlength: 255,
    },
    contact_no: {
      required: true,
      maxlength: 12,
    },
  },
})

// validate the create vehicle Model form
$('#vehicle_form').validate({
  rules: {
    vehicle_name: {
      required: true,
      maxlength: 255,
    },
    vehicle_no: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the create brand Model form
$('#brand_form').validate({
  rules: {
    brand_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the create brand Model form
$('#brand_sector_form').validate({
  rules: {
    brand_sector_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the region Model form
$('#region_form').validate({
  rules: {
    region: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the region Model form
$('#town_form').validate({
  rules: {
    town_name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the unit Model form
$('#unit_form').validate({
  rules: {
    unit_name: {
      required: true,
      maxlength: 255,
    },
    symbol: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the unit Model form
$('#store_form').validate({
  rules: {
    name: {
      required: true,
      maxlength: 255,
    },
    code: {
      required: true,
      maxlength: 255,
    },
    address: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the unit Model form
$('#edit_store_form').validate({
  rules: {
    store_name: {
      required: true,
      maxlength: 255,
    },
    code: {
      required: true,
      maxlength: 255,
    },
    address: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the unit Model form
$('#open_balance_accounts').validate({
  rules: {
    amount: {
      required: true,
      maxlength: 255,
    },
    date: {
      required: true,
      maxlength: 255,
    },
    description: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the unit Model form
$('#journal_voucher').validate({
  rules: {
    description: {
      required: true,
      maxlength: 255,
    },
    date: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the head form
$('#chart_of_accounts_form').validate({
  rules: {
    name: {
      required: true,
      maxlength: 255,
    },
  },
})

// validate the product add Model form
$('#product_form').validate({
  rules: {
    product_name: {
      required: true,
      maxlength: 255,
    },
    formula_name: {
      required: true,
      maxlength: 255,
    },
    product_mg: {
      required: true,
      maxlength: 4,
    },
    quantity: {
      required: true,
      minlength: 1,
    },
    purchase: {
      required: true,
      minlength: 1,
    },
    retail: {
      required: true,
      minlength: 1,
    },
    whole_sale: {
      required: true,
      minlength: 1,
    },
  },
})

// Validate the product edit Model form
$('#update_product_form').validate({
  rules: {
    edit_product_name: {
      required: true,
      maxlength: 255,
    },
    edit_formula_name: {
      required: true,
      maxlength: 255,
    },
    edit_mg: {
      required: true,
      maxlength: 4,
    },
    edit_retail: {
      required: true,
      minlength: 1,
    },
    edit_purchase: {
      required: true,
      minlength: 1,
    },
  },
})

// validate the Customer add Model form
$('#Customer_form').validate({
  rules: {
    customer_name: {
      required: true,
      maxlength: 50,
    },

    // customer_email: {
    // 	required: true,
    // 	maxlength: 50
    // }
  },
})

// Validate the Customer edit Model form
$('#Edit_Customer_form').validate({
  rules: {
    edit_customer_name: {
      required: true,
      maxlength: 50,
    },
    edit_customer_email: {
      required: true,
      maxlength: 50,
    },
    edit_customer_address: {
      required: true,
      maxlength: 100,
    },
    edit_customer_contatc1: {
      required: true,
      minlength: 11,
    },
    edit_customer_company: {
      required: true,
      maxlength: 100,
    },
    edit_customer_city: {
      required: true,
      maxlength: 100,
    },
    edit_customer_country: {
      required: true,
      maxlength: 100,
    },
    edit_customer_description: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the user add Model form
$('#User_form').validate({
  rules: {
    user_name: {
      required: true,
      maxlength: 50,
    },
    user_email: {
      required: true,
      maxlength: 50,
    },
    user_password: {
      required: true,
      minlength: 5,
    },
    User_cpassword: {
      required: true,
      minlength: 5,
      equalTo: '#user_password',
    },
  },
})

// Validate the User edit Model form
$('#Edit_User_form').validate({
  rules: {
    Edit_user_name: {
      required: true,
      maxlength: 50,
    },
    Edit_user_email: {
      required: true,
      maxlength: 50,
    },
  },
})

// Validate the TodoList add Model form
$('#Todolist_form').validate({
  rules: {
    todolist_name: {
      required: true,
      maxlength: 50,
    },
    Todolist_Date: {
      required: true,
    },
  },
})

// Validate the TodoList edit Model form
$('#Edit_Todolist_form').validate({
  rules: {
    edit_todo_name: {
      required: true,
      maxlength: 50,
    },
    edit_todolist_date: {
      required: true,
    },
  },
})

// Validate the Supplier Model form
$('#supplier_form').validate({
  rules: {
    customer_name: {
      required: true,
      maxlength: 50,
    },
    customer_email: {
      required: true,
    },
  },
})

//Validate Bank
$('#bank_form').validate({
  rules: {
    bankname: {
      required: true,
      maxlength: 50,
    },
    branch: {
      required: true,
    },
    branchcode: {
      required: true,
    },
    title: {
      required: true,
    },
    accountno: {
      required: true,
    },
  },
})

// Validate the Supplier payment Model form
$('#supplier_payment').validate({
  rules: {
    amount: {
      required: true,
      minlength: 1,
    },
    description: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the Supplier payment Model form
$('#customer_payment').validate({
  rules: {
    amount: {
      required: true,
      minlength: 1,
    },
    description: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the PharmistList add Model form
$('#Pharmacist_form').validate({
  rules: {
    pharmacist_name: {
      required: true,
      maxlength: 50,
    },
    pharmacist_post: {
      required: true,
      maxlength: 100,
    },
  },
})

// Validate the edit_PharmistList add Model form
$('#Edit_Pharmacist_form').validate({
  rules: {
    edit_pharmacist_name: {
      required: true,
      maxlength: 50,
    },
    edit_pharmacist_post: {
      required: true,
      maxlength: 100,
    },
    edit_pharmacist_des: {
      required: true,
      maxlength: 100,
    },
    edit_pharmacist_facebook: {
      required: true,
      maxlength: 100,
    },
    edit_pharmacist_twitter: {
      required: true,
      maxlength: 100,
    },
    edit_pharmacist_linked: {
      required: true,
      maxlength: 100,
    },
    edit_pharmacist_googleplus: {
      required: true,
      maxlength: 100,
    },
  },
})

// Validate the Somewords Add Model form
$('#SomewordsList_form').validate({
  rules: {
    somewords_title: {
      required: true,
      maxlength: 50,
    },
    somewords_description: {
      required: true,
      maxlength: 255,
    },
    somewords_icon: {
      required: true,
    },
  },
})

// Validate the Somewords edit Model form
$('#Edit_Somewords_form').validate({
  rules: {
    edit_somewords_title: {
      required: true,
      maxlength: 50,
    },
    edit_somewords_des: {
      required: true,
      maxlength: 255,
    },
    edit_somewords_icon: {
      required: true,
    },
  },
})

// Validate the Service Add Model form
$('#Service_form').validate({
  rules: {
    Service_Title: {
      required: true,
      maxlength: 50,
    },
    Service_description: {
      required: true,
      maxlength: 255,
    },
    Service_Icon: {
      required: true,
    },
  },
})

// Validate the Service edit Model form
$('#Edit_Service_form').validate({
  rules: {
    edit_service_title: {
      required: true,
      maxlength: 50,
    },
    edit_service_des: {
      required: true,
      maxlength: 255,
    },
    edit_service_icon: {
      required: true,
    },
  },
})

// Validate the Testamonial Add Model form
$('#Testamonial_form').validate({
  rules: {
    testamonial_name: {
      required: true,
      maxlength: 50,
    },
    testamonial_description: {
      required: true,
      maxlength: 255,
    },
    testamonial_picture: {
      required: true,
    },
  },
})

// Validate the Testamonial edit Model form
$('#Edit_Testamonial_form').validate({
  rules: {
    edit_testamonial_name: {
      required: true,
      maxlength: 50,
    },
    edit_testamonial_des: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the Delivered Add  Model form
$('#Deliverd_form').validate({
  rules: {
    delivered_to: {
      required: true,
      maxlength: 50,
    },
    delivered_by: {
      required: true,
      maxlength: 50,
    },
    delivered_date: {
      required: true,
    },
    delivered_description: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the Logo Model form
$('#logo_form').validate({
  rules: {
    company_logo: {
      required: true,
    },
  },
})

// Validate the Banner Model form
$('#banner_form').validate({
  rules: {
    company_thumbnail: {
      required: true,
    },
  },
})

// Validate the Layout Form
$('#layout_form').validate({
  rules: {
    company_name: {
      required: true,
      maxlength: 100,
    },
    company_description: {
      required: true,
      maxlength: 255,
    },
    company_keywords: {
      required: true,
      maxlength: 255,
    },
    company_currency: {
      required: true,
      maxlength: 5,
    },
    company_language: {
      required: true,
      maxlength: 10,
    },
    company_stock_limit: {
      required: true,
      minlength: 1,
    },
    company_expire_time: {
      required: true,
      minlength: 1,
    },
  },
})

// Validate the Website Form
$('#website_form').validate({
  rules: {
    front_title1: {
      required: true,
      maxlength: 100,
    },
    front_title2: {
      required: true,
      maxlength: 100,
    },
    front_title3: {
      required: true,
      maxlength: 100,
    },
    front_title4: {
      required: true,
      maxlength: 100,
    },
    front_title5: {
      required: true,
      maxlength: 100,
    },
    front_title6: {
      required: true,
      maxlength: 100,
    },
    front_sub_title1: {
      required: true,
      maxlength: 100,
    },
    front_sub_title2: {
      required: true,
      maxlength: 100,
    },
    front_title8: {
      required: true,
      maxlength: 100,
    },
    front_title9: {
      required: true,
      maxlength: 100,
    },
    front_title10: {
      required: true,
      maxlength: 100,
    },
  },
})

// Validate the About Form  Model form
$('#contact_form1').validate({
  rules: {
    contact_title: {
      required: true,
      maxlength: 100,
    },
    contact_description: {
      required: true,
      maxlength: 255,
    },
    phone_number: {
      required: true,
      maxlength: 15,
      minlength: 15,
    },
    email_address: {
      required: true,
    },
    facebook: {
      required: true,
      maxlength: 100,
    },
    twitter: {
      required: true,
      maxlength: 100,
    },
    linkedin: {
      required: true,
      maxlength: 100,
    },
    googleplus: {
      required: true,
      maxlength: 100,
    },
  },
})

// Validate the About Form  Model form
$('#about_form1').validate({
  rules: {
    about_title: {
      required: true,
      maxlength: 255,
    },
    about_quotation: {
      required: true,
      maxlength: 255,
    },
    about_name: {
      required: true,
      maxlength: 255,
    },
    about_title2: {
      required: true,
      maxlength: 255,
    },
    about_description: {
      required: true,
      maxlength: 255,
    },
    about_address: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the Admin Picture Model form
$('#Picture_Model_admin').validate({
  rules: {
    customer_picture: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the Admin Password Model form
$('#change_password_Model_Admin').validate({
  rules: {
    old_password: {
      required: true,
      maxlength: 255,
    },
    new_password: {
      required: true,
      minlength: 5,
    },
    confirm_password: {
      required: true,
      minlength: 5,
      equalTo: '#new_password',
    },
  },
})

// Validate the Forget_form_Model form
$('#Forget_form_Model').validate({
  rules: {
    user_email: {
      required: true,
      maxlength: 255,
    },
    new_password: {
      required: true,
      minlength: 5,
    },
    confirm_password: {
      required: true,
      minlength: 5,
      equalTo: '#New_Password',
    },
  },
})

// Validate the Forgetpassword_form
$('#Forgetpassword_form').validate({
  rules: {
    user_email: {
      required: true,
      maxlength: 255,
    },
    user_password: {
      required: true,
      minlength: 5,
    },
    user_code: {
      required: true,
    },
  },
})

// Validate the Email  form
$('#send_email').validate({
  rules: {
    subject: {
      required: true,
      maxlength: 50,
    },
    email_desc: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the Return item  form
$('#Return_items_form').validate({
  rules: {
    quantity: {
      required: true,
    },
    description: {
      required: true,
      maxlength: 255,
    },
  },
})

// Validate the  Edit Return item  form
$('#Edit_Return_items').validate({
  rules: {
    edit_quantity: {
      required: true,
    },
    edit_description: {
      required: true,
      maxlength: 255,
    },
  },
})

function formatRupiah(angka, prefix) {
  var number_string = angka.toString()
  split = []
  split[0] = number_string.slice(0, -2)
  split[1] = number_string.slice(-2)
  console.log(split)
  sisa = split[0].length % 3
  ;(rupiah = split[0].substr(0, sisa)),
    (ribuan = split[0].substr(sisa).match(/\d{3}/gi))

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : ''
    rupiah += separator + ribuan.join('.')
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah
  return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : ''
}

function send_wa(phone_number, message) {
  message = encodeURIComponent(message)
  return `https://api.whatsapp.com/send?phone=${phone_number}&text=${message}`
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // Strip all characters but numerical ones.
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === 'undefined' ? '.' : thousands_sep,
    dec = typeof dec_point === 'undefined' ? ',' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec)
      return '' + Math.round(n * k) / k
    }
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }
  return s.join(dec)
}

function formatRupiah2(angka, prefix) {
  var number_string = angka.toString()
  expl = number_string.split('.', 2)
  // console.log("ex");
  if (expl[1] == undefined) {
    expl[1] = '00'
  } else {
    if (expl[1].length == 1) expl[1] = expl[1] + '0'
    else expl[1] = expl[1].slice(0, 2)
  }

  sisa = expl[0].length % 3
  ;(rupiah = expl[0].substr(0, sisa)),
    (ribuan = expl[0].substr(sisa).match(/\d{3}/gi))

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : ''
    rupiah += separator + ribuan.join('.')
  }

  rupiah = expl[1] != undefined ? rupiah + ',' + expl[1] : rupiah
  return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : ''
}

function formatRupiahComa(angka, prefix) {
  var number_string = angka.toString()
  expl = number_string.split(',', 2)
  // console.log("ex");
  if (expl[1] == undefined) {
    expl[1] = '00'
  } else {
    if (expl[1].length == 1) expl[1] = expl[1] + '0'
    else expl[1] = expl[1].slice(0, 2)
  }

  sisa = expl[0].length % 3
  ;(rupiah = expl[0].substr(0, sisa)),
    (ribuan = expl[0].substr(sisa).match(/\d{3}/gi))

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : ''
    rupiah += separator + ribuan.join('.')
  }

  rupiah = expl[1] != undefined ? rupiah + ',' + expl[1] : rupiah
  return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : ''
}

function printDiv(divName) {
  var printContents = document.getElementById(divName).innerHTML
  printContents =
    printContents +
    `<style>
    .no-print {
        display: none !important;
    }
</style>`
  var originalContents = document.body.innerHTML
  document.body.innerHTML = printContents
  window.print()
  document.body.innerHTML = originalContents
}

function printSingleJurnal(id) {
  var naration = document.getElementById('naration_' + id).innerHTML
  var no_jurnal = document.getElementById('no_jurnal_' + id).innerHTML
  var name = document.getElementsByClassName('rinc_name_' + id)
  var ket = document.getElementsByClassName('rinc_ket_' + id)
  var debit = document.getElementsByClassName('rinc_debit_' + id)
  var kredit = document.getElementsByClassName('rinc_kredit_' + id)
  isi = ''
  var consdebit = 0
  var conskredit = 0
  console.log(name[0].innerHTML)
  for (var i = 0; i < name.length; i++) {
    isi += `<tr style="height : 10px">
    <td>${name[i].innerHTML.substring(1, 13)}</td>
    <td>${ket[i].innerHTML}</td>
    <td style="text-align:right ; padding-right : 10px">${
      debit[i].innerHTML
    }</td>
    <td>${kredit[i].innerHTML}</td>
    </tr>
    `
    last = i
    console.log(debit[i].innerHTML.replace(/[^0-9]/g, ''))
    consdebit =
      consdebit +
      (debit[i].innerHTML
        ? parseInt(debit[i].innerHTML.replace(/[^0-9]/g, ''))
        : 0)
    conskredit =
      conskredit +
      (kredit[i].innerHTML
        ? parseInt(kredit[i].innerHTML.replace(/[^0-9]/g, ''))
        : 0)
  }
  for (var j = last; j < 10; j++) {
    isi += `<tr  style="height : 22px; padding : 10px">
    <td> </td>
    <td> </td>
    <td> </td>
    <td> </td>
    </tr>
    `
  }
  isi += `<tr  style="height : 22px; padding : 10px">
    <td> </td>
    <td> </td>
    <td>${formatRupiah(consdebit)} </td>
    <td>${formatRupiah(conskredit)} </td>
    </tr>
    `

  var printContents = `
         <div class="box-body box-bg ">
            <div class="make-container-center">
              <div class="col-md-12">
                            <h2 style="text-align:center">Jurnal Voucher</h2>
                            <h3 style="text-align:center">PT. Indometal Asia </h3>
                        </div>
              <div class="col-md-12">
            <table style="" border="0">
        <tr>
            <td style="width: 100px">Deskripsi</td>
            <td style="width: 10px">:</td>
            <td style="width: 300px">${naration}</td>
			 <td style="width: 100px">Tanggal</td>
            <td style="width: 10px">:</td>
            <td style="width: 300px">${no_jurnal}</td>
        </tr>
        <tr>
        </tr>
    </table>
	 <table style="" border="1" cellspacing="0">
        <tr>
            <td style="width: 200px ;text-align:center">No Akun</td>
            <td style="width: 350px ; text-align:center">Keterangan</td>
            <td style="width: 100px ; text-align:center">Debit</td>
            <td style="width: 100px; text-align:center">Kredit</td>
        </tr>
        ${isi}
    </table>
             </div>
        </div>
		
        
             </div>
             `
  // console.log(printContents);
  var originalContents = document.body.innerHTML
  document.body.innerHTML = printContents
  window.print()
  document.body.innerHTML = originalContents
}

function printJournalEntry(divName) {
  var printContents = document.getElementById(divName).innerHTML
  var originalContents = document.body.innerHTML
  document.body.innerHTML = printContents
  window.print()
  document.body.innerHTML = originalContents
}

function terbilang(bilangan) {
  bilangan = bilangan.slice(0, -2)
  // console.log(bilangan);
  var kalimat = ''
  var angka = new Array(
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
  )
  var kata = new Array(
    '',
    'Satu',
    'Dua',
    'Tiga',
    'Empat',
    'Lima',
    'Enam',
    'Tujuh',
    'Delapan',
    'Sembilan',
  )
  var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun')
  var panjang_bilangan = bilangan.length

  /* pengujian panjang bilangan */
  if (panjang_bilangan > 15) {
    kalimat = 'Diluar Batas'
  } else {
    /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
    for (i = 1; i <= panjang_bilangan; i++) {
      angka[i] = bilangan.substr(-i, 1)
    }

    var i = 1
    var j = 0

    /* mulai proses iterasi terhadap array angka */
    while (i <= panjang_bilangan) {
      subkalimat = ''
      kata1 = ''
      kata2 = ''
      kata3 = ''

      /* untuk Ratusan */
      if (angka[i + 2] != '0') {
        if (angka[i + 2] == '1') {
          kata1 = 'Seratus'
        } else {
          kata1 = kata[angka[i + 2]] + ' Ratus'
        }
      }

      /* untuk Puluhan atau Belasan */
      if (angka[i + 1] != '0') {
        if (angka[i + 1] == '1') {
          if (angka[i] == '0') {
            kata2 = 'Sepuluh'
          } else if (angka[i] == '1') {
            kata2 = 'Sebelas'
          } else {
            kata2 = kata[angka[i]] + ' Belas'
          }
        } else {
          kata2 = kata[angka[i + 1]] + ' Puluh'
        }
      }

      /* untuk Satuan */
      if (angka[i] != '0') {
        if (angka[i + 1] != '1') {
          kata3 = kata[angka[i]]
        }
      }

      /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
      if (angka[i] != '0' || angka[i + 1] != '0' || angka[i + 2] != '0') {
        subkalimat = kata1 + ' ' + kata2 + ' ' + kata3 + ' ' + tingkat[j] + ' '
      }

      /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
      kalimat = subkalimat + kalimat
      i = i + 3
      j = j + 1
    }

    /* mengganti Satu Ribu jadi Seribu jika diperlukan */
    if (angka[5] == '0' && angka[6] == '0') {
      kalimat = kalimat.replace('Satu Ribu', 'Seribu')
    }
  }

  // console.log(kalimat);
  return kalimat + ' Rupiah'
  // document.getElementById("terbilang").innerHTML = kalimat;
}
