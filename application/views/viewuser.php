<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">View User</h4>
</div>
<div class="modal-body customModal">
<div class="formDesign">
<div class="controls">
<div class="row">

<div class="col-md-12">
<div class="form-group">
<label for="form_name">Name : <?php echo $user->name; ?></label>
</div>
</div>


<div class="col-md-12">
<div class="form-group">
<label for="form_name">Email : <?php echo $user->email; ?></label>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label for="form_name">Address : <?php echo $user->address; ?></label>
</div>
</div>

<?php 

if($user->status==1)
{
  $status = 'Active';
} 
else if($user->status==2)
{
  $status = 'Inactive';
}
else
{
  $status = 'Waiting for Permission';
}
?>

<div class="col-md-12">
<div class="form-group">
<label for="form_name">Status : <?php echo $status; ?></label>
</div>
</div>

<?php if(!empty($user->image)) { ?>
<div class="col-md-12">
<div class="form-group">
<label for="form_name">Image :  <img src="<?php echo $user->image; ?>" style="height:100px;"></label>
</div>
</div>
<?php } ?>


</div>
</div>
</div>

<div class="modal-footer custom-modalFooter">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>