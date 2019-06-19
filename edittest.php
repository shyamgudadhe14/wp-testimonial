<?php
/*
Template Name: edittest
*/
?>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/jquery.validate.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
    jQuery("#testi").validate();
    });           
</script>
<script language="javascript" type="text/javascript">
    function textCounter( field, countfield, maxlimit )
    {
          if ( field.value.length > maxlimit )
          {
        field.value = field.value.substring( 0, maxlimit );
        alert( 'Testimonial value can only be 5000 characters in length.' );
        return false;
          }
          else
          {
        countfield.value = maxlimit - field.value.length;
          }
    }

</script>

<?php
global $wpdb;
$table = $wpdb->prefix."testimonial";
if($_POST['submit']=="Add New Testimonial")
{
    extract($_POST);
    $wpdb -> insert($table, array('Client_Name'=>$fname, 'Site_Title'=>$title, 'Web_url'=>$eid,'Full_Text'=>$fullt));   
    echo "<script>self.location='?page=testimonials/testimonials.php';</script>";
}
    if($_GET['editid']) //this will check for the call for editing the record
    {
    $id=$_GET['editid'];
    $sql ="select * from $table where Test_id=$id";
    $results = $wpdb->get_results($sql);
        foreach($results as $r)
        {
        $fname=$r->Client_Name;   
        $eid=$r->Web_url;   
        $fullt=stripslashes($r->Full_Text);
        $title=$r->Site_Title;       
        }
    }
if($_POST['submit']=="Update Testimonial")
{   
//Updating Record into database
extract($_POST);
$wpdb -> update($table, array('Client_Name'=>$fname, 'Site_Title'=>$title, 'Web_url'=>$eid, 'Full_Text'=>$fullt), array('Test_id'=>$id));
echo "<script>self.location='?page=testimonials/testimonials.php';</script>";
}
?>


    <form class="cmxform" id="testi" action="" method="post" enctype="multipart/form-data">   
        <br/>
        <table class="widefat" style="margin-top: 0.5em;">
            <thead>
                    <tr valign="top">
                        <th bgcolor="#dddddd" colspan="2">
                        <?php
                        if($id)
                        {
                        echo "Edit A Testimonial Here";
                        }
                        else
                        echo "Add New Testimonial Here";
                        ?>                      
                        </th>
                    </tr>
            </thead>           
            <tr>
                <td>
                Name
                </td>
                <td>
                <input type='text' id="firstname" name='fname' class="required" size="35" <?php if($id){?> value="<?php echo $fname;?>" <?php }?>/>
                </td>
            </tr>
           
             <tr>
                <td>
                Site Title
                </td>
                <td>
                <input type='text' id="title" name='title' class="required" size="35" <?php if($id){?> value="<?php echo $title;?>" <?php }?>/>
                </td>
            </tr>
           
             <tr>
                <td>
                Client URL
                </td>
                <td>
                <input type='text' id="eid" name='eid' class="url" size="35" <?php if($id){ ?> value="<?php echo $eid;?>"<?php }?>/>
                </td>
            </tr>            
           
            <tr>
                <td valign="top">
                Testimonial (Max 5000 Characters)
                </td>
                <td>
                <textarea rows="10" cols="27" name="fullt" id="fullt" class="required" onkeypress="textCounter(this,this.form.counter,5000)"><?php if($id){?><?php echo $fullt;}?></textarea>
                </td>
            </tr>
            <tr>         
                   <td>                               
                </td>
                <td>
                <input type="text" name="counter" maxlength="4" size="4" value="5000"
                onblur="textCounter(this.form.counter,this,5000);"> Characters Remaining                              
                </td>
            </tr>                   
            <tr>         
                   <td>
                               
                </td>
                <td align="left">
                <input type="submit" name="submit" <?php if($id){?>value="Update Testimonial"<?php } else {?> value="Add New Testimonial" <?php }?> />                  
                </td>
            </tr>
         </table>        
    </form>