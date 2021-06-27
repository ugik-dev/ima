<?php
/*

*/
class Transaction_model extends CI_Model
{
    //USED TO INSERT SALE AND ACCOUNTS TRANSACTION
    function single_pos_transaction($data)
    {
        $this->db->trans_start();

        // PASSING ARRAY OF VALUES RECIEVED FROM TEXTBOX TO generate PRINT
        $data['discountfield'] = $data['discount'];
        $data['customer_id'] = $data['cus_id'];

        $credithead  = 0;
        $debithead   = 0;

        if ($data['total_bill'] == $data['bill_paid']) {
            $debithead = 2; // CASH
            $credithead = 3; // INVENTORY

            $debitamount = $data['total_bill'];
            $creditamount = $data['bill_paid'];
        } else if ($data['total_bill'] != $data['bill_paid'] and $data['bill_paid'] > 0) {
            $debithead = 2;
            $debithead2 = 4; //AR
            $credithead  = 3;

            $debitamount = $data['bill_paid'];
            $debitamount2 = $data['total_bill'] - $data['bill_paid'];
            $creditamount = $data['total_bill'];
        } else if ($data['bill_paid'] == 0) {
            $debithead = 4;
            $credithead = 3;

            $debitamount = $data['total_bill'];
            $creditamount = $data['total_bill'];
        } else {
        }

        $data1  = array(
            'date'                 => date('Y-m-d'),
            'naration'             => 'Transaksi dilakukan dari penjualan POS',
            'generated_source'     => 'pos'
        );

        $this->db->insert('mp_generalentry', $data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $debithead,
            'amount'      => $debitamount,
            'type'        => 0
        );

        $this->db->insert('mp_sub_entry', $sub_data);

        if ($data['total_bill'] != $data['bill_paid'] and $data['bill_paid'] > 0) {
            //3RD ENRTY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $debithead2,
                'amount'      => $debitamount2,
                'type'        => 0
            );

            $this->db->insert('mp_sub_entry', $sub_data);
        }

        //2ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $credithead,
            'amount'      => $creditamount,
            'type'        => 1
        );

        $this->db->insert('mp_sub_entry', $sub_data);


        //ASSIGNING DATA TO ARRAY
        $insert_data  = array(
            'transaction_id' => $transaction_id,
            'discount' =>  $data['discount'],
            'date' =>  $data['date'],
            'status' =>  $data['status'],
            'agentname' =>  $data['agentname'],
            'cus_id' =>  $data['cus_id'],
            'total_bill' =>  $data['total_bill'],
            'bill_paid' =>  $data['bill_paid']
        );

        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_invoices', $insert_data);
        $order_id = $this->db->insert_id();

        //FETCHING THE RECORD FROM TEMPORARY TABLE
        $result = $this->db->get('mp_temp_barcoder_invoice');
        $result = $result->result();

        foreach ($result as $single_item) {
            $data1  = array(
                'order_id'     => $order_id,
                'product_no'   => $single_item->product_no,
                'product_id'  => $single_item->product_id,
                'product_name' => $single_item->product_name,
                'mg'           => $single_item->mg,
                'price'        => $single_item->price,
                'purchase'     => $single_item->purchase,
                'qty'          => $single_item->qty,
                'tax'          => $single_item->tax
            );

            $this->db->insert('mp_sales', $data1);
        }


        $this->load->model('Accounts_model');
        $data['cus_previous'] = $this->Accounts_model->previous_balance($data['cus_id']);
        $data['item_data']    = $result;
        $data['invoice_id']   = $order_id;

        //USED TO CLEAR TEMP INVOICE
        $this->db->truncate('mp_temp_barcoder_invoice');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data;
    }

    //USED TO ADD RETURN ITEMS BACK TO STOCK 
    function add_return_items_transaction($data_fields)
    {
        $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID

        $credithead  = 0;
        $debithead   = 0;
        $credithead2 = 0;

        $debitamount  = 0;
        $creditamount  = 0;
        $creditamount2 = 0;

        if ($data_fields['total_bill'] == $data_fields['return_amount']) {
            $debithead = 3; // INVENTORY
            $credithead = 2; // CASH 

            $debitamount = $data_fields['return_amount'];
            $creditamount = $data_fields['total_bill'];
        } else if ($data_fields['total_bill'] != $data_fields['return_amount'] and $data_fields['return_amount'] > 0) {
            $debithead = 3;
            $credithead2 = 5; //AP
            $credithead  = 2;

            $debitamount = $data_fields['total_bill'];
            $creditamount2 = $data_fields['total_bill'] - $data_fields['return_amount'];
            $creditamount = $data_fields['return_amount'];
        } else if ($data_fields['return_amount'] == 0) {
            $debithead = 3;
            $credithead = 5;

            $debitamount = $data_fields['total_bill'];
            $creditamount = $data_fields['total_bill'];
        } else {
        }

        $data1  = array(
            'date'                 => date('Y-m-d'),
            'naration'             => 'Transaksi dilakukan dari Retur penjualan.',
            'generated_source'     => 'return_pos'
        );

        $this->db->insert('mp_generalentry', $data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $debithead,
            'amount'      => $debitamount,
            'type'        => 0
        );
        $this->db->insert('mp_sub_entry', $sub_data);


        //2ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $credithead,
            'amount'      => $creditamount,
            'type'        => 1
        );
        $this->db->insert('mp_sub_entry', $sub_data);

        if ($data_fields['total_bill'] != $data_fields['return_amount'] and $data_fields['return_amount'] > 0) {
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $credithead2,
                'amount'      => $creditamount2,
                'type'        => 1
            );

            $this->db->insert('mp_sub_entry', $sub_data);
        }

        $data  = array(
            'transaction_id' => $transaction_id,
            'date' => $data_fields['date'],
            'agent' => $data_fields['agent'],
            'invoice_id' => $data_fields['invoice_id'],
            'cus_id' => $data_fields['customer_id'],
            'return_amount' => $data_fields['return_amount'],
            'total_bill' => $data_fields['total_bill'],
            'discount_given' => $data_fields['discount']
        );

        $this->db->insert('mp_return', $data);
        $return_id = $this->db->insert_id();

        //FETCHING THE RECORD FROM TEMPORARY TABLE
        $result = $this->db->get('mp_temp_barcoder_invoice');
        $result = $result->result();
        foreach ($result as $single_item) {
            $this->db->where(['id' => $single_item->product_id]);
            $query = $this->db->get('mp_productslist');
            $stock_med = $query->result();

            $data2  = array(
                'quantity' => $stock_med[0]->quantity + $single_item->qty
            );

            $this->db->where('id', $single_item->product_id);
            $this->db->update('mp_productslist', $data2);

            //ADDING ITEMS TO RETURN STOCK
            $sub_data  = array(
                'return_id' => $return_id,
                'barcode' => $single_item->barcode,
                'product_no' => $single_item->product_no,
                'product_id' => $single_item->product_id,
                'product_name' => $single_item->product_name,
                'mg' => $single_item->mg,
                'price' => $single_item->price,
                'purchase' => $single_item->purchase,
                'qty' => $single_item->qty,
                'tax' => $single_item->tax
            );

            $this->db->insert('mp_return_list', $sub_data);
        }

        //USED TO CLEAR TEMP INVOICE
        $this->db->truncate('mp_temp_barcoder_invoice');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data_fields = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    //USED TO ADD EXPENSES TRANSACTIONS 
    function add_expense_transaction($data_fields)
    {
        $this->db->trans_start();


        $credithead  = 0;
        $debithead   = 0;
        $credithead2 = 0;

        $debitamount  = 0;
        $creditamount  = 0;
        $creditamount2 = 0;

        if ($data_fields['total_bill'] == $data_fields['total_paid']) {
            $debithead    = $data_fields['head_id']; // EXPENSE
            $credithead   = $data_fields['credithead'];

            $debitamount  = $data_fields['total_bill'];
            $creditamount = $data_fields['total_paid'];
        } else if ($data_fields['total_bill'] != $data_fields['total_paid'] and $data_fields['total_paid'] > 0) {
            $debithead = $data_fields['head_id'];;
            $credithead2 = 5; //AP
            $credithead  = $data_fields['credithead'];

            $debitamount = $data_fields['total_bill'];
            $creditamount2 = $data_fields['total_bill'] - $data_fields['total_paid'];
            $creditamount = $data_fields['total_paid'];
        } else if ($data_fields['total_paid'] == 0) {
            $debithead = $data_fields['head_id'];
            $credithead = 5;

            $debitamount = $data_fields['total_bill'];
            $creditamount = $data_fields['total_bill'];
        } else {
        }

        $data1  = array(
            'date'                 => date('Y-m-d'),
            'naration'             => 'Transaksi dilakukan dari pengeluaran / expense',
            'generated_source'     => 'expense'
        );

        $this->db->insert('mp_generalentry', $data1);
        $transaction_id = $this->db->insert_id();


        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $debithead,
            'amount'      => $debitamount,
            'type'        => 0
        );
        $this->db->insert('mp_sub_entry', $sub_data);


        //2ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $credithead,
            'amount'      => $creditamount,
            'type'        => 1
        );
        $this->db->insert('mp_sub_entry', $sub_data);

        if ($data_fields['total_bill'] != $data_fields['total_paid'] and $data_fields['total_paid'] > 0) {
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $credithead2,
                'amount'      => $creditamount2,
                'type'        => 1
            );

            $this->db->insert('mp_sub_entry', $sub_data);
        }

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $transaction_id,
            'head_id'        => $data_fields['head_id'],
            'method'         => $data_fields['method'],
            'total_bill'     => $data_fields['total_bill'],
            'total_paid'     => $data_fields['total_paid'],
            'date'           => $data_fields['date'],
            'description'    => $data_fields['description'],
            'user'           => $data_fields['user'],
            'payee_id'       => $data_fields['payee_id']
        );

        $this->db->insert('mp_expense', $args);

        if ($data_fields['credithead'] == 16) {
            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'      => $transaction_id,
                'bank_id'             => $data_fields['bank_id'],
                'payee_id'            => $data_fields['payee_id'],
                'method'              => $data_fields['method'],
                'cheque_amount'       =>  $data_fields['total_paid'],
                'ref_no'              => $data_fields['ref_no'],
                'transaction_status'  => 1,
                'transaction_type'    => 'paid'
            );
            $this->db->insert('mp_bank_transaction', $sub_data);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data_fields = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    public function customer_payment_collection($data_fields)
    {
        $this->db->trans_start();

        $credithead  = 0;
        $debithead   = 0;

        $debitamount  = 0;
        $creditamount  = 0;

        if ($data_fields['amount'] >= 0) {
            $debithead    = $data_fields['credithead']; //CASH 
            $credithead   = 4; //ACCOUNT RECIEVABLE 

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];
        }

        $data1  = array(
            'date'                 => date('Y-m-d'),
            'naration'             => 'Transaksi dilakukan dari pembayaran Customer',
            'generated_source'     => 'customer_payment'
        );

        $this->db->insert('mp_generalentry', $data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $debithead,
            'amount'      => $debitamount,
            'type'        => 0
        );
        $this->db->insert('mp_sub_entry', $sub_data);

        //2ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $credithead,
            'amount'      => $creditamount,
            'type'        => 1
        );
        $this->db->insert('mp_sub_entry', $sub_data);

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $transaction_id,
            'customer_id' => $data_fields['customer_id'],
            'date' =>        $data_fields['date'],
            'amount' =>      $data_fields['amount'],
            'method' =>      $data_fields['method'],
            'description' => $data_fields['description'],
            'agentname' =>   $data_fields['agentname']
        );

        if ($data_fields['credithead'] == 16) {
            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'      => $transaction_id,
                'bank_id'             => $data_fields['bank_id'],
                'payee_id'            => $data_fields['customer_id'],
                'method'              => $data_fields['method'],
                'cheque_amount'       =>  $data_fields['amount'],
                'ref_no'              => $data_fields['ref_no'],
                'transaction_status'  => 1,
                'transaction_type'    => 'recieved'
            );
            $this->db->insert('mp_bank_transaction', $sub_data);
        }

        //ADD TRANSACTION TO PAYMENTS
        $this->db->insert('mp_customer_payments', $args);
        $customer_payment_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data_fields = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    public function supplier_payment_collection($data_fields)
    {

        $this->db->trans_start();

        $credithead  = 0;
        $debithead   = 0;

        $debitamount  = 0;
        $creditamount  = 0;

        if ($data_fields['amount'] >= 0 and $data_fields['mode'] == 0) {
            $debithead    = 5;
            $credithead   = $data_fields['credithead'];

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];
        } else if ($data_fields['amount'] >= 0 and $data_fields['mode'] == 1) {
            $debithead    = $data_fields['credithead'];
            $credithead   = 4;

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];
        }

        $data1  = array(
            'date'                 => date('Y-m-d'),
            'naration'             => 'Transaksi dilakukan dari pembayaran ke Supplier',
            'generated_source'     => 'supplier_payment'
        );

        $this->db->insert('mp_generalentry', $data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $debithead,
            'amount'      => $debitamount,
            'type'        => 0
        );
        $this->db->insert('mp_sub_entry', $sub_data);

        //2ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $credithead,
            'amount'      => $creditamount,
            'type'        => 1
        );
        $this->db->insert('mp_sub_entry', $sub_data);

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $transaction_id,
            'supplier_id' =>  $data_fields['supplier_id'],
            'amount' => $data_fields['amount'],
            'method' => $data_fields['method'],
            'date' => $data_fields['date'],
            'description' => $data_fields['description'],
            'agentname' => $data_fields['agentname'],
            'mode' => $data_fields['mode']
        );

        $this->db->insert('mp_supplier_payments', $args);

        if ($data_fields['credithead'] == 16 and $data_fields['mode'] == 0) {
            $mode = 'paid';
        } else {
            $mode = 'recieved';
        }

        if ($data_fields['credithead'] == 16) {
            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'      => $transaction_id,
                'bank_id'             => $data_fields['bank_id'],
                'payee_id'            => $data_fields['supplier_id'],
                'method'              => $data_fields['method'],
                'cheque_amount'       =>  $data_fields['amount'],
                'ref_no'              => $data_fields['ref_no'],
                'transaction_status'  => 1,
                'transaction_type'    => $mode
            );
            $this->db->insert('mp_bank_transaction', $sub_data);
        }
        //$supplier_payment_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data_fields = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    public function purchase_transaction($data_fields)
    {
        $this->db->trans_start();

        if ($data_fields['status'] == 0) {
            $data1  = array(
                'date'             => date('Y-m-d'),
                'naration'         => 'Transaksi dilakukan dari Pembelian ke Supplier',
                'generated_source'     => 'create_purchases'
            );

            $this->db->insert('mp_generalentry', $data1);
            $tran_id = $this->db->insert_id();

            if ($data_fields['total_amount'] == $data_fields['cash']) {
                $debithead    = 21;
                $credithead   = $data_fields['credithead'];

                $debitamount  = $data_fields['total_amount'];
                $creditamount = $data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $debithead,
                    'amount'      => $debitamount,
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry', $sub_data);

                //2ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $credithead,
                    'amount'      => $creditamount,
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry', $sub_data);
            } else if ($data_fields['total_amount'] > $data_fields['cash']) {
                $debithead     = 21;
                $credithead    =  $data_fields['credithead'];
                $credithead2   = 5;

                $debitamount  = $data_fields['total_amount'];
                $creditamount = $data_fields['cash'];
                $creditamount2 = $data_fields['total_amount'] - $data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $debithead,
                    'amount'      => $debitamount,
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry', $sub_data);

                //2ND ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $credithead,
                    'amount'      => $creditamount,
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry', $sub_data);

                //3RD ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $credithead2,
                    'amount'      => $creditamount2,
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry', $sub_data);
            }

            if ($data_fields['credithead'] == 16) {
                //TRANSACTION DETAILS 
                $sub_data  = array(
                    'transaction_id'      => $tran_id,
                    'bank_id'             => $data_fields['bank_id'],
                    'payee_id'            => $data_fields['supplier_id'],
                    'method'              => $data_fields['payment_type_id'],
                    'cheque_amount'              => $data_fields['cash'],
                    'ref_no'              => $data_fields['ref_no'],
                    'transaction_status'  => 1,
                    'transaction_type'    => 'paid'
                );
                $this->db->insert('mp_bank_transaction', $sub_data);
            }
        } else if ($data_fields['status'] == 1) {
            $data1  = array(
                'date'             => date('Y-m-d'),
                'naration'         => 'Transaksi dilakukan dari Retur Pembelian',
                'generated_source'     => 'purchases_return'
            );

            $this->db->insert('mp_generalentry', $data1);
            $tran_id = $this->db->insert_id();

            if ($data_fields['total_amount'] == $data_fields['cash']) {
                $debithead    = 2;
                $credithead   = 21;

                $debitamount  = $data_fields['total_amount'];
                $creditamount = $data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $debithead,
                    'amount'      => $debitamount,
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry', $sub_data);

                //2ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $credithead,
                    'amount'      => $creditamount,
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry', $sub_data);
            } else if ($data_fields['total_amount'] > $data_fields['cash']) {
                $debithead     = 2;
                $debithead2    = 4;
                $credithead    = 21;

                $debitamount  = $data_fields['cash'];
                $creditamount = $data_fields['total_amount'];
                $debitamount2 = $data_fields['total_amount'] - $data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $debithead,
                    'amount'      => $debitamount,
                    'type'        => 0
                );
                $this->db->insert('mp_sub_entry', $sub_data);

                //2ND ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $debithead2,
                    'amount'      => $debitamount2,
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry', $sub_data);


                //3RD ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id,
                    'accounthead' => $credithead,
                    'amount'      => $creditamount,
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry', $sub_data);
            }

            if ($data_fields['credithead'] == 16) {
                //TRANSACTION DETAILS 
                $sub_data  = array(
                    'transaction_id'      => $tran_id,
                    'bank_id'             => $data_fields['bank_id'],
                    'payee_id'            => $data_fields['supplier_id'],
                    'method'              => $data_fields['payment_type_id'],
                    'cheque_amount'       => $data_fields['cash'],
                    'ref_no'              => $data_fields['ref_no'],
                    'transaction_status'  => 1,
                    'transaction_type'    => 'recieved'
                );
                $this->db->insert('mp_bank_transaction', $sub_data);
            }
        }
        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $tran_id,
            'date' => $data_fields['date'],
            'supplier_id' => $data_fields['supplier_id'],
            'store' => $data_fields['store'],
            'invoice_id' => $data_fields['invoice_id'],
            'total_amount' => $data_fields['total_amount'],
            'payment_type_id' => $data_fields['payment_type_id'],
            'payment_date' => $data_fields['payment_date'],
            'cash' => $data_fields['cash'],
            'description' => $data_fields['description'],
            'cus_picture' => $data_fields['cus_picture'],
            'status' => $data_fields['status']
        );


        $this->db->insert('mp_purchase', $args);
        $purchase_return = $this->db->insert_id();


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data_fields = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    //USED TO INSERT SALE AND ACCOUNTS TRANSACTION
    function single_supply_transaction($data)
    {
        $this->db->trans_start();

        // PASSING ARRAY OF VALUES RECIEVED FROM TEXTBOX TO generate PRINT
        $credithead  = 0;
        $debithead   = 0;
        $debithead2 = 0;

        $debitamount  = 0;
        $debitamount2  = 0;
        $creditamount = 0;

        if ($data['total_bill'] == $data['bill_paid']) {
            $debithead = $data['credithead']; // CASH
            $credithead = 3; // INVENTORY

            $debitamount = $data['total_bill'];
            $creditamount = $data['bill_paid'];
        } else if (($data['total_bill'] != $data['bill_paid']) and $data['bill_paid'] > 0) {
            $data['total_bill'];
            $data['bill_paid'];
            $debithead = $data['credithead'];
            $debithead2 = 4; //AR
            $credithead  = 3;

            $debitamount = $data['bill_paid'];
            $debitamount2 = $data['total_bill'] - $data['bill_paid'];
            $creditamount = $data['total_bill'];
        } else if ($data['bill_paid'] == 0) {
            $debithead = 4;
            $credithead = 3;

            $debitamount = $data['total_bill'];
            $creditamount = $data['total_bill'];
        }
        // else
        // {

        // }

        $data1  = array(
            'date'                 => date('Y-m-d'),
            'naration'             => 'Transaksi dilakukan dari penjualan GROSIR',
            'generated_source'     => 'pos'
        );

        $this->db->insert('mp_generalentry', $data1);
        $transaction_id = $this->db->insert_id();

        if ($debithead != 0) {
            //1ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $debithead,
                'amount'      => $debitamount,
                'type'        => 0
            );

            $this->db->insert('mp_sub_entry', $sub_data);
        }

        if ($debithead2 != 0) {
            //2ND ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $debithead2,
                'amount'      => $debitamount2,
                'type'        => 0
            );

            $this->db->insert('mp_sub_entry', $sub_data);
        }

        if ($credithead != 0) {
            //3RD ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $credithead,
                'amount'      => $creditamount,
                'type'        => 1
            );
            $this->db->insert('mp_sub_entry', $sub_data);
        }

        $data_invoice  = array(
            'transaction_id' => $transaction_id,
            'discount'       => $data['discount'],
            'date'           => $data['date'],
            'status'         => $data['status'],
            'agentname'      => $data['agentname'],
            'driver_id'      => $data['driver_id'],
            'vehicle_id'     => $data['vehicle_id'],
            'region_id'      => $data['region_id'],
            'payment_method' => $data['payment_method'],
            'total_bill'     => $data['total_bill'],
            'bill_paid'      => $data['bill_paid'],
            'description'    => $data['description'],
            'source'         => $data['source'],
            'cus_id'         => $data['cus_id']
        );

        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_invoices', $data_invoice);
        $order_id = $this->db->insert_id();

        //FETCHING THE RECORD FROM TEMPORARY TABLE
        $result = $this->db->get('mp_temp_barcoder_invoice');
        $result = $result->result();
        // print "";
        // print_r($result);
        // die;
        foreach ($result as $single_item) {
            $data1  = array(
                'order_id'     => $order_id,
                'product_no'   => $single_item->product_no,
                'product_id'  => $single_item->product_id,
                'product_name' => $single_item->product_name,
                'mg'           => $single_item->mg,
                'price'        => (($single_item->price * $single_item->pack) / $single_item->qty),
                'purchase'     => $single_item->purchase,
                'qty'          => $single_item->qty,
                'tax'          => $single_item->tax
            );

            $this->db->insert('mp_sales', $data1);
        }

        $pay_method = NULL;

        if ($data['payment_method'] == 0) {
            $pay_method = 'Cash';
        } else {
            $pay_method = 'Cheque';
        }

        if ($data['credithead'] == 16) {
            //  echo "sdfsdf";
            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'      => $transaction_id,
                'bank_id'             => $data['bank_id'],
                'payee_id'            => $data['cus_id'],
                'method'              => $pay_method,
                'cheque_amount'       => $data['bill_paid'],
                'ref_no'              => $data['ref_no'],
                'transaction_status'  => 1,
                'transaction_type'    => 'recieved'
            );
            $this->db->insert('mp_bank_transaction', $sub_data);
        }


        //USED TO CLEAR TEMP INVOICE
        $this->db->truncate('mp_temp_barcoder_invoice');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data;
    }

    // CHECK NO JURNAL
    function check_no_jurnal($data, $id = '')
    {
        $this->db->select("count(id) as count");
        $this->db->from('mp_generalentry');
        if (!empty($id)) $this->db->where('id <> "' . $id . '"');
        $this->db->where('no_jurnal', $data);
        $query = $this->db->get();
        return $query->result_array()[0]['count'];
    }

    function check_last_transaction_usaha()
    {
        $this->db->select("count(id) as count");
        $this->db->from('mp_invoice_usaha');
        // if (!empty($id)) $this->db->where('id <> "' . $id . '"');
        if (!empty($id)) $this->db->where('date like "' . date('Y-m') . '%"');
        // $this->db->order_by('id', 'desc');
        // $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array()[0]['count'];
    }

    function check_no_invoice($data, $id = '')
    {
        $this->db->select("count(id) as count");
        $this->db->from('mp_invoice_v2');
        if (!empty($id)) $this->db->where('id <> "' . $id . '"');
        $this->db->where('no_invoice', $data);
        $query = $this->db->get();
        return $query->result_array()[0]['count'];
    }



    function check_lock($id)
    {
        $this->db->select("gen_lock as gen_lock");
        $this->db->from('mp_generalentry');
        $this->db->where('id',  $id);
        $query = $this->db->get();
        return $query->result_array()[0]['gen_lock'];
    }


    function check_direktur($filter = [])
    {
        // var_dump($filter);
        // die();
        $this->db->select("*");
        $this->db->from('mp_approv');
        $this->db->where('id_transaction',  $filter['id']);
        if (!empty($filter['acc_1'])) $this->db->where('acc_1',  $filter['acc_1']);
        if (!empty($filter['acc_2'])) $this->db->where('acc_2',  $filter['acc_2']);
        if (!empty($filter['acc_3'])) $this->db->where('acc_3',  $filter['acc_3']);
        $query = $this->db->get();
        return $query->result_array()[0];
    }


    function approv_process($data)
    {

        $this->db->select("id_transaction");
        if ($data['draft_value'] == 'true')
            $this->db->from('draft_approv');
        else
            $this->db->from('mp_approv');
        // $this->db->from('mp_approv');
        $this->db->where('id_transaction',  $data['id']);
        $query = $this->db->get();
        $res = $query->result_array();
        if (!empty($data['acc_1'])) {
            $this->db->set("st_acc_1", $data['keputusan']);
            $this->db->set("catatan_1", $data['catatan']);
            $this->db->set("date_acc_1", date('Y-m-d'));
        }

        if (!empty($data['acc_2'])) {
            $this->db->set("st_acc_2", $data['keputusan']);
            $this->db->set("catatan_2", $data['catatan']);
            $this->db->set("date_acc_2", date('Y-m-d'));
        }

        if (!empty($data['acc_3'])) {
            $this->db->set("st_acc_3", $data['keputusan']);
            $this->db->set("catatan_3", $data['catatan']);
            $this->db->set("date_acc_3", date('Y-m-d'));
        }

        if (empty($res)) {
            $this->db->set("id_transaction", $data['id']);
            if ($data['draft_value'] == 'true')
                $this->db->insert('draft_approv');
            else
                $this->db->insert('mp_approv');
        } else {
            $this->db->where("id_transaction", $data['id']);
            if ($data['draft_value'] == 'true')
                $this->db->update('draft_approv');
            else
                $this->db->update('mp_approv');
        }
    }


    function activity_edit($id, $acc, $draft_value)
    {

        $this->db->select("id_transaction");
        if ($draft_value == 'true')
            $this->db->from('draft_approv');
        else
            $this->db->from('mp_approv');

        $this->db->where('id_transaction',  $id);
        $query = $this->db->get();
        $res = $query->result_array();
        $this->db->set("acc_1", $acc[1]);
        $this->db->set("acc_2", $acc[2]);
        $this->db->set("acc_3", $acc[3]);
        $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
        $this->db->set("date_acc_0", date('Y-m-d'));
        if (empty($res)) {
            $this->db->set("id_transaction", $id);
            if ($draft_value == 'true')
                $this->db->insert('draft_approv');
            else
                $this->db->insert('mp_approv');
            // $this->db->insert('mp_approv');
        } else {
            $this->db->where("id_transaction", $id);
            if ($draft_value == 'true')
                $this->db->update('draft_approv');
            else
                $this->db->update('mp_approv');
            // $this->db->update('mp_approv');
        }
    }

    //USED TO CREATE A JOURNAL VOUCHER ENTRY
    function journal_voucher_entry($data)
    {

        $trans_data = array(
            'date' => $data['date'],
            'naration' => $data['description'],
            'customer_id' => $data['customer_id'],
            'arr_cars' => $data['arr_cars'],
            'no_jurnal' => $data['no_jurnal'],
            'generated_source' => 'Journal Voucher'
        );
        $this->db->trans_start();

        if ($data['draft_value'] == 'true')
            $this->db->insert('draft_generalentry', $trans_data);
        else
            $this->db->insert('mp_generalentry', $trans_data);
        $order_id = $this->db->insert_id();

        $total_heads = count($data['account_head']);

        for ($i = 0; $i < $total_heads; $i++) {

            if (!empty($data['account_head'][$i])) {
                if ($data['debitamount'][$i] != 0) {
                    $sub_data  = array(
                        'parent_id'   => $order_id,
                        'accounthead' => $data['account_head'][$i],
                        'amount'      => substr($data['debitamount'][$i], 0, -2) . '.' . substr($data['debitamount'][$i], -2),
                        'type'        => 0,
                        'sub_keterangan' => $data['sub_keterangan'][$i]
                    );
                } else if ($data['creditamount'][$i] != 0) {
                    $sub_data  = array(
                        'parent_id'   => $order_id,
                        'accounthead' => $data['account_head'][$i],
                        'amount'      => substr($data['creditamount'][$i], 0, -2) . '.' . substr($data['creditamount'][$i], -2),
                        'type'        => 1,
                        'sub_keterangan' => $data['sub_keterangan'][$i]
                    );
                }
                if ($data['draft_value'] == 'true')
                    $this->db->insert('draft_sub_entry', $sub_data);
                else
                    $this->db->insert('mp_sub_entry', $sub_data);
            }
        }
        $this->db->trans_complete();
        // $db_error = $this->db->error();
        // var_dump($db_error);
        // die();
        // if ($db_error) {
        //     throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
        //     return false; // unreachable retrun statement !!!
        // }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
            $this->record_activity(array('jenis' => 1, 'sub_id' => $order_id, 'desk' => 'Entry Jurnal'));
        }


        return $order_id;
    }

    function invoice_entry($data)
    {

        // $trans_data = $data;
        $trans_data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'customer_id' => $data['customer_id'],
            'no_invoice' => $data['no_invoice'],
            'payment_metode' => $data['payment_metode'],
            'ppn_pph' => $data['ppn_pph'],
            'acc_1' => $data['acc_1'],
            'acc_2' => $data['acc_2'],
            'acc_3' => $data['acc_3'],
            'acc_0' => $this->session->userdata('user_id')['name'],
        );

        $this->db->trans_start();
        $this->db->insert('mp_invoice_v2', $trans_data);
        $order_id = $this->db->insert_id();
        $total_heads = count($data['amount']);

        for ($i = 0; $i < $total_heads; $i++) {

            if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                $trans_data  = array(
                    'parent_id'   => $order_id,
                    'qyt' => $data['qyt'][$i],
                    'satuan' => $data['satuan'][$i],
                    'date_item' => $data['date_item'][$i],
                    'keterangan_item' => $data['keterangan_item'][$i],
                    'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                );
                $this->db->insert('mp_sub_invoice', $trans_data);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
            $this->record_activity(array('jenis' => 4, 'sub_id' => $order_id, 'desk' => 'Entry Invoice'));
        }

        return $order_id;
    }

    function invoice_entry_usaha($data)
    {

        // $trans_data = $data;
        $trans_data = array(
            'date' => $data['date'],
            'description' => 'Car Wash',
            'no_invoice' => $data['no_invoice'],
            'payment_metode' => $data['payment_metode'],
            'ppn_pph' => $data['ppn_pph'],
            'acc_0' => $this->session->userdata('user_id')['name'],
        );

        $this->db->trans_start();
        $this->db->insert('mp_invoice_usaha', $trans_data);
        $order_id = $this->db->insert_id();
        $total_heads = count($data['amount']);

        for ($i = 0; $i < $total_heads; $i++) {
            if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                $trans_data  = array(
                    'parent_id'   => $order_id,
                    'qyt' => $data['qyt'][$i],
                    'satuan' => $data['satuan'][$i],
                    'keterangan_item' => $data['keterangan_item'][$i],
                    'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                );
                $this->db->insert('mp_sub_invoice_usaha', $trans_data);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
            $this->record_activity(array('jenis' => 4, 'sub_id' => $order_id, 'desk' => 'Entry Invoice'));
        }

        return $order_id;
    }




    function invoice_edit($data)
    {

        // $trans_data = $data;
        $trans_data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'customer_id' => $data['customer_id'],
            'no_invoice' => $data['no_invoice'],
            'payment_metode' => $data['payment_metode'],
            'ppn_pph' => $data['ppn_pph'],
            'acc_1' => $data['acc_1'],
            'acc_2' => $data['acc_2'],
            'acc_3' => $data['acc_3'],
            'acc_0' => $this->session->userdata('user_id')['name'],
        );

        $this->db->trans_start();
        $this->db->where('id', $data['id']);
        $this->db->update('mp_invoice_v2', $trans_data);
        $total_heads = count($data['amount']);

        for ($i = 0; $i < $total_heads; $i++) {
            if (!empty($data['id_item'][$i])) {
                if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                    $trans_data  = array(
                        'qyt' => $data['qyt'][$i],
                        'satuan' => $data['satuan'][$i],
                        'date_item' => $data['date_item'][$i],
                        'keterangan_item' => $data['keterangan_item'][$i],
                        'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                    );
                    $this->db->where('mp_sub_invoice.id', $data['id_item'][$i]);
                    $this->db->where('mp_sub_invoice.parent_id', $data['id']);
                    $this->db->update('mp_sub_invoice', $trans_data);
                } else {
                    $this->db->where('mp_sub_invoice.id', $data['id_item'][$i]);
                    // $this->db->where('mp_sub_invoice.parent_id', $data['id']);
                    $this->db->delete('mp_sub_invoice');
                }
            } else if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                $trans_data  = array(
                    'parent_id'   => $data['id'],
                    'satuan' => $data['satuan'][$i],
                    'qyt' => $data['qyt'][$i],
                    'date_item' => $data['date_item'][$i],
                    'keterangan_item' => $data['keterangan_item'][$i],
                    'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                );
                $this->db->insert('mp_sub_invoice', $trans_data);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
            $this->record_activity(array('jenis' => 5, 'sub_id' => $data['id'], 'desk' => 'Edit Invoice'));
        }

        return $data['id'];
    }

    function journal_voucher_edit($data)
    {

        $trans_data = array(
            'date' => $data['date'],
            'naration' => $data['description'],
            'customer_id' => $data['customer_id'],
            'arr_cars' => $data['arr_cars'],
            'no_jurnal' => $data['no_jurnal'],
            'generated_source' => 'Journal Voucher'
        );

        $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->where('id', $data['id']);
        if ($data['draft_value'] == 'true')
            $this->db->update('draft_generalentry', $trans_data);
        else
            $this->db->update('mp_generalentry', $trans_data);

        // $this->db->update('mp_generalentry', $trans_data);
        // $order_id = $this->db->insert_id();

        $total_heads = count($data['account_head']);

        for ($i = 0; $i < $total_heads; $i++) {
            if ($data['account_head'][$i] != 0) {
                if ($data['debitamount'][$i] != 0) {
                    $sub_data  = array(
                        'parent_id'   =>  $data['id'],
                        'accounthead' => $data['account_head'][$i],
                        'amount'      => substr($data['debitamount'][$i], 0, -2) . '.' . substr($data['debitamount'][$i], -2),
                        'type'        => 0,
                        'sub_keterangan' => $data['sub_keterangan'][$i],
                    );
                } else if ($data['creditamount'][$i] != 0) {
                    $sub_data  = array(
                        'parent_id'   =>  $data['id'],
                        'accounthead' => $data['account_head'][$i],
                        'amount'      => substr($data['creditamount'][$i], 0, -2) . '.' . substr($data['creditamount'][$i], -2),
                        'type'        => 1,
                        'sub_keterangan' => $data['sub_keterangan'][$i],
                    );
                }

                if ($data['creditamount'][$i] == 0 && $data['debitamount'][$i] == 0) {
                    if (!empty($data['sub_id'][$i])) {
                        $this->db->where('id', $data['sub_id'][$i]);
                        if ($data['draft_value'] == 'true')
                            $this->db->delete('draft_sub_entry');
                        else
                            $this->db->delete('mp_sub_entry');
                    }
                } else  if (!empty($data['sub_id'][$i])) {
                    $this->db->where('id', $data['sub_id'][$i]);
                    if ($data['draft_value'] == 'true')
                        $this->db->update('draft_sub_entry', $sub_data);
                    else
                        $this->db->update('mp_sub_entry', $sub_data);
                } else {
                    if ($data['draft_value'] == 'true')
                        $this->db->insert('draft_sub_entry', $sub_data);
                    else
                        $this->db->insert('mp_sub_entry', $sub_data);
                }
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
            $this->record_activity(array('jenis' => 2, 'sub_id' => $data['id'], 'desk' => 'Edit Jurnal'));
        }
        return $data;
    }

    //USED TO CREATE A OPENING BALANCE
    function opening_balance($data)
    {
        $trans_data = array(
            'date' => $data['date'],
            'naration' => $data['description'],
            'customer_id' => $data['customer_id'],
            'generated_source' => 'Opening balance'
        );

        $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_generalentry', $trans_data);
        $order_id = $this->db->insert_id();

        $sub_data  = array(
            'parent_id'   => $order_id,
            'accounthead' => $data['head'],
            'amount'      => $data['amount'],
            'type'        => $data['nature']
        );

        $this->db->insert('mp_sub_entry', $sub_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $data;
    }

    public function delete_jurnal($id)
    {
        $logs = $this->session->userdata('user_id')['name'] . '|' . $this->session->userdata('user_id')['name'] . '|' . date('Y-m-d');
        $this->db->select("*");
        $this->db->from('mp_generalentry');
        $this->db->where('id ', $id);
        $this->db->order_by('mp_generalentry.id',);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result()[0];
            // die();
            $data1  = array(
                'id'             => $transaction_records->id,
                'date'                 => $transaction_records->date,
                'customer_id'             => $transaction_records->customer_id,
                'generated_source'             => $transaction_records->generated_source,
                'no_jurnal'             => $transaction_records->no_jurnal,
                'gen_lock'             => $transaction_records->gen_lock,
                'arr_cars'             => $transaction_records->arr_cars,
                'naration'             => $transaction_records->naration,
                'logs_delete'             => $logs,
            );
            $this->db->insert('mp_generalentry_delete', $data1);
            $this->db->where('id ', $id);
            // $this->db->where('mp_generalentry.id =', $id);
            $this->db->delete('mp_generalentry');
        }


        // sub 
        $this->db->select("*");
        $this->db->from('mp_sub_entry');
        $this->db->where('mp_sub_entry.parent_id =', $id);
        $sub_query = $this->db->get();
        if ($sub_query->num_rows() > 0) {
            $sub_query =  $sub_query->result();
            if ($sub_query != NULL) {
                foreach ($sub_query as $single_trans) {
                    // var_dump($single_trans);
                    $data2  = array(
                        'id'             => $single_trans->id,
                        'parent_id'                 => $single_trans->parent_id,
                        'accounthead'             => $single_trans->accounthead,
                        'amount'             => $single_trans->amount,
                        'type'             => $single_trans->type,
                        'sub_keterangan'             => $single_trans->sub_keterangan,
                        'pos_lock'             => $single_trans->pos_lock,
                        'logs_delete'             => $logs,
                    );
                    $this->db->insert('mp_sub_entry_delete', $data2);

                    $this->db->where('mp_sub_entry.parent_id =', $id);
                    $this->db->delete('mp_sub_entry');
                }
            }
        }

        $this->record_activity(array('jenis' => 3, 'sub_id' => $id, 'desk' => 'Delete Jurnal'));
    }

    public function remove_draft($id)
    {
        $this->db->where('draft_sub_entry.parent_id =', $id);
        $this->db->delete('draft_sub_entry');

        $this->db->where('draft_generalentry.id ', $id);
        $this->db->delete('draft_generalentry');

        $this->db->where('draft_approv.id_transaction ', $id);
        $this->db->delete('draft_approv');
    }

    public function create_cheque($data_fields)
    {
        $this->db->trans_start();

        $credithead  = 0;
        $debithead   = 0;
        $debitamount  = 0;
        $creditamount  = 0;

        if ($data_fields['amount'] >= 0) {
            $debithead    = $data_fields['account_head']; //ACCOUNT HEAD 
            $credithead   = 16; //CASH IN BANK

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];


            $data1  = array(
                'date'                 => $data_fields['date'],
                'naration'             => $data_fields['description'],
                'generated_source'     => 'cheque'
            );

            $this->db->insert('mp_generalentry', $data1);
            $transaction_id = $this->db->insert_id();


            //1ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $debithead,
                'amount'      => $debitamount,
                'type'        => 0
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //2ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $credithead,
                'amount'      => $creditamount,
                'type'        => 1
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'      => $transaction_id,
                'bank_id'             => $data_fields['bank_id'],
                'payee_id'            => $data_fields['payee_id'],
                'method'              => 'Cheque',
                'ref_no'              => $data_fields['cheque_id'],
                'cheque_amount'       => $data_fields['amount'],
                'transaction_status'  => 1,
                'transaction_type'    => 'paid'
            );

            $this->db->insert('mp_bank_transaction', $sub_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data_fields = NULL;
            } else {
                $this->db->trans_commit();
            }

            return $data_fields;
        }
    }

    //TRANSACTION USED TO CREATE A BANK DEPOSIT 
    public function create_deposit($data_fields)
    {
        $this->db->trans_start();

        $credithead    = 0;
        $debithead     = 0;
        $debitamount   = 0;
        $creditamount  = 0;

        if ($data_fields['amount'] >= 0) {
            $debithead    =  16; //CASH IN BANK 
            $credithead   = $data_fields['account_head']; //ACCOUNT HEAD
            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];

            $data1  = array(
                'date'                 => $data_fields['date'],
                'naration'             => $data_fields['memo'],
                'generated_source'     => 'deposit'
            );

            $this->db->insert('mp_generalentry', $data1);
            $transaction_id = $this->db->insert_id();

            //1ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $debithead,
                'amount'      => $debitamount,
                'type'        => 0
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //2ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $credithead,
                'amount'      => $creditamount,
                'type'        => 1
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'   => $transaction_id,
                'bank_id'          => $data_fields['bank_id'],
                'payee_id'         => $data_fields['payee_id'],
                'method'           => $data_fields['method'],
                'cheque_amount'    => $data_fields['amount'],
                'ref_no'           => $data_fields['refno'],
                'transaction_status'    => 1,
                'transaction_type'      => 'recieved'
            );

            $this->db->insert('mp_bank_transaction', $sub_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data_fields = NULL;
            } else {
                $this->db->trans_commit();
            }

            return $data_fields;
        }
    }

    //USED TO CREATE A TRANSACTION WHEN CREATE NEW BANK 
    function bank_transaction($data_fields)
    {
        $this->db->trans_start();

        $credithead  = 0;
        $debithead   = 0;
        $debitamount  = 0;
        $creditamount  = 0;

        if ($data_fields['end_balance'] >= 0) {

            // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
            $args = array(
                'bankname' => $data_fields['bankname'],
                'branch' => $data_fields['branch'],
                'branchcode' => $data_fields['branchcode'],
                'title' => $data_fields['title'],
                'accountno' => $data_fields['accountno']
            );

            // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
            $this->db->insert('mp_banks', $args);
            $bank_id = $this->db->insert_id();

            $debithead    =  16; //CASH IN BANK 
            //$credithead   = $data_fields['account_head']; //ACCOUNT HEAD

            $debitamount  = $data_fields['end_balance'];
            // $creditamount = $data_fields['amount'];

            $data1  = array(
                'date'                 => $data_fields['end_date'],
                'naration'             => 'Transaksi dilakukan dari penambahan akun Bank',
                'generated_source'     => 'add_bank'
            );

            $this->db->insert('mp_generalentry', $data1);
            $transaction_id = $this->db->insert_id();

            //1ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id,
                'accounthead' => $debithead,
                'amount'      => $debitamount,
                'type'        => 0
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //TRANSACTION DETAILS 
            $sub_data  = array(
                'date_created' => $data_fields['end_date'],
                'bank_id'      => $bank_id,
                'amount'       => $data_fields['end_balance']
            );

            $this->db->insert('mp_bank_opening', $sub_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data_fields = NULL;
            } else {
                $this->db->trans_commit();
            }

            return $data_fields;
        }
    }

    //USED TO EDIT INVOICE 
    function edit_invoice_transaction($data, $invoice_id)
    {
        $this->db->trans_start();

        $this->db->where(['id' => $invoice_id]);
        $query = $this->db->get('mp_invoices');
        $result = $query->result();
        $transaction_id = $result[0]->transaction_id;

        $credithead  = 0;
        $creditamount  = 0;

        $debithead   = 0;
        $debitamount  = 0;

        if ($transaction_id != 0) {
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = FALSE;
            $this->db->where(['parent_id' => $transaction_id]);
            $this->db->delete('mp_sub_entry');
            if ($this->db->affected_rows() > 0) {

                $credithead  = 0;
                $debithead   = 0;

                if ($data['total_bill'] == $data['bill_paid']) {
                    $debithead = 2; // CASH
                    $credithead = 3; // INVENTORY

                    $debitamount = $data['total_bill'];
                    $creditamount = $data['bill_paid'];
                } else if ($data['total_bill'] != $data['bill_paid'] and $data['bill_paid'] > 0) {
                    $debithead = 2;
                    $debithead2 = 4; //AR
                    $credithead  = 3;

                    $debitamount = $data['bill_paid'];
                    $debitamount2 = $data['total_bill'] - $data['bill_paid'];
                    $creditamount = $data['total_bill'];
                } else if ($data['bill_paid'] == 0) {
                    $debithead = 4;
                    $credithead = 3;

                    $debitamount = $data['total_bill'];
                    $creditamount = $data['total_bill'];
                } else {
                }

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $transaction_id,
                    'accounthead' => $debithead,
                    'amount'      => $debitamount,
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry', $sub_data);

                if ($data['total_bill'] != $data['bill_paid'] and $data['bill_paid'] > 0) {
                    //3RD ENRTY
                    $sub_data  = array(
                        'parent_id'   => $transaction_id,
                        'accounthead' => $debithead2,
                        'amount'      => $debitamount2,
                        'type'        => 0
                    );

                    $this->db->insert('mp_sub_entry', $sub_data);
                }

                //2ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $transaction_id,
                    'accounthead' => $credithead,
                    'amount'      => $creditamount,
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry', $sub_data);
            }

            $this->db->db_debug = $db_debug;


            //UPDATE invoices
            $this->db->where('id', $invoice_id);
            $this->db->update('mp_invoices', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data = NULL;
            } else {
                $this->db->trans_commit();
            }

            return $data;
        }
    }


    //USED TO RESTORE BACKUP
    function backup_restore_transaction()
    {
        $this->db->trans_start();
        $config['upload_path'] = './uploads/files';
        $config['allowed_types'] = 'txt';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('backup_file')) {
            $result = '';
        } else {
            $data = $this->upload->data();
            // $data will contain full inforation
            $result = $data['full_path'];
        }

        $isi_file = file_get_contents($result);
        foreach (explode(";\n", $isi_file) as $sql) {
            $sql = trim($sql);

            if ($sql) {
                $this->db->query($sql);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result = NULL;
        } else {
            $this->db->trans_commit();
        }

        return $result;
    }

    function record_activity($data)
    {
        $sub_data  = array(
            'user_id'   => $this->session->userdata('user_id')['id'],
            'jenis'   => $data['jenis'],
            'desk'   => $data['desk'],
            'sub_id'   => $data['sub_id']
        );

        $this->db->insert('mp_activity', $sub_data);
    }

    public function delete_jurnal_draft($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('draft_generalentry');


        $this->db->where('parent_id', $id);
        $this->db->delete('draft_generalentry');
    }
}
