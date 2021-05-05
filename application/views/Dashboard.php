<div class="container pt-3">
  <div class="row">
    <div class="col-md-3">
      <h5>Employees</h5>
      <hr>

      <ul class="list-group">
        <?php foreach($employee_unassigned as $employee): ?>
          <li class="list-group-item drag-drop" id="<?= $employee->id; ?>"><?= $employee->first_name . ' '. $employee->last_name; ?> </li>
        <?php endforeach; ?>
      </ul>

    </div>
    <div class="col-md-9">
      <h5 class="text-right">Companies</h5>
      <hr>
      <div class="d-flex">
        <?php foreach($companies_all as $company): ?>
          <div class="card mr-2" style="width: 15rem;">
            <img style="max-width:100%;max-height:120px;margin:15px auto;" src="/public/logos/<?= $company->logo; ?>" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title text-center"><?= $company->name; ?></h5>
              <hr>
              <span class="text-muted">Name</span>
              <ul class="list-group dropzone" id="<?= $company->id; ?>">
                <?php foreach($company->employees as $employee): ?>
                  <li class="list-group-item"><?= $employee->first_name . ' ' .$employee->last_name; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
window.onload = () => {
  /* The dragging code for '.draggable' from the demo above
 * applies to this demo as well so it doesn't have to be repeated. */

// enable draggables to be dropped into this
interact('.dropzone').dropzone({
  ondrop: function (event) {
    const droppedEmployeeId = event.relatedTarget.id;
    const draggedEmployeeListEl = $("#"+droppedEmployeeId); 

    const droppedCompanyId = event.target.id;
    const droppedCompanyListEl = $("#"+droppedCompanyId);

    draggedEmployeeListEl.removeAttr('style');
    draggedEmployeeListEl.removeAttr('data-x');
    draggedEmployeeListEl.removeAttr('data-y');
    draggedEmployeeListEl.removeClass('drag-drop');
    droppedCompanyListEl.append(draggedEmployeeListEl);

    update_company(droppedEmployeeId, droppedCompanyId);

    // alert("Employee "+event.relatedTarget.id
    //         + ' was dropped into '
    //         + 'Company '+event.target.id);
  },  
  ondragleave: function (event) {
    
  }
});

interact('.drag-drop')
  .draggable({
    inertia: true,
    modifiers: [
      interact.modifiers.restrict({
        endOnly: true
      })
    ],
    autoScroll: true,
    // dragMoveListener from the dragging demo above
    listeners: { 
      move: dragMoveListener
    }
  })

  function dragMoveListener (event) {
    var target = event.target
    // keep the dragged position in the data-x/data-y attributes
    var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
    var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy

    // translate the element
    target.style.transform = 'translate(' + x + 'px, ' + y + 'px)'

    // update the posiion attributes
    target.setAttribute('data-x', x)
    target.setAttribute('data-y', y)
  }
};

// update employee company
const update_company = (employeeId, companyId) => {
  const sendData = {
    'id' : employeeId,
    'company_id' : companyId
  };
  call_ajax('/v1/api/admin/employee/update_company', 'POST', sendData, (data) => {
    if(data.status === 'error'){
      alert(data.msg);
    }
    console.log(data);
  });
};
</script>