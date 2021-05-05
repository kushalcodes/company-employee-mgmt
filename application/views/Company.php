<div class="p-2">
  <h4>Company</h4>
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
    Create new company
  </button>
  
  <div class="mt-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Company Name</th>
          <th scope="col">Logo</th>
          <th scope="col">Website</th>
          <th scope="col">Email</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $key => $row): ?>
          <?php $key = $key + 1; ?>
          <tr ondblclick="edit(<?= $row->id; ?>);">
            <th scope="row"><?= $row->id; ?></th>
            <td id="name-<?= $row->id; ?>" ><?= $row->name; ?></td>
            <td id="logo-<?= $row->id; ?>" ><img class="img-fluid" src="/public/logos/<?= $row->logo; ?>"/></td>
            <td id="website-<?= $row->id; ?>" ><?= $row->website; ?></td>
            <td id="email-<?= $row->id; ?>" ><?= $row->email; ?></td>
            <td>
              <!-- <a href="<?= current_url()?>/edit" class="btn btn-info btn-sm mb-2" onclick>Edit</a> -->
              <a href="#" class="btn btn-info btn-sm mb-2" onclick="edit(<?= $row->id; ?>);">Edit</a>
              <a href="/admin/company/delete/<?= $row->id; ?>" class="btn btn-danger btn-sm mb-2">Delete</a>
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
  <?= form_open_multipart() ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dashboardModalTitle">Add Company</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dashboardModalBody">
        <label for="name">Name</label>
        <input class="form-control mb-2" type="text" name="name" id="name" placeholder="Name">
        <label for="email">Email</label>
        <input class="form-control mb-2" type="text" name="email" id="email" placeholder="Email">
        <label for="logo">Logo</label>
        <input class="form-control mb-2" type="file" name="logo" id="logo">
        <label for="website">Website</label>
        <input class="form-control mb-2" type="text" name="website" id="website" placeholder="Website">
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
  <?= form_open_multipart('/admin/company/edit') ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dashboardEditModalTitle">Edit <span id="editCompanyName" class="text-muted"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dashboardEditModalBody">
        <label for="name">Name</label>
        <input class="form-control mb-2" type="text" name="name" id="editName" placeholder="Name">
        <label for="email">Email</label>
        <input class="form-control mb-2" type="text" name="email" id="editEmail" placeholder="Email">
        <label for="logo">Logo</label>
        <input class="form-control mb-2" type="file" name="logo">
        <img class="img-fluid" src="" id="editLogo"/>
        <div class="clear-fix"></div><br>
        <label for="website">Website</label>
        <input class="form-control mb-2" type="text" name="website" id="editWebsite" placeholder="Website">
        <input type="hidden" name="id" value="" id="editId">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary btn-sm" value="Edit" name="dashboard_modal_submit">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
const edit = (id) => {
  $("#editId").val(id);
  $("#editName").val( $("#name-"+id).text() );
  $("#editCompanyName").text( '('+$("#name-"+id).text()+')' );
  $("#editEmail").val( $("#email-"+id).text() );
  $("#editLogo").attr('src', $("#logo-"+id+" img").attr('src') );
  $("#editWebsite").val( $("#website-"+id).text() );
  $('#dashboardEditModal').modal('show');
};
</script>