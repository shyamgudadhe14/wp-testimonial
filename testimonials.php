<?php      
/*   
Plugin Name: testimonial
Plugin URI: https://github.com/shyamgudadhe14
Author: Shyam G
Author URI: https://github.com/shyamgudadhe14
Description: This plugin is used to add the new client
Version: 1.1       
*/ 
    function test_table()//this is function for creating table in database                          
    {           
        global $wpdb;
        //create table testimonial
        $table=$wpdb->prefix."testimonial";        
        $sql="CREATE TABLE IF NOT EXISTS $table(
        Test_id INT NOT NULL AUTO_INCREMENT,
        Client_Name VARCHAR( 150 ) NOT NULL,
        Site_Title VARCHAR( 150 ) NOT NULL,
        Web_url VARCHAR( 150 ) NOT NULL,       
        Full_Text VARCHAR( 5000 ) NOT NULL,
        Status ENUM('Active','Inactive') DEFAULT 'Active',        
        PRIMARY KEY (Test_id) )";
           $wpdb->query($sql);       
    }
    add_action('activate_testimonials/testimonials.php' ,'test_table'); //to call the function use the hooks name add_action
   
    add_action('admin_menu','addtestimon');//this for creting menu at admin side
   
    //Following function will create a menu for Image upload   
        function addtestimon()
        {
        add_menu_page("Testimonials","Testimonials",1,__FILE__, "all_test");
        add_submenu_page(__FILE__, 'Add New', 'Add New', 1, "Edit-Test", 'edit_test');
        }
                       
        function edit_test()
        {
        global $wpdb;
        include 'edittest.php';
        }
               
        function all_test()
        {
        include 'listall.php';
        }
       
?>
