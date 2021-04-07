<?php
/*

*/
class Crud_model extends CI_Model
{
    public function insert_data($tablename, $arg1)
    {
        $this->db->insert($tablename, $arg1);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function insert_data_last_id($tablename, $arg1)
    {
        $this->db->insert($tablename, $arg1);
        if ($this->db->affected_rows() > 0)
        {
            return $last_insert_id = $this->db->insert_id();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_last_record($table)
    {
        $this->db->select("id");
        $this->db->from($table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    // DEFINES TO AVOID MULTIPLE EMAILS IN DATABASE
    public function check_email_address($table_name, $tbl_attribute, $email)
    {
        $this->db->select("id");
        $this->db->from($table_name);
        $this->db->where([$tbl_attribute => $email]);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    function add_return_item_stock($product_id,$quantity)
    {
       $product_fetch = $this->fetch_record_by_id('mp_productslist',$product_id);
       $fetched_qty = $product_fetch[0]->quantity;
       $fetched_qty = $fetched_qty + $quantity;

       $data_edit = array(
            'quantity' => $fetched_qty,
            'status'   => 0
        );

       $args_edit = array(
            'table_name' => 'mp_productslist',
            'id' => $product_id
        );

       $result_edit = $this->edit_record_id($args_edit,$data_edit);
       return $result_edit; 
    }
    
    public function fetch_limit_record($table, $limit)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record($tablename, $args)
    {
        if ($args != NULL)
        {
            $this->db->where(['status' => 0]);
            $query = $this->db->get($tablename);
        }
        else
        {
            $query = $this->db->get($tablename);
        }

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }
    
    public function fetch_payee_record($type,$status = '')
    {
        $this->db->where(['type' => $type]);
        if($status != '')
        {
            $this->db->where(['cus_status' => 0]);
        }

        $query = $this->db->get('mp_payee');

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }




    public function recover_password($tablename, $email, $attribute)
    {
        $this->db->where([$attribute => $email]);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_by_id($tablename, $id)
    {
        $this->db->where(['id' => $id]);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME
    public function fetch_attr_record_by_id($table_name,$attr,$val,$status = '')
    {
        if($status != '')
        {
            $this->db->where(['status ='=>$status]);    
        }
        $this->db->where([$attr => $val]);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($table_name);
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }    

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND DATES
    public function fetch_record_with_date($table_name,$attr,$val,$date1,$date2)
    {
        $this->db->where([$attr => $val]);
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($table_name);
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }    

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME
    public function fetch_attr_record_by_userid($table_name,$attr,$val,$id)
    {

        $this->db->where([$attr => $val]);
        $this->db->where('id', $id);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }   

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME
    public function fetch_attr_record_by_userid_source($table_name,$attr,$val,$id,$source)
    {
        $this->db->where([$attr => $val]);
        $this->db->where('agentid', $id);
        $this->db->where('source',$source);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME AND SOURCE
    public function fetch_userid_source($table_name,$source,$agentid)
    {
        $this->db->select('mp_temp_barcoder_invoice.*,mp_productslist.unit_type');
        $this->db->join('mp_productslist','mp_productslist.id = mp_temp_barcoder_invoice.product_id');
        $this->db->where(['agentid' => $agentid]);
        $this->db->where('source',$source);
        $query = $this->db->get('mp_temp_barcoder_invoice');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_temp_invoice_by_id($tablename, $id)
    {
        $this->db->select("cus_picture,discount,shippingcharges,status,cus_id,delivered_to,delivered_by,delivered_date,delivered_description,prescription_id,agentname");
        $this->db->where(['id' => $id]);
        $this->db->from($tablename);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_temp_sales_by_id($tablename, $id)
    {
        $this->db->select("product_id,order_id,product_name,product_category,mg,price,purchase,qty");
        $this->db->where(['order_id' => $id]);
        $this->db->from($tablename);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_orders($tablename, $id, $first_date, $second_date)
    {
        $this->db->where(['cus_id' => $id]);
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_customer_orders($arg)
    {
        $this->db->select("mp_payee.customer_name , mp_payee.cus_email , mp_payee.cus_contact_1 , mp_orders.id , mp_orders.cus_id , mp_orders.cus_picture , mp_orders.date , mp_orders.status");
        $this->db->from('mp_payee');
        $this->db->join('mp_orders', "mp_payee.id = mp_orders.cus_id and mp_orders.status = $arg ");
        $this->db->where('mp_payee.type','customer');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }


    //USED TO FETCH STOCK RECORD
    public function fetch_stock_list()
    {
        $this->db->select("mp_stock.*,mp_productslist.id as product_id, mp_productslist.product_name,mp_productslist.mg,mp_productslist.unit_type");
        $this->db->from('mp_stock');
         $this->db->join('mp_productslist', "mp_productslist.id = mp_stock.mid");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_expense($date1,$date2)
    {
        $this->db->select("mp_expense.*,mp_payee.customer_name, mp_head.name as head_name,mp_head.nature");
        $this->db->where('mp_expense.date >=', $date1);
        $this->db->where('mp_expense.date <=', $date2);
        $this->db->from('mp_expense');
        $this->db->join('mp_head', "mp_expense.head_id = mp_head.id");
        $this->db->join('mp_payee', "mp_payee.id = mp_expense.payee_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }   

    public function customerFinalLedger()
    {
        $customer_id = html_escape($this->input->post('customer_id'));
        $date1 = html_escape($this->input->post('date1'));
        $date2 = html_escape($this->input->post('date2'));        
        $this->db->select('mp_invoices.id,mp_invoices.discount,mp_invoices.cus_id,mp_invoices.total_bill,
        mp_invoices.bill_paid,mp_invoices.date,mp_payee.customer_name,mp_payee.cus_contact_1,mp_payee.cus_email, 
        mp_customer_payments.amount as custamount, mp_customer_payments.description as custdescription');
        $this->db->from('mp_invoices');
        $this->db->join('mp_payee', "mp_payee.id = mp_invoices.cus_id");
        $this->db->join('mp_customer_payments', "mp_customer_payments.customer_id = mp_invoices.cus_id");
        if(!empty($customer_id)){
          $this->db->where('mp_invoices.cus_id',$customer_id);
         }
         if(!empty($date1) && !empty($date2)){
            $this->db->where('mp_invoices.date >=', $date1);
            $this->db->where('mp_invoices.date <=', $date2);
            $this->db->order_by('mp_invoices.id','DESC');
         }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }



    public function expense_through_user($date1,$date2,$method,$payee_id)
    {
        $this->db->select("mp_expense.*,mp_payee.customer_name, mp_head.name as head_name,mp_head.nature");
        $this->db->from('mp_expense');
        $this->db->join('mp_head', "mp_expense.head_id = mp_head.id");
        $this->db->join('mp_payee', "mp_payee.id = mp_expense.payee_id");
        $this->db->where('mp_expense.date <=', $date2);
         $this->db->where('mp_expense.date >=', $date1);
        $this->db->where('mp_expense.payee_id',$payee_id);
        $this->db->where('mp_expense.method', $method);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product($arg )
    {

        // DEFINES JOIN QUERY WHICH WOULD RETURN THE CATEGORY NAME OF product FROM
        // mp_category TABLE INSTEAD OF JUST RETURNING NUMBERIC ID FORM mp_productslist TABLE.
        // INSEAD OF CATEGORY ID 12 WILL GET THE category_name FROM TABLE.
        // IF 0 MEANS SELECT ONLY THOSE RECORDS WHORE STATUS IS 0 MEANS VISIBLE OR 1 MEANS FETCH ALL
        // WEATHER IT WOULD BE VISIBLE OR HIDDEN MEANS STATUS = 0 OR STATUS = 1
        if ($arg == 'all')
        {
              $this->db->select('mp_productslist.*,mp_category.category_name,mp_brand.name');
            $this->db->from('mp_category');
            $this->db->join('mp_productslist', 'mp_category.id = mp_productslist.category_id and mp_productslist.status != 2');
            $this->db->join('mp_brand', "mp_brand.id = mp_productslist.brand_id");
            $query = $this->db->get();   
        }
        else
        {  
          $this->db->select('mp_productslist.*,mp_category.category_name,');
            $this->db->from('mp_category');
            $this->db->join('mp_productslist', "mp_category.id = mp_productslist.category_id and mp_productslist.status = $arg ");
            $this->db->join('mp_brand', "mp_brand.id = mp_productslist.brand_id");
            $query = $this->db->get();
        }

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product_alert()
    {
        //FETCHING THE STOCK LIMIT FROM DATABASE
        $this->db->select('*');
        $this->db->from('mp_productslist');
        $this->db->where('mp_productslist.quantity < mp_productslist.min_stock');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product_alert_limit($limit)
    {
        $this->db->select('*');
        $this->db->from('mp_productslist');
        $this->db->where('mp_productslist.quantity < mp_productslist.min_stock');
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product_returned($first_date, $second_date)
    {
        $this->db->select('mp_productslist.product_name,mp_productslist.retail');
        $this->db->from('mp_productslist');
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function delete_record($tablename, $arg)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->where(['id' => $arg]);
        $this->db->delete($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }

     public function delete_record_by_userid($tablename, $source, $userid)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->where(['source' => $source]);
        $this->db->where(['agentid' => $userid]);
        $this->db->delete($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }

    public function delete_all($tablename)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->truncate($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }
    public function delete_jurnal($tablename)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->empty_table($tablename);
        $this->db->where('id > 0');
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }

    public function delete_image($path, $id, $tablename)
    {
        // IMAGE FOLDER PATH
        $image_path = $path;

        // TABLE ID TO DELETE ROW
        $args = $id;

        // DEFINES TO RETREVE DATA ROW FROM TABLE AGINST GIVEN ID
        $data = $this->get_by_id($tablename, $id);

        // WE WILL NOT DELETE THE DEAFULT PICTURE BECAUSE WE USED THIS PICTURE MANY TIMES FOR OTHER PROFILE
        // IF WE DID SO THEM THIS COULD CAUSE AN ERROR IN PROFILE IMAGES OF PEOPLE IN TABLES
        if ($data->cus_picture != "default.jpg")
        {

            // TO DELETE IMAGE FROM FOLDER TO GIVEN PATH
            @@unlink($image_path . $data->cus_picture);
        }
    }

    public function edit_record_id($args, $data)
    {
        extract($args);
        $this->db->where('id', $id);
        $this->db->update($table_name, $data);
        return TRUE;
    }   

     public function edit_record_attr($args, $data)
    {
        extract($args);
        $this->db->where('set_default', $set_default);
        $this->db->update($table_name, $data);
        return TRUE;
    }

    public function edit_record_transac($args, $data)
    {
        extract($args);
        $this->db->where('parent_id', $id);
        $this->db->update($table_name, $data);
        return TRUE;
    }

    public function edit_prescription_id($args, $data)
    {
        extract($args);
        $fetched_record = $this->fetch_record_by_id($table_name, $id);
        $prescription_id = $fetched_record[0]->prescription_id;
        $this->db->where('id', $prescription_id);
        $this->db->update('mp_orders', $data);
        return TRUE;
    }

    public function edit_record_given_field($fieldname, $args, $data)
    {
        extract($args);
        $this->db->where($fieldname, $id);
        $this->db->update($table_name, $data);
        return TRUE;
    }

    public function get_by_id($table, $id)
    {
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // DEFINES TO UPLOAD PICTURE
    public function do_upload_picture($picture, $path)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 5000;

        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($picture))
        {
            $error = array(
                'error' => $this->upload->display_errors()
            );
            return "default.jpg";
        }
        else
        {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            return $data['upload_data']['file_name'];
        }
    }

    public function count_product($table_name, $tbl_attr, $status)
    {
        $this->db->where($tbl_attr, $status);
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    public function count_sales($table_name, $first_date, $second_date)
    {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    public function count_expire_products($table_name, $first_date, $second_date)
    {
        $this->db->where('expire >=', $first_date);
        $this->db->where('expire <=', $second_date);
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    function result_retail_cost()
    {
        $sum_amt = 0;
        $result_parts = $this->fetch_record('mp_productslist','status');
            if($result_parts != "")
            {

            $sum_amt = 0;

            foreach ($result_parts as $single_part) 
            {
               $sum_amt += $single_part->quantity*$single_part->retail;
            }
        }
        return $sum_amt;
    }

    public function fetch_todo_record($table_name, $first_date, $second_date)
    {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->where('status = 0');
        $this->db->limit(6);
        $this->db->from($table_name);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return "";
        }
    }

    public function authenticate_user($Email, $password)
    {
       
        $this->db->where('user_email =', $Email);
        $this->db->where('user_password =', sha1($password));
        $this->db->where('status = 0');
        $query = $this->db->get('mp_users');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function authenticate_panel_user($Email, $password)
    {
        $this->db->where('cus_email =', $Email);
        $this->db->where('cus_password =', sha1($password));
        $this->db->where('cus_status = 0');
        $this->db->where(['type' => 'customer']);
        $query = $this->db->get('mp_payee');
        if ($query->num_rows() > 0)
        {

           return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_user_details_menus()
    {
        $this->db->select("mp_users.id as user_id , mp_users.user_name , mp_users.user_email , mp_users.user_description ,mp_menu.name,mp_multipleroles.id as rolesid");
        $this->db->from('mp_users');
        $this->db->from('mp_multipleroles');
        $this->db->join('mp_menu', "mp_users.id = mp_multipleroles.user_id and mp_multipleroles.menu_Id = mp_menu.id ");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function delete_image_custom($path, $id,$attr,$tablename)
    {

        // IMAGE FOLDER PATH
        $image_path = $path;

        // TABLE ID TO DELETE ROW
        $args = $id;

        // DEFINES TO RETREVE DATA ROW FROM TABLE AGINST GIVEN ID
        $data = $this->get_by_id($tablename, $id);

        // WE WILL NOT DELETE THE DEAFULT PICTURE BECAUSE WE USED THIS PICTURE MANY TIMES FOR OTHER PROFILE
        // IF WE DID SO THEM THIS COULD CAUSE AN ERROR IN PROFILE IMAGES OF PEOPLE IN TABLES
        if ($data->$attr != "default.jpg")
        {
            // TO DELETE IMAGE FROM FOLDER TO GIVEN PATH
            @@unlink($image_path . $data->$attr);
        }
    }

    public function check_role_duplication($user_id, $menu_id)
    {
        $this->db->where('user_id =', $user_id);
        $this->db->where('menu_Id =', $menu_id);
        $query = $this->db->get('mp_multipleroles');
        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return NULL;
        }
    }

    // /CHECK THE STATUS OF VERIFIED invoiceS
    public function verified_expiry_time_checks()
    {
        $this->db->select('mp_tempinvoices.id as invoice_id,mp_tempinvoices.date,');
        $this->db->from('mp_tempinvoices');
        $this->db->where('status =', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $fetched_invoices = $query->result();

            // FETCHING THE EXPIRY TIME FROM TABLE mp_langingpage
            $set_expirey = $this->fetch_record_by_id('mp_langingpage', 1);
            $retrieve_val = $set_expirey[0]->expirey;
            $todays_date = Date('Y-m-d');
            foreach($fetched_invoices as $obj_fetched_invoices)
            {

                // invoice DATE FROM TABLE OF TMP TABLE
                $invoice_date = $obj_fetched_invoices->date;
                $invoice_days = date_diff(date_create($invoice_date) , date_create($todays_date));
                $invoice_days->format("%a");
                if ($retrieve_val >= $invoice_days)
                {

                    // TABLENAME AND ID FOR DATABASE Actions
                    $args = array(
                        'table_name' => 'mp_tempinvoices',
                        'id' => $obj_fetched_invoices->invoice_id
                    );

                    // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
                    $data = array(
                        'status' => 4
                    );
                    $this->edit_record_id($args, $data);
                }
            }
        }
    }

    //USED TO RECOVER FORGET PASSWORD
    function fetch_forget_password($user_email,$user_code)
    {
        $this->db->select("mp_users.id");
        $this->db->from('mp_users');
        $this->db->where(['user_email'=>$user_email]);  
        $this->db->where(['user_password'=>$user_code]);    
        $this->db->where(['status' =>'0']);    

        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }  
    }

    //USED TO RECOVER FORGET PASSWORD
    function fetch_forget_password_user($user_email,$user_code)
    {
        $this->db->select("mp_customer.id");
        $this->db->from('mp_customer');
        $this->db->where(['cus_email'=>$user_email]);  
        $this->db->where(['cus_password'=>$user_code]);    
        $this->db->where(['cus_status' =>'0']);    

        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }  
    }

    //FOR SHOWING COST IN POS
    function check_pos_cost()
    {
        $user_name = $this->session->userdata('user_id');
        $user_id = $user_name['id'];

        $this->db->select("id");
        $this->db->from('mp_multipleroles');
        $this->db->where(['menu_Id' => 19]);  
        $this->db->where(['agentid' => $user_id]);  

        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return NULL;
        }
    }

    //USED TO SEARCH ATTR
    function search_items_stock($data)
    {
        $this->db->select("*");
        $this->db->from('mp_productslist');
        $this->db->or_like(['product_name' => $data]);   

        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        } 
    }

    //USED TO LIST THE EXPIRED ITEMS 
    function fetch_expired_record()
    {
        $this->db->select("*");
        $this->db->from('mp_productslist');
        $this->db->where(['mp_productslist.expire < ' => date('Y-m-d')]);  

        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE PURCHASED STOCK 
    //Invoice/fetch_record_purchased
    function fetch_record_purchased($status = 0,$date1,$date2)
    {
        $this->db->select("mp_purchase.*,mp_payee.customer_name");
        $this->db->from('mp_purchase');
        $this->db->join('mp_payee', "mp_purchase.supplier_id = mp_payee.id");
        $this->db->where(['mp_purchase.status' =>$status]); 
        $this->db->where('mp_purchase.date >=', $date1);
        $this->db->where('mp_purchase.date <=', $date2); 
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME FOR SUPPLY LIST
    public function fetch_supply($date1,$date2)
    {
        $this->db->select("mp_invoices.*,mp_drivers.name as drivername,mp_vehicle.name as vehiclename,mp_town.name as townname,mp_town.region as townregion,mp_payee.customer_name");
        $this->db->from('mp_invoices');
        $this->db->join('mp_drivers', "mp_invoices.driver_id = mp_drivers.id");
        $this->db->join('mp_vehicle', "mp_invoices.vehicle_id = mp_vehicle.id");
        $this->db->join('mp_town', "mp_invoices.region_id = mp_town.id");
        $this->db->join('mp_payee', "mp_invoices.cus_id = mp_payee.id");
        $this->db->where(['source' => '1']);
        $this->db->where('mp_invoices.date >=', $date1);
        $this->db->where('mp_invoices.date <=', $date2);
         $query = $this->db->get();
  
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }
}