<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* The WP_List_Table class isn't automatically available to plugins, so we need
* to check if it's available and load it if necessary.
*/
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Kocf_Admin_Signup_List extends WP_List_Table {
    /**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels,
    * as well as whether the class supports AJAX.
    */
    function __construct() {
       parent::__construct( array(
      'singular'=> 'Signup', //Singular label
      'plural' => 'Singups', //plural label, also this well be one of the table css class
      'ajax'   => false //We won't support Ajax for this table
      ) );
    }

    /**
    * This method is called when the parent class can't find a method
    * specifically build for a given column.
    */
    function column_default($item, $column_name){
        switch($column_name){
            case 'kocf_col_signup_id':
            case 'kocf_col_signup_email':
            case 'kocf_col_signup_catan_universe_name':
            case 'kocf_col_signup_colonist_name':
            case 'kocf_col_signup_catan_vr_name':
            case 'kocf_col_signup_discord_name':
            case 'kocf_col_signup_game_modes':
            case 'kocf_col_signup_discord_server':
            case 'kocf_col_signup_add_to_newsletter':
            case 'kocf_col_signup_time_zone':
            case 'kocf_col_signup_time_stamp':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    /**
    * Define the columns that are going to be used in the table
    * @return array $columns, the array of columns to use with the table
    */
    function get_columns() {
       return $columns= array(
          'kocf_col_signup_id'=>__('ID'),
          'kocf_col_signup_email'=>__('Email'),
          'kocf_col_signup_catan_universe_name'=>__('Catan Universe Name'),
          'kocf_col_signup_colonist_name'=>__('Colonist Name'),
          'kocf_col_signup_catan_vr_name'=>__('Catan VR Name'),
          'kocf_col_signup_discord_name'=>__('Discord Name'),
          'kocf_col_signup_game_modes'=>__('Game Modes'),
          'kocf_col_signup_discord_server'=>__('Discord Server'),
          'kocf_col_signup_add_to_newsletter'=>__('Add to Newsletter'),
          'kocf_col_signup_time_zone'=>__('Time Zone'),
          'kocf_col_signup_time_stamp'=>__('Time stamp'),
       );
    }

    /**
    * Decide which columns to activate the sorting functionality on
    * @return array $sortable, the array of columns that can be sorted by the user
    */
    public function get_sortable_columns() {
       return $sortable = array(
          'kocf_col_signup_time_stamp'=> array('time_stamp',false), //true means it's already sorted
          'kocf_col_signup_email'=> array('user_email_id',false),
       );
    }

    /**
    * Prepare the table with different parameters, pagination, columns and table elements
    */
    function prepare_items() {
       global $wpdb;

       /**
       * First, lets decide how many records per page to show
       */
       $per_page = 30;

       /**
       * Now we need to define our column headers.
       */
       $columns = $this->get_columns();
       $hidden = array();
       $sortable = $this->get_sortable_columns();

       /**
       * REQUIRED. Finally, we build an array to be used by the class for column
       * headers. The $this->_column_headers property takes an array which contains
       * 3 other arrays. One for all columns, one for hidden columns, and one
       * for sortable columns.
       */
       $this->_column_headers = array($columns, $hidden, $sortable);

       /* -- Preparing your query -- */
       $kocf_signup_table_name = $wpdb->prefix . KOCF_SIGNUP_TABLE;
       $query = "SELECT * FROM $kocf_signup_table_name";

       /* -- Ordering parameters -- */
       //Parameters that are going to be used to order the result
       $orderby = !empty($_REQUEST["orderby"]) ? $_REQUEST["orderby"] : 'user_id';
       $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : 'asc';
       $orderByString = sanitize_sql_orderby($orderby. ' ' .$order);
       if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderByString; }

       /* -- Pagination parameters -- */
       /**
       * REQUIRED for pagination. Let's figure out what page the user is currently
       * looking at. We'll need this later, so you should always include it in
       * your own package classes.
       */
       $current_page = $this->get_pagenum();

       /**
       * REQUIRED for pagination. Let's check how many items are in our data array.
       * In real-world use, this would be the total number of items in your database,
       * without filtering. We'll need this later, so you should always include it
       * in your own package classes.
       */
       //Number of elements in your table?
       $total_items = $wpdb->query($query); //return the total number of affected rows
       //How many to display per page?
       /**
       * REQUIRED. We also have to register our pagination options & calculations.
       */
       $this->set_pagination_args( array(
         'total_items' => $total_items,                  //WE have to calculate the total number of items
         'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
         'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
       ) );

       /* -- Fetch the items -- */
       $this->items = $wpdb->get_results($query);
    }

    /**
    * Display the rows of records in the table
    * @return string, echo the markup of the rows
    */
    function display_rows() {

       //Get the records registered in the prepare_items method
       $records = $this->items;

       //Get the columns registered in the get_columns and get_sortable_columns methods
       list( $columns, $hidden ) = $this->get_column_info();

       //Loop for each record
       if(!empty($records)){foreach($records as $rec){

          //Open the line
            echo '<tr id="record_'.$rec->user_id.'">';
          foreach ( $columns as $column_name => $column_display_name ) {

             //Style attributes for each col
             $class = "class='$column_name column-$column_name'";
             $style = "";
             if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';
             $attributes = $class . $style;

             //edit link
             $editlink  = '/wp-admin/link.php?action=edit&link_id='.(int)$rec->user_id;

             //Display the cell
             switch ( $column_name ) {
                case "kocf_col_signup_id":  echo '<td '.$attributes.'>'.$rec->user_id.'</td>';   break;
                case "kocf_col_signup_email": echo '<td '.$attributes.'>'.$rec->user_email_id.'</td>'; break;
                case "kocf_col_signup_catan_universe_name": echo '<td '.$attributes.'>'.$rec->catan_universe_name.'</td>'; break;
                case "kocf_col_signup_colonist_name": echo '<td '.$attributes.'>'.$rec->colonist_name.'</td>'; break;
                case "kocf_col_signup_catan_vr_name": echo '<td '.$attributes.'>'.$rec->catan_vr_name.'</td>'; break;
                case "kocf_col_signup_discord_name": echo '<td '.$attributes.'>'.$rec->discord_name.'</td>'; break;
                case "kocf_col_signup_game_modes": echo '<td '.$attributes.'>'.$rec->game_modes.'</td>'; break;
                case "kocf_col_signup_discord_server": echo '<td '.$attributes.'>'.$rec->discord_server.'</td>'; break;
                case "kocf_col_signup_add_to_newsletter":
                  $add_newletter_value = $rec->add_to_newsletter == 0 ? 'No' : 'Yes';
                  echo '<td '.$attributes.'>'. $add_newletter_value . '</td>';
                  break;
                case "kocf_col_signup_time_zone": echo '<td '.$attributes.'>'.$rec->user_time_zone.'</td>'; break;
                case "kocf_col_signup_time_stamp": echo '<td '.$attributes.'>'.$rec->time_stamp.'</td>'; break;
             }
          }

          //Close the line
          echo'</tr>';
       }}
    }

}
