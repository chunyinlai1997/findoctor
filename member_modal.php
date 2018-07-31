<?php
  include_once 'token.php';
  $role = getRole();
?>

<div class='modal fade' id='Modal1' tabindex='-1' role='dialog' aria-labelledby='ModalContent1' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title' id='ModalContent1'>OPTIONS</h5>
      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'></span>
      </button>
      </div>
      <div class='modal-body'>
      <?php
        if($role=="patient"){
          echo "<a href='profile' class='btn btn-danger'>View Profile</a>";
        }
        else if($role=="staff"){
          echo "<a href='staff_login' class='btn btn-danger'>Staff Panel</a>";
        }
        else if($role=="admin"){
          echo "<a href='admin_login' class='btn btn-danger'>Admin Panel</a>";
        }
      ?>
      <form role='form' action='logout' method='POST'>
        <button type='submit' name='logout' value='this' class='btn btn-primary'>Logout</button></a>
      </form>
      </div>
      <div class='modal-footer'>
      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
      </div>
    </div>
    </div>
</div>
