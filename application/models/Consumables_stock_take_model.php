<?php

    if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Consumables_stock_take_model extends CI_Model
    {

        public $table = 'consumables_in_stock';
        public $id = 'id_instock';
        public $order = 'ASC';

        /**
         * Constructor for Consumables_stock_take_model class.
         */
        function __construct()
        {
            parent::__construct();
        }

        /**
         * Retrieves data for displaying consumables in stock in JSON format.
         *
         * @return string The JSON data for consumables in stock.
         */
        function jsonGetInStock() 
        {
            $this->datatables->select('consumables_in_stock.id_instock, consumables_in_stock.id_stock, ref_objective.id_objective, ref_objective.objective, consumables_stock.product_name, consumables_in_stock.closed_container,
            consumables_in_stock.unit_measure_lab, consumables_in_stock.quantity_per_unit, consumables_in_stock.loose_items,
            consumables_in_stock.total_quantity, consumables_in_stock.unit_of_measure, consumables_in_stock.expired_date,
            consumables_in_stock.comments, consumables_in_stock.date_collected, consumables_in_stock.time_collected,  
            consumables_in_stock.date_created, consumables_in_stock.date_updated, GREATEST(consumables_in_stock.date_created, consumables_in_stock.date_updated) AS latest_date');
            $this->datatables->from('consumables_in_stock');
            $this->datatables->join('consumables_stock', 'consumables_in_stock.id_stock = consumables_stock.id_stock', 'left');
            $this->datatables->join('ref_objective', 'consumables_in_stock.id_objective = ref_objective.id_objective', 'left');
            $this->datatables->where('consumables_in_stock.flag', '0');
            $this->datatables->where('consumables_in_stock.lab', $this->session->userdata('lab'));
            $this->datatables->add_column('quantity_with_unit', '$1 $2', 'total_quantity,unit_of_measure');

            $lvl = $this->session->userdata('id_user_level');
            if ($lvl == 7){
                $this->datatables->add_column('action', '', 'id_instock');
            }
            else if (($lvl == 2) | ($lvl == 3)){
                $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'id_instock');
            }
            else {
                // $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-primary btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'barcode_sample');
                $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>'." 
                    ".'<button type="button" class="btn_delete btn btn-danger btn-sm" data-id="$1" aria-hidden="true"><i class="fa fa-trash-o" aria-hidden="true"></i></button>', 'id_instock');
            }

            // Order by latest date
            $this->db->order_by('latest_date', 'DESC');

            return $this->datatables->generate();
        }


        /**
         * Retrieves all consumables in stock from the database.
         *
         * @return array Data of all consumables in stock
         */
        function getAllConsumablesInStock()
        {
            $response = array();
            $this->db->select('*');
            $this->db->where('flag', '0');  // Assuming flag is a string, otherwise use 0 without quotes
            $q = $this->db->get('consumables_in_stock');
            $response = $q->result_array();
        
            return $response;
        }

        /**
         * Retrieves product information from the database.
         *
         * @return array Data of all products
         */
        // function getProduct()
        // {
        //     $response = array();
        //     $this->db->select('*');
        //     $this->db->where('flag', '0');
        //     $q = $this->db->get('consumables_products');
        //     $response = $q->result_array();
        //     return $response;
        // }

        function getStock()
        {
            $response = array();
            $this->db->select('*');
            $this->db->where('flag', '0');
            $q = $this->db->get('consumables_stock');
            $response = $q->result_array();
            return $response;
        }

        function getStockById($idStock)
        {
            $this->db->select('unit, unit_of_measure, quantity_per_unit');
            $this->db->where('id_stock', $idStock);
            $q = $this->db->get('consumables_stock');
            return $q->row_array();
        }

        // function getStockByObjective($id_objective)
        // {
        //     $this->db->select('consumables_stock.id_stock, consumables_stock.product_name');
        //     $this->db->join('ref_consumables', 'ref_consumables.id_stock = consumables_stock.id_stock');
        //     $this->db->where('ref_consumables.id_objective', $id_objective);
        //     $q = $this->db->get('consumables_stock');
        //     return $q->result_array();
        // }

        function getStockByObjective($id_objective)
        {
            // Pastikan parameter adalah array dan menggunakan where_in
            $this->db->select('consumables_stock.id_stock, consumables_stock.product_name');
            $this->db->join('ref_consumables', 'consumables_stock.id_stock = ref_consumables.id_stock');
            $this->db->where_in('ref_consumables.id_objective', $id_objective); // Menggunakan where_in
            $this->db->group_by('consumables_stock.product_name');
            $q = $this->db->get('consumables_stock');
            return $q->result_array();
        }
        
        


        function getObjective()
        {
            $response = array();
            $this->db->select('id_objective, objective');
            $this->db->where('flag', '0');
            $q = $this->db->get('ref_objective');
            $response = $q->result_array();
            return $response;
        }

        // function getProductById($productId)
        // {
        //     $this->db->select('unit_of_measure'); // Ubah sesuai dengan nama kolom yang relevan
        //     $this->db->where('id', $productId);
        //     $q = $this->db->get('consumables_products');
        //     return $q->row_array(); // Mengembalikan hasil sebagai array
        // }

    /**
     * Inserts data into the "consumables_in_stock" table.
     *
     * @param array $data The data to be inserted.
     * @return void
     */
        // function insertConsumablesInStock($data)
        // {
        //     $this->db->insert('consumables_in_stock', $data);
        // }

        function insertConsumablesInStock($data)
        {
            // insert into rhe consumables_in_stock table
            $this->db->trans_start();  // Starting Transaction
            $this->db->insert('consumables_in_stock', $data);
            $id_instock = $this->db->insert_id();

            // update product quantity
            $id_stock = $data['id_stock'];
            $closed_container_subs = $data['closed_container'];

            $this->db->set('quantity', 'quantity - ' . (int)$closed_container_subs, FALSE);
            $this->db->where('id_stock', $id_stock);
            $this->db->update('consumables_stock');
            $this->db->trans_complete();  // Completing transaction

            return $this->db->trans_status(); // Return true if the transaction succeeded
        }

        /**
         * Updates consumables in stock based on the provided ID and data.
         *
         * @param datatype $id The ID of the consumable to update.
         * @param datatype $data The data to update the consumable with.
         * @return void
         */
        // function updatetConsumablesInStock($id, $data)
        // {
        //     $this->db->where($this->id, $id);
        //     $this->db->update('consumables_in_stock', $data);
        // }

        function updatetConsumablesInStock($id, $data)
        {
            $this->db->trans_start(); // Starting Transaction

            // Get previous stock data
            $this->db->where('id_instock', $id);
            $old_stock = $this->db->get('consumables_in_stock')->row();

            if($old_stock) {
                // calculate difference
                $old_closed_container_subs = $old_stock->closed_container;
                $new_closed_container_subs = $data['closed_container'];
                $closed_container_diff = $new_closed_container_subs - $old_closed_container_subs;
                // var_dump($quantity_diff);
                // die();

                // update stock in consumables_in_stock table
                $this->db->where('id_instock', $id);
                $this->db->update('consumables_in_stock', $data);

                // update product quantity
                $id_stock = $data['id_stock'];
                $this->db->set('quantity', 'quantity - ' . (int)$closed_container_diff, FALSE);
                $this->db->where('id_stock', $id_stock);
                $this->db->update('consumables_stock');
            }

            // if ($old_stock) {
            //     // Calculate difference for old product
            //     $old_product_id = $old_stock->product_id;
            //     $old_total_quantity = $old_stock->total_quantity;
            //     $new_total_quantity = $data['total_quantity'];
            //     $quantity_diff = $new_total_quantity - $old_total_quantity;
    
            //     // Update stock in in_stock table
            //     $this->db->where('id_instock', $id);
            //     $this->db->update('consumables_in_stock', $data);
    
            //     // Adjust old product quantity
            //     $this->db->set('quantity', 'quantity + ' . (int)$old_total_quantity, FALSE);
            //     $this->db->where('id', $old_product_id);
            //     $this->db->update('consumables_products');
    
            //     // Adjust new product quantity
            //     $new_product_id = $data['product_id'];
            //     $this->db->set('quantity', 'quantity + ' . (int)$quantity_diff, FALSE);
            //     $this->db->where('id', $new_product_id);
            //     $this->db->update('consumables_products');
            // }

            $this->db->trans_complete(); // Completing transaction
            return $this->db->trans_status(); // Return true if the transaction succeeded
        }

    /**
     * Deletes a record from the "consumables_in_stock" table based on the provided ID.
     *
     * @param int $id The ID of the record to be deleted.
     * @return void
     */
        // function destroyConsumablesInStock($id)
        // {
        //     $this->db->where($this->id, $id);
        //     $this->db->delete('consumables_in_stock');
        // }

        function destroyConsumablesInStock($id)
        {
            $this->db->trans_start(); // Start transaction

            // Get stock data
            $this->db->where('id_instock', $id);
            $stock = $this->db->get('consumables_in_stock')->row();
    
            if ($stock) {
                // Calculate quantity to be reduced
                $closed_container_to_remove = $stock->closed_container;
    
                // Delete from in_stock table
                $this->db->where('id_instock', $id);
                $this->db->delete('consumables_in_stock');
    
                // Update product quantity
                $id_stock = $stock->id_stock;
                $this->db->set('quantity', 'quantity + ' . (int)$closed_container_to_remove, FALSE);
                $this->db->where('id_stock', $id_stock);
                $this->db->update('consumables_stock');
            }
    
            $this->db->trans_complete(); // Complete transaction
    
            return $this->db->trans_status(); // Return TRUE if transaction successful, FALSE otherwise
        }

        /**
         * Retrieves a record from the "consumables_in_stock" table based on the provided ID.
         *
         * @param datatype $id The ID of the record to retrieve.
         * @throws Exception if the record is not found.
         * @return object The retrieved record.
         */
        function getById($id)
        {
            $this->db->where($this->id, $id);
            $this->db->where('flag', '0');
            return $this->db->get('consumables_in_stock')->row();
        }


        function checkStockLevelsAndSendNotification()
        {
            log_message('debug', 'Started checking stock levels.');
            $this->load->library('email');  
    
            // Get all products
            $this->db->select('id_stock, quantity, minimum_stock');
            $query = $this->db->get('consumables_stock');
            $stockData = $query->result_array();
    
            foreach ($stockData as $data) {
                $id_stock = $data['id_stock'];
                $quantity = $data['quantity'];
                $minimumStock = $data['minimum_stock'];
    
                // Check if quantity is approaching minimum stock
                if ($quantity <= $minimumStock + 10) {
                    // Get product details
                    $this->db->select('product_name');
                    $this->db->where('id_stock', $id_stock);
                    $productQuery = $this->db->get('consumables_stock');
                    $product = $productQuery->row_array();
    
                    // Prepare email
                    $this->email->from('uhqdev@gmail.com', 'LIMS2.0 - Alerts');
                    $this->email->to('ulhaq.ulhaq@monash.edu');
                    $this->email->subject('Stock Info: ' . $product['product_name']);
                    $this->email->message('The stock for product ' . $product['product_name'] . ' is approaching the minimum level. Current quantity: ' . $quantity . ', Minimum stock: ' . $minimumStock . '.' . "\n" . 'Please update the stock levels as soon as possible.');
    
                    // Send email
                    if ($this->email->send()) {
                        log_message('debug', 'Email sent successfully for product ' . $product['product_name']);
                    } else {
                        log_message('error', 'Error sending email for product ' . $product['product_name'] . ': ' . $this->email->print_debugger());
                    }
                }
            }
            log_message('debug', 'Finished checking stock levels.');
        }

        function get_all() {
            $this->db->select('ro.objective, cs.product_name, cis.closed_container, cis.unit_measure_lab, cis.quantity_per_unit, 
            cis.loose_items, cis.total_quantity, cis.unit_of_measure, cis.expired_date, cis.comments, cis.date_collected, cis.time_collected');
            $this->db->from('consumables_in_stock AS cis');
            $this->db->join('consumables_stock AS cs', 'cis.id_stock = cs.id_stock', 'left');
            $this->db->join('ref_objective AS ro', 'cis.id_objective = ro.id_objective', 'left');
            $this->db->where('cis.flag', '0');
            $query = $this->db->get();
            return $query->result();
        }
        
    }

?>