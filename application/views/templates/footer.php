<?php if(current_url() !== 'admin/login'): ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<script src="/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/public/assets/js/bootstrap.bundle.min.js"></script>
<script src="/public/root.js"></script>
<?php 
  if(isset($custom_js_links))
  {
    foreach ($custom_js_links as $key => $js_file_name) 
    {
      echo '<script src="/public/assets/js/' . $js_file_name . '.js"></script>';
    }; 
  }
?>
</body>
</html>