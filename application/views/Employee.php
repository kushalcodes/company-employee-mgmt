<div class="p-2">
  <h4>Employees</h4>
  <hr>

  <?php if( isset($_SESSION['success']) ): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_SESSION['success'] ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif;?>

  <?php if( isset($_SESSION['error']) ): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= $_SESSION['error'] ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif;?>

  <?php if(validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo validation_errors(); ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#dashboardModal">
    Create new employee
  </button>
  
  <div class="mt-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Company</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $key => $row): ?>
          <?php $key = $key + 1; ?>
          <tr id="table-row-<?= $row->id; ?>" ondblclick="editModalOpen(<?= $row->id; ?>);">
            <th scope="row"><?= $row->id; ?></th>
            <td id="first_name-<?= $row->id; ?>" ><?= $row->first_name; ?></td>
            <td id="last_name-<?= $row->id; ?>" ><?= $row->last_name; ?></td>
            <td id="email-<?= $row->id; ?>" ><?= $row->email; ?></td>
            <td id="phone-<?= $row->id; ?>" ><?= $row->phone; ?></td>
            <td id="company-<?= $row->id; ?>" ><?= $row->company->name ?? $row->company; ?></td>
            <td>
              <!-- <a href="<?= current_url()?>/edit" class="btn btn-info btn-sm mb-2" onclick>Edit</a> -->
              <a href="#" class="btn btn-info btn-sm mb-2" onclick="editModalOpen(<?= $row->id; ?>);">Edit</a>
              <a href="#" class="btn btn-danger btn-sm mb-2" onclick="del(<?= $row->id; ?>);">Delete</a>
              <?php if(isset($row->company->name)): ?>
                <a href="#" class="btn btn-warning btn-sm mb-2" onclick="unassign(<?= $row->id; ?>);">Unassign Company</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  
  
  <hr>
  <nav>
    <ul class="pagination">
      <?php echo $this->pagination->create_links(); ?>
      <!-- <li class="page-item"><a class="page-link" href="#">1</a></li> -->
    </ul>
  </nav>

</div>

<div class="modal fade" tabindex="-1" role="dialog" id="dashboardModal" aria-labelledby="dashboardModalLabel" aria-hidden="true">
  <?= form_open('v1/api/admin/employee/create') ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dashboardModalTitle">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dashboardModalBody">
        <label for="firstName">First Name</label>
        <input class="form-control mb-2" type="text" name="first_name" id="firstName" placeholder="First Name">
        <label for="lastName">Last Name</label>
        <input class="form-control mb-2" type="text" name="last_name" id="lastName" placeholder="Last Name">
        <label for="email">Email</label>
        <input class="form-control mb-2" type="email" name="email" id="email" placeholder="Email">
        <label for="phone">Phone</label>
        <input class="form-control mb-2" type="text" name="phone" id="phone" placeholder="Phone">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary btn-sm" value="Submit" name="dashboard_modal_submit">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </form>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="dashboardEditModal" aria-labelledby="dashboardEditModalLabel" aria-hidden="true">
  <?= form_open('#', array('id' => 'editForm')) ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dashboardEditModalTitle">Edit <span id="editEmployeeName" class="text-muted"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dashboardEditModalBody">
        <label for="firstName">First Name</label>
        <input class="form-control mb-2" type="text" name="first_name" id="editFirstName" placeholder="First Name">
        <label for="lastName">Last Name</label>
        <input class="form-control mb-2" type="text" name="last_name" id="editLastName" placeholder="Last Name">
        <label for="email">Email</label>
        <input class="form-control mb-2" type="email" name="email" id="editEmail" placeholder="Email">
        <label for="phone">Phone</label>
        <input class="form-control mb-2" type="text" name="phone" id="editPhone" placeholder="Phone">
        <input type="hidden" name="id" value="" id="editId">
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-primary btn-sm" value="Edit" name="dashboard_modal_submit" onclick="edit();">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
const editModalOpen = (id) => {
  $("#editId").val(id);
  $("#editEmployeeName").text( '('+$("#first_name-"+id).text()+' '+$("#last_name-"+id).text()+')' );
  $("#editFirstName").val( $("#first_name-"+id).text() );
  $("#editLastName").val( $("#last_name-"+id).text() );
  $("#editEmail").val( $("#email-"+id).text() );
  $("#editPhone").val( $("#phone-"+id).text() );
  $('#dashboardEditModal').modal('show');
};

// edit employee
const edit = () => {
  const id = $("#editId").val();
  const sendData = {
    id : id,
    first_name: $("#editFirstName").val(),
    last_name: $("#editLastName").val(),
    email: $("#editEmail").val(),
    phone: $("#editPhone").val()
  };
  call_ajax('/v1/api/admin/employee/edit', 'POST', sendData, (data) => {
    alert(data.msg);
    if(data.status === 'success'){
      $("#dashboardEditModal").modal('hide');
      $("#first_name-"+id).text(sendData.first_name);
      $("#last_name-"+id).text(sendData.last_name);
      $("#email-"+id).text(sendData.email);
      $("#phone-"+id).text(sendData.phone);
    }
    console.log(data);
  });
};

// delete employee
const del = (id) => {
  call_ajax('/v1/api/admin/employee/delete/'+id, 'DELETE', {}, (data) => {
    alert(data.msg);
    if(data.status === 'success'){
      $("#table-row-"+id).hide();
    }
  });
};

// unassign employee from company
const unassign = (id) => {
  const sendData = {
    'id' : id,
    'company_id' : 0
  };
  call_ajax('/v1/api/admin/employee/update_company', 'POST', sendData, (data) => {
    if(data.status === 'error'){
      alert(data.msg);
    }
    if(data.status === 'success'){
      window.location.reload();
    }
  });
};

</script>