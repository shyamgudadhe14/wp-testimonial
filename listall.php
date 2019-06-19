<?php
/*
Template Name: listall
*/
global $wpdb;
global $msg;
$table = $wpdb->prefix."testimonial";
   
    if($_GET['delid']) //This will delete the image of specific id
    {
        $id=$_GET['delid'];
        $table = $wpdb->prefix."testimonial";       
        $sql = "DELETE FROM $table WHERE Test_id=".$id;
        $wpdb->query($sql);
        $msg="Record Deleted Successfully";       
    }
   
    if($_GET['s_id']) //this will set the status of the specific image id i.e. active or inactive
    {
        $status_id = $_GET['s_id'];
        $status_res = $wpdb->get_row("SELECT Status FROM $table WHERE Test_id = ". $status_id );
         $stat=$status_res->Status;
            if($stat=="Active")
            {
                $wpdb->update($table,array('Status'=>'Inactive'),array('Test_id'=>$status_id));
            }
            else
            {
                $wpdb->update($table,array('Status'=>'Active'),array('Test_id'=>$status_id));
            }
    }
if($_POST['submit'])
{
$id=$_POST['list'];
$cnt=count($id);
$action=$_POST['act'];
    if($cnt<=0)
    {
    $msg="Please Select at least one checkbox";
    }
    else
    {
        if($action=="Active")
        {
            $table=$wpdb->prefix."testimonial";
            foreach($id as $i)
            {           
                $results_act = $wpdb->get_row("SELECT Status FROM $table WHERE Test_id = ". $i );           
                $wpdb->update($table,array('Status'=>'Active'),array('Test_id'=>$i));
                $msg="Records Activated Successfully";
            }
        }
        else if($action=="Inactive")
        {
            $table=$wpdb->prefix."testimonial";
            foreach($id as $i)
            {           
                $results_inact = $wpdb->get_row("SELECT Status FROM $table WHERE Test_id = ". $i );           
                $wpdb->update($table,array('Status'=>'Inactive'),array('Test_id'=>$i));           
                $msg="Records Inactivated Successfully";
            }
        }
        else if($action=="Delete")
        {
            $table=$wpdb->prefix."testimonial";
            foreach($id as $i)
            {           
                //$results_inact = $wpdb->get_row("SELECT Status FROM $table WHERE id = ". $i );
                $sql= "delete from $table where Test_id = $i" ;   
                $wpdb->query($sql);
                $msg="Records Deleted Successfully";           
            }
        }
    }
}
$sql ="select * from $table order by Test_id desc";
$results = $wpdb->get_results($sql);
$SrNo=1;
?>
<br/>
    <form name="listing" action="" method="post" onsubmit="return confall()">
        <select name="act" id="acts">
            <option value="Active">  Active  </option>
            <option value="Inactive">  Inactive  </option>
            <option value="Delete">  Delete  </option>               
        </select>&nbsp;&nbsp;
           <input type="submit" name="submit" value="Apply" onclick="return confir1() "/>
        <center><b><?php echo $msg;?></b></center>
        <table class="widefat" style="margin-top: 0.5em;">
        <thead>
            <tr valign="top" bgcolor="#dddddd">
                <th width="5%"><input type="checkbox" id="checkall" name="checkall" onclick="setall(document.listing.list)"></th>
                <th width="10%" scope="row">Sr. No.</th>             
                <th width="15%" scope="row">Name</th>
                <th width="45%" scope="row">Testimonials</th>       
                <th width="10%" scope="row">Status</th>
                <th width="5%" scope="row">Edit</th>
                <th width="10%" scope="row">Delete</th>
            </tr>
        </thead>
        <tbody>      
           
    <?php foreach($results as $r)
    {?>
       <tr>
        <td>&nbsp;
             <input type="checkbox" id="list" name="list[]" value="<?php echo $r->Test_id;?>" />
        </td>
        <td>
            <?php echo $SrNo;?>
        </td>       
        <td>
            <?php echo $r->Client_Name;?>
        </td>
        <td>
            <?php echo $r->    Full_Text;?>
        </td>       
        <td>
            <a href="?page=testimonials/testimonials.php&s_id=<?php echo $r->Test_id;?>"><?php echo $r->Status;?></a>
        </td>
        <td>
            <a href="?page=Edit-Test&editid=<?php echo $r->Test_id;?>">Edit</a>
        </td>
        <td>
            <a href="?page=testimonials/testimonials.php&delid=<?php echo $r->Test_id; ?>" onclick="return confir()" >Delete</a>
        </td>
    </tr>
<?php
    $SrNo++;
    }
?>    </tbody>
    </table>
</form>
<script language="javascript" type="text/javascript">
function confir()
{
    //This function is for just confirmation of the deleting a single record
    var conf=confirm("Do you Really want to delete this record!");
    if(conf==true)
    {
    return true;
    }
    else
    {
    return false;
    }
}
function setall(field)
{
    if(document.getElementById("checkall").checked==true)
    {   
    for (i = 0; i < field.length; i++)
    field[i].checked = true;   
    }
    else if(document.getElementById("checkall").checked==false)
    {
    for (i = 0; i < field.length; i++)
    field[i].checked = false ;
    }
}
function confall()
{
    //This function is for just confirmation of the deleting all selected records
    if(document.getElementById("acts").value=="Delete")
    {
        var conf=confirm("Do you Really want to delete Selected records!");
        if(conf==true)
        {
        return true;
        }
        else
        {
        return false;
        }
    }
    else
    {
    return true;
    }
}
</script>
